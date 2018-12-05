<?php
/**
 * Created by PhpStorm.
 * User: lilei
 * Date: 2018/12/3
 * Time: 6:32 PM
 */

namespace app\system\controller;


use app\common\controller\BaseController;

class User extends BaseController
{
    public function login(){
//        http_response_code(401);
        echo json_encode(['token'=>'admin']);
    }

    public function save_error_logger(){

    }

    public function get_info(){
        $result = [
            'name' => 'super_admin',
            'user_id' => '1',
            'access' => ['super_admin', 'admin'],
            'token' => 'super_admin',
            'avator' => 'https://file.iviewui.com/dist/a0e88e83800f138b94d2414621bd9704.png'
        ];
        echo json_encode($result);
    }

}