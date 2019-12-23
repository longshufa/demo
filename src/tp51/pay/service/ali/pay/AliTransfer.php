<?php

namespace tp51\pay\service\ali\pay;

use think\facade\Log;
use tp51\pay\sdk\ali\aop\request\AlipayFundTransOrderQueryRequest;
use tp51\pay\sdk\ali\aop\request\AlipayFundTransToaccountTransferRequest;
use tp51\pay\sdk\ali\aop\request\AlipaySystemOauthTokenRequest;
use tp51\pay\sdk\ali\aop\request\AlipayUserInfoShareRequest;
use tp51\pay\service\ali\BaseAli;

class AliTransfer extends BaseAli {

    const PAYEE_TYPE_LOGONID = "ALIPAY_LOGONID"; // ALIPAY_LOGONID 支付宝登录号，支持邮箱和手机号格式。
    const PAYEE_TYPE_USERID  = "ALIPAY_USERID"; // ALIPAY_USERID 支付宝账号对应的支付宝唯一用户号。
    /**
     * @param $params
     * @return string
     */
    public function toAccountTransfer($params){
        $request = new AlipayFundTransToaccountTransferRequest();
        $data = [
            "out_biz_no"    => $params["out_trade_no"],
            "payee_type"    => (isset($params["payee_type"]) && $params["payee_type"]) ? $params["payee_type"] : self::PAYEE_TYPE_LOGONID, ////收款方类型 默认登录号
            "payee_account" => $params["payee_account"], // 收款方账户
            "amount"        => $params["amount"]/100, // 转账金额: 单位元
        ];
		 if( isset($params['remark']) && $params['remark']){
            $data['remark'] = $params['remark'];
        }
        $bizcontent = json_encode($data, JSON_UNESCAPED_UNICODE);
        $request->setBizContent($bizcontent);
        //这里和普通的接口调用不同，使用的是sdkExecute
        $response = $this->aop->execute($request);
        $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
        $resultCode = $response->$responseNode->code;
        if(!empty($resultCode)&&$resultCode == 10000) {
            $returnData = [
                "out_trade_no"   => $response->$responseNode->out_biz_no,
                "transaction_id" => $response->$responseNode->order_id,
                "pay_date"       => $response->$responseNode->pay_date,
            ];
            return $returnData;
        }else{
            $code    = $response->$responseNode->code;
            $message = $response->$responseNode->msg;
            $subCode = $response->$responseNode->sub_code;
            $subMsg  = $response->$responseNode->sub_msg;
            throw new \Exception("code:{$code}, " . " msg: {$message}, " . "subCode:" . $subCode . "subMsg:" . $subMsg );
        }
    }

    /***
     * 转账订单查询
     * @return array
     * @throws \Exception
     */
    public function query($params){
        $request = new AlipayFundTransOrderQueryRequest();
        $data = [
            "out_biz_no"     => $params["out_trade_no"],
            "order_id"       => $params["transaction_id"], // 支付宝转账单据号
        ];
        $bizcontent = json_encode($data, JSON_UNESCAPED_UNICODE);
        $request->setBizContent($bizcontent);
        //这里和普通的接口调用不同，使用的是sdkExecute
        $response = $this->aop->execute($request);
        $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
        $resultCode = $response->$responseNode->code;
        if(!empty($resultCode)&&$resultCode == 10000) {
            $returnData = [
                "out_trade_no"   => $response->$responseNode->out_biz_no,
                "transaction_id" => $response->$responseNode->order_id,
                'pay_date'       => $response->$responseNode->pay_date,
                'status'         => $response->$responseNode->status,
            ];
            $status = $response->$responseNode->status;
            if( $status == 'FAIL'){
                $returnData['fail_reason'] = $response->$responseNode->fail_reason;
                $returnData['error_code'] = $response->$responseNode->error_code;
            }
            return $returnData;
        }else{
            $code    = $response->$responseNode->code;
            $message = $response->$responseNode->msg;
            $subCode = $response->$responseNode->sub_code;
            $subMsg  = $response->$responseNode->sub_msg;
            throw new \Exception("code:{$code}, " . " msg: {$message}, " . "subCode:" . $subCode . "subMsg:" . $subMsg );
        }
    }
}