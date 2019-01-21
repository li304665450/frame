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
    private $model;

    public function __construct()
    {
        $this->model = model($this->getModelName());
    }

    /**
     * @throws \Exception
     */
    public function fetchList(){
        $param = input('get');
        $param['_limit'] = $this->doLimit($param['_limit']);
        $this->success($this->model->get($param, $param['order']));
    }

    public function getInfo(){

    }

    /**
     * @throws \Exception
     */
    public function update(){
        $param = input('put');
        $this->success($this->model->update($param['where'],$param['data']));
    }

    /**
     * @throws \Exception
     */
    public function create(){
        $this->success($this->model->insert(input('put')));
    }

    /**
     * @throws \Exception
     */
    public function delete(){
        $this->success( $this->model->delete( input('delete') ) );
    }

    public function options()
    {
        $this->success('Opinons success');
    }


}