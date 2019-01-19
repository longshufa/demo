<?php
/**
 * User: lyndon
 * Date: 2019/1/19 0019
 * Time: 16:50
 */

namespace tp51\pay\service;


class ToolService {
    /**
     * 创建订单号
     * @param string $prefix
     * @return string
     */
    public static function createOrderNo($prefix = 'OR') {
        $microSec = microtime(true) * 10000 % 10000;
        if ($microSec < 1000) { //
            $microSec = "0" . $microSec;
        }
        return $prefix . date('YmdHis') . $microSec . rand(1000, 9999);
    }
}