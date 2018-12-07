<?php
/**
 * Created by PhpStorm.
 * User: tuyou
 * Date: 2018/6/12
 * Time: 上午10:29
 */

// +----------------------------------------------------------------------
// | 数据库配置
// +----------------------------------------------------------------------
return [
    //默认连接的数据库
    'default' => [
        // 数据库类型
        'dbms'            => 'mysql',
        // 服务器地址
        'host'        => '127.0.0.1',
        // 数据库名
        'dbName'        => 'fbi',
        // 用户名
        'user'        => 'root',
        // 密码
        'pass'        => 'li123456',
        // 端口
        'hostport'        => '3306',
        // 连接dsn
        'dsn'             => '',
        // 数据库连接参数
        'params'          => [],
        // 数据库编码默认采用utf8
        'charset'         => 'utf8',
        // 数据库表前缀
        'prefix'          => '',
    ],
    'default2' => [
        'dbms'            => 'mysql',
        'host'        => '127.0.0.1',
        'dbName'        => 'app2',
        'user'        => 'root',
        'pass'        => 'li123456',
        'hostport'        => '3306',
        'dsn'             => '',
        'params'          => [],
        'charset'         => 'utf8',
        'prefix'          => 'ims_',
    ],
    'wxbi' => [
        'dbms'            => 'mysql',
        'host'        => 'biserverha.ywdier.com',
        'dbName'        => 'bi_wxa',
        'user'        => 'dcweb',
        'pass'        => 'TuYougame2018!',
        'hostport'        => '3306',
        'dsn'             => '',
        'params'          => [],
        'charset'         => 'utf8',
        'prefix'          => '',
    ]
];