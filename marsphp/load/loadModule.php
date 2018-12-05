<?php
/**
 * Created by PhpStorm.
 * User: tuyou
 * Date: 2018/6/12
 * Time: 上午10:20
 */

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\SwiftMailerHandler;

//设置http头信息，解决前端调用api跨域问题
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Method: *');
header('Access-Control-Allow-Headers: *');

////异常处理模块
//$whoops = new \Whoops\Run();
//$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler());
//$whoops->register();
//
////异常日志记录模块
//$log = new Logger("my-frame-log");
//$log->pushHandler(new StreamHandler('log/monolog.log', logger::WARNING));
//
////添加swiftmailer处理重要错误,发送邮件
//$transport = \Swift_SmtpTransport::newInstance('https://mail.163.com',25)
//    ->setUsername('15600017090')
//    ->setPassword('li8369945');
//$mailer = \Swift_Mailer::newInstance($transport);
//$message = \Swift_Message::newInstance()
//    ->setSubject('Website error!')
//    ->setFrom(array('304665450@qq.com' => 'John Doe'))
//    ->setTo(array('15600017090@163.com'));
//$log->pushHandler(new SwiftMailerHandler($mailer, $message, logger::CRITICAL));

//$log->addCritical('The server is no fire');