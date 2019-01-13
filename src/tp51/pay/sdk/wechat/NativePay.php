<?php
namespace tp51\pay\sdk\wechat;

use tp51\pay\sdk\wechat\wxPayData\WxPayBizPayUrl;

/**
 * 
 * 刷卡支付实现类
 * @author widyhu
 *
 */
class NativePay
{
    /**
     *
     * 生成扫描支付URL,模式一
     * @param $productId
     * @return string
     * @internal param BizPayUrlInput $bizUrlInfo
     */
	public function GetPrePayUrl($config,$productId)
	{
		$biz = new WxPayBizPayUrl();
		$biz->SetProduct_id($productId);
		$values = WxPayApi::bizpayurl($config, $biz);
		$url = "weixin://wxpay/bizpayurl?" . $this->ToUrlParams($values);
		return $url;
	}

    /**
     *
     * 参数数组转换为url参数
     * @param array $urlObj
     * @return string
     */
	private function ToUrlParams($urlObj)
	{
		$buff = "";
		foreach ($urlObj as $k => $v)
		{
			$buff .= $k . "=" . $v . "&";
		}
		
		$buff = trim($buff, "&");
		return $buff;
	}

    /**
     *
     * 生成直接支付url，支付url有效期为2小时,模式二
     * @param UnifiedOrderInput $input
     * @return 成功时返回
     */
	public function GetPayUrl($input)
	{
		if($input->GetTrade_type() == "NATIVE")
		{
			$result = WxPayApi::unifiedOrder($input);
			return $result;
		}
	}
}