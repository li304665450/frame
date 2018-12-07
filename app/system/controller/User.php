<?php
/**
 * Created by PhpStorm.
 * User: lilei
 * Date: 2018/12/3
 * Time: 6:32 PM
 */

namespace app\system\controller;


use app\common\controller\BaseController;
use app\common\lib\Request;
use lib\exception\ApiException;

class User extends BaseController
{
    /**
     * 登录
     */
    public function login(){
        $data = input('post');

        $user = model('user')->get([
            'userName' => $data['userName'],
            'password' => $data['password']
        ]);

        if ($user)
            $this->success(['token' => $user['token']]);

        $this->error('账号或密码错误');
    }

    public function save_error_logger(){

        $this->success(input('post'));

    }

    public function getInfo(){
        $data = input('get');

        $user = model('user')->get(['token' => $data['token']]);
        $group = model('userGroup')->get(['id' => $user['group']]);

        if ($group){
            $result = [
                'roles' => ['admin'],
                'introduction' => '我是超级管理员',
                'avatar' => 'https://wpimg.wallstcn.com/f778738c-e4f8-4870-b634-56703b4acafe.gif',
                'name' => '李磊'
//                'name' => $user['realName']
            ];
        }
            $this->success($result);

        $this->error('用户权限错误');
    }

    public function test(){
        $user = model('usertmp')->get([
        ]);

        var_dump($user);
    }

}