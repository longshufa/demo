<?php
namespace app\index\controller;

use think\facade\Log;
use tp51\pay\config\PayConfig;
use tp51\pay\Notify;
use tp51\pay\OrderQuery;
use tp51\pay\Pay;
use tp51\pay\Query;
use tp51\pay\Refund;
use tp51\pay\RefundQuery;
use tp51\pay\service\ali\pay\AliTransfer;
use tp51\pay\ToAccountTransfer;

class Index {
    /**
     * @return array|bool|string
     * @throws \Exception
     */
    public function wxAppPay()
    {
        //APP 支付
       $object = new Pay(PayConfig::CHANNEL_WECHAT_PAY, PayConfig::WX_APP);
       $payData = [
             'body'    => 'test body',
             'subject'    => 'test subject',
             'order_no'    =>time(),
             'timeout_express' => 600, // 表示必须 600s 内付款
             'amount'    => '1',// 微信沙箱模式，需要金额固定为3.0
       ];
       $params =  $object->pay($payData);
       var_dump($params);
    }

    /**
     * 服务商版APP支付
     * @return array|bool|string
     * @throws \Exception
     */
    public function subWxAppPay()
    {
        //APP 支付
        $object = new Pay(PayConfig::CHANNEL_WECHAT_PAY, PayConfig::SUB_WX_APP);
        $payData = [
            'body'    => 'test body',
            'subject'    => 'test subject',
            'order_no'    =>time(),
            'timeout_express' => 600, // 表示必须 600s 内付款
            'amount'    => '1',// 微信沙箱模式，需要金额固定为3.0
        ];
        $params =  $object->pay($payData);
        var_dump($params);
    }


    /**
     * 微信扫码支付 模式一
     * @throws \Exception
     */
    public function wxQrCodePay()
    {
        //APP 支付
        $object = new Pay(PayConfig::CHANNEL_WECHAT_PAY, PayConfig::WX_QRCODE);
        $payData = [
            'body'    => 'test body',
            'subject'    => 'test subject',
            'order_no'    =>time(),
            'timeout_express' => 600, // 表示必须 600s 内付款
            'amount'    => '1',//
        ];
        $url =  $object->pay($payData);
        var_dump($url);
    }

    /***
     * 扫码支付回调地址
     * @throws \Exception
     * //需要设置回调地址  详情查看微信官方文档  https://pay.weixin.qq.com/wiki/doc/api/native.php?chapter=6_3
     */
    public function qrCodeCallBack(){
        $obj = new Pay(PayConfig::CHANNEL_WECHAT_PAY, PayConfig::WX_QRCODE);
        $obj->QrCodeCallBack();
    }


    /**
     * 微信支付生成二维码
     * url 微信支付
     */
    public function qrCode(){
        $url = input('param.url/s', '', 'trim');
        $url = base64_decode($url);
        //TODO 将上面的url 生成二维码
        $img = buildQrcode($url);
        // 发送合适的报头
        header("Content-Type: image/jpeg;text/html; charset=utf-8");
        // 发送图片
        echo $img;
        exit;
    }

    /**
     * 小程序支付
     * 公众号支付  payType 改为 PayConfig::WX_PUB
     * @throws \Exception
     */
    public function wxMiniPay(){
        $obj = new Pay(PayConfig::CHANNEL_WECHAT_PAY, PayConfig::WX_MINI);
        $payData = [
            'body'    => 'test body',
            'subject'    => 'test subject',
            'order_no'    =>time(),
            'openid'      =>'oV7H64pmvfg7gr3wlx8hiGc-lqSg',  //用户openid 圣路
            'timeout_express' => 600, // 表示必须 600s 内付款
            'amount'    => '1',// 微信沙箱模式，需要金额固定为1
        ];
        $params = $obj->pay($payData);
        var_dump($params);
    }

