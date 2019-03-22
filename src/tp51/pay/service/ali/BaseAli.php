<?php

namespace tp51\pay\service\ali;

use tp51\pay\sdk\ali\aop\AopClient;

class BaseAli {
    /**
     * 订单信息
     * @var array
     */
    protected $_payData = [];
    protected $_config  = [];
    protected $aop;

    /**
     * 支付下单  构造函数
     * WechatPay constructor.
     * @param $config
     * @param $payData
     */
    public function __construct($config, $payData=[]) {
        $aop = new AopClient();
        $aop->gatewayUrl = $config['gatewayUrl'];
        $aop->appId = $config['app_id'];
        $aop->rsaPrivateKey = $config['merchant_private_key'];
        $aop->alipayrsaPublicKey = $config['alipay_public_key'];
        $aop->apiVersion = '1.0';
        $aop->signType = $config['sign_type'];
        $aop->postCharset = $config['charset'];
        $aop->format = 'json';
        $this->aop = $aop;
        if( $payData ){ //支付宝金额 单位：元
            $payData["total_amount"] = $payData["amount"] / 100;
            unset($payData['amount']);
            $payData["out_trade_no"] = $payData["order_no"];
            unset($payData["order_no"]);
            if( !$payData['subject'] ){
                $payData["subject"] = $payData["body"];
            }
        }
        $this->_payData = $payData;
        $this->_config = $config;
    }
}