<?php
/**
 * Created by PhpStorm.
 * User: tuyou
 * Date: 2018/6/12
 * Time: 上午10:25
 */

return [
    // 错误显示信息,非调试模式有效
    'error_message'             => '系统错误！请稍后再试～',
    // 显示错误信息
    'show_error_msg'            => false,
    //model默认数据库配置
    'model_default_database'    => 'default',
    //restful接口请求方法map
    'restful_method_action'    => [
        'GET'     => 'fetchList',
        'POST'    => 'update',
        'PUT'     => 'create',
        'DELETE'  => 'delete',
        'OPTIONS' => 'options'
    ],
];