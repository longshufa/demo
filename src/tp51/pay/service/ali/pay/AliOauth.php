<?php

namespace tp51\pay\service\ali\pay;

use tp51\pay\sdk\ali\aop\request\AlipaySystemOauthTokenRequest;
use tp51\pay\sdk\ali\aop\request\AlipayUserInfoShareRequest;
use tp51\pay\service\ali\BaseAli;

class AliOauth extends BaseAli {
    /**
     * app请求支付
     * @param $params
     * @return mixed
     */
    public function getOauthToken($params){
        $request = new AlipaySystemOauthTokenRequest();
        $token = '';
        $refreshToken  = '';
        if( isset($params['code'])){
            $token = $params['code'];
        }
        if( isset($params["refresh_token"]) ){
            $refreshToken = $params["refresh_token"];
        }

        if( $token ){
            $request->setGrantType('authorization_code');
            $request->setCode($token);
        }

        if( $refreshToken ){
            $request->setGrantType('refresh_token');
            $request->setRefreshToken($refreshToken);
        }

        //这里和普通的接口调用不同，使用的是sdkExecute
        $response = $this->aop->sdkExecute($request);
        return $response;
    }

    /**
     * 获取支付宝用户授权信息
     * @param $params
     * @return bool|mixed|\SimpleXMLElement
     */
    public function getUserInfo($params){
        $accessToken = $params['access_token'];
        $request = new AlipayUserInfoShareRequest();
        $response = $this->aop->execute ($request , $accessToken);
        return $response;

    }
}