<?php
/**
 * Created by PhpStorm.
 * User: lilei
 * Date: 2017/11/22
 * Time: 16:57
 */

namespace lib\exception;


/**
 * 自定义接口报错类
 * Class ApiException
 * @package app\common\lib\exception
 */
class ApiException extends \Exception {

    //提示信息
    public  $message;
    //http状态码
    public $httpCode;
    //系统状态码
    public $code;

    public function __construct($message = "", $httpCode = 500, $code = 3)
    {
        $this->message = $message;
        $this->httpCode = $httpCode;
        $this->code = $code;
    }
}