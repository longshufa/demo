<?php

namespace tp51\pay\service\ali\refund;

use tp51\pay\sdk\ali\pagepay\buildermodel\AlipayTradeFastpayRefundQueryContentBuilder;
use tp51\pay\sdk\ali\pagepay\service\AlipayTradeService;
use tp51\pay\service\ali\BaseAli;

class AliRefundQuery extends BaseAli {
    /**
     * 查询退款  //请二选一设置
     * @param $data
     * @return bool|mixed|SimpleXMLElement|string 提交表单HTML文本
     * @internal param string $out_trade_no //商户订单号，商户网站订单系统中唯一订单号
     * @internal param string $transaction_id //支付宝交易号
     * @internal param string $refund_no //请求退款接口时，传入的退款请求号，如果在退款请求时未传入，则该值为创建交易时的外部交易号，必填
     * @throws Exception
     */
    public function refundQuery($data){
        //请二选一设置
        //构造参数
        $RequestBuilder=new AlipayTradeFastpayRefundQueryContentBuilder();
        if ( isset($params['transaction_id']) ) { //支付宝交易号
            $trade_no = trim($params['transaction_id']);
            $RequestBuilder->setTradeNo($trade_no);
        }

        if( isset($params["out_trade_no"]) ){  //商户订单号，商户网站订单系统中唯一订单号
            $out_trade_no = trim($params['out_trade_no']);
            $RequestBuilder->setOutTradeNo($out_trade_no);
        }
        //请求退款接口时，传入的退款请求号，如果在退款请求时未传入，则该值为创建交易时的外部交易号，必填
        $out_request_no = trim($data['out_refund_no']);

        $RequestBuilder->setOutRequestNo($out_request_no);
        $aop = new AlipayTradeService($this->_config);
        /**
         * 退款查询   alipay.trade.fastpay.refund.query (统一收单交易退款查询)
         * @param $builder object 业务参数，使用buildmodel中的对象生成。
         * @return $response 支付宝返回的信息
         */
        $response = $aop->refundQuery($RequestBuilder);
        return $response;
    }
}