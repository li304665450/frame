<?php
/**
 * Created by PhpStorm.
 * User: lilei
 * Date: 2018/9/4
 * Time: 上午11:02
 */

namespace mars\DB;


class Query
{
    public $sqlConstructor = '';   //sql语句构造类
    public $sql = '';              //最后一次操作的sql语句
    public $db = '';               //DB操作对象

    public function __construct($database,$table,$field,$otherDB = '')
    {
        $config = config('database.'.$database);
        $prefix = $config['prefix'];
        $this->field = $field;
        $this->db = new DB($database,$this->otherDB);
        $this->sqlConstructor = new  Sql($prefix.$table);
    }

    /**
     * 获取最后一次操作的sql语句
     * @return string
     */
    public function getLastSql(){
        return $this->sql;
    }

    /**
     * 数据获取方法
     * @param array $condition
     * return array|null
     */
    public function get($condition = []){

        $this->sqlConstructor->select($condition);

        $set = $this->sqlConstructor->getSet();

        $this->sql = $set['outSql'];

        return $this->db->query($set['doSql'], $set['sqlParam']) ? $this->db->getFetch() : null;

    }

    /**
     * 数据插入方法
     * @param $data 数据数组
     * @return mixed|null 插入后的行id
     */
    public function insert($data){

        $this->sqlConstructor->insert($data);

        $set = $this->sqlConstructor->getSet();

        $this->sql = $set['outSql'];

        return $this->db->query($set['doSql'], $set['sqlParam']) ? $this->db->getInsertId() : null;

    }

    /**
     * 数据更新修改方法
     * @param $condition 行筛选条件
     * @param $data 数据数组
     * @return mixed|null 影响行数
     */
    public function update($condition,$data){

        $this->sqlConstructor->update($condition,$data);

        $set = $this->sqlConstructor->getSet();

        $this->sql = $set['outSql'];

        return $this->db->query($set['doSql'], $set['sqlParam']) ? $this->db->getRowCount() : null;

    }

    /**
     * 数据删除
     * @param $condition 行筛选条件
     * @return mixed|null 影响行数
     */
    public function delete($condition){

        $this->sqlConstructor->delete($condition);

        $set = $this->sqlConstructor->getSet();

        $this->sql = $set['outSql'];

        return $this->db->query($set['doSql'], $set['sqlParam']) ? $this->db->getRowCount() : null;

    }



}