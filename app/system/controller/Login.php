<?php
/**
 * Created by PhpStorm.
 * User: lilei
 * Date: 2018/12/24
 * Time: 4:47 PM
 */

namespace app\system\controller;


use mars\Controller;

class Login extends Controller
{
    /**
     * 登录
     */
    public function login(){
        $param = input('post');

        $user = model('user')->get([
            'userName' => $param['userName'],
            'password' => $param['password']
        ]);

        if ($user)
            $this->success(['token' => $user['token']]);

        $this->error('账号或密码错误');
    }

    public function getInfo(){
        $param = input('get');

        $user = model('user')->get(['token' => $param['token']]);
        $group = model('userGroup')->get([],["id in ({$user[0]['group']})"]);

        if ($group){
            $access = '';
            $allow_product = '';
            foreach ($group as $key => $value){
                if ($key == 0) {
                    $access = $value['access'];
                    $allow_product = $value['allow_product'];
                }else{
                    $access .= ','.$value['access'];
                    $allow_product .= ','.$value['allow_product'];
                }
            }

            $result = [
                'roles' => explode(',',$access),
                'introduction' => '我是超级管理员',
                'avatar' => 'https://wpimg.wallstcn.com/f778738c-e4f8-4870-b634-56703b4acafe.gif',
                'name' => '李磊'
//                'name' => $user['realName']
            ];
            $this->success($result);
        }

        $this->error('用户权限错误');
    }

}