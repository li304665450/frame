<?php

//关闭系统报错，改用自己的方式
ini_set('display_startup_errors','Off');
ini_set('display_errors','Off');
ini_set('error_reporting','E_ALL & ~E_NOTICE');
ini_set('log_errors','On');

//设置自定义报错回调方式
function appException($exception) {

    $httpCode = $exception->httpCode ?: 500;
    $trance[] = $exception->getFile().' in '.$exception->getLine();
    foreach ($exception->getTrace() as $value){
        $content = $value['file'] ?: $value['function'];
        $position = $value['line'] ?: $value['class'];
        $trance[] = $content.' in '.$position;
    }

    //报出错误信息，或只显示统一提升信息
    if (config('show_error_msg')){
        apiResult($exception->getCode(),config('error_message'),'',$httpCode);
    }else{
        apiResult($exception->getCode(),$exception->getMessage(),$trance,$httpCode);
    }
}

//指定错误处理函数
set_exception_handler('appException');
