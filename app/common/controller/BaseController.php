<?php
/**
 * Created by PhpStorm.
 * User: lilei
 * Date: 2018/11/30
 * Time: 4:08 PM
 */

namespace app\common\controller;


use mars\Controller;

class BaseController extends Controller
{
    public function get(){
        debug($this->getModel());
    }

    public function doLimit($limit){
        $start = ($limit['page'] -1) * $limit['size'];
        return [$start,$limit['size']];
    }

    public function update(){

    }

    public function insert(){

    }

    public function deleted(){

    }

    protected function getModel(){
        return $this->model ?: ucfirst(getName('controller'));
    }

}