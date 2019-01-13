<?php

namespace tp51\pay\service\ali\pay;

use tp51\pay\sdk\ali\aop\request\AlipayTradeAppPayRequest;
use tp51\pay\service\ali\BaseAli;

class AliAppPay  extends BaseAli {
    /**
     * app请求支付
    ];
     * @param $request
     * @return mixed
     */
    public function getParams(){
        $request = new AlipayTradeAppPayRequest();
        $this->_payData["product_code"] = "QUICK_MSECURITY_PAY";
        $bizcontent = json_encode($this->_payData, JSON_UNESCAPED_UNICODE);
        $request->setNotifyUrl($this->_config['notify_url']);
        $request->setBizContent($bizcontent);
        //这里和普通的接口调用不同，使用的是sdkExecute
        $response = $this->aop->sdkExecute($request);
        return $response;
    }
}