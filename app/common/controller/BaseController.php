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
    public $database = 'default';
    public $query;

    public function __construct()
    {
        $this->query = query($this->database,$this->getModel());
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
        $this->success( $this->query->update( input('post') ) );
    }

    /**
     * @throws \Exception
     */
    public function create(){
        $param = input('put');
        $this->success($this->query->insert($param['where'],$param['data']));
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

    public function doLimit($limit){

        if (!$limit)
            return [];

        $start = ($limit['page'] -1) * $limit['size'];
        return [$start,$limit['size']];
    }

    protected function getModel(){
        return $this->model ?: getName('controller');
    }

}