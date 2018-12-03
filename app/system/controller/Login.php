<?php
/**
 * Created by PhpStorm.
 * User': lilei
 * Date': 2018/12/3
 * Time': 4':23 PM
 */

namespace app\system\controller;


use app\common\controller\BaseController;

class Login extends BaseController
{
    public function login(){
        echo json_encode(['token'=>'admin']);
    }

    public function save_error_logger(){

    }

}