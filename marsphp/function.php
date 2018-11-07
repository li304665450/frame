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

// 打印出错信息
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
 * api回调结果，json格式及http状态码处理
 * @param $result
 * @param $httpCode
 */
function json($result,$httpCode){
    http_response_code($httpCode);
    echo json_encode($result);
}