<?php
/**
 * Created by PhpStorm.
 * User: 30466
 * Date: 2018/3/9
 * Time: 11:42
 */

// 定义应用目录
define('APP_PATH', __DIR__ . '/../app');

//配置文件目录
define('CONF_PATH',__DIR__ . '/../config');

//自动加载类
require_once __DIR__ . '/../vendor/autoload.php';

//框架入口
require_once __DIR__ . '/../marsphp/start.php';