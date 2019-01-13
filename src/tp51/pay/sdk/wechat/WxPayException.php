<?php
/**
 * 
 * 微信支付API异常类
 * @author widyhu
 *
 */
namespace tp51\pay\sdk\wechat;

class WxPayException extends \Exception {
	public function errorMessage()
	{
		return $this->getMessage();
	}
}
