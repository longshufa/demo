<?php

namespace tp51\pay\service\ali\pay;

use tp51\pay\sdk\ali\pagepay\buildermodel\AlipayTradePagePayContentBuilder;
use tp51\pay\sdk\ali\pagepay\service\AlipayTradeService;
use tp51\pay\service\ali\BaseAli;

class AliWebPay extends BaseAli {
    /**
     * @param $out_trade_no  string //商户订单号，商户网站订单系统中唯一订单号，必填
     * @param $subject  string //订单名称，必填
     * @param $total_amount double 单位元 精确到后两位
     * @param string $body string 商品描述，可空
     * @throws Exception
     */
    public function pagePay(){
        //构造参数
        $payRequestBuilder = new AlipayTradePagePayContentBuilder();
        $payRequestBuilder->setBody($this->_payData["body"]);
        $payRequestBuilder->setSubject($this->_payData["subject"]);
        $payRequestBuilder->setTotalAmount($this->_payData["amount"]);
        $payRequestBuilder->setOutTradeNo($this->_payData["order_no"]);

        $aop = new AlipayTradeService($this->_config);

        /**
         * pagePay 电脑网站支付请求
         * @param $builder object 业务参数，使用buildmodel中的对象生成。
         * @param $return_url string 同步跳转地址，公网可以访问
         * @param $notify_url string 异步通知地址，公网可以访问
         * @return $response 支付宝返回的信息
         */
        $response = $aop->pagePay($payRequestBuilder,$this->_config['return_url'],$this->_config['notify_url']);
    }
}