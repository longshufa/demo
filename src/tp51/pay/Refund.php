<?php

namespace tp51\pay;

use tp51\pay\config\PayConfig;
use tp51\pay\service\ali\refund\AliRefund;
use tp51\pay\service\wechat\refund\WechatRefund;

class Refund extends BaseDataInit {
    /**
     * 退款
     * @param $params
     * @param bool $originalData  是否原数据返回  返回官方的数据
     * @throws \Exception
     * @throws service\ali\refund\Exception
     */
    public function refund($params, $originalData=false) {
        try {
            //检测数据是否合法
            $this->checkParams($params);

            switch ( $this->_channel ) {
                case PayConfig::CHANNEL_WECHAT_PAY:
                    $chennel = new WechatRefund($config);
                    $returnData = $chennel->refund($params, $originalData);
                    break;
                case  PayConfig::CHANNEL_ALI_PAY:
                    $chennel = new AliRefund($config);
                    $returnData = $chennel->refund($params, $originalData);
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
        //金额参数检测
        if( empty($params['total_fee']) || empty($params['refund_fee']) ){
            throw new \Exception("订单金额与退款金额参数不能缺少");
        }

        if( $params["refund_fee"] > $params["total_fee"] ){
            throw new \Exception("退款金额不能大于订单金额");
        }

        if(  ( !isset($params['transaction_id']) && !isset($params['out_trade_no']) ) || (  (isset($params["transaction_id"]) && !$params["transaction_id"] ) && (isset($params["out_trade_no"]) && !$params["out_trade_no"] )
             )
        ){
            throw new \Exception("交易号和商户订单号不能同时为空");
        }
    }
}