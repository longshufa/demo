<?php

namespace tp51\pay\service\wechat;

class BaseWechat {
    /**
     * 订单信息
     * @var array
     */
    protected $_payData = [];
    protected $_config  = [];

    /**
     * 支付下单  构造函数
     * WechatPay constructor.
     * @param $config
     * @param $payData
     */
    public function __construct($config, $payData=[]) {
        $this->_config  = $config;
        $this->_payData = $payData;
    }
}