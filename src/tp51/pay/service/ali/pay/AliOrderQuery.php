<?php

namespace tp51\pay\service\ali\pay;

class AliOrderQuery {
    /**
     * //请二选一设置
     * @param $out_trade_no //商户订单号，商户网站订单系统中唯一订单号
     * @param $transaction_id //支付宝交易号
     * @return bool|mixed|SimpleXMLElement|SimpleXMLElement[]|string 提交表单HTML文本
     * @throws Exception
     */
    public function queryOrder($out_trade_no, $transaction_id){
        //构造参数
        $RequestBuilder = new AlipayTradeQueryContentBuilder();
        $RequestBuilder->setOutTradeNo($out_trade_no);
        $RequestBuilder->setTradeNo($transaction_id);
        $config = config('pay.ali_pay');
        $aop = new AlipayTradeService($config);

        /**
         * alipay.trade.query (统一收单线下交易查询)
         * @param $builder 业务参数，使用buildmodel中的对象生成。
         * @return $response 支付宝返回的信息
         */
        $response = $aop->Query($RequestBuilder);
        return $response;
    }
}