<?php

namespace tp51\pay\service\wechat\pay;

use think\facade\Log;
use tp51\pay\sdk\wechat\WxPayApi;
use tp51\pay\sdk\wechat\wxPayData\WxPayOrderQuery;
use tp51\pay\service\wechat\BaseWechat;

class WechatOrderQuery extends BaseWechat {

    /**
     * 查询订单
     * @param $out_trade_no
     * @param string $transaction_id
     * @return 成功时返回
     */
    public function orderQuery($params){
        //第三方交易号查询
        if( isset($params["transaction_id"]) && $params["transaction_id"] ){
            $input = new WxPayOrderQuery();
            $input->SetTransaction_id( $params["transaction_id"]);
            return WxPayApi::orderQuery($this->_config, $input);
        }
        //商家订单号查询
        if( isset($params["out_trade_no"]) && $params["out_trade_no"] ){
            $input = new WxPayOrderQuery();
            $input->SetOut_trade_no($params["out_trade_no"]);
            return WxPayApi::orderQuery($this->_config, $input);
        }
    }
}