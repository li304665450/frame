<?php
/**
 * Created by PhpStorm.
 * User: tuyou
 * Date: 2018/6/12
 * Time: 上午10:16
 */

//加载助手函数
require_once __DIR__ . '/function.php';

////加载load目录中所有加载项
//$file = require_dir(__DIR__.'/load');
//
//foreach ($file as $value){
//    require_once $value;
//}

//加载配置信息
require_once __DIR__ . '/load/loadConfig.php';

//加载默认加载模块
require_once __DIR__ . '/load/loadModule.php';

//加载路由模块
require_once __DIR__ . '/load/loadRoute.php';