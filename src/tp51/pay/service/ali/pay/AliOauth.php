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
        $response = $this->aop->execute($request);
        $resultObj = $response->alipay_system_oauth_token_response;
        return [
            'user_id'     => $resultObj->user_id,
            'access_token' => $resultObj->access_token,
            'expires_in'   => $resultObj->expires_in,
            'refresh_token'   => $resultObj->refresh_token,
            're_expires_in'   => $resultObj->re_expires_in,
        ];
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
        $result = $response->alipay_user_info_share_response;
        if( isset($result->code) && $result->code == 10000){
            $data = [
                'avatar' => $result->avatar,
                'city'   => $result->city,
                'user_id' => $result->user_id,
                'user_type' => $result->user_type,
                'is_certified' => $result->is_certified,
                'province' => $result->province,
                'is_student_certified' => $result->is_student_certified,
                'user_status' => $result->user_status,
                'city' => $result->city,
            ];
            return  $data;
        }
    }
}