    /**
     * 小程序支付
     * 公众号支付  payType 改为 PayConfig::WX_PUB
     * @throws \Exception
     */
    public function subWxMiniPay(){
        $obj = new Pay(PayConfig::CHANNEL_WECHAT_PAY, PayConfig::SUB_WX_MINI);
        $payData = [
            'body'    => 'testbody',
            'subject'    => 'testsubject',
            'order_no'    =>time(),
            'sub_openid'      =>'odUBd5fOh1lp6BUH6QyzgVb2dH_s',  //用户openid 子商户的openid
            'timeout_express' => 600, // 表示必须 600s 内付款
            'amount'    => '1',// 微信沙箱模式，需要金额固定为1
        ];
        $obj->setNotifyUrl("http://kjsdks.com"); //手动设置回调地址
        $params = $obj->pay($payData);
        var_dump($params);
    }


    /**
     * 支付宝App支付 return string
     * @throws \Exception
     */
    public function aliAppPay(){
        $obj = new Pay(PayConfig::CHANNEL_ALI_PAY, PayConfig::ALI_APP);
        $data = [
            'body' => 'test body',
            'subject' => 'test subject',
            'order_no' =>time(),
            'timeout_express' => '1d',  //
            'amount' => 2, //单位：分
        ];
        $params = $obj->pay($data);
        var_dump($params);
    }

    /**
     * 支付宝App支付
     * @throws \Exception
     */
    public function aliWebPay(){
        $obj = new Pay(PayConfig::CHANNEL_ALI_PAY, PayConfig::ALI_WEB);
        $data = [
            'body' => 'test body',
            'subject' => 'test subject',
            'order_no' =>time(),
            'timeout_express' => '1d',  //
            'amount' => 1000000, //单位：分
        ];
        $obj->pay($data);
    }

    /**
     *
     */
    public function queryOrder(){
        $obj = new Pay(PayConfig::CHANNEL_WECHAT_PAY, PayConfig::ALI_WEB);
    }


