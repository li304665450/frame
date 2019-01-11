<?php
/**
 * Created by PhpStorm.
 * User: lilei
 * Date: 2019/1/7
 * Time: 10:51 AM
 */

namespace app\common\controller;


use mars\Controller;

class QueryBaseController extends Controller implements BaseControllerInt
{
    public $query;

    public function __construct()
    {
        $database = getName('group');
        $database = config('model_default_database') ?: $database;
        $database = $this->database ?: $database;
        $this->query = query($database,$this->getModelName());
    }

    /**
     * @throws \Exception
     */
    public function fetchList(){
        $param = input('get');
        $param['_limit'] = $this->doLimit($param['_limit']);
        $this->success($this->query->get($param));
    }

    public function getInfo(){

    }

    /**
     * @throws \Exception
     */
    public function update(){
        $param = input('put');
        $this->success($this->query->update($param['where'],$param['data']));
    }

    /**
     * @throws \Exception
     */
    public function create(){
        $this->success($this->query->insert(input('put')));
    }

    /**
     * @throws \Exception
     */
    public function delete(){
        $this->success( $this->query->delete( input('delete') ) );
    }

    public function options()
    {
        $this->success('Opinons success');
    }

}