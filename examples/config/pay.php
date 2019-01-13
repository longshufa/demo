<?php
/**
 * User: lyndon
 * Date: 2019/01/13 0012
 * Time: 16:22
 */

use \think\facade\Env;

return [ //支付配置
    'ali' => [
        'ali_app' => [  //支付宝APP支付
            //应用ID,您的APPID。
            'app_id'=>Env::get('pay:ali:ali_app.app_id', ''),
            //商户私钥
            'merchant_private_key'=>Env::get('pay:ali:ali_app.merchant_private_key', ''),
            //异步通知地址
            'notify_url'=>Env::get('pay:ali:ali_app.notify_url', ''),
            //同步跳转
            'return_url'=>Env::get('pay:ali:ali_app.return_url', ''),
            //编码格式
            'charset'=>Env::get('pay:ali:ali_app.charset', 'UTF-8'),
            //签名方式
            'sign_type'=>Env::get('pay:ali:ali_app.sign_type', 'RSA2'),
            //支付宝网关
            //'gatewayUrl' => "https://openapi.alipay.com/gateway.do", //生产环境
            'gatewayUrl'=> Env::get('pay:ali:ali_app.gatewayUrl', 'gatewayUrl = https://openapi.alipaydev.com/gateway.do'), //沙箱环境
            //支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
            'alipay_public_key'=>Env::get('pay:ali:ali_app.alipay_public_key', ''),
        ],
        'ali_web' => [  //支付宝Web支付
            //应用ID,您的APPID。
            'app_id'=>Env::get('pay:ali:ali_web.app_id', ''),
            //商户私钥
            'merchant_private_key'=>Env::get('pay:ali:ali_web.merchant_private_key', ''),
            //异步通知地址
            'notify_url'=>Env::get('pay:ali:ali_web.notify_url', ''),
            //同步跳转
            'return_url'=>Env::get('pay:ali:ali_web.return_url', ''),
            //编码格式
            'charset'=>Env::get('pay:ali:ali_web.charset', 'UTF-8'),
            //签名方式
            'sign_type'=>Env::get('pay:ali:ali_web.sign_type', 'RSA2'),
            //支付宝网关
            //'gatewayUrl' => "https://openapi.alipay.com/gateway.do", //生产环境
            'gatewayUrl'           => Env::get('pay:ali:ali_web.gatewayUrl', 'gatewayUrl = https://openapi.alipaydev.com/gateway.do'), //沙箱环境
            //支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
            'alipay_public_key'    => Env::get('pay:ali:ali_web.alipay_public_key', ''),
        ],
    ],
    'wechat' => [
        'wx_pub' => [
            'app_id'        =>Env::get('pay:wechat:wx_pub.app_id', ''),
            'mch_id'        =>Env::get('pay:wechat:wx_pub.mch_id', ''),
            'key'          =>Env::get('pay:wechat:wx_pub.key', ''),
            'app_secret'    =>Env::get('pay:wechat:wx_pub.app_secret', ''),
            'notify_url'   =>Env::get('pay:wechat:wx_pub.notify_url', ''),
            'sslcert_path' =>Env::get('pay:wechat:wx_pub.sslcert_path', ''),
            'sslkey_path'  =>Env::get('pay:wechat:wx_pub.sslkey_path', ''),
        ],
        'wx_mini' =>[ //小程序相关信息
            'app_id'        =>Env::get('pay:wechat:wx_mini.app_id', ''),
            'mch_id'        =>Env::get('pay:wechat:wx_mini.mch_id', ''),
            'key'          =>Env::get('pay:wechat:wx_mini.key', ''),
            'app_secret'    =>Env::get('pay:wechat:wx_mini.app_secret', ''),
            'notify_url'   =>Env::get('pay:wechat:wx_mini.notify_url', ''),
            'sslcert_path' =>Env::get('pay:wechat:wx_mini.sslcert_path', ''),
            'sslkey_path'  =>Env::get('pay:wechat:wx_mini.sslkey_path', ''),
        ],
        'wx_app' =>[ //微信app相关信息
            'app_id'        =>Env::get('pay:wechat:wx_app.app_id', ''),
            'mch_id'        =>Env::get('pay:wechat:wx_app.mch_id', ''),
            'key'          =>Env::get('pay:wechat:wx_app.key', ''),
            'app_secret'    =>Env::get('pay:wechat:wx_app.app_secret', ''),
            'notify_url'   =>Env::get('pay:wechat:wx_app.notify_url', ''),
            'sslcert_path' =>Env::get('pay:wechat:wx_app.sslcert_path', ''),
            'sslkey_path'  =>Env::get('pay:wechat:wx_app.sslkey_path', ''),
        ],
        'wx_qrcode' =>[ //微信app相关信息
            'app_id'        =>Env::get('pay:wechat:wx_qrcode.app_id', ''),
            'mch_id'        =>Env::get('pay:wechat:wx_qrcode.mch_id', ''),
            'key'          =>Env::get('pay:wechat:wx_qrcode.key', ''),
            'app_secret'    =>Env::get('pay:wechat:wx_qrcode.app_secret', ''),
            'notify_url'   =>Env::get('pay:wechat:wx_qrcode.notify_url', ''),
            'sslcert_path' =>Env::get('pay:wechat:wx_qrcode.sslcert_path', ''),
            'sslkey_path'  =>Env::get('pay:wechat:wx_qrcode.sslkey_path', ''),
        ]
    ]
];