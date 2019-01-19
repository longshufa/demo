<?php

namespace tp51\pay;

use tp51\pay\config\PayConfig;
use tp51\pay\sdk\ali\pagepay\service\AlipayTradeService;

class Notify extends BaseDataInit {

    /**
     * 回调验签 验签正确返回 true 验签失败 返回false
     * @param $notifyData
     * @return bool|string
     */
    public function checkSign($notifyData){
        if( $this->_channel == PayConfig::CHANNEL_ALI_PAY ){
            $result = $this->aliCheckSign($notifyData);
        }else{
            $result = $this->wxCheckSign($notifyData);
        }
        return $result;
    }

    /**
     * 微信验证签名
     * @param $notifyData
     * @return string
     */
    protected function wxCheckSign($notifyData){
        //签名步骤一：按字典序排序参数
        ksort($notifyData);
        $buff = "";
        foreach ($notifyData as $k => $v)
        {
            if($k != "sign" && $v != "" && !is_array($v)){
                $buff .= $k . "=" . $v . "&";
            }
        }
        $buff = trim($buff, "&");
        //签名步骤二：在string后加入KEY
        $string = $buff . "&key=".$this->_config["key"];
        //签名步骤三：MD5加密
        $string = md5($string);
        //签名步骤四：所有字符转为大写
        $sign = strtoupper($string);
        if( $sign != $notifyData["sign"] ){ //验签失败
            return false;
        }
        return true;
    }

    protected function aliCheckSign($notifyData){
        $AlipayService = new AlipayTradeService($this->_config);
        $result = $AlipayService->check($notifyData);
        if( !$result ){ //验签失败
            return false;
        }
        return true;
    }
    /**
     * @param $message
     * @return string
     * @throws \Exception
     */
    public function responseNotifyResult($message){
        $message = strtolower($message);
        if( !in_array($message, ["success", "fail"])){
            throw new \Exception("传值3不正确");
        }
        if( $this->_channel == PayConfig::CHANNEL_ALI_PAY ){
            $string = $this->responseAliNotifyResult($message);
        }else{
            $string = $this->responseWxNotifyResult($message);
        }
        return $string;
    }
    /**
     * 返回支付宝参数
     * @param $type
     * @return string
     */
    protected function responseAliNotifyResult($message){
        return strtolower($message);
    }

    /**
     * 返回微信参数
     * @param $type
     * @return string
     */
    protected function responseWxNotifyResult($message){
        $msg = strtoupper($message);
        return "<xml><return_code><![CDATA[" . $msg . "]]></return_code><return_msg><![CDATA[OK]]></return_msg></xml>";
    }
}