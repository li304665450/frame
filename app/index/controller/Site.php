<?php
/**
 * Created by PhpStorm.
 * User: 30466
 * Date: 2018/3/9
 * Time: 12:20
 */
namespace app\index\controller;

use mars\Controller;

class Site extends Controller
{

    public function action(){
        echo  "this is index/site/action";
    }

    public function view()
    {
        $body = 'this is admin information';
//        echo __DIR__;
        require __DIR__.'/../view/site/view.php';
    }


}