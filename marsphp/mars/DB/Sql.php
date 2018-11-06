<?php
/**
 * Created by PhpStorm.
 * User: lilei
 * Date: 2018/8/15
 * Time: 下午3:35
 */

namespace mars\DB;


class Sql
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
     * 获取结果集(全家桶)
     * return array
     */
    public function getSet(){
        $result = [];
        $result['outSql'] = $this->outSql;
        $result['doSql'] = $this->doSql;
        $result['sqlParam'] = $this->sqlParam;
        return $result;
    }

    /**
     * @param array $condition 筛选条件，数字为limit取几条，数组为筛选条件
     */
    public function select($condition = []){

        $select = $condition['_select'] ? implode(',',$condition['_select']) : '*';

        $sql = 'SELECT '.$select.' FROM '.$this->table;

        if (empty($condition)) $this->doSql = $this->outSql = $sql;

        if (is_array($condition) && !empty($condition)){

            $group_str = $condition['_group'] ? ' GROUP BY '.implode(',',$condition['_group']) : '';

            $order_str = $condition['_order'] ? self::splitOrder($condition['_order']) : '';

            $limit_str = $condition['_limit'] ? self::splitLimit($condition['_limit']) : '';

            $where = $this->splitCondition($condition,' AND ');

            $ext = $this->splitExt($condition['_ext'] ?: '');

            $this->sqlParam = array_merge($where['param'],$ext['param']);

            $this->outSql = $sql.' WHERE '.$where['out_sql'].$ext['out_sql'].$group_str.$order_str.$limit_str;
            $this->doSql = $sql.' WHERE '.$where['sql'].$ext['sql'].$group_str.$order_str.$limit_str;
            
        }elseif (is_int($condition)){

            $this->doSql = $this->outSql = $sql.' LIMIT '.$condition;

        }

    }

    /**
     * 数据插入方法
     * @param $data
     * @return null
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

    /**
     * 拓展检索条件处理方法
     * @param $ext
     * @return array
     */
    private function splitExt($ext){
        $result = [
            'out_sql'   => '',
            'sql'    => '',
            'param' => []
        ];

        if (!is_array($ext))
            return $result;

        $i = 0;//条件计数器，解决同一字段多条件筛选问题

        foreach ($ext as $value){
            list($k,$gull,$v) = explode(' ',$value);
            $result['out_sql']  .= " AND $value";
            $result['sql'] .= " AND $k $gull :$k$i";
            $result['param'][":$k$i"] = $v;
            $i++;
        }
        return $result;
    }

    /**
     * order条件处理方法
     * @param $order
     * return string
     * @return string
     */
    private function splitOrder($order){
        $str = ' ORDER BY ';
        foreach ($order as $key=>$value){
            $desc = $value ? 'desc' : 'asc';
            $str .= $key.' '.$desc.' ';
        }
        return $str;
    }

    /**
     * limit条件处理方法
     * @param $limit
     * @return string
     */
    private function splitLimit($limit){
        $str = ' LIMIT ';

        if (!is_array($limit)){
            return $str.intval($limit);
        }else{
            if (count($limit) == 2){
                return $str.implode(',',$limit);
            }
        }
        return '';
    }

}