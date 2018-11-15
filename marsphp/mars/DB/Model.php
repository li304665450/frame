<?php
/**
 * Created by PhpStorm.
 * User: lilei
 * Date: 2018/6/12
 * Time: 下午3:20
 */

namespace mars\DB;


class Model
{

    public $database = 'default';  //数据库配置名，默认为default
    public $otherDB = '';          //若需当前连接该地址下其他库，填写库名
    public $table = '';            //表名
    public $db = '';               //DB操作对象
    public $query = '';            //sql操作对象
    public $field = '';           //查询字段，默认所有字段

    public function __construct($database = '')
    {
        $database = $database ?: $this->database;
        $path_arr = explode('\\',get_called_class());
        $modelName = strtolower(end($path_arr));
        $this->query = new Query($database,$modelName,$this->otherDB);
    }

    /**
     * 设置需要查询的字段
     * @param string $field
     */
    public function setField($field)
    {
        $this->field = $field;
    }

    /**
     * 获取最后一次操作的sql语句
     * @return string
     */
    public function getLastSql(){
        return $this->query->getLastSql();
    }

    /**
     * 数据获取方法
     * @param array $condition 筛选条件，数字为limit取几条，数组为筛选条件
     * @param string $limit 分页条件
     * @param array $condExt 除equals外的条件
     * @param array $order 排序条件
     * @param array $group 分组条件
     * @param array $select 结果集
     * return array|null
     */
    /**
     * 数据获取方法
     * @param array $condition 筛选条件，数字为limit取几条，数组为筛选条件
     * @param array $condExt
     * @param array $order 排序条件
     * @param array $limit 分页条件
     * @param array $select 查询条件
     * @param array $group 分组条件
     * @return array|null
     * @throws \Exception
     */
    public function get($condition = [],$condExt = [], $order = [],$limit = [],$select =[], $group = []){

        $limit && $condition['_limit'] = $limit;
        $condExt && $condition['_ext'] = $condExt;
        $order && $condition['_order'] = $order;
        $group && $condition['_group'] = $group;
        $this->field && $condition['_select'] = $this->field;
        $select && $condition['_select'] = $select;

        return $this->query->get($condition);

    }

    /**
     * 数据插入方法
     * @param array $data 数据数组
     * @return mixed|null 插入后的行id
     * @throws \Exception
     */
    public function insert($data){
        return $this->query->insert($data);
    }

    /**
     * 按ID更新数据
     * @param $id
     * @param array $data 数据集
     * @return mixed|null
     * @throws \Exception
     */
    public function updateById($id,$data){
        return $this->query->update(['id'=>$id],$data);
    }

    /**
     * 数据更新修改方法
     * @param array $condition 行筛选条件
     * @param array $data 数据数组
     * @return mixed|null 影响行数
     * @throws \Exception
     */
    public function update($condition,$data){
        return $this->query->update($condition,$data);
    }

    /**
     * 按ID删除数据
     * @param $id
     * @return mixed|null
     * @throws \Exception
     */
    public function deleteById($id){
        return $this->query->delete(['id'=>$id]);
    }

    /**
     * 按条件数据删除
     * @param array $condition 行筛选条件
     * @return mixed|null 影响行数
     * @throws \Exception
     */
    public function delete($condition){
        return $this->query->delete($condition);
    }



}