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
    public $sql = '';              //最后一次操作的sql语句
    public $db = '';               //DB操作对象
    public $query = '';            //sql操作对象
    public $field = '*';           //查询字段，默认所有字段

    public function __construct($database = '')
    {
        $database = $database ?: $this->database;
        $path_arr = explode('\\',get_called_class());
        $modelName = strtolower(end($path_arr));
        $this->query = new Query($database,$modelName,$this->field,$this->otherDB);
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
        return $this->sql;
    }

    /**
     * 数据获取方法
     * @param string $condition 筛选条件，数字为limit取几条，数组为筛选条件
     * @param string $order 排序条件
     * @param string $limit 分页条件
     * @return array|null 结果集
     */
    public function get($condition = '',$limit = '',$condExt = '', $order = '',$select =''){




    }

    /**
     * 数据插入方法
     * @param $data 数据数组
     * @return mixed|null 插入后的行id
     */
    public function insert($data){

    }

    /**
     * 数据更新修改方法
     * @param $condition 行筛选条件
     * @param $data 数据数组
     * @return mixed|null 影响行数
     */
    public function update($condition,$data){

    }

    /**
     * 数据删除
     * @param $condition 行筛选条件
     * @return mixed|null 影响行数
     */
    public function delete($condition){

    }

}