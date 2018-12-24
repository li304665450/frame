<?php
/**
 * Created by PhpStorm.
 * User: lilei
 * Date: 2018/12/21
 * Time: 3:56 PM
 */

namespace app\system\controller;


use app\common\controller\BaseController;
use app\common\lib\Common;

class Game extends BaseController
{
    public function getTree()
    {
        $list = model('game')->get([],[],['pid']);

        $tree = [];
        foreach ($list as $value){
            if (!$value['pid']){
                $tree[$value['code_id']] = [
                    'id' => $value['code_id'],
                    'name' => $value['name']
                ];
            } else {
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

}