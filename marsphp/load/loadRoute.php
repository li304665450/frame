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
$controller = ucfirst($param[2]);
$action = $param[3];
$GLOBALS['mars']['group'] = $group;
$controllerName = 'app\\'.$group.'\\controller\\' . $controller;
$result = call_user_func_array(array($controllerName, $action),$_GET);
//返回值为字符串，渲染view页面
if (is_array($result)){
    foreach ($result['assign'] as $k=>$v){
        $$k = $v;
    }
    require '../app/'.$group.'/view/'.$controller.'/'.$result['view'].'.php';
}