<?php
/**
 * Created by PhpStorm.
 * User: lilei
 * Date: 2019/1/11
 * Time: 3:38 PM
 */

namespace app\grouptest\controller;


use mars\Controller;

class Test extends Controller
{
    public function cc(){
        debug($GLOBALS['config']);
    }

}