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

class User extends BaseController
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
        $group = model('userGroup')->get([],["id in ({$user['group']})"]);

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

    public function userList(){
        $param = input('get');

        $groupList = model('userGroup')->get();

        $groupList = array_column($groupList,'name','id');

        $userList = model('user')->get();

        foreach ($userList as &$value){
            $arr = explode(',',$value['group']);
            $group = '';
            foreach ($arr as $k=>$v){
                if ($k == 0){
                    $group = $groupList[$v];
                }else{
                    $group .= ','.$groupList[$v];
                }
            }
            $value['group'] = $group;
        }

        $this->success(['items' => $userList, 'total' => 100, 'param' => $param]);

    }

    public function groupList(){
        $param = input('get');

        if (!$param)
            $this->success('');

        $limit = $this->doLimit($param['limit']);

        $total  = model('userGroup')->getTotal($param['where']);

        $list = model('userGroup')->get($param['where'],[],$param['order'],$limit);

        $this->success(['items' => $list, 'total' => $total['total'], 'param' => $param]);
    }

    public function createGroup(){
        $param = input('post');

        if (!$param)
            $this->success('');

        $param['update_time'] = date('Y-m-d h:i:s');

        $insert = model('userGroup')->insert($param);

        $this->success($insert);
    }

    public function updateGroup()
    {
        $param = input('post');

        if (!$param)
            $this->success('');

        unset($param['update_time']);

        $update = model('userGroup')->updateById($param['id'], $param);

        $this->success($update);
    }

    public function test(){
        $update = model('userGroup')->updateById(1, ['status' => 0]);
        $this->success($update);
    }

}