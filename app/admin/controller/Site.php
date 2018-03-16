<?php
/**
 * Created by PhpStorm.
 * User: 30466
 * Date: 2018/3/9
 * Time: 12:20
 */
namespace app\admin\controller;

class Site
{

    public function action(){
        echo  "this is admin/site/action";
        echo  "<br/>";
//        echo $a.$b;
    }

    public function view()
    {
        $body = 'this is admin information';
        $assign = array(
            'body' => $body,
            'name' => 'Jack'
        );
        $rote = array(
            'view' => 'view',
            'assign' => $assign
        );
//        require '/../view/site/view.php';
        return $rote;
    }
}