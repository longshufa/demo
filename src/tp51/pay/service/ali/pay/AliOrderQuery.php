<?php

namespace tp51\pay\service\ali\pay;

use tp51\pay\sdk\ali\pagepay\buildermodel\AlipayTradeQueryContentBuilder;
use tp51\pay\sdk\ali\pagepay\service\AlipayTradeService;
use tp51\pay\service\ali\BaseAli;

class AliOrderQuery extends BaseAli {
    /**
     * //请二选一设置
     * @param $out_trade_no //商户订单号，商户网站订单系统中唯一订单号
     * @param $transaction_id //支付宝交易号
     * @return bool|mixed|SimpleXMLElement|SimpleXMLElement[]|string 提交表单HTML文本
     * @throws Exception
     */
    public function orderQuery($params){
        //构造参数
        $RequestBuilder = new AlipayTradeQueryContentBuilder();
        if( isset($params["transaction_id"]) && $params["transaction_id"] ){
            $RequestBuilder->setTradeNo($params["transaction_id"] );
        }elseif (isset($params["out_trade_no"]) && $params["out_trade_no"]){
            $RequestBuilder->setOutTradeNo($params["out_trade_no"]);
        }
        $aop = new AlipayTradeService($this->_config);
        /**
         * alipay.trade.query (统一收单线下交易查询)
         * @param $builder 业务参数，使用buildmodel中的对象生成。
         * @return $response 支付宝返回的信息
         */
        $response = $aop->Query($RequestBuilder);
        return $response;
    }
}