<?php
/**
 * Created by PhpStorm.
 * User: lilei
 * Date: 2018/8/15
 * Time: 下午3:35
 */

namespace mars\DB;


class Query
{

    public $doSql;
    public $outSql;
    public $sqlParam;
    private $table;
    
    public function __construct($table)
    {
        $this->table = $table;
    }

    /**
     * 数据获取方法
     * @param string $condition 筛选条件，数字为limit取几条，数组为筛选条件
     * @return array|null 结果集
     */
    public function get($condition = ''){

        $select = $condition['_select'] ?: '*';

        $sql = 'SELECT '.$select.' FROM '.$this->table;

        if (empty($condition)) $this->doSql = $this->outSql = $sql;

        if (is_array($condition) && !empty($condition)){

            $order_str = empty($condition['_order']) ? '' : ' ORDER BY '.$condition['_order'];

            $limit_str = empty($condition['_limit']) ? '' : ' LIMIT '.$condition['_limit'];

            $where = $this->splitCondition($condition,' AND ');

            $this->sqlParam = $where['param'];

            $this->outSql = $sql.' WHERE '.$where['out_sql'].$order_str.$limit_str;
            $this->doSql = $sql.' WHERE '.$where['sql'].$order_str.$limit_str;
            
        }elseif (is_int($condition)){
            
            $this->outSql = $sql.' LIMIT '.$condition;
            $this->doSql .= ' LIMIT '.$condition;

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

        $this->outSql = $sql.' '.$front_str.' VALUES '.$out_after_str;
        $this->doSql = $sql.' '.$front_str.' VALUES '.$after_str;
        $this->sqlParam = $param;

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

        $this->outSql = $sql.' '.$set['out_sql'].' WHERE '.$where['out_sql'];
        $this->doSql = $sql.' '.$set['sql'].' WHERE '.$where['sql'];
        $this->sqlParam = $param;

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

        $this->outSql = $sql.$where['out_sql'];
        $this->doSql = $sql.$where['sql'];
        $this->sqlParam = $where['param'];
        
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
            if (substr($k,0,1) == '_') continue;
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