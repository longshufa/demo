<?php

namespace tp51\pay\service\wechat\refund;

use think\Exception;
use think\facade\Log;
use tp51\pay\sdk\wechat\WxPayApi;
use tp51\pay\sdk\wechat\wxPayData\WxPayRefund;
use tp51\pay\service\wechat\BaseWechat;

class WechatRefund extends BaseWechat {
    /**
     * 退款操作
     * @param $data array  需包含(transaction_id | out_trade_no) refund_fee total_fee
     * @return 成功时返回|bool
     * @throws \Exception
     */
    public function refund($data) {
        Log::error("微信支付开始退款》》》》》》》》》》》》》》" . "传进来参数为:>>>>>>" . var_export($data, 1));
        if( empty($data['total_fee']) || empty($data['refund_fee']) ){
            throw new \Exception("参数不正确", 10001);
        }

        if( isset($data['transaction_id']) && $data['transaction_id'] ){
            $result = $this->refundByTransactionId($data);
        }elseif (isset($data['out_trade_no']) && $data['out_trade_no']){
            $result =  $this->refundByOutTradeNo($data);
        }
        if( $result['result_code'] == 'SUCCESS' && $result['return_code'] == 'SUCCESS' ){
            return $result;
        }else{
            Log::error("退款失败" . "\r\n退款参数：" . var_export($data, 1) . "\r\n退款返回数据：" .var_export($result, 1) );
            throw new Exception("退款失败原因 : " . $result['err_code_des'] ?? "" );
            return false;
        }
    }

    /**
     * @param $data
     * @return string \成功时返回，其他抛异常
     */
    private  function refundByTransactionId($data){
        $transaction_id = $data["transaction_id"];
        $total_fee = $data["total_fee"];
        $refund_fee = $data["refund_fee"];
        $input = new WxPayRefund();
        $input->SetTransaction_id($transaction_id);
        $input->SetTotal_fee($total_fee);
        $input->SetRefund_fee($refund_fee);
        $input->SetOut_refund_no($this->_config['mch_id'] . date("YmdHis"));
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
        $input = new WxPayRefund();
        $input->SetOut_trade_no($out_trade_no);
        $input->SetTotal_fee($total_fee);
        $input->SetRefund_fee($refund_fee);
        $input->SetOut_refund_no($this->_config['mch_id'] . date("YmdHis"));
        $input->SetOp_user_id($this->_config['mch_id']);
        return WxPayApi::refund($this->_config, $input);
    }

}