<?php
/**
 * User: lyndon
 * Date: 2019/1/19 0019
 * Time: 16:50
 */

namespace tp51\pay\service;


class ToolService {
    /**
     * 验证http 地址是否合法
     * @param $url
     * @return bool
     */
    public static function checkUrl($url){
        if( preg_match("/^(http:\/\/|https:\/\/).*$/", $url)){
            return $url;
        }else{
            return false;
        }
    }
}