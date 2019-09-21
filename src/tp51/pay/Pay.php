<?php

namespace tp51\pay;

use think\Exception;
use tp51\pay\config\PayConfig;
use tp51\pay\sdk\ali\pagepay\service\AlipayTradeService;
use tp51\pay\sdk\wechat\WxPayException;
use tp51\pay\service\ali\pay\AliAppPay;
use tp51\pay\service\ali\pay\AliWebPay;
use tp51\pay\service\ToolService;
use tp51\pay\service\wechat\pay\AppPay;
use tp51\pay\service\wechat\pay\PubAndMiniPay;
use tp51\pay\service\wechat\pay\QrCodePay;
use tp51\pay\service\wechat\pay\SubPubAndMiniPay;
use tp51\pay\service\wechat\pay\WechatPay;
use tp51\pay\service\wechat\refund\WechatRefund;

class Pay extends BaseDataInit {

    /**
     * 支付入口
     * @param $payData
     * @return array|bool|string
     * @throws \Exception
     */
    public function pay($payData) {
        try{
            switch ( $this->_payType ){
                /******************** start 微信支付 ***************************/
                case PayConfig::WX_QRCODE:
                    $channel = new QrCodePay($this->_config, $payData);
                    return $channel->getPrePayUrl();
                    break;
                case PayConfig::WX_APP:
                    $channel = new AppPay($this->_config, $payData);
                    break;
                case PayConfig::WX_MINI: //小程序 与 公众号 统一下单 一样
                case PayConfig::WX_PUB:
                    $channel = new PubAndMiniPay($this->_config, $payData);
                    break;

                /**********************服务商版*****************************/
                case PayConfig::SUB_WX_QRCODE:
                    break;
                case PayConfig::SUB_WX_APP:
                    break;
                case PayConfig::SUB_WX_MINI: //小程序 与 公众号 统一下单 一样
                case PayConfig::SUB_WX_PUB:
                    $channel = new SubPubAndMiniPay($this->_config, $payData);
                    break;

                case PayConfig::WX_BAR:
                case PayConfig::WX_WAP:
                case PayConfig::SUB_WX_WAP:
                    throw new \Exception(' 微信 暂不支持 刷卡支付&wap支付');
                    break;
               /********************** end 微信支付 ********************************/


               /********************** start 支付宝支付 *****************************/
                case PayConfig::ALI_APP:
                    $channel = new AliAppPay($this->_config, $payData);
                    break;
                case PayConfig::ALI_WEB:
                    $channel = new AliWebPay($this->_config, $payData);
                    $channel->pagePay();
                    return;
                    break;

               /********************** end 支付宝支付 ********************************/
                default:
                    throw new \Exception('当前仅支持：支付宝  微信');
                    break;
            }

            $params = $channel->getParams();
            return $params;

        }catch (\Exception $e){
            throw new \Exception("发生异常了~异常信息=>>>>>" . $e->getMessage() );
        }
    }

    /**
     * 手动设置回调地址
     * @param $value
     */
    public function setNotifyUrl($value){
        if( !ToolService::checkUrl($value) ){
            throw new \Exception("地址格式错误");
        }
        $this->_config["notify_url"] = $value;
    }

    /**
     * 微信扫码支付  微信回调URL 需要再微信
     * 详情查看微信官方文档  https://pay.weixin.qq.com/wiki/doc/api/native.php?chapter=6_3
     */
    public function QrCodecallBack(){
        $channel = new QrCodePay($this->_config);
        $channel->callBack();
    }
}