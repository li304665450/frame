<?php
/**
 * Created by PhpStorm.
 * User: tuyou
 * Date: 2018/6/12
 * Time: 上午10:18
 */

//路由处理模块
$route = $_SERVER['PATH_INFO'];

//路由配置项
if (config('route')[$route]){
    $route = config('route')[$route]['route'];
}

//拆分路由
$param = explode('/', $route);

if (count($param) > 4)
    throw new \lib\exception\ApiException('非法URL',401);

$group = $param[1] ?: 'index';
$controller = $param[2] ?: 'index';
$action = $param[3] ?: 'index';

if (count($param) == 3)
    $action = config('restful_method_action')[$_SERVER['REQUEST_METHOD']];

unset($param);//销毁中间变量
$controllerName = 'app\\'.$group.'\\controller\\' . ucfirst($controller);

if ($group == 'common')
    throw new \lib\exception\ApiException('非法请求',401);

if (!class_exists($controllerName))
    throw new \lib\exception\ApiException('控制器不存在',404);

$controllerClass = new $controllerName();

if (!$controllerClass instanceof \mars\Controller)
    throw new \lib\exception\ApiException('非法控制器',402);

//var_dump($_SERVER['REQUEST_METHOD']);
//die();

if (!method_exists($controllerClass, $action))
    throw new \lib\exception\ApiException('访问的方法不存在',404);

//run
$controllerClass->$action();
