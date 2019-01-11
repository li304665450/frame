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

        $userList = model('user')->get($param['where'],$param['order'],$limit);

        $total  = model('user')->getTotal($param['where']);

        $this->success(['items' => $userList, 'total' => $total]);

    }

    public function create(){
        $param = input('put');

        if (!$param)
            $this->success('');

        $param['create_time'] = date('Y-m-d h:i:s');
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

        if ($param['default_game']){
            $param['default_game'] = implode('_',$param['default_game']);
        }

        $update = model('user')->updateById($param['id'], $param);

        $this->success($update);
    }

}