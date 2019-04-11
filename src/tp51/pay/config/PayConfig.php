<?php
namespace tp51\pay\config;

class PayConfig {
    /**
     * 版本号
     * @var string
     */
    const VERSION = '1.1.0';
    /*******************************ali相关接口************************************/
    // 支付相关常量
    const ALI_APP     = 'ali_app';// 支付宝 手机app 支付
    const ALI_WAP     = 'ali_wap';// 支付宝 手机网页 支付
    const ALI_WEB     = 'ali_web';// 支付宝 PC 网页支付
    const ALI_QRCODE  = 'ali_qrcode';// 支付宝 扫码支付
    const ALI_BAR     = 'ali_bar';// 支付宝 条码支付

    // 其他操作常量
    const ALI_CHARGE   = 'ali_charge';  // 支付
    const ALI_REFUND   = 'ali_refund';  // 退款
    const ALI_RED      = 'ali_red';     // 红包
    const ALI_TRANSFER = 'ali_transfer';// 转账
    /*******************************微信相关接口************************************/
    // 支付常量
    const WX_APP     = 'wx_app';   // 微信 APP 支付
    const WX_PUB     = 'wx_pub';   // 微信 公众账号 支付
    const WX_QRCODE  = 'wx_qrcode';// 微信 扫码支付  (可以使用app的帐号，也可以用公众的帐号完成)
    const WX_MINI    = 'wx_mini';  // 微信小程序支付

    const WX_BAR     = 'wx_bar';   // 微信 刷卡支付
    const WX_WAP     = 'wx_wap';   // 微信wap支付，针对特定用户

    /**============================服务商===============================*/
    const SUB_WX_APP     = 'sub_wx_app';   // 微信 APP 支付
    const SUB_WX_PUB     = 'sub_wx_pub';   // 微信 公众账号 支付
    const SUB_WX_QRCODE  = 'sub_wx_qrcode';// 微信 扫码支付  (可以使用app的帐号，也可以用公众的帐号完成)
    const SUB_WX_MINI    = 'sub_wx_mini';  // 微信小程序支付

    const SUB_WX_BAR     = 'sub_wx_bar';   // 微信 刷卡支付
    const SUB_WX_WAP     = 'sub_wx_wap';   // 微信wap支付，针对特定用户

    const WX_CHARGE   = 'wx_charge';  // 支付
    const WX_REFUND   = 'wx_refund';  // 退款
    const WX_RED      = 'wx_red';     // 红包
    const WX_TRANSFER = 'wx_transfer';// 转账

    /****************************金额问题设置 *****************************/
    const PAY_MIN_FEE = '0.01';// 支付的最小金额
    const TRANS_FEE = '50000';// 转账达到这个金额，需要添加额外信息


    /****************************支付渠道类型 *****************************/
    const CHANNEL_WECHAT_PAY = 'wechat';
    const CHANNEL_ALI_PAY    = 'ali';

}