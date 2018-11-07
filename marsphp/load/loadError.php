<?php

$isDev = config('model.isDev');

//生产环境下的错误处理
if (!$isDev){

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

        apiResult($exception->code,$message,$trance,$exception->httpCode);

    }

    //指定错误处理函数
    set_exception_handler('appException');
}

////设置自定义报错回调方式
//function appException($exception) {
//    $message = $exception->getMessage();
//    $trance = [];
//    foreach ($exception->getTrace() as $value){
//        $trance[] = $value['file'].' in '.$value['line'];
//    }
//
//    apiResult($exception->code,$message,$trance,$exception->httpCode);
//
//}
//
////指定错误处理函数
//set_exception_handler('appException');



