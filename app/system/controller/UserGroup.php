<?php
/**
 * Created by PhpStorm.
 * User: lilei
 * Date: 2018/12/24
 * Time: 11:47 AM
 */

namespace app\system\controller;


use app\common\controller\BaseController;

class UserGroup extends BaseController
{
    public function fetchList(){
        $param = input('get');

        if (!$param)
            $this->success('');

        $limit = $this->doLimit($param['limit']);

        $total  = model('userGroup')->getTotal($param['where']);

        $list = model('userGroup')->get($param['where'],[],$param['order'],$limit);

        //把权限和游戏内容转为数组
        foreach ($list as &$group_item) {
            $group_item['access'] = explode(',', $group_item['access']);
            $group_item['access_game'] = explode(',', $group_item['access_game']);
        }

        $this->success(['items' => $list, 'total' => $total['total'], 'param' => $param]);
    }

    public function create(){
        $param = input('put');

        if (!$param)
            $this->success('');

        $param['update_time'] = date('Y-m-d h:i:s');

        $insert = model('userGroup')->insert($param);

        $this->success($insert);
    }

    public function update()
    {
        $param = input('post');

        if (!$param)
            $this->success('');

        unset($param['update_time']);
        $param['access'] = implode(',', $param['access']);
        $param['access_game'] = implode(',', $param['access_game']);

        $update = model('userGroup')->updateById($param['id'], $param);

        $this->success($update);
    }

    public function fetchMap(){
        $groupList = model('userGroup')->get();
        $groupList = array_column($groupList,'name','id');

        $this->success($groupList);
    }

}