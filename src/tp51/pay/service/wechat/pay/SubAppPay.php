<?php

namespace tp51\pay\service\wechat\pay;
use tp51\pay\sdk\wechat\JsApiPay;
use tp51\pay\sdk\wechat\WxPayApi;
use tp51\pay\sdk\wechat\wxPayData\WxPayJsApiPay;
use tp51\pay\sdk\wechat\wxPayData\WxPayUnifiedOrder;
use tp51\pay\service\wechat\BaseWechat;

ini_set('date.timezone','Asia/Shanghai');


//error_reporting(E_ERROR);

class SubAppPay extends BaseWechat {
    /**
     * 获取app调用微信支付需要的参数
     * @param $order array 订单
     * @return array|bool
     * @throws Exception
     */
    public function getParams() {
        $wxOrder = $this->unifiedOrder();
        $prepayId = $wxOrder['prepay_id'] ?? '';
        if (empty($prepayId)) {
            \think\facade\Log::error("统一下单失败，参数返回==" . var_export($wxOrder, 1));
            throw new \Exception("统一下单失败,参数返回:" . var_export($wxOrder, 1));
        }

        $params = array(
            'appid' =>$this->_config['sub_app_id'],
            'noncestr' => WxPayApi::getNonceStr(),
            'package' => 'Sign=WXPay',
            'partnerid' => $this->_config['sub_mch_id'],
            'prepayid' => $prepayId,
            'timestamp' => time(),
        );
        $params['sign'] = self::makeSign($params);

        return $params;
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
        $input->SetTrade_type("APP");
        $wxOrder = WxPayApi::unifiedOrder($this->_config, $input);
        //统一下单返回
        return $wxOrder;
    }

    /**
     * 生成签名(已微信支付的签名格式进行签名)
     * @param $data array 需要签名的数据
     * @return string 返回生成的签名
     */
    public function makeSign($data) {
        //签名步骤一：按字典序排序参数
        ksort($data);
        $buff = "";
        foreach ($data as $k => $v) {
            if ($k != "sign" && $v != "" && !is_array($v)) {
                $buff .= $k . "=" . $v . "&";
            }
        }
        $string = trim($buff, "&");
        //签名步骤二：在string后加入KEY
        $string = $string . "&key=" . $this->_config['key'];
        //签名步骤三：MD5加密
        $string = md5($string);
        //签名步骤四：所有字符转为大写
        $result = strtoupper($string);
        return $result;
    }
}