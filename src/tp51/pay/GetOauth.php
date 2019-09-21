<?php

namespace tp51\pay;

use tp51\pay\config\PayConfig;
use tp51\pay\service\ali\pay\AliOauth;

class GetOauth extends BaseDataInit {
    /**
     * 退款
     * @param $params
     * @return mixed
     * @throws \Exception
     */
    public function getOauthToken($params) {
        try {
            //检测数据是否合法
            $this->checkParams($params);
            switch ( $this->_channel ) {
                case PayConfig::CHANNEL_WECHAT_PAY:
                    break;
                case  PayConfig::CHANNEL_ALI_PAY:
                    $chennel = new AliOauth($this->_config);
                    $returnData = $chennel->getOauthToken($params);
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

    /**
     * 获取授权用户信息
     * @param $params
     * @return bool|mixed|\SimpleXMLElement
     * @throws \Exception
     */
    public function getUserInfo($params){
        try {
            //检测数据是否合法
            if( !isset($params["access_token"]) || (isset($params['access_token']) && !$params['access_token'])){
                throw new \Exception("access_token不能为空" );
            }
            switch ( $this->_channel ) {
                case PayConfig::CHANNEL_WECHAT_PAY:
                    break;
                case  PayConfig::CHANNEL_ALI_PAY:
                    $chennel = new AliOauth($this->_config);
                    $returnData = $chennel->getUserInfo($params);
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

    /**
     * @param $params
     * @throws \Exception
     */
    protected function checkParams($params){
        $token = '';
        $refreshToken  = '';
        if( isset($params['code'])){
            $token = $params['code'];
        }
        if( isset($params["refresh_token"]) ){
            $refreshToken = $params["refresh_token"];
        }
        if( !$token && !$refreshToken ){
            throw new \Exception("code&refresh_token不能同时为空");
        }
    }
}