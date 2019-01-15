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
///**
// * 服务商版
// * 小程序支付
// * 公众号支付  payType 改为 PayConfig::SUB_WX_PUB
// * @throws \Exception
// */
//public function subWxMiniPay(){
//    $obj = new Pay(PayConfig::CHANNEL_WECHAT_PAY, PayConfig::SUB_WX_MINI);
//    $payData = [
//        'body'    => 'testbody',
//        'subject'    => 'testsubject',
//        'order_no'    =>time(),
//        'sub_openid'      =>'odUBd5fOh1lp6BUH6QyzgVb2dH_s',  //用户openid
//        'timeout_express' => 600, // 表示必须 600s 内付款
//        'amount'    => '1',// 微信沙箱模式，需要金额固定为1
//    ];
//    $params = $obj->pay($payData);
//    var_dump($params);
//}
//
//
//    /**
//     * 支付宝App支付 return string alipay_sdk=alipay-sdk-php-20161101&app_id=2018080360947037&biz_content=%7B%22body%22%3A%22test+body%22%2C%22subject%22%3A%22test+subject%22%2C%22order_no%22%3A1547372211%2C%22timeout_express%22%3A%221d%22%2C%22amount%22%3A0.02%2C%22product_code%22%3A%22QUICK_MSECURITY_PAY%22%7D&charset=UTF-8&format=json&method=alipay.trade.app.pay&notify_url=notify_url&sign_type=RSA2&timestamp=2019-01-13+17%3A36%3A52&version=1.0&sign=XNtqLuucuoDaSN%2B%2FGlCNCuZ1ycqVuVRLamHBdxt1XnwGYNBtTVgnFI9e2fOLkivPlESPJNJZ1pjJ%2Fzl%2BOdxycqJUTpmcBlOpFsSn8FBsveAUtFyXJXqFi4zoPZN65h0IQ%2FoAu25eRV7RuCafzdlgJpaUHzbGZyEgxD8m%2Bw%2F9XHYmDoq2ae6Lug1jkvYIW9gdt7hQ6gOha6D05uPx4LPdXvcs3eEhccaai7pMiaqKkpUvAmYln748xOfZPWWehD9Iqm9tbqnEIJFPmGG2vEPkYkdrdQuzAwQiSH7U1rfULJs1lqhjGJdmpShGvtpQwp4FHkm%2B6zy%2F87LciiVH0SVOHw%3D%3D
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

///**
// * 微信支付回调通知
// * @throws \Exception
// */
//public function wxNotify(){
//    $xml = file_get_contents("php://input");
//    $notifyData = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), 1);
//    $obj = new Pay(PayConfig::CHANNEL_WECHAT_PAY, PayConfig::WX_MINI);
//    if ( $obj->checkSign($notifyData) ) { //验签成功
//        $orderNo       = $notifyData["out_trade_no"]; //提交给微信的订单号
//        $transactionId = $notifyData['transaction_id']; //第三方交易号
//        //TODO 处理回调的业务逻辑
//        //业务逻辑
//        //..........
//        echo $obj->responseNotifyResult("SUCCESS"); //传 SUCCESS 或 success 业务逻辑处理完 响应微信
//        exit();
//    }else{ //验签失败
//        echo $obj->responseNotifyResult("FAIL");//传 FAIL/fail 出错 响应微信
//        exit();
//    }
//}
//
///**
// * ALI 回调通知
// * @throws \Exception
// */
//public function aliNotify() {
//    $notifyData = $_POST;
//    $obj =  new Pay(PayConfig::CHANNEL_ALI_PAY, PayConfig::ALI_APP);
//    if ($obj->checkSign($notifyData)) {//验证成功
//        //商户订单号
//        $out_trade_no  = $notifyData['out_trade_no'];
//        //支付宝交易号
//        $transactionId = $notifyData['trade_no'];
//        //交易状态
//        $trade_status = $notifyData['trade_status'];
//        //支付时间
//        $paymentTime = $notifyData['gmt_payment']; //  gmt_payment = 2018-04-18 18:00:20
//        //回调通知时间
//        $notifyTime = $notifyData['notify_time'];
//        if ($trade_status == 'TRADE_FINISHED') {
//            //判断该笔订单是否在商户网站中已经做过处理
//            //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
//            //请务必判断请求时的total_amount与通知时获取的total_fee为一致的
//            //如果有做过处理，不执行商户的业务程序
//            //注意：
//            //退款日期超过可退款期限后（如三个月可退款），支付宝系统发送该交易状态通知
//        } else if ($trade_status == 'TRADE_SUCCESS') {
//            //判断该笔订单是否在商户网站中已经做过处理
//            //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
//            //请务必判断请求时的total_amount与通知时获取的total_fee为一致的
//            //如果有做过处理，不执行商户的业务程序
//            //注意：
//            //付款完成后，支付宝系统发送该交易状态通知
//        }
//        //——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
//
//        echo $obj->responseNotifyResult("SUCCESS"); //传 SUCCESS 或 success 业务逻辑处理完 响应支付宝
//        exit();
//    } else {
//        //验证失败
//        echo $obj->responseNotifyResult("FAIL");//传 FAIL/fail 出错 响应支付宝
//        exit();
//    }
//
//}
//
//
//
//
//
//}
