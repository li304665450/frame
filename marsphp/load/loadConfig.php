<?php
/**
 * Created by PhpStorm.
 * User: lilei
 * Date: 2018/6/12
 * Time: 上午10:45
 */

$file = require_dir(CONF_PATH);

foreach ($file as $k => $v){
    if ($k == 'config'){
        $config_default = require_once $v;
    }else{
        $config_extend[$k] = require_once $v;
    }
}

$config = array_merge($config_default,$config_extend);

unset($config_default);
unset($config_extend);
unset($k);
unset($v);