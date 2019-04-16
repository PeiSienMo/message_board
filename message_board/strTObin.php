<?php
/**
 * Created by PhpStorm.
 * User: Mo
 * Date: 2018/6/2
 * Time: 13:49
 */
header("Content-type: text/html; charset=utf-8");

/**
 * 将字符串转换成二进制
 * @param type $str
 * @return type
 */
function StrToBin($str){
    //1.列出每个字符
    $arr = preg_split('/(?<!^)(?!$)/u', $str);
    //2.unpack字符
    foreach($arr as &$v){
        $temp = unpack('H*', $v);
        $v = base_convert($temp[1], 16, 2);
        unset($temp);
    }

    return join(' ',$arr);

}