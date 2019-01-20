<?php

namespace tp51\pay;

use tp51\pay\config\PayConfig;
use tp51\pay\service\ali\pay\AliOrderQuery;
use tp51\pay\service\wechat\pay\WechatOrderQuery;

class OrderQuery extends BaseDataInit {

    /**
     * 退款
     * @param $params
     * @param bool $originalData  是否原数据返回  返回官方的数据
     * @throws \Exception
     */
    public function orderQuery($params) {
        try {
            //检测数据是否合法
            $this->checkParams($params);

            switch ( $this->_channel ) {
                case PayConfig::CHANNEL_WECHAT_PAY:
                    $chennel = new WechatOrderQuery($this->_config);
                    $returnData = $chennel->orderQuery($params);
                    break;
                case  PayConfig::CHANNEL_ALI_PAY:
                    $chennel = new AliOrderQuery($this->_config);
                    $returnData = $chennel->orderQuery($params);
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
        if(  ( !isset($params['transaction_id']) || !$params["transaction_id"] )  && ( !isset($params['out_trade_no']) || !$params["out_trade_no"] ) ){
            throw new \Exception("传入参数错误，交易单号或商户单号不能同时为空");
        }
    }

}