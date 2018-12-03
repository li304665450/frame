<?php
/**
 * Created by PhpStorm.
 * User: lilei
 * Date: 2018/6/12
 * Time: 上午10:49
 */

/**
 * 获取目录下所有文件名
 * @param dir 目录路径
 * @return array 包含所有文件名的数组
 */
function require_dir($dir){
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
 * 获取配置信息
 * @param name 配置名以点间隔
 * @return mixed 配置信息数组
 */
function config($name = null){

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
 * @param model 模型类类名
 * @param null group 分组名，默认当前分组
 * @return null 模型类实例
 */
function model($model,$group = null){
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
 * @param $database db配置名
 * @param $table 表名
 * @param string $otherDB 连接配置下其他库名
 * @return null
 */
function query($database,$table,$otherDB = ''){
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
function json($result,$httpCode){
    http_response_code($httpCode);
    echo json_encode($result);
}

/**
 * api接口回调消息封装方法
 * @param $status 业务状态码
 * @param $msg 提示信息
 * @param array $data 数据
 * @param int $httpCode http状态码
 * @return \Json
 */
function apiResult($status, $msg, $data = [], $httpCode = 200){
    $result = [
        'status' => $status,
        'msg' => $msg,
        'data' => $data
    ];
    return json($result, $httpCode);
}

/**
 * 获取全局信息
 * @param string $name
 * @return mixed
 */
function getName($name = 'controller'){
    return $GLOBALS[$name];
}