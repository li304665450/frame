<?php
/**
 * Created by PhpStorm.
 * User: lilei
 * Date: 2018/12/6
 * Time: 9:43 AM
 */

namespace lib;


class Request
{

    public static function getInput(){
        return json_decode(file_get_contents("php://input"), true);
    }

    /**
     * post参数获取方法
     * @return bool|string
     */
    public static function getPost(){

        if ($_SERVER['CONTENT_TYPE'] == 'application/json;charset=UTF-8')
            return self::getInput();

        return $_POST;

    }



}