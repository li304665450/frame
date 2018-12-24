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


    public function fetchList(){
        $param = input('get');

        $limit = $this->doLimit($param['limit']);

        $groupList = model('userGroup')->get();

        $groupList = array_column($groupList,'name','id');

        $userList = model('user')->get($param['where'],[],$param['order'],$limit);

//        $this->success(model('user')->getLastSql());

        //把用户组ID转为名称
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

    public function create(){
        $param = input('put');

        if (!$param)
            $this->success('');

        $param['update_time'] = date('Y-m-d h:i:s');

        $insert = model('user')->insert($param);

        $this->success($insert);
    }

    public function update()
    {
        $param = input('post');

        if (!$param)
            $this->success('');

        unset($param['update_time']);

        $update = model('user')->updateById($param['id'], $param);

        $this->success($update);
    }

}