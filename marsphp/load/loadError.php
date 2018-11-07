<?php

//生产环境下的错误处理
if (!config('debug')){

    //页面不显示报错信息
    ini_set('display_startup_errors','Off');
    ini_set('display_errors','Off');
    ini_set('error_reporting','E_ALL & ~E_NOTICE');
    ini_set('log_errors','On');

    //设置自定义报错回调方式
    function appException($exception) {
        $message = $exception->getMessage();
        $trance = [];
        foreach ($exception->getTrace() as $value){
            $trance[] = $value['file'].' in '.$value['line'];
        }

        if (config('config')){
            apiResult($exception->code,$message,$trance,$exception->httpCode);
        }else{
            apiResult($exception->code,'系统内部错误','',$exception->httpCode);
        }
    }

    //指定错误处理函数
    set_exception_handler('appException');
}
