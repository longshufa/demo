<?php

namespace tp51\pay\service\wechat\pay;

use tp51\pay\sdk\wechat\JsApiPay;
use tp51\pay\sdk\wechat\WxPayApi;
use tp51\pay\sdk\wechat\wxPayData\WxPayUnifiedOrder;
use tp51\pay\service\wechat\BaseWechat;

class SubPubAndMiniPay extends BaseWechat {
    /**
     * 获取小程序调起支付的参数
     * @param $order
     * @param $openId
     * @return string json数据，可直接填入js函数作为参数
     */
    public function getParams(){
        $wxOrder = $this->unifiedOrder();
        $tool =     new JsApiPay();
        $wxParams = $tool->GetJsApiParameters($this->_config, $wxOrder);

        return $wxParams;
    }

    /**
     * 统一下单
     * @param array $order
     * @param $openId
     * @return string 成功时返回，其他抛异常
     */
    public function unifiedOrder(){
        //②、统一下单
        $config  = $this->_config;
        $payData = $this->_payData;
        /**
         * $input WxPayUnifiedOrder
         */
        $input = new WxPayUnifiedOrder();
        $input->SetBody($payData['body']);
        $input->SetOut_trade_no($payData['order_no']);
        $input->SetTotal_fee($payData['amount']);
        $input->SetTime_expire(date("YmdHis", time() + $payData['timeout_express']));
        $input->SetNotify_url($config['notify_url']);
        $input->SetTrade_type("JSAPI");
        if( isset($payData["openid"]) && $payData["openid"] ){
            $input->SetOpenid($payData['openid']);
        }
        if( isset($payData["sub_openid"]) ){
            $input->SetSubOpenid($payData['sub_openid']);
        }
        $wxOrder = WxPayApi::unifiedOrder($config, $input );
        //统一下单返回
        return $wxOrder;
    }
}