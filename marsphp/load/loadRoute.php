<?php
/**
 * Created by PhpStorm.
 * User: tuyou
 * Date: 2018/6/12
 * Time: 上午10:18
 */

//路由处理模块
$route = $_SERVER['PATH_INFO'];
$param = explode('/', $route);
$group = $param[1] ?: 'index';
$controller = $param[2] ?: 'index';
$action = $param[3] ?: 'index';
unset($param);
$controllerName = 'app\\'.$group.'\\controller\\' . ucfirst($controller);

//run
(new $controllerName())->$action();