    /**
     * 微信支付回调通知
     * $notifyData = [
        'appid' => 'wx17abe699ae067eff',
        'bank_type' => 'CFT',
        'cash_fee' => '1',
        'fee_type' => 'CNY',
        'is_subscribe' => 'N',
        'mch_id' => '1518258771',
        'nonce_str' => 'ghfqbkezfp6nahmgm2rypfu19ttcsx05',
        'openid' => 'oV7H64pmvfg7gr3wlx8hiGc-lqSg',
        'out_trade_no' => 'OR2018122717025449437737',
        'result_code' => 'SUCCESS',
        'return_code' => 'SUCCESS',
        'sign' => 'D1F412F36DE35CF295343B2263A9670B',
        'time_end' => '20181227170300',
        'total_fee' => '1',
        'trade_type' => 'JSAPI',
        'transaction_id' => '4200000212201812273250903099',
        ];
     * @throws \Exception
     */
    public function wxNotify(){
        $xml = file_get_contents("php://input");
        $notifyData = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), 1);
        $obj = new Notify(PayConfig::CHANNEL_WECHAT_PAY, PayConfig::WX_MINI);
        if ( $obj->checkSign($notifyData) ) { //验签成功
            $orderNo       = $notifyData["out_trade_no"]; //提交给微信的订单号
            $transactionId = $notifyData['transaction_id']; //第三方交易号
            //TODO 处理回调的业务逻辑
            //业务逻辑
            //..........
            echo $obj->responseNotifyResult("SUCCESS"); //传 SUCCESS 或 success 业务逻辑处理完 响应微信
            exit();
        }else{ //验签失败
            echo $obj->responseNotifyResult("FAIL");//传 FAIL/fail 出错 响应微信
            exit();
        }
    }

    /**
     * ALI 回调通知
     * @throws \Exception
     */
    public function aliNotify() {
        $notifyData = $_POST;
            $obj =  new Notify(PayConfig::CHANNEL_ALI_PAY, PayConfig::ALI_APP);
            if ($obj->checkSign($notifyData)) {//验证成功
                //商户订单号
                $out_trade_no  = $notifyData['out_trade_no'];
                //支付宝交易号
                $transactionId = $notifyData['trade_no'];
                //交易状态
                $trade_status = $notifyData['trade_status'];
                //支付时间
                $paymentTime = $notifyData['gmt_payment']; //  gmt_payment = 2018-04-18 18:00:20
                //回调通知时间
                $notifyTime = $notifyData['notify_time'];
                if ($trade_status == 'TRADE_FINISHED') {
                    //判断该笔订单是否在商户网站中已经做过处理
                    //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                    //请务必判断请求时的total_amount与通知时获取的total_fee为一致的
                    //如果有做过处理，不执行商户的业务程序
                    //注意：
                    //退款日期超过可退款期限后（如三个月可退款），支付宝系统发送该交易状态通知
                } else if ($trade_status == 'TRADE_SUCCESS') {
                    //判断该笔订单是否在商户网站中已经做过处理
                    //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                    //请务必判断请求时的total_amount与通知时获取的total_fee为一致的
                    //如果有做过处理，不执行商户的业务程序
                    //注意：
                    //付款完成后，支付宝系统发送该交易状态通知
                }
                //——请根据您的业务逻辑来编写程序（以上代码仅作参考）——

                echo $obj->responseNotifyResult("SUCCESS"); //传 SUCCESS 或 success 业务逻辑处理完 响应支付宝
                exit();
            } else {
                //验证失败
                echo $obj->responseNotifyResult("FAIL");//传 FAIL/fail 出错 响应支付宝
                exit();
            }

    }

    /**
     * @throws \Exception
     */
    public function refund(){
        $data = [
            'refund_fee'     => 1, //单位:分（必传）
            'total_fee'      => 1, //订单总额 单位：分 （必传）
            'transaction_id' => "4000201901161002", //第三方交易号
            'out_trade_no'   => "OR201901161002",  //商户订单号（下单订单号） 注：第三方交易号 和 商户订单 必须传一个
            'out_refund_no'  => "RF201901161002"   //（不是必填）退款订单号
        ];

        $obj = new Refund(PayConfig::CHANNEL_WECHAT_PAY, PayConfig::SUB_WX_MINI); //
        $returnData = $obj->refund($data); // 第二个参数为真是，返回原始数据
        var_dump($returnData); //默认返回： *  [
        ///'out_refund_no'  => "" //商户退款单号
        //'transaction_id' => "" ,//第三方交易订单号
       // 'out_trade_no'   => "", //商户订单号
       // "refund_fee"     => "", //退款金额, 单位：分
    }

    public function refundSuccessCallback(){ //退款结果通知 回调地址
        $xml = file_get_contents("php://input");
        $notifyData = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), 1);

        $obj = new Notify(PayConfig::CHANNEL_WECHAT_PAY, PayConfig::SUB_WX_MINI);
        $result = $obj->wxDecrypt($notifyData); //解密返回 xml 格式
        var_dump($result);
        /**<root>
            <out_refund_no><![CDATA[20190120004]]></out_refund_no>
            <out_trade_no><![CDATA[15835568898]]></out_trade_no>
            <refund_account><![CDATA[REFUND_SOURCE_UNSETTLED_FUNDS]]></refund_account>
            <refund_fee><![CDATA[1]]></refund_fee>
            <refund_id><![CDATA[85558255558888]]></refund_id>
            <refund_recv_accout><![CDATA[农业银行信用卡8989]]></refund_recv_accout>
            <refund_request_source><![CDATA[API]]></refund_request_source>
            <refund_status><![CDATA[SUCCESS]]></refund_status>
            <settlement_refund_fee><![CDATA[1]]></settlement_refund_fee>
            <settlement_total_fee><![CDATA[5]]></settlement_total_fee>
            <success_time><![CDATA[2019-01-20 12:21:21]]></success_time>
            <total_fee><![CDATA[5]]></total_fee>
            <transaction_id><![CDATA[420000xxxxxxxxxxxxx0957431]]></transaction_id>
            </root>**/
        $arr = $obj->xmlToArray($result); //xml 转数组
        /**
         * array ( 'out_refund_no' => '20190120004', 'out_trade_no' => '15835568898', 'refund_account' => 'REFUND_SOURCE_UNSETTLED_FUNDS', 'refund_fee' => '1', 'refund_id' => '85558255558888', 'refund_recv_accout' => '农业银行信用卡8989', 'refund_request_source' => 'API', 'refund_status' => 'SUCCESS', 'settlement_refund_fee' => '1', 'settlement_total_fee' => '5', 'success_time' => '2019-01-20 12:21:21', 'total_fee' => '5', 'transaction_id' => '420000xxxxxxxxxxxxx0957431', )
         */
        dump($arr);

    }


    /**
     * 退款查询
     * @throws \Exception
     */
    public function refundQuery(){
        $params = [
            "out_refund_no"  => "", //商户退款单号 (支付宝 必传)
            "transaction_id" => "", //第三方交易号
            "out_trade_no"   => "", //商户订单号 （支付宝 第三方交易号或商户订单号 二选一）  微信是三选一
        ];

        $obj = new RefundQuery(PayConfig::CHANNEL_WECHAT_PAY, PayConfig::SUB_WX_MINI);
        $result = $obj->refundQuery($params);
        var_dump($result);
    }

    /**
     * 订单查询
     * @throws \Exception
     */
    public function orderQuery(){
        $params = [
            "transaction_id" => "", //第三方交易号
            "out_trade_no"   => "", //商户订单号 （第三方交易号或商户订单号 二选一）
        ];

        $obj = new OrderQuery(PayConfig::CHANNEL_WECHAT_PAY, PayConfig::SUB_WX_MINI);
        $result = $obj->orderQuery($params);
        var_dump($result);
    }

    /**
     * @throws \Exception
     * array (size=3) 返回的数据
        'out_trade_no' => string '2018041115591975138'
        'transaction_id' => string '20180411110060001502940099579542'
        'pay_date' => string '2019-04-11 15:59:19'
     */
    public function transfer(){
        $params = [
            "out_trade_no"  => date("YmdHis") . rand(10000, 99999),
            "payee_account" => "2088002098784318",  //收款人账户
            "amount" => 10,  //单位:分  （注：支付宝转账最低 0.1元 即 10分）
            "payee_type" => AliTransfer::PAYEE_TYPE_USERID, //支付宝收款方类型 可不传 默认 支付宝登录号（即邮箱或手机号）
            'payer_show_name' => '小羊淘'
        ];
        $obj = new ToAccountTransfer(PayConfig::CHANNEL_ALI_PAY, PayConfig::ALI_TRANSFER);
        $result = $obj->toAccountTransfer($params);
        var_dump($result);
    }

    /**
     * 转账查询
     * @throws \Exception
     */
    public function transferQuery(){
        $params = [
            "out_trade_no"  => '',//商户订单号
            "transaction_id" => "",  //转账第三方交易号  两者不能同时为空
        ];
        $obj = new ToAccountTransfer(PayConfig::CHANNEL_ALI_PAY, PayConfig::ALI_TRANSFER);
        $result = $obj->query($params);
        var_dump($result);
    }

    /**
     * 支付宝资金账户资产查询
     * @throws \Exception
     */
    public function queryBalance(){
        $params = [
            "alipay_user_id"  => 'xxxxxxxxxx', //支付宝账户管理->合作伙伴管理->PID
        ];
        $obj = new Query(PayConfig::CHANNEL_ALI_PAY, PayConfig::ALI_TRANSFER);
        $result = $obj->queryBalance($params);
        var_dump($result);
    }



}
