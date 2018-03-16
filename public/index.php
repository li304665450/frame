<?php
/**
 * Created by PhpStorm.
 * User: 30466
 * Date: 2018/3/9
 * Time: 11:42
 */

require_once __DIR__ . '/../vendor/autoload.php';
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\SwiftMailerHandler;

//异常处理模块
$whoops = new \Whoops\Run();
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler());
$whoops->register();

//异常日志记录模块
$log = new Logger("my-frame-log");
$log->pushHandler(new StreamHandler('log/monolog.log', logger::WARNING));

//添加swiftmailer处理重要错误,发送邮件
$transport = \Swift_SmtpTransport::newInstance('https://mail.163.com',80)
    ->setUsername('15600017090')
    ->setPassword('li8369945');
$mailer = \Swift_Mailer::newInstance($transport);
$message = \Swift_Message::newInstance()
    ->setSubject('Website error!')
    ->setFrom(array('304665450@qq.com' => 'John Doe'))
    ->setTo(array('15600017090@163.com'));
$log->pushHandler(new SwiftMailerHandler($mailer, $message, logger::CRITICAL));

//$log->addCritical('The server is no fire');


//路由处理模块
$route = $_SERVER['PATH_INFO'];
$param = explode('/', $route);
$group = $param[1];
$controller = ucfirst($param[2]);
$action = $param[3];
$controllerName = 'app\\'.$group.'\\controller\\' . $controller;
$result = call_user_func_array(array($controllerName, $action),$_GET);
//返回值为字符串，渲染view页面
if (is_array($result)){
    foreach ($result['assign'] as $k=>$v){
        $$k = $v;
    }
    require '../app/'.$group.'/view/'.$controller.'/'.$result['view'].'.php';
}