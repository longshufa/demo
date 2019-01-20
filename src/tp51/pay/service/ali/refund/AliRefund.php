<?php

namespace tp51\pay\service\ali\refund;

use tp51\pay\sdk\ali\pagepay\buildermodel\AlipayTradeQueryContentBuilder;
use tp51\pay\sdk\ali\pagepay\buildermodel\AlipayTradeRefundContentBuilder;
use tp51\pay\sdk\ali\pagepay\service\AlipayTradeService;
use tp51\pay\service\ali\BaseAli;
use tp51\pay\service\ToolService;

class AliRefund extends BaseAli {

    /***
     * ALI退款
     * @param $params  array  需包含(transaction_id | out_trade_no) refund_fee total_fee
     * @param bool $originalData  是否原数据返回  返回官方的数据
     * @return bool|mixed|\SimpleXMLElement|string|\tp51\pay\sdk\ali\aop\提交表单HTML文本
     */
    public function refund($params, $originalData=false){
        //构造参数
        $RequestBuilder=new AlipayTradeRefundContentBuilder();
        if ( isset($params['transaction_id']) ) { //支付宝交易号
            $trade_no = trim($params['transaction_id']);
            $RequestBuilder->setTradeNo($trade_no);
        }

        if( isset($params["out_trade_no"]) ){  //商户订单号，商户网站订单系统中唯一订单号
            $out_trade_no = trim($params['out_trade_no']);
            $RequestBuilder->setOutTradeNo($out_trade_no);
        }

        //需要退款的金额，该金额不能大于订单金额，必填
        $refund_amount = trim($params['refund_fee'])/100;
        $out_refund_no    =$params['out_refund_no'];
        $RequestBuilder->setRefundAmount($refund_amount);
        $RequestBuilder->setOutRequestNo($out_refund_no);
        $aop = new AlipayTradeService($this->_config);
        /**
         * alipay.trade.refund (统一收单交易退款接口)
         * @param $builder object 业务参数，使用buildmodel中的对象生成。
         * @return $response 支付宝返回的信息
         */
        $response = $aop->Refund($RequestBuilder);
        if( $response->code != '10000' ){
            if( property_exists($aop, "sub_msg") ){
                throw new \Exception($response->sub_msg);
            }else{
                throw new \Exception($response->msg);
            }
        }else{
            return $this->dealReturnData($response, $out_refund_no, $originalData);
        }

    }

    protected function dealReturnData($response, $outRefundNo, $originalData=false){
        if( $originalData ){
            $returnData = [
                'out_refund_no'  => $outRefundNo, //商户退款单号
                'transaction_id' => $response->trade_no,//第三方交易订单号
                'out_trade_no'   => $response->out_trade_no, //商户订单号
                "refund_fee"     => $response->refund_fee*100, //退款金额
            ];
            return $returnData;
        }else{
            return $response;
        }
    }

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