<?php
/**
 * Created by PhpStorm.
 * User: lilei
 * Date: 2018/12/7
 * Time: 2:53 PM
 */

namespace lib;

/**
 * 框架工具类
 * Class Unit
 * @package lib\exception
 */
class Unit
{
    /**
     * 对象转数组
     * @param $obj
     * @return array|void
     */
    public static function objToArray($obj) {
        $obj = (array)$obj;
        foreach ($obj as $k => $v) {
            if (gettype($v) == 'resource') {
                return;
            }
            if (gettype($v) == 'object' || gettype($v) == 'array') {
                $obj[$k] = (array)object_to_array($v);
            }
        }

        return $obj;
    }


    /**
     * 驼峰字符串转自定义分隔符
     * @param $str
     * @param string $sep 分隔符(默认为空格)
     * @return bool|null|string|string[]
     */
    public static function humpToLine($str,$sep = ' '){
        $str = preg_replace_callback('/([A-Z]{1})/',function($matches) use ($sep) {
            return $sep.strtolower($matches[0]);
        },$str);
        strpos($str,$sep) === 0 && $str = substr($str,1);
        return $str;
    }

    /**
     * 分隔符字符串转驼峰
     * @param $str
     * @param string $sep 分隔符(可传多个 -*_ 连着写就行)
     * @return null|string|string[]
     */
    public static function lineToHump($str, $sep = ' ')
    {
        $str = preg_replace_callback("/([$sep]+([a-z]{1}))/i",function($matches){
            return strtoupper($matches[2]);
        },$str);
        return $str;
    }



}