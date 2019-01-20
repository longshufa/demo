<?php

namespace tp51\pay;

use tp51\pay\config\PayConfig;

class BaseDataInit {
    /**
     * 版本号
     * @var string
     */
    private $version = "1.0.5";

    /**
     * 初始化配置信息
     * @var array
     */
    protected $_config  = [];

    /**
     * 具体业务 配置信息
     * @var array
     */
    protected $_payTypeConfig = [];

    /**
     * 支付渠道
     * @var string
     */
    protected $_channel = '';

    /**
     * 支付类型
     * @var string
     */
    protected $_payType = '';

    /**
     * 支付宝配置信息
     * @var array
     */
    protected $_ali_config = [
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
    protected $_wechat_config = [
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
            PayConfig::SUB_WX_APP,    //微信 APP 支付 (服务商)
            PayConfig::SUB_WX_PUB,    // 微信 公众账号 支付(服务商)
            PayConfig::SUB_WX_BAR,    // 微信 刷卡支付，与支付宝的条码支付对应(服务商)
            PayConfig::SUB_WX_QRCODE, // 微信 扫码支付  (可以使用app的帐号，也可以用公众的帐号完成)(服务商)
            PayConfig::SUB_WX_MINI,   // 微信小程序支付(服务商)
            PayConfig::SUB_WX_WAP,    // 微信wap支付，针对特定用户(服务商)
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