<?php
/**
 * Created by PhpStorm.
 * User: tuyou
 * Date: 2018/6/12
 * Time: 上午10:18
 */

//路由处理模块
$route = $_SERVER['PATH_INFO'] ?: '/index/index/index';
$param = explode('/', $route);
$group = $param[1];
$controller = $param[2];
$action = $param[3];
$controllerName = 'app\\'.$group.'\\controller\\' . ucfirst($controller);

$controll = new $controllerName();
$controll->$action();
