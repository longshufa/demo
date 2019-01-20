<?php

namespace tp51\pay;

use tp51\pay\config\PayConfig;
use tp51\pay\service\ali\refund\AliRefundQuery;
use tp51\pay\service\wechat\refund\WechatRefundQuery;

class RefundQuery extends BaseDataInit {

    /**
     * 退款
     * @param $params
     * @param bool $originalData  是否原数据返回  返回官方的数据
     * @throws \Exception
     */
    public function refundQuery($params) {
        try {
            //检测数据是否合法
            $this->checkParams($params);

            switch ( $this->_channel ) {
                case PayConfig::CHANNEL_WECHAT_PAY:
                    $chennel = new WechatRefundQuery($this->_config);
                    $returnData = $chennel->refundQuery($params);
                    break;
                case  PayConfig::CHANNEL_ALI_PAY:
                    $chennel = new AliRefundQuery($this->_config);
                    $returnData = $chennel->refundQuery($params);
                    break;

                /********************** end 支付宝支付 ********************************/
                default:
                    throw new \Exception('当前仅支持：支付宝  微信');
                    break;
            }

            return $returnData;
        }catch (\Exception $e){
            throw new \Exception("发生异常了~异常信息=>>>>>" . $e->getMessage() );
        }
    }

    protected function checkParams($params){
        if( $this->_channel == PayConfig::CHANNEL_ALI_PAY ){
            if( !isset($params["out_refund_no"])  || $params["out_refund_no"] ){
                throw new \Exception("支付宝查询，退款单号必传");
            }

            if(  ( !isset($params['transaction_id']) && !isset($params['out_trade_no']) ) || (  (isset($params["transaction_id"]) && !$params["transaction_id"] ) && (isset($params["out_trade_no"]) && !$params["out_trade_no"] )
                )
            ){
                throw new \Exception("支付宝交易号和商户订单号不能同时为空");
            }
        }else{
            if(  !isset($params['transaction_id']) || !isset($params['out_trade_no']) ||  !isset($params["out_refund_no"]) || ( !$params["transaction_id"] && !$params['out_trade_no'] && !$params["out_refund_no"] ) ){
                throw new \Exception("传入参数错误，交易单号或商户单号或商户退款单号不能同时为空");
            }
        }
    }
}