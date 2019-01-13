<?php

namespace tp51\pay;

use tp51\pay\config\PayConfig;
use tp51\pay\service\ali\pay\AliAppPay;
use tp51\pay\service\ali\pay\AliWebPay;
use tp51\pay\service\wechat\pay\AppPay;
use tp51\pay\service\wechat\pay\PubAndMiniPay;
use tp51\pay\service\wechat\pay\QrCodePay;
use tp51\pay\service\wechat\pay\WechatPay;
use tp51\pay\service\wechat\refund\WechatRefund;

class Pay {

    /**
     * 版本号
     * @var string
     */
    private $version = "1.0.0";

    /**
     * 初始化配置信息
     * @var array
     */
    private $_config  = [];

    /**
     * 具体业务 配置信息
     * @var array
     */
    private $_payTypeConfig = [];

    /**
     * 支付渠道
     * @var string
     */
    private $_channel = '';

    /**
     * 支付类型
     * @var string
     */
    private $_payType = '';

    /**
     * 支付宝配置信息
     * @var array
     */
    private $_ali_config = [
        'app_id'               =>  '', //应用ID,您的APPID。
        'merchant_private_key' =>  '', //商户私钥
        'notify_url'           =>  '', //异步通知地址
        'return_url'           =>  '',  //同步跳转
        'charset'              =>  '', //编码格式
        'sign_type'            =>  '', //签名方式
        'gatewayUrl'           =>  '',  //支付宝网关
        'alipay_public_key'    =>  '', //支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
    ];

    /**
     * 微信公众号信息配置
     * @var array
     */
    private $_wechat_config = [
        'app_id'         => '',
        'mch_id'         => '',
        'key'            => '',
        'app_secret'     => '',
        'notify_url'     => '', // 微信支付成功后的回调地址 http://域名/notify/wxPay,
        'sslcert_path'   => '',
        'sslkey_path'    => '',
        'curl_proxy_host'=> "0.0.0.0",//"10.152.18.220";
        'curl_proxy_port'=> 0,//8080;
    ];

    /**
     * Pay constructor.
     * @param $channel string 渠道
     * @param $payType string 支付类型
     * @param $config  array   配置信息
     * @throws \Exception
     */
    public function __construct($channel, $payType, $config = []) {
        /************* start 检查支付渠道 *******************/
        $this->_checkChannel($channel);
        /************* end 检查支付渠道 *******************/

        /************** start 检查支付类型 ****************/
        $this->_checkPayType($payType);
        /************** end 检查支付类型 *****************/

        if( $channel == PayConfig::CHANNEL_ALI_PAY ){
            $this->_config = array_merge($this->_ali_config, $this->_payTypeConfig, $config);
        }elseif( $channel == PayConfig::CHANNEL_WECHAT_PAY ){
            $this->_config = array_merge($this->_wechat_config, $this->_payTypeConfig, $config);
        }else{
            throw new \Exception("暂不支持该渠道");
        }
    }

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
                case PayConfig::WX_BAR:
                case PayConfig::WX_WAP:
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
            throw new \Exception("发生异常了！~~~~ 异常信息=========" . $e->getMessage() );
        }
    }

    /**
     * 微信扫码支付  微信回调URL 需要再微信
     * 详情查看微信官方文档  https://pay.weixin.qq.com/wiki/doc/api/native.php?chapter=6_3
     */
    public function QrCodecallBack(){
        $channel = new QrCodePay($this->_config);
        $channel->callBack();
    }


    /**
     * 退款
     */
    public function refund($params) {
        try {
            switch ( $this->_channel ) {
                case PayConfig::CHANNEL_WECHAT_PAY:
                    $chennel = new WechatRefund($config);
                    $returnData = $chennel->refund($params);
                    break;
                case  PayConfig::CHANNEL_ALI_PAY:
                    $chennel = "";


                /********************** end 支付宝支付 ********************************/
                default:
                    throw new \Exception('当前仅支持：支付宝  微信');
                    break;
            }
        }catch (\Exception $e){
            throw new \Exception("发生异常了！~~~~ 异常信息=========" . $e->getMessage() );
        }
    }

    /**
     * 检查支付类型 是否合法
     * @param $payType
     * @throws \Exception
     */
    private function _checkPayType($payType){
        $config = config('pay.'); //文件配置信息
        if( $this->_channel == PayConfig::CHANNEL_ALI_PAY ){
            $payTypeArr = $this->_getAliAllPayType();
        }elseif ($this->_channel == PayConfig::CHANNEL_WECHAT_PAY) {
            $payTypeArr = $this->_getWechatAllPayType();
        }

        if( !in_array($payType, $payTypeArr) ){
            throw new \Exception("暂不支持此种【{$payType}】支付类型");
        }

        if( !isset($config[$this->_channel][$payType]) ){
            throw new \Exception("请检查是否添加pay.php并且已配置信息");
        }

        $this->_payType = $payType;
        $this->_payTypeConfig = $config[$this->_channel][$payType];
    }

    /**
     * 获取ali所有支付方式
     * @return array
     */
    private function _getAliAllPayType(){
        return [
            PayConfig::ALI_APP,    //支付宝 手机app 支付
            PayConfig::ALI_WEB,   // 支付宝 PC 网页支付
            PayConfig::ALI_BAR,   // 支付宝 条码支付
            PayConfig::ALI_QRCODE,// 支付宝 扫码支付
            PayConfig::ALI_WAP,   // 支付宝 手机网页 支付
        ];
    }

    /**
     * 获取微信所有支付方式
     * @return array
     */
    private function _getWechatAllPayType(){
        return [
            PayConfig::WX_APP,    //微信 APP 支付
            PayConfig::WX_PUB,    // 微信 公众账号 支付
            PayConfig::WX_BAR,    // 微信 刷卡支付，与支付宝的条码支付对应
            PayConfig::WX_QRCODE, // 微信 扫码支付  (可以使用app的帐号，也可以用公众的帐号完成)
            PayConfig::WX_MINI,   // 微信小程序支付
            PayConfig::WX_WAP,    // 微信wap支付，针对特定用户
        ];
    }

    /**
     * 检验渠道
     * @param $channel
     */
    private function _checkChannel($channel){
        if( !in_array($channel, [PayConfig::CHANNEL_ALI_PAY,PayConfig::CHANNEL_WECHAT_PAY])){
            throw new \Exception("暂不支持【{$channel}】渠道");
        }else{
           $this->_channel = $channel ;
        }
    }
}