<?php

namespace tp51\pay\service\wechat\pay;

use tp51\pay\sdk\wechat\NativePay;
use tp51\pay\sdk\wechat\WxPayNotify;
use tp51\pay\service\wechat\BaseWechat;

ini_set('date.timezone','Asia/Shanghai');

class QrCodePay extends BaseWechat {

    /**
     * 模式一
     * 扫码支付
     * @param $order_no
     * @return array|bool
     */
    public function getPrePayUrl(){
        $notify = new NativePay();
        $order_no = $this->_payData['order_no'];
        return $url = $notify->GetPrePayUrl($this->_config, $order_no);
    }

    /**
     * 微信回调数据
     * @param array $data
     * @param string $msg
     * @return bool|\true回调出来完成不需要继续回调，false回调处理未完成需要继续回调
     */
    public function NotifyProcess($data, &$msg)
    {
        //echo "处理回调";
        \think\facade\Log::error("call back:" . json_encode($data));

        if(!array_key_exists("openid", $data) ||
            !array_key_exists("product_id", $data))
        {
            $msg = "回调数据异常";
            \think\facade\Log::error("回调数据异常");
            return false;
        }

        //统一下单
        $result = self::unifiedorder();
        if(!array_key_exists("appid", $result) ||
            !array_key_exists("mch_id", $result) ||
            !array_key_exists("prepay_id", $result))
        {
            $msg = "统一下单失败";
            \think\facade\Log::error("统一下单失败");
            return false;
        }

        $this->SetData("appid", $result["appid"]);
        $this->SetData("mch_id", $result["mch_id"]);
        $this->SetData("nonce_str", WxPayApi::getNonceStr());
        $this->SetData("prepay_id", $result["prepay_id"]);
        $this->SetData("result_code", "SUCCESS");
        $this->SetData("err_code_des", "OK");
        return true;
    }

    /**
     * 扫码支付回调
     */
    public function callBack(){
        \think\facade\Log::info("begin notify!");
        $notify = new WxPayNotify();
        $notify->Handle($this->_config,true);
    }


    /**
     * 统一下单
     * 'body'    => 'test body',
     * 'subject'    => 'test subject',
     * 'order_no'    => $orderNo,
     * 'timeout_express' => 600, s// 表示必须 600s 内付款
     * 'amount'    => '3.01',// 微信沙箱模式，需要金额固定为3.01
     * 'return_param' => '123',
     * 'openid' => 'ottkCuO1PW1Dnh6PWFffNk-2MPbY',
     * @param $product_id
     * @return string 成功时返回
     */
    public function unifiedorder()
    {
        $config  = $this->_config;
        $payData = $this->_payData;
        //统一下单
        $input = new \WxPayUnifiedOrder();
        $input->SetBody($payData['body']);
        $input->SetAttach($payData['subject']);
        $input->SetOut_trade_no($payData['order_no']);
        $input->SetTotal_fee($payData['amount']); //$orderInfo['pay_price']
        $input->SetTime_expire(date("YmdHis", time() + $payData['timeout_express']));
        $input->SetNotify_url($config['notify_url']);
        $input->SetTrade_type("NATIVE");
        $result = \WxPayApi::unifiedOrder($config, $input);
        return $result;
    }
}