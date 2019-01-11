<?php
declare(ticks=1);

/**
 * 获取目录下所有文件名
 * @param string $dir 目录路径
 * @return array 包含所有文件名的数组
 */
function require_dir(string $dir):array
{
    $file_arr = [];
    if (is_dir($dir)) {
        if ($dh = opendir($dir)) {
            while (($file = readdir($dh)) !== false) {
                if ($file != '.' && $file != '..'){
                    list($name) = explode('.',$file);
                    $file_arr[$name] = $dir.'/'.$file;
                }

            }
            closedir($dh);
        }
    }
    return $file_arr;
}

/**
 * 按规则加载目录下所有配置文件
 * @param $path
 * @return array
 */
function configPlant ($path) {

    if (!is_dir($path)) return [];

    $config_default = [];
    $config_extend = [];
    $file = require_dir($path);
    foreach ($file as $key=>$item){
        if (!is_dir($item)){
            if ($key == 'config'){
                $config_default = require_once $item;
            }else{
                $config_extend[$key] = require_once $item;
            }
        }
    }
    return array_merge($config_default,$config_extend);
};

/**
 * 获取配置信息
 * @param string|null $name 配置名以点间隔
 * @return mixed|string 配置信息数组
 */
function config(string $name = null){

    $config = $GLOBALS['config'];

    if (!empty($name)){
       $arr = explode('.',$name);

       foreach ($arr as $v){
           $config = $config[$v] ?: '';
       }
    }

    return $config;
}

/**
 * 模型类助手函数
 * @param string $model 模型类类名
 * @param string|null $group 分组名，默认当前分组
 * @return \mars\DB\Model 模型类实例
 */
function model(string $model, string $group = null):\mars\DB\Model
{
    $group = empty($group) ? $GLOBALS['group'] : $group;
    $result = null;
    if (!empty($model)){
            $modelName = 'app\\'.$group.'\\model\\' . $model;
            $result = !empty($GLOBALS['model'][$group][$model]) ? $GLOBALS['model'][$group][$model] : new $modelName();
            $GLOBALS['model'][$group][$model] = $result;
    }

    return $result;
}

/**
 * 数据快速操作类助手函数
 * @param string $database db配置名
 * @param string $table 表名
 * @param string $otherDB 连接配置下其他库名
 * @return \mars\DB\Query 数据类实例
 */
function query(string $database, string $table, string $otherDB = ''):\mars\DB\Query
{
    $result = null;
    if ($database && $table){
        if (empty($GLOBALS['query'][$database][$otherDB]))
            $GLOBALS['query'][$database][$otherDB] = new \mars\DB\Query($database,$table,$otherDB);

        $result = $GLOBALS['query'][$database][$otherDB];
    }
    return $result;
}

/**
 * 页面信息打印方法
 */
function debug()
{
    $argList = func_get_args();
    foreach ( $argList as $value )
    {
        echo "<pre>";
        print_r( $value );
        echo "</pre>";
    }
}

/**
 * cli命令行打印方法
 */
function debugCli()
{
    $argList = func_get_args();
    foreach ( $argList as $value )
    {
        print_r( $value );
    }
    echo "\n";
}

/**
 * api回调结果，json格式及http状态码处理
 * @param $result
 * @param $httpCode
 */
function json($result,$httpCode)
{
    http_response_code($httpCode);
    echo json_encode($result);
    exit();
}

/**
 * api接口回调消息封装方法
 * @param int $status 业务状态码
 * @param string $msg 提示信息
 * @param array $data 数据
 * @param int $httpCode http状态码
 * @return void
 */
function apiResult(int $status, string $msg, $data = [], int $httpCode = 200):void
{
    $result = [
        'status' => $status,
        'msg' => $msg,
        'data' => $data
    ];
    json($result, $httpCode);
}

/**
 * 获取全局信息
 * @param string $name
 * @return mixed
 */
function getName($name = 'controller')
{
    return $GLOBALS[$name];
}

/**
 * 获取request请求传递的参数
 * @param string $key http请求类型
 * @param array $default 默认需要的数据
 * @return array 数据
 */
function input(string $key = '', array $default = []):array
{

    switch ($key){
        case 'get':
            $request = $_GET;
            break;
        case 'post':
            $request = \lib\Request::getPost();
            break;
        case 'put':
            $request = \lib\Request::getInput();
            break;
        case 'delete':
            $request = \lib\Request::getInput();
            break;
        default:
            $request  = array_merge($_GET,\lib\Request::getPost());
            break;
    }

    if ($default){
        $request = array_merge($request, $default);
    }

    return \lib\Unit::recuArr($request);
}
