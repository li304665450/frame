<?php
/**
 * Created by PhpStorm.
 * User: 30466
 * Date: 2017/11/22
 * Time: 16:28
 */

namespace lib\exception;



/**
 * 自定义接口报错渲染类
 * Class ApiHandleException
 * @package app\common\lib\exception
 */
class ApiHandleException extends H{

    /**
     * @var int http状态码
     */
    private $httpCode = 500;

    public function render(\Exception $e)
    {
        if (config('app_debug') == true){
            return parent::render($e);
        }

        $result = [
            'status' => 0,
            'msg' => $e->getMessage(),
            'data' => ''
        ];

        if ($e instanceof ApiException) {
            $this->httpCode = $e->httpCode;
        }

        return json($result,$this->httpCode);
    }

}