<?php

class AppPayHandler {
    protected $aop;

    public function __construct($alipay_config) {
        $aop = new AopClient();
        $aop->gatewayUrl = $alipay_config['gatewayUrl'];
        $aop->appId = $alipay_config['app_id'];
        $aop->rsaPrivateKey = $alipay_config['merchant_private_key'];
        $aop->alipayrsaPublicKey = $alipay_config['alipay_public_key'];
        $aop->apiVersion = '1.0';
        $aop->signType = $alipay_config['sign_type'];
        $aop->postCharset = $alipay_config['charset'];
        $aop->format = 'json';
        $this->aop = $aop;
    }

    /**
     * app请求支付
     * @param $request
     * @return mixed
     */
    public function appPay($request){
        $response = $this->aop->sdkExecute($request);
        \think\facade\Log::error("统一收单返回" . var_export($response, 1));
        return $response;
    }
}