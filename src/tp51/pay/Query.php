<?php

namespace tp51\pay;

use tp51\pay\config\PayConfig;
use tp51\pay\service\ali\pay\AliQuery;

class Query extends BaseDataInit {
    /**
     * 查询余额
     * @param $params
     * @param bool $originalData  是否原数据返回  返回官方的数据
     * @throws \Exception
     */
    public function queryBalance($params) {
        try {
            //检测数据是否合法
            $this->checkParams($params);
            switch ( $this->_channel ) {
                case PayConfig::CHANNEL_WECHAT_PAY:
                    break;
                case  PayConfig::CHANNEL_ALI_PAY:
                    $chennel = new AliQuery($this->_config);
                    $returnData = $chennel->queryBalance($params);
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
        if ( !$params["alipay_user_id"] ) {
            throw new \Exception("蚂蚁统一会员ID必填");
        }
    }
}