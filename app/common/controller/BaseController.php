<?php
/**
 * Created by PhpStorm.
 * User: lilei
 * Date: 2018/11/30
 * Time: 4:08 PM
 */

namespace app\common\controller;


use mars\Controller;

class BaseController extends Controller implements BaseControllerInt
{
    public function fetchList(){

    }

    public function getInfo(){

    }

    public function update(){

    }

    public function create(){

    }

    public function delete(){

    }

    public function options()
    {
        // TODO: Implement options() method.
    }

    public function doLimit($limit){

        if (!$limit)
            return [];

        $start = ($limit['page'] -1) * $limit['size'];
        return [$start,$limit['size']];
    }

    protected function getModel(){
        return $this->model ?: ucfirst(getName('controller'));
    }

}