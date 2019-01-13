<?php
require_once dirname(__FILE__).'/pagepay/service/AlipayTradeService.php';
require_once dirname(__FILE__).'/pagepay/buildermodel/AlipayTradePagePayContentBuilder.php';
require_once dirname(__FILE__).'/pagepay/buildermodel/AlipayTradeRefundContentBuilder.php';
require_once dirname(__FILE__).'/pagepay/buildermodel/AlipayTradeQueryContentBuilder.php';
require_once dirname(__FILE__).'/pagepay/buildermodel/AlipayTradeFastpayRefundQueryContentBuilder.php';
require_once dirname(__FILE__).'/AppPayHandler.php';

class AliPayHandler {
    /**
     * @param $out_trade_no  string //商户订单号，商户网站订单系统中唯一订单号，必填
     * @param $subject  string //订单名称，必填
     * @param $total_amount double 单位元 精确到后两位
     * @param string $body string 商品描述，可空
     * @throws Exception
     */
    public function pagePay($out_trade_no, $subject, $total_amount, $body=''){
        //构造参数
        $payRequestBuilder = new AlipayTradePagePayContentBuilder();
        $payRequestBuilder->setBody($body);
        $payRequestBuilder->setSubject($subject);
        $payRequestBuilder->setTotalAmount($total_amount);
        $payRequestBuilder->setOutTradeNo($out_trade_no);

        $config = config('pay.ali_pay');
        $aop = new AlipayTradeService($config);

        /**
         * pagePay 电脑网站支付请求
         * @param $builder object 业务参数，使用buildmodel中的对象生成。
         * @param $return_url string 同步跳转地址，公网可以访问
         * @param $notify_url string 异步通知地址，公网可以访问
         * @return $response 支付宝返回的信息
         */
        $response = $aop->pagePay($payRequestBuilder,$config['return_url'],$config['notify_url']);
    }

    /**
     * 退款
     * @param $data
     * @return bool|SimpleXMLElement[]|string 提交表单HTML文本
     * @throws Exception
     */
    public function refund($data){
        //商户订单号，商户网站订单系统中唯一订单号
        $out_trade_no = trim($data['out_trade_no']);
        //支付宝交易号
        $trade_no = trim($data['transaction_id']);
        //需要退款的金额，该金额不能大于订单金额，必填
        $refund_amount = trim($data['refund_fee'])/100;
        $refund_out_no = trim($data['refund_out_no']);

        //构造参数
        $RequestBuilder=new AlipayTradeRefundContentBuilder();
        $RequestBuilder->setOutTradeNo($out_trade_no);
        $RequestBuilder->setTradeNo($trade_no);
        $RequestBuilder->setRefundAmount($refund_amount);
        $RequestBuilder->setOutRequestNo($refund_out_no);
        $config = config('pay.ali_pay');
        $aop = new AlipayTradeService($config);
        /**
         * alipay.trade.refund (统一收单交易退款接口)
         * @param $builder object 业务参数，使用buildmodel中的对象生成。
         * @return $response 支付宝返回的信息
         */
        $response = $aop->Refund($RequestBuilder);
        return $response;
    }

    /**
     * //请二选一设置
     * @param $out_trade_no //商户订单号，商户网站订单系统中唯一订单号
     * @param $transaction_id //支付宝交易号
     * @return bool|mixed|SimpleXMLElement|SimpleXMLElement[]|string 提交表单HTML文本
     * @throws Exception
     */
    public function queryOrder($out_trade_no, $transaction_id){
        //构造参数
        $RequestBuilder = new AlipayTradeQueryContentBuilder();
        $RequestBuilder->setOutTradeNo($out_trade_no);
        $RequestBuilder->setTradeNo($transaction_id);
        $config = config('pay.ali_pay');
        $aop = new AlipayTradeService($config);

        /**
         * alipay.trade.query (统一收单线下交易查询)
         * @param $builder 业务参数，使用buildmodel中的对象生成。
         * @return $response 支付宝返回的信息
         */
        $response = $aop->Query($RequestBuilder);
        return $response;
    }

    /**
     * 查询退款  //请二选一设置
     * @param $data
     * @return bool|mixed|SimpleXMLElement|string 提交表单HTML文本
     * @internal param string $out_trade_no //商户订单号，商户网站订单系统中唯一订单号
     * @internal param string $transaction_id //支付宝交易号
     * @internal param string $refund_no //请求退款接口时，传入的退款请求号，如果在退款请求时未传入，则该值为创建交易时的外部交易号，必填
     * @throws Exception
     */
    public function refundQuery($data){
        //商户订单号，商户网站订单系统中唯一订单号
        $out_trade_no = trim($data['out_trade_no']);

        //支付宝交易号
        $trade_no = trim($data['transaction_id']);
        //请二选一设置

        //请求退款接口时，传入的退款请求号，如果在退款请求时未传入，则该值为创建交易时的外部交易号，必填
        $out_request_no = trim($data['refund_out_no']);
        //构造参数
        $RequestBuilder=new AlipayTradeFastpayRefundQueryContentBuilder();
        $RequestBuilder->setOutTradeNo($out_trade_no);
        $RequestBuilder->setTradeNo($trade_no);
        $RequestBuilder->setOutRequestNo($out_request_no);
        $config = config('pay.ali_pay');
        $aop = new AlipayTradeService($config);
        /**
         * 退款查询   alipay.trade.fastpay.refund.query (统一收单交易退款查询)
         * @param $builder object 业务参数，使用buildmodel中的对象生成。
         * @return $response 支付宝返回的信息
         */
        $response = $aop->refundQuery($RequestBuilder);
        return $response;
    }

    /**
     * @param $order
     * @return array
     * @throws Exception
     */
    public function pay($order) {
        $request = new AlipayTradeAppPayRequest();
        $data = [
            'body' => '普通商品',
            'subject' => '普通商品',
            'out_trade_no' => $order['order_no'],
            'timeout_express' => '1d',  //
            'total_amount' => $order['pay_price']/100, //单位：元
            'product_code' => 'QUICK_MSECURITY_PAY'
        ];
        $config = config('pay.ali_app_pay');
        $bizcontent = json_encode($data, JSON_UNESCAPED_UNICODE);
        $request->setNotifyUrl($config['notify_url']);
        $request->setBizContent($bizcontent);
        $appHandler  = new AppPayHandler($config);
        //这里和普通的接口调用不同，使用的是sdkExecute
        $response = $appHandler->appPay($request);;
        //        //htmlspecialchars是为了输出到页面时防止被浏览器将关键参数html转义，实际打印到日志以及http传输不会有这个问题
        //        return htmlspecialchars($response);//就是orderString 可以直接给客户端请求，无需再做处理。
        return ['orderString' => $response];
    }
}