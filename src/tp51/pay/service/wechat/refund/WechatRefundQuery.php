<?php

namespace tp51\pay\service\wechat\refund;

use tp51\pay\sdk\wechat\WxPayApi;
use tp51\pay\sdk\wechat\wxPayData\WxPayRefundQuery;
use tp51\pay\service\wechat\BaseWechat;

class WechatRefundQuery extends BaseWechat {
    /**
     * 退款操作
     * @param $refundParams  array  需包含(transaction_id | out_trade_no) refund_fee total_fee
     * @param bool $originalData   是否原数据返回  返回官方的数据
     * @return string|成功时返回
     * @throws Exception
     */
    public function refundQuery($params){
        if( isset($params["transaction_id"]) && $params["transaction_id"] ){
            $result =  $this->queryByTransactionId($params["transaction_id"] );
        }else if( isset($params["out_trade_no"]) && $params["out_trade_no"] ){
            $result = $this->queryByOutTradeNo($params["out_trade_no"]);
        }else if( isset($params["out_refund_no"]) && $params["out_refund_no"] ){
            $result = $this->queryByOutRefundNo($params["out_refund_no"]);
        }

        if( $result['result_code'] == 'SUCCESS' && $result['return_code'] == 'SUCCESS' ){
            return $result;
        }else{
            Log::error("退款查询失败" . "\r\n请求参数：" . var_export($params, 1) . "\r\n退款查询返回数据：" .var_export($result, 1) );
            throw new \Exception("退款查询失败原因 : " . $result['err_code_des'] ?? "" );
        }
    }

    /**
     * @param $transactionId 第三方交易号查询
     * @return \tp51\pay\sdk\wechat\成功时返回，其他抛异常
     * @throws \Exception
     * @throws \tp51\pay\sdk\wechat\WxPayException
     */
    protected function queryByTransactionId($transactionId){
        try{
            $input = new WxPayRefundQuery();
            $input->SetTransaction_id($transactionId);
            return WxPayApi::refundQuery($this->_config, $input);
        } catch(\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param $outTradeNo 商户订单号查询
     * @return \tp51\pay\sdk\wechat\成功时返回，其他抛异常
     * @throws \Exception
     * @throws \tp51\pay\sdk\wechat\WxPayException
     */
    protected function queryByOutTradeNo($outTradeNo){
        try{
            $input = new WxPayRefundQuery();
            $input->SetOut_trade_no($outTradeNo);
           return WxPayApi::refundQuery($this->_config,$input);
        } catch(\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * 退款查询
     * @param $outRefundNo 商户退款单号
     * @return \tp51\pay\sdk\wechat\成功时返回，其他抛异常
     * @throws \Exception
     * @throws \tp51\pay\sdk\wechat\WxPayException
     */
    protected function queryByOutRefundNo($outRefundNo){
        try{
            $input = new WxPayRefundQuery();
            $input->SetOut_refund_no($outRefundNo);
            return WxPayApi::refundQuery($this->_config,$input);
        } catch(\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}