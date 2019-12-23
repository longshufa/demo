<?php

namespace tp51\pay;

use tp51\pay\config\PayConfig;
use tp51\pay\service\ali\pay\AliTransfer;

class ToAccountTransfer extends BaseDataInit {
    /**
     * 转账
     * @param $params
     * @param bool $originalData  是否原数据返回  返回官方的数据
     * @throws \Exception
     */
    public function toAccountTransfer($params) {
        try {
            //检测数据是否合法
            $this->checkParams($params);
            switch ( $this->_channel ) {
                case PayConfig::CHANNEL_WECHAT_PAY:
                    break;
                case  PayConfig::CHANNEL_ALI_PAY:
                    $chennel = new AliTransfer($this->_config);
                    $returnData = $chennel->toAccountTransfer($params);
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

    /***
     * 查询转账订单
     * @param $params
     * @return array
     * @throws \Exception
     */
    public function query($params){
        try {
            //检测数据是否合法
            $this->checkQueryParams($params);
            switch ( $this->_channel ) {
                case PayConfig::CHANNEL_WECHAT_PAY:
                    break;
                case  PayConfig::CHANNEL_ALI_PAY:
                    $chennel = new AliTransfer($this->_config);
                    $returnData = $chennel->query($params);
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

    protected function checkQueryParams($params){
        if ( !$params["out_trade_no"] && !$params['transaction_id'] ) {
            throw new \Exception("商户转账订单号，支付宝转账单据号不能同时为空");
        }
    }

    protected function checkParams($params){
        if ( !$params["out_trade_no"] ) {
            throw new \Exception("商户转账订单号必填");
        }

        if( !$params["payee_account"]){
            throw new \Exception("收款方账户必填");
        }

        if( $params["amount"] < 10  ){
            throw new \Exception("转账金额必须大于等于0.1元");
        }
    }
}