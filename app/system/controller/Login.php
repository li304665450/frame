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

    public function options()
    {
        $this->success('Opinons success');
    }

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
            $this->success(['token' => $user[0]['token']]);

        $this->error('账号或密码错误');
    }

    public function getInfo(){
        $param = input('get');

        $user = model('user')->get(['token' => $param['token']]);
        $group_ids = explode(',',$user[0]['group']);
        $group = model('userGroup')->get([
            'id' => [
                'in' => $group_ids
            ]
        ]);

        if ($group){
            $access = '';
            $access_game = '';
            foreach ($group as $key => $value){
                if ($key == 0) {
                    $access = $value['access'];
                    $access_game = $value['access_game'];
                }else{
                    !empty($value['access']) && $access .= ','.$value['access'];
                    !empty($value['access_game']) && $access_game .= ','.$value['access_game'];
                }
            }

            $default_game = explode('_',$user[0]['default_game']);

            array_walk($default_game, function (&$value) {
                $value = intval($value);
            });

            $result = [
                'user_id' => $user[0]['id'],
                'roles' => explode(',',$access),
                'access_game' => $this->getGameList($access_game),
                'default_game' => $default_game,
                'introduction' => '我是超级管理员',
                'avatar' => 'https://wpimg.wallstcn.com/f778738c-e4f8-4870-b634-56703b4acafe.gif',
                'name' => $user[0]['realName']
            ];
            $this->success($result);
        }

        $this->error('用户权限错误');
    }

    public function getGameList($access_game){

        $clouds = [];
        $games = [];
        foreach (explode(',', $access_game) as $value){
            $access = explode('_',$value);
            !empty($access[0]) && $clouds[] = $access[0];
            !empty($access[1]) && $games[] = $access[1];
        }

        $cloudList = model('game')->get([
            'pid' => 0,
            'code_id' => [
                'in' => $clouds
            ]
        ]);

        $gameList = model('game')->get([
            'pid' => [
                '<>' => 0
            ],
            'code_id' => [
                'in' => $games
            ]
        ]);

        $tree = [];
        foreach (array_merge($cloudList, $gameList) as $value) {
            if (!$value['pid']){
                $tree[$value['code_id']] = [
                    'value' => $value['code_id'],
                    'label' => $value['name']
                ];
            } else {
                $tree[$value['pid']]['children'][] = [
                    'value' => $value['code_id'],
                    'label' => $value['name'],
                ];
            }
        }

        return array_values($tree);
    }

}