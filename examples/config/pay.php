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
            'app_id'=>Env::get('pay:ali:ali_app.app_id', ''),//应用ID,您的APPID。
            'merchant_private_key'=>Env::get('pay:ali:ali_app.merchant_private_key', ''), //商户私钥
            'notify_url'=>Env::get('pay:ali:ali_app.notify_url', ''), //异步通知地址
            'return_url'=>Env::get('pay:ali:ali_app.return_url', ''), //同步跳转
            'charset'=>Env::get('pay:ali:ali_app.charset', 'UTF-8'),//编码格式
            'sign_type'=>Env::get('pay:ali:ali_app.sign_type', 'RSA2'),//签名方式
            //'gatewayUrl' => "https://openapi.alipay.com/gateway.do", //生产环境   //支付宝网关
            'gatewayUrl'           => Env::get('pay:ali:ali_app.gatewayUrl', 'https://openapi.alipaydev.com/gateway.do'), //沙箱环境   //支付宝网关
            'alipay_public_key'    => Env::get('pay:ali:ali_app.alipay_public_key', ''),  //支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
        ],
        'ali_web' => [  //支付宝Web支付
            'app_id'=>Env::get('pay:ali:ali_web.app_id', ''),//应用ID,您的APPID。
            'merchant_private_key'=>Env::get('pay:ali:ali_web.merchant_private_key', ''), //商户私钥
            'notify_url'=>Env::get('pay:ali:ali_web.notify_url', ''), //异步通知地址
            'return_url'=>Env::get('pay:ali:ali_web.return_url', ''), //同步跳转
            'charset'=>Env::get('pay:ali:ali_web.charset', 'UTF-8'),//编码格式
            'sign_type'=>Env::get('pay:ali:ali_web.sign_type', 'RSA2'),//签名方式
            //'gatewayUrl' => "https://openapi.alipay.com/gateway.do", //生产环境   //支付宝网关
            'gatewayUrl'           => Env::get('pay:ali:ali_web.gatewayUrl', 'https://openapi.alipaydev.com/gateway.do'), //沙箱环境   //支付宝网关
            'alipay_public_key'    => Env::get('pay:ali:ali_web.alipay_public_key', ''),  //支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
        ],

        'ali_transfer' => [  //支付宝Web支付
            //应用ID,您的APPID。
            'app_id'=>Env::get('pay:ali:ali_transfer.app_id', ''),
            //商户私钥
            'merchant_private_key'=>Env::get('pay:ali:ali_transfer.merchant_private_key', ''),
            //编码格式
            'charset'=>Env::get('pay:ali:ali_transfer.charset', 'UTF-8'),
            //签名方式
            'sign_type'=>Env::get('pay:ali:ali_transfer.sign_type', 'RSA2'),
            //支付宝网关
            //'gatewayUrl' => "https://openapi.alipay.com/gateway.do", //生产环境
            'gatewayUrl'           => Env::get('pay:ali:ali_transfer.gatewayUrl', 'gatewayUrl = https://openapi.alipaydev.com/gateway.do'), //沙箱环境
            //支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
            'alipay_public_key'    => Env::get('pay:ali:ali_transfer.alipay_public_key', 'gatewayUrl = https://openapi.alipaydev.com/gateway.do'),
        ],
    ],
    'wechat' => [
        'wx_pub' => [ //公众号
            'app_id'        =>Env::get('pay:wechat:wx_pub.app_id', ''), //绑定支付的APPID（必须配置，开户邮件中可查看）
            'mch_id'        =>Env::get('pay:wechat:wx_pub.mch_id', ''), //MCHID：商户号（必须配置，开户邮件中可查看）
            'key'          =>Env::get('pay:wechat:wx_pub.key', ''), //KEY：商户支付密钥，参考开户邮件设置（必须配置，登录商户平台自行设置）设置地址：https://pay.weixin.qq.com/index.php/account/api_cert
            'app_secret'    =>Env::get('pay:wechat:wx_pub.app_secret', ''),  //APPSECRET：公众帐号secert（仅JSAPI支付的时候需要配置， 登录公众平台，进入开发者中心可设置），获取地址：https://mp.weixin.qq.com/advanced/advanced?action=dev&t=advanced/dev&token=2005451881&lang=zh_CN
            'notify_url'   =>Env::get('pay:wechat:wx_pub.notify_url', ''),//支付回调通知地址 公网外部可访问
            'refund_success_notify_url'   =>Env::get('pay:wechat:wx_pub.refund_success_notify_url', ''), //退款结果通知url
            /***********证书路径,注意应该填写绝对路径（仅退款、撤销订单时需要，可登录商户平台下载，***********/
            /***********API证书下载地址：https://pay.weixin.qq.com/index.php/account/api_cert，下载之前需要安装商户操作证书)***********/
            'sslcert_path' =>Env::get('pay:wechat:wx_pub.sslcert_path', ''), //需要填写绝对地址
            'sslkey_path'  =>Env::get('pay:wechat:wx_pub.sslkey_path', ''),  //需要填写绝对地址
            /****************************************** end *******************************************/
        ],
        'wx_mini' =>[ //小程序相关信息
            'app_id'        =>Env::get('pay:wechat:wx_mini.app_id', ''),//绑定支付的APPID（必须配置，开户邮件中可查看）
            'mch_id'        =>Env::get('pay:wechat:wx_mini.mch_id', ''), //MCHID：商户号（必须配置，开户邮件中可查看）
            'key'          =>Env::get('pay:wechat:wx_mini.key', ''),//KEY：商户支付密钥，参考开户邮件设置（必须配置，登录商户平台自行设置）设置地址：https://pay.weixin.qq.com/index.php/account/api_cert
            'app_secret'    =>Env::get('pay:wechat:wx_mini.app_secret', ''),//APPSECRET：公众帐号secert（仅JSAPI支付的时候需要配置， 登录公众平台，进入开发者中心可设置），获取地址：https://mp.weixin.qq.com/advanced/advanced?action=dev&t=advanced/dev&token=2005451881&lang=zh_CN
            'notify_url'   =>Env::get('pay:wechat:wx_mini.notify_url', ''),//支付回调通知地址 公网外部可访问
            'refund_success_notify_url'   =>Env::get('pay:wechat:wx_mini.refund_success_notify_url', ''), //退款结果通知url
            /***********证书路径,注意应该填写绝对路径（仅退款、撤销订单时需要，可登录商户平台下载，***********/
            /***********API证书下载地址：https://pay.weixin.qq.com/index.php/account/api_cert，下载之前需要安装商户操作证书)***********/
            'sslcert_path' =>Env::get('pay:wechat:wx_mini.sslcert_path', ''), //需要填写绝对地址
            'sslkey_path'  =>Env::get('pay:wechat:wx_mini.sslkey_path', ''),//需要填写绝对地址
            /****************************************** end *******************************************/
        ],
        'wx_app' =>[ //微信app相关信息  同上
            'app_id'        =>Env::get('pay:wechat:wx_app.app_id', ''),
            'mch_id'        =>Env::get('pay:wechat:wx_app.mch_id', ''),
            'key'          =>Env::get('pay:wechat:wx_app.key', ''),
            'app_secret'    =>Env::get('pay:wechat:wx_app.app_secret', ''),
            'notify_url'   =>Env::get('pay:wechat:wx_app.notify_url', ''),
            'refund_success_notify_url'   =>Env::get('pay:wechat:wx_app.refund_success_notify_url', ''), //退款结果通知url
            'sslcert_path' =>Env::get('pay:wechat:wx_app.sslcert_path', ''),
            'sslkey_path'  =>Env::get('pay:wechat:wx_app.sslkey_path', ''),
        ],
        'wx_h5' =>[ //微信app相关信息  同上
            'app_id'        =>Env::get('pay:wechat:wx_h5.app_id', ''),
            'mch_id'        =>Env::get('pay:wechat:wx_h5.mch_id', ''),
            'key'          =>Env::get('pay:wechat:wx_h5.key', ''),
            'app_secret'    =>Env::get('pay:wechat:wx_h5.app_secret', ''),
            'notify_url'   =>Env::get('pay:wechat:wx_h5.notify_url', ''),
            'refund_success_notify_url'   =>Env::get('pay:wechat:wx_h5.refund_success_notify_url', ''), //退款结果通知url
            'sslcert_path' =>Env::get('pay:wechat:wx_h5.sslcert_path', ''),
            'sslkey_path'  =>Env::get('pay:wechat:wx_h5.sslkey_path', ''),
        ],
        'sub_wx_app' =>[ //微信app相关信息  同上
            'app_id'       =>Env::get('pay:wechat:sub_wx_app.app_id', ''), //服务商app_id
            'mch_id'       =>Env::get('pay:wechat:sub_wx_app.mch_id', ''),//服务商商户mch_id
            'sub_app_id'   =>Env::get('pay:wechat:sub_wx_app.sub_app_id', ''), //为服务商模式的场景appid
            'sub_mch_id'   =>Env::get('pay:wechat:sub_wx_app.sub_mch_id', ''), //为和服务商商户号有父子绑定关系的子商户号
            'key'          =>Env::get('pay:wechat:sub_wx_app.key', ''),  //KEY：服务商商户支付密钥，参考开户邮件设置（必须配置，登录服务商商户平台自行设置）
            'app_secret'    =>Env::get('pay:wechat:sub_wx_app.app_secret', ''),//服务商app_secret 与  服务商app_id 相匹配的
            'notify_url'   =>Env::get('pay:wechat:sub_wx_app.notify_url', ''), //支付回调通知地址 公网外部可访问
            'refund_success_notify_url'   =>Env::get('pay:wechat:sub_wx_app.refund_success_notify_url', ''), //退款结果通知url
            'sslcert_path' =>Env::get('pay:wechat:sub_wx_app.sslcert_path', ''),
            'sslkey_path'  =>Env::get('pay:wechat:sub_wx_app.sslkey_path', ''),
        ],
        'wx_qrcode' =>[ //微信二维码相关信息 同上
            'app_id'        =>Env::get('pay:wechat:wx_qrcode.app_id', ''),
            'mch_id'        =>Env::get('pay:wechat:wx_qrcode.mch_id', ''),
            'key'          =>Env::get('pay:wechat:wx_qrcode.key', ''),
            'app_secret'    =>Env::get('pay:wechat:wx_qrcode.app_secret', ''),
            'notify_url'   =>Env::get('pay:wechat:wx_qrcode.notify_url', ''),
            'refund_success_notify_url'   =>Env::get('pay:wechat:wx_qrcode.refund_success_notify_url', ''), //退款结果通知url
            'sslcert_path' =>Env::get('pay:wechat:wx_qrcode.sslcert_path', ''),
            'sslkey_path'  =>Env::get('pay:wechat:wx_qrcode.sslkey_path', ''),
        ],
        'sub_wx_mini' =>[ //微信app相关信息
            'app_id'       =>Env::get('pay:wechat:sub_wx_mini.app_id', ''), //服务商app_id
            'mch_id'       =>Env::get('pay:wechat:sub_wx_mini.mch_id', ''),//服务商商户mch_id
            'sub_app_id'   =>Env::get('pay:wechat:sub_wx_mini.sub_app_id', ''), //为服务商模式的场景appid
            'sub_mch_id'   =>Env::get('pay:wechat:sub_wx_mini.sub_mch_id', ''), //为和服务商商户号有父子绑定关系的子商户号
            'key'          =>Env::get('pay:wechat:sub_wx_mini.key', ''), //KEY：服务商商户支付密钥，参考开户邮件设置（必须配置，登录服务商商户平台自行设置）
            'app_secret'   =>Env::get('pay:wechat:sub_wx_mini.app_secret', ''), //服务商app_secret 与  服务商app_id 相匹配的
            'notify_url'   =>Env::get('pay:wechat:sub_wx_mini.notify_url', ''), //支付回调通知地址 公网外部可访问
            'refund_success_notify_url'   =>Env::get('pay:wechat:sub_wx_mini.refund_success_notify_url', ''), //退款结果通知url 
            /***********证书路径,注意应该填写绝对路径（仅退款、撤销订单时需要，可登录商户平台下载，***********/
            /***********API证书下载地址：https://pay.weixin.qq.com/index.php/account/api_cert，下载之前需要安装商户操作证书)***********/
            'sslcert_path' =>Env::get('pay:wechat:sub_wx_mini.sslcert_path', ''), //需要填写绝对地址
            'sslkey_path'  =>Env::get('pay:wechat:sub_wx_mini.sslkey_path', ''), //需要填写绝对地址
            /****************************************** end *******************************************/
        ],
        'sub_wx_h5' =>[ //微信h5相关信息
            'app_id'       =>Env::get('pay:wechat:sub_wx_h5.app_id', ''), //服务商app_id
            'mch_id'       =>Env::get('pay:wechat:sub_wx_h5.mch_id', ''),//服务商商户mch_id
            'sub_app_id'   =>Env::get('pay:wechat:sub_wx_h5.sub_app_id', ''), //为服务商模式的场景appid
            'sub_mch_id'   =>Env::get('pay:wechat:sub_wx_h5.sub_mch_id', ''), //为和服务商商户号有父子绑定关系的子商户号
            'key'          =>Env::get('pay:wechat:sub_wx_h5.key', ''), //KEY：服务商商户支付密钥，参考开户邮件设置（必须配置，登录服务商商户平台自行设置）
            'app_secret'   =>Env::get('pay:wechat:sub_wx_h5.app_secret', ''), //服务商app_secret 与  服务商app_id 相匹配的
            'notify_url'   =>Env::get('pay:wechat:sub_wx_h5.notify_url', ''), //支付回调通知地址 公网外部可访问
            'refund_success_notify_url'   =>Env::get('pay:wechat:sub_wx_h5.refund_success_notify_url', ''), //退款结果通知url
            /***********证书路径,注意应该填写绝对路径（仅退款、撤销订单时需要，可登录商户平台下载，***********/
            /***********API证书下载地址：https://pay.weixin.qq.com/index.php/account/api_cert，下载之前需要安装商户操作证书)***********/
            'sslcert_path' =>Env::get('pay:wechat:sub_wx_h5.sslcert_path', ''), //需要填写绝对地址
            'sslkey_path'  =>Env::get('pay:wechat:sub_wx_h5.sslkey_path', ''), //需要填写绝对地址
            /****************************************** end *******************************************/
        ],
    ]
];