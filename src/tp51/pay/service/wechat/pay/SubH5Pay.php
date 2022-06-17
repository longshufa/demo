<?php

namespace tp51\pay\service\wechat\pay;
use tp51\pay\sdk\wechat\JsApiPay;
use tp51\pay\sdk\wechat\WxPayApi;
use tp51\pay\sdk\wechat\wxPayData\WxPayJsApiPay;
use tp51\pay\sdk\wechat\wxPayData\WxPayUnifiedOrder;
use tp51\pay\service\wechat\BaseWechat;

ini_set('date.timezone','Asia/Shanghai');


//error_reporting(E_ERROR);

class SubH5Pay extends BaseWechat {
    /**
     * 获取app调用微信支付需要的参数
     * @param $order array 订单
     * @return array|bool
     * @throws Exception
     */
    public function getParams() {
        $wxOrder = $this->unifiedOrder();
        $mwebUrl = $wxOrder['mweb_url'] ?? '';
        if (empty($mwebUrl)) {
            \think\facade\Log::error("统一下单失败，参数返回==" . var_export($wxOrder, 1));
            throw new \Exception("统一下单失败,参数返回:" . var_export($wxOrder, 1));
        }

        return $mwebUrl;
    }

    /**
     * 统一下单
     * @param array $order
     * @return string 成功时返回，其他抛异常
     */
    public function unifiedOrder(){
        //②、统一下单
        $config  = $this->_config;
        $payData = $this->_payData;
        $input = new WxPayUnifiedOrder();
        $input->SetBody($payData['body']);
        $input->SetAttach($payData['subject']);
        $input->SetOut_trade_no($payData['order_no']);
        $input->SetTotal_fee($payData['amount']);
        $input->SetTime_expire(date("YmdHis", time() + $payData['timeout_express']));
        $input->SetNotify_url($config['notify_url']);
        $input->SetTrade_type("MWEB");
        $sceneInfo = [
            'h5_info' => [
                'type' => 'Wap', //固定
                'wap_url' => '', //这个是调用此接口的页面url,应该可以忽略
                'wap_name' => '' //网站名字,应该也可以忽略
            ]
        ];
        $scene = json_encode($sceneInfo, JSON_UNESCAPED_UNICODE);
        $input->SetScene_info($scene);
        $wxOrder = WxPayApi::unifiedOrder($this->_config, $input);
        //统一下单返回
        return $wxOrder;
    }
}