<?php

namespace tp51\pay\service\ali\pay;

use tp51\pay\sdk\ali\aop\request\AlipayFundAccountQueryRequest;
use tp51\pay\service\ali\BaseAli;

class AliQuery extends BaseAli {

    /**
     * @param $params
     * @return array
     * @throws \Exception
     */
    public function queryBalance($params){
        $request = new AlipayFundAccountQueryRequest();
        $data = [
            "alipay_user_id"       => $params['alipay_user_id'],
            'account_type'         => 'ACCTRANS_ACCOUNT',
        ];
        $bizcontent = json_encode($data, JSON_UNESCAPED_UNICODE);
        $request->setBizContent($bizcontent);
        $response =$this->aop->execute ( $request);

        $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
        $resultCode = $response->$responseNode->code;
        if(!empty($resultCode)&&$resultCode == 10000){
            $returnData = [
                "balance"   => $response->$responseNode->available_amount,
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
}