<?php
/**
 * Created by PhpStorm.
 * User: 30466
 * Date: 2018/3/9
 * Time: 13:48
 */

//function sayEnglish($fName, $content) {
//    echo 'I am ' . $content;
//}
//
//function sayChinese($fName, $content, $country) {
//    echo $content . $country;
//    echo "<br>";
//}
//
//function say() {
//    $args = func_get_args();
//    call_user_func_array($args[0], $args);
//}
//
//say('sayChinese', '我是', '中国人');
//say('sayEnglish', 'Chinese');

class A {
    public static function sayChinese($fName, $content, $country) {
        echo '你好'.$fName.$content.$country;
     }
}

function say() {
    $args = func_get_args();
    call_user_func_array(array('A', 'sayChinese'),$args);
}

say('1','2'.'3');