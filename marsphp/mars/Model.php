<?php
/**
 * Created by PhpStorm.
 * User: lilei
 * Date: 2018/6/12
 * Time: 下午3:20
 */

namespace mars;


class Model
{

    public $database = 'default';  //数据库配置名，默认为default
    public $otherDB = '';          //若需当前连接该地址下其他库，填写库名
    public $table = '';            //表名
    public $sql = '';              //最后一次操作的sql语句
    public $db = '';               //DB操作对象
    public $field = '*';           //查询字段，默认所有字段

    public function __construct()
    {
        $prefix = config('database.'.$this->database)['prefix'];
        $path_arr = explode('\\',get_called_class());
        $className = strtolower(end($path_arr));
        $this->table = $prefix.$className;
        $this->db = DB::getInstance($this->database,$this->otherDB);
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
    public function get($condition = '',$order = '',$limit = ''){

        $sql = 'SELECT '.$this->field.' FROM '.$this->table;

        if (empty($condition)) return $this->db->query($sql) ? $this->db->getFetch() : null;

        if (is_array($condition)){

            $param = [];

            $where = $this->splitCondition($condition,' AND ');
            $param = array_merge($param,$where['param']);

            $order_str = empty($order) ? '' : ' ORDER BY '.$this->splitCondition($order,',',' ')['out_sql'];

            $limit_str = empty($limit) ? '' : ' LIMIT '.implode(',',$limit);

            $this->sql = $sql.' WHERE '.$where['out_sql'].$order_str.$limit_str;
            $sql = $sql.' WHERE '.$where['sql'].$order_str.$limit_str;

            return $this->db->query($sql,$param) ? $this->db->getFetch() : null;

        }elseif (is_int($condition)){
            $this->sql = $sql.' LIMIT '.$condition;
            $sql .= ' LIMIT '.$condition;

            return $this->db->query($sql) ? $this->db->getFetch() : null;

        }else{
            return null;
        }

    }

    /**
     * 数据插入方法
     * @param $data 数据数组
     * @return mixed|null 插入后的行id
     */
    public function insert($data){
        if(count($data) < 1) return null;

        $sql = "INSERT INTO ".$this->table;
        $param = [];
        $front = [];
        $after = [];
        $out_after = [];
        foreach ($data as $k => $v){
            $param[':'.$k] = $v;
            array_push($front,$k);
            array_push($after,':'.$k);
            array_push($out_after,$v);
        }

        $front_str = '('.implode(',',$front).')';
        $after_str = '('.implode(',',$after).')';
        $out_after_str = '('.implode(',',$out_after).')';

        $this->sql = $sql.' '.$front_str.' VALUES '.$out_after_str;
        $sql = $sql.' '.$front_str.' VALUES '.$after_str;

        return $this->db->query($sql,$param) ? $this->db->getInsertId() : null;

    }

    /**
     * 数据更新修改方法
     * @param $condition 行筛选条件
     * @param $data 数据数组
     * @return mixed|null 影响行数
     */
    public function update($condition,$data){
        if(count($condition) < 1 || count($data) < 1) return null;

        $sql = "UPDATE ".$this->table.' SET';

        $where = $this->splitCondition($condition,' AND ');
        $set = $this->splitCondition($data,',');

        $param = array_merge($where['param'],$set['param']);

        $this->sql = $sql.' '.$set['out_sql'].' WHERE '.$where['out_sql'];
        $sql = $sql.' '.$set['sql'].' WHERE '.$where['sql'];

        return $this->db->query($sql,$param) ? $this->db->getRowCount() : null;

    }

    /**
     * 数据删除
     * @param $condition 行筛选条件
     * @return mixed|null 影响行数
     */
    public function delete($condition){
        if(count($condition) < 1) return null;

        $sql = 'DELETE FROM '.$this->table.' WHERE ';

        $where = $this->splitCondition($condition,' AND ');

        $this->sql = $sql.$where['out_sql'];
        $sql = $sql.$where['sql'];

        return $this->db->query($sql,$where['param']) ? $this->db->getRowCount() : null;

    }

    /**
     * 拆分条件参数方法
     * @param $condition 条件数组
     * @param string $glue 分割符
     * @return array 分割后的数组或字符串
     */
    protected function splitCondition($condition,$glue,$connet = '='){
        $param = [];
        $arr = [];
        $out_arr = [];
        foreach ($condition as $k=>$v){
            if (is_int($k)){
                array_push($arr,$v);
                array_push($out_arr,$v);
            }else{
                $param[':'.$k] = $v;
                array_push($arr,$k.$connet.':'.$k);
                array_push($out_arr,$k.$connet.$v);
            }
        }

        $result = [];
        $result['sql'] = implode($glue,$arr);
        $result['out_sql'] = implode($glue,$out_arr);

        $result['param'] = $param;
        return $result;

    }

}