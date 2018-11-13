<?php
/**
 * Created by PhpStorm.
 * User: tuyou
 * Date: 2018/6/12
 * Time: 上午10:16
 */

//加载助手函数
require_once __DIR__ . '/function.php';

//加载项目全局函数
require_once __DIR__ . '/../app/common.php';

//加载配置信息
require_once __DIR__ . '/load/loadConfig.php';

//加载错误处理方式
require_once __DIR__ . '/load/loadError.php';

//加载默认加载模块
//require_once __DIR__ . '/load/loadModule.php';

//在非命令行模式，加载路由模块
if (php_sapi_name() != 'cli'){
    require_once __DIR__ . '/load/loadRoute.php';
}
