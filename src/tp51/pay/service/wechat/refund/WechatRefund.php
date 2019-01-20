<?php

namespace tp51\pay\service\wechat\refund;

use think\Exception;
use think\facade\Log;
use tp51\pay\sdk\wechat\WxPayApi;
use tp51\pay\sdk\wechat\wxPayData\WxPayRefund;
use tp51\pay\service\ToolService;
use tp51\pay\service\wechat\BaseWechat;

class WechatRefund extends BaseWechat {

    /**
     * 退款操作
     * @param $refundParams  array  需包含(transaction_id | out_trade_no) refund_fee total_fee
     * @param bool $originalData   是否原数据返回  返回官方的数据
     * @return string|成功时返回
     * @throws Exception
     */
    public function refund($refundParams, $originalData=false) {
        Log::error("微信支付开始退款》》》》》》》》》》》》》》" . "传进来参数为:>>>>>>" . var_export($refundParams, 1));
        if( isset($refundParams['transaction_id']) && $refundParams['transaction_id'] ){
            $result = $this->refundByTransactionId($refundParams);
        }elseif (isset($refundParams['out_trade_no']) && $refundParams['out_trade_no']){
            $result =  $this->refundByOutTradeNo($refundParams);
        }
        if( $result['result_code'] == 'SUCCESS' && $result['return_code'] == 'SUCCESS' ){
            return $this->dealReturnData($result, $originalData);
        }else{
            Log::error("退款失败" . "\r\n退款参数：" . var_export($refundParams, 1) . "\r\n退款返回数据：" .var_export($result, 1) );
            throw new \Exception("退款失败原因 : " . $result['err_code_des'] ?? "" );
        }
    }

    /**
     * 处理退款数据返回
     * @param $result
     * @param bool $originalData
     * @return array
     */
    protected function dealReturnData($result, $originalData=false){
        if( $originalData ){
            return $result;
        }else{
            $returnData = [
                'out_refund_no'  => $result['out_refund_no'], //商户退款单号
                'transaction_id' => $result['transaction_id'],//第三方交易订单号
                'out_trade_no'   => $result['out_trade_no'], //商户订单号
                "refund_fee"     => $result["refund_fee"], //退款金额
            ];
            return $returnData;
        }
    }

    /**
     * @param $data
     * @return string \成功时返回，其他抛异常
     */
    private  function refundByTransactionId($data){
        $transaction_id = $data["transaction_id"];
        $total_fee      = $data["total_fee"];
        $refund_fee     = $data["refund_fee"];
        $out_refund_no  = $data['out_refund_no'] ;
        $input = new WxPayRefund();
        $input->SetTransaction_id($transaction_id);
        $input->SetTotal_fee($total_fee);
        $input->SetRefund_fee($refund_fee);
        $input->SetOut_refund_no($out_refund_no);
        $input->SetOp_user_id($this->_config['mch_id']);
        return WxPayApi::refund($this->_config, $input);
    }


    /**
     * @param $data
     * @return 成功时返回
     */
    private  function refundByOutTradeNo($data){
        $out_trade_no = $data["out_trade_no"];
        $total_fee = $data["total_fee"];
        $refund_fee = $data["refund_fee"];
        $out_refund_no = $data['out_refund_no'];
        $input = new WxPayRefund();
        $input->SetOut_trade_no($out_trade_no);
        $input->SetTotal_fee($total_fee);
        $input->SetRefund_fee($refund_fee);
        $input->SetOut_refund_no( $out_refund_no );
        $input->SetOp_user_id($this->_config['mch_id']);
        return WxPayApi::refund($this->_config, $input);
    }

}