<?php
/**
 * Created by PhpStorm.
 * User: lilei
 * Date: 2018/12/21
 * Time: 3:56 PM
 */

namespace app\system\controller;


use app\common\controller\BaseController;

class Game extends BaseController
{
    public function fetchList()
    {
        $list = model('game')->get([], ['pid']);

        $tree = [];
        foreach ($list as $value){
            if (!$value['pid']){
                $tree[$value['code_id']] = [
                    'id' => $value['id'],
                    'code_id' => $value['code_id'],
                    'name' => $value['name'],
                    'status' => $value['status']
                ];
            } else {
                $tree[$value['pid']]['children'][] = [
                    'id' => $value['id'],
                    'code_id' => $value['code_id'],
                    'name' => $value['name'],
                    'access_game' => "{$value['pid']}_{$value['code_id']}",
                    'status' => $value['status'],
                    'pid' => $value['pid']
                ];
            }
        }

        $tree = array_values($tree);

        $this->success($tree);
    }

    public function getTree()
    {
        $list = model('game')->get(['status' => 1], ['pid']);

        $tree = [];
        foreach ($list as $value){
            if (!$value['pid']){
                $tree[$value['code_id']] = [
                    'id' => $value['code_id'],
                    'name' => $value['name']
                ];
            } else {
                if (!$tree[$value['pid']])
                    continue;

                $tree[$value['pid']]['children'][] = [
                    'id' => $value['code_id'],
                    'name' => $value['name'],
                    'access_game' => "{$value['pid']}_{$value['code_id']}"
                ];
            }
        }

        $tree = array_values($tree);

        $this->success($tree);
    }

    public function create()
    {
        $param = input('put');

        if (!$param)
            $this->success('');

        $param['update_time'] = date('Y-m-d h:i:s');

        $insert = model('game')->insert($param);

        $this->success($insert);
    }

    public function update()
    {
        $param = input('post');

//        $this->success($param);

        if (!$param)
            $this->success('');

        unset($param['update_time']);

        $update = model('game')->updateById($param['id'], $param);

        $this->success($update);
    }

}