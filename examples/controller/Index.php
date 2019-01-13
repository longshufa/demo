<?php
//namespace app\index\controller;
//
//use tp51\pay\config\PayConfig;
//use tp51\pay\Pay;
//
//class Index {
//    /**
//     * @return array|bool|string
//     * @throws \Exception
//     * return array (size=7)
//        'appid' => string 'wxwqe93jw1jo589owb' (length=18)
//        'noncestr' => string 'affofqt31xewyzep0g7e6apct4qb9u7v' (length=32)
//        'package' => string 'Sign=WXPay' (length=10)
//        'partnerid' => string '2138071395' (length=10)
//        'prepayid' => string 'wx2720642053636017550802955912284436' (length=36)
//        'timestamp' => int 1547366645
//        'sign' => string 'C9E9B4E0A67AC1779141A670FEDFEAEF' (length=32)
//     */
//    public function wxAppPay()
//    {
//        //APP 支付
//        $object = new Pay(PayConfig::CHANNEL_WECHAT_PAY, PayConfig::WX_APP);
//        $payData = [
//            'body'    => 'test body',
//            'subject'    => 'test subject',
//            'order_no'    =>time(),
//            'timeout_express' => 600, // 表示必须 600s 内付款
//            'amount'    => '1',// 微信沙箱模式，需要金额固定为3.0
//        ];
//        $params =  $object->pay($payData);
//        var_dump($params);
//    }
//
//
//    /**
//     * 扫码支付 模式一
//     * return string "weixin://wxpay/bizpayurl?appid=&mch_id=&nonce_str=s1dnptn6j8dco4ll2hg3dfqynf4q0zzo&product_id=15535678281&time_stamp=1547368281&sign=11A599546D713CBFD7EB28A590F8190C"
//     * @throws \Exception
//     */
//    public function wxQrCodePay()
//    {
//        //APP 支付
//        $object = new Pay(PayConfig::CHANNEL_WECHAT_PAY, PayConfig::WX_QRCODE);
//        $payData = [
//            'body'    => 'test body',
//            'subject'    => 'test subject',
//            'order_no'    =>time(),
//            'timeout_express' => 600, // 表示必须 600s 内付款
//            'amount'    => '1',//
//        ];
//        $url =  $object->pay($payData);
//        var_dump($url);
//    }
//
//    /***
//     * 扫码支付 模式一 回调地址
//     * @throws \Exception
//     * //需要设置回调地址  详情查看微信官方文档  https://pay.weixin.qq.com/wiki/doc/api/native.php?chapter=6_3
//     */
//    public function wxQrCodeCallBack(){
//        $obj = new Pay(PayConfig::CHANNEL_WECHAT_PAY, PayConfig::WX_QRCODE);
//        $obj->QrCodeCallBack();
//    }
//
//    /**
//     * 微信支付生成二维码
//     * url 微信扫码支付 模式一 返回的url
//     */
//    public function showQrCode(){
//        $url = input('param.url/s', '', 'trim');
//        $url = base64_decode($url);
//        //TODO 将上面的url 生成二维码
//        $img = buildQrcode($url);
//        // 发送合适的报头
//        header("Content-Type: image/jpeg;text/html; charset=utf-8");
//        // 发送图片
//        echo $img;
//        exit;
//    }
//
//    /**
//     * 小程序支付
//     * 公众号支付  payType 改为 PayConfig::WX_PUB
//     * @throws \Exception
//     */
//    public function wxMiniPay(){
//        $obj = new Pay(PayConfig::CHANNEL_WECHAT_PAY, PayConfig::WX_MINI);
//        $payData = [
//            'body'    => 'test body',
//            'subject'    => 'test subject',
//            'order_no'    =>time(),
//            'openid'      =>'openidxxxxx', //用户openid
//            'timeout_express' => 600, // 表示必须 600s 内付款
//            'amount'    => '1',// 单位：分
//        ];
//        $params = $obj->pay($payData);
//        var_dump($params);
//    }
//
//
//    /**
//     * 支付宝App支付 return string alipay_sdk=alipay-sdk-php-20161101&app_id=&biz_content=%7B%22body%22%3A%22test+body%22%2C%22subject%22%3A%22test+subject%22%2C%22order_no%22%3A1547372211%2C%22timeout_express%22%3A%221d%22%2C%22amount%22%3A0.02%2C%22product_code%22%3A%22QUICK_MSECURITY_PAY%22%7D&charset=UTF-8&format=json&method=alipay.trade.app.pay&notify_url=notify_url&sign_type=RSA2&timestamp=2019-01-13+17%3A36%3A52&version=1.0&sign=XNtqLuucuoDaSN%2B%2FGlCNCuZ1ycqVuVRLamHBdxt1XnwGYNBtTVgnFI9e2fOLkivPlESPJNJZ1pjJ%2Fzl%2BOdxycqJUTpmcBlOpFsSn8FBsveAUtFyXJXqFi4zoPZN65h0IQ%2FoAu25eRV7RuCafzdlgJpaUHzbGZyEgxD8m%2Bw%2F9XHYmDoq2ae6Lug1jkvYIW9gdt7hQ6gOha6D05uPx4LPdXvcs3eEhccaai7pMiaqKkpUvAmYln748xOfZPWWehD9Iqm9tbqnEIJFPmGG2vEPkYkdrdQuzAwQiSH7U1rfULJs1lqhjGJdmpShGvtpQwp4FHkm%2B6zy%2F87LciiVH0SVOHw%3D%3D
//     * @throws \Exception
//     */
//    public function aliAppPay(){
//        $obj = new Pay(PayConfig::CHANNEL_ALI_PAY, PayConfig::ALI_APP);
//        $data = [
//            'body' => 'test body',
//            'subject' => 'test subject',
//            'order_no' =>time(),
//            'timeout_express' => '1d',  //
//            'amount' => 1, //单位：分
//        ];
//        $params = $obj->pay($data);
//        var_dump($params);
//    }
//
//    /**
//     * 支付宝Web支付
//     * @throws \Exception
//     */
//    public function aliWebPay(){
//        $obj = new Pay(PayConfig::CHANNEL_ALI_PAY, PayConfig::ALI_WEB);
//        $data = [
//            'body' => 'test body',
//            'subject' => 'test subject',
//            'order_no' =>time(),
//            'timeout_express' => '1d',  //
//            'amount' => 2, //单位：分
//        ];
//        $obj->pay($data);
//    }
//
//
//
//
//
//}
