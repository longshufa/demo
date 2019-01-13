<?php

namespace tp51\pay\service\wechat\pay;

use think\facade\Log;
use tp51\pay\sdk\wechat\WxPayApi;
use tp51\pay\sdk\wechat\wxPayData\WxPayOrderQuery;
use tp51\pay\service\wechat\BaseWechat;

class OrderQuery extends BaseWechat {

    /**
     * 查询订单
     * @param $out_trade_no
     * @param string $transaction_id
     * @return 成功时返回
     */
    public function orderQuery($out_trade_no='', $transaction_id=''){
        if( $out_trade_no == "" && $transaction_id == "" ){
           Log::error("交易订单号或第三方交易订单号不能两个都为空");
        }
        //第三方交易号查询
        if( $transaction_id != ""){
            $input = new WxPayOrderQuery();
            $input->SetTransaction_id($transaction_id);
            $result = WxPayApi::orderQuery($this->_config, $input);
        }
        //商家订单号查询
        if( $out_trade_no != "" ){
            $input = new WxPayOrderQuery();
            $input->SetOut_trade_no($out_trade_no);
            $result =  WxPayApi::orderQuery($this->_config, $input);
        }
        return $result;
    }
}