<?php

namespace tp51\pay\sdk\wechat\wxPayData;
use tp51\pay\sdk\wechat\WxPayException;

/**
 *
 * 接口调用结果类
 * @author widyhu
 *
 */
class WxPayResults extends WxPayDataBase
{
    /**
     *
     * 检测签名
     */
    public function CheckSign($config)
    {
        //fix异常
        if(!$this->IsSignSet()){
            throw new WxPayException("签名错误！");
        }

        $sign = $this->MakeSign($config);
        if($this->GetSign() == $sign){
            return true;
        }
        throw new WxPayException("签名错误！");
    }

    /**
     *
     * 使用数组初始化
     * @param array $array
     */
    public function FromArray($array)
    {
        $this->values = $array;
    }

    /**
     *
     * 使用数组初始化对象
     * @param array $array
     * @param 是否检测签名 $noCheckSign
     * @return WxPayResults
     */
    public static function InitFromArray($array, $noCheckSign = false)
    {
        $obj = new self();
        $obj->FromArray($array);
        if($noCheckSign == false){
            $obj->CheckSign($config);
        }
        return $obj;
    }

    /**
     *
     * 设置参数
     * @param string $key
     * @param string $value
     */
    public function SetData($key, $value)
    {
        $this->values[$key] = $value;
    }

    /**
     * 将xml转为array
     * @param string $xml
     * @throws WxPayException
     */
    public static function Init($config,$xml)
    {
        $obj = new self();
        $obj->FromXml($xml);

        $arrayData = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);

        if($arrayData["return_code"] == "FAIL"){
            throw new WxPayException($arrayData["return_msg"]);
        }else{
			if( $arrayData["result_code"] == "FAIL"){
				throw new WxPayException("code:".$arrayData["err_code"] . $arrayData["err_code_des"]);
			}
		}

        //fix bug 2015-06-29
        if($obj->values['mch_id']){
            return $obj->GetValues();
        }
        $obj->CheckSign($config);
        return $obj->GetValues();
    }
}