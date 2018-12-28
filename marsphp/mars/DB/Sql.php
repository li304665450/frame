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
    private $param;
    private $arr  = [];
    private $out_arr = [];

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

            $where = $this->splitCondition($condition);

            $ext = $this->splitExt($condition['_ext']);

            $this->sqlParam = array_merge($where['param'],$ext['param']);

            $this->outSql = $sql.' WHERE 1=1 '.$where['out_sql'].$ext['out_sql'].$group_str.$order_str.$limit_str;
            $this->doSql = $sql.' WHERE 1=1 '.$where['sql'].$ext['sql'].$group_str.$order_str.$limit_str;

        }elseif (is_int($condition)){

            $this->doSql = $this->outSql = $sql.' LIMIT '.$condition;

        }

    }

    /**
     * 数据插入方法
     * @param array $data
     * @return null
     */
    public function insert($data){

        if(count($data) < 1) return null;

        $param = [];
        $front = [];
        $after = [];
        $out_after = [];
        $sql = "INSERT INTO ".$this->table;
        foreach ($data as $k => $v){
            $param[':'.$k] = $v;
            array_push($front,$k);
            array_push($after,':'.$k);
            array_push($out_after,$v);
        }

        $front_str = "(".implode(",",$front).")";
        $after_str = "(".implode(",",$after).")";
        $out_after_str = "('".implode("','",$out_after)."')";

        $this->outSql = $sql.' '.$front_str.' VALUES '.$out_after_str;
        $this->doSql = $sql.' '.$front_str.' VALUES '.$after_str;
        $this->sqlParam = $param;

    }

    /**
     * 数据更新修改方法
     * @param array $condition 行筛选条件
     * @param array $data 数据数组
     * @return mixed|null 影响行数
     */
    public function update($condition,$data){

        if(count($condition) < 1 || count($data) < 1) return null;

        $sql = "UPDATE ".$this->table.' SET';

        $where = $this->splitCondition($condition);
        $set = self::splitSet($data);

        $param = array_merge($where['param'],$set['param']);

        $this->outSql = $sql.' '.$set['out_sql'].' WHERE 1=1 '.$where['out_sql'];
        $this->doSql = $sql.' '.$set['sql'].' WHERE 1=1 '.$where['sql'];
        $this->sqlParam = $param;
    }

    /**
     * 数据删除
     * @param array $condition 行筛选条件
     * @return null
     */
    public function delete($condition){

        if(count($condition) < 1) return null;

        $sql = 'DELETE FROM '.$this->table.' WHERE ';

        $where = $this->splitCondition($condition);

        $this->outSql = $sql.$where['out_sql'];
        $this->doSql = $sql.$where['sql'];
        $this->sqlParam = $where['param'];

    }

    /**
     * 拆分条件参数方法
     * @param $condition 条件数组
     * @param string $field 二级差分时需要传递条件字段
     * @return array 分割后的数组或字符串
     */
    protected function splitCondition($condition, $field = ''){

        foreach ($condition as $k=>$v){
            if (substr($k,0,1) == '_') continue;
            if (empty($v) && $v !== 0) continue;

            if (is_array($v) && $k != 'in'){
                $this->splitCondition($v, $k);
                continue;
            }

            static $i = 0;//条件计数器，解决同一字段多条件筛选问题

            if (empty($field)) {
                $this->param[':'.$i.$k] = $v;
                array_push($this->arr,"`{$k}` = :{$i}{$k}");
                array_push($this->out_arr, "`{$k}` = '{$v}'");
                $i++;
            }else{
                switch ($k) {
                    case 'like':
                        array_push($this->arr,"`{$field}` like '%{$v}%'");
                        array_push($this->out_arr,"`{$field}` like '%{$v}%'");
                        break;
                    case 'in':
                        array_push($this->arr,"`{$field}` in (".implode(',', $v).")");
                        array_push($this->out_arr,"`{$field}` in (".implode(',', $v).")");
                        break;
                    default:
                        $this->param[':'.$i.$field] = $v;
                        array_push($this->arr,"`{$field}` {$k} :{$i}{$field}");
                        array_push($this->out_arr, "`{$field}` {$k} '{$v}'");
                        $i++;
                }
            }

        }

        $result = [];

        if (count($this->arr) > 0){
            $result['sql'] = ' AND '.implode(' AND ',$this->arr);
            $result['out_sql'] = ' AND '.implode(' AND ',$this->out_arr);
        }

        $result['param'] = $this->param;

        return $result;

    }

    /**
     * 拓展检索条件处理方法
     * @param array $ext
     * @return array
     */
    private function splitExt($ext){

        if (!$ext){
            return [
                'param' => []
            ];
        }

        $result = [
            'out_sql'   => '',
            'sql'    => '',
            'param' => []
        ];

        if (!is_array($ext))
            return $result;

        $i = 0;//条件计数器，解决同一字段多条件筛选问题

        $gull_special = ['like', 'in'];

        foreach ($ext as $value){
            list($k,$gull,$v) = explode(' ',$value);
            $result['out_sql']  .= " AND $value";
            if (in_array($gull,$gull_special)){
                $result['sql']  .= " AND $value";
            }else{
                $result['sql'] .= " AND $k $gull :$k$i";
                $result['param'][":$k$i"] = $v;
            }
            $i++;
        }
        return $result;
    }

    /**
     * update语句中
     * set条件处理方法
     * @param array $set 条件
     * @return array
     */
    private function splitSet($set){
        $param = [];
        $arr = [];
        $out_arr = [];
        foreach ($set as $k=>$v){
            $param[':s_'.$k] = $v;
            array_push($arr,"`$k`".'=:s_'.$k);
            array_push($out_arr,"`$k`"."='".$v."'");
        }

        $result = [];
        $result['sql'] = implode(',',$arr);
        $result['out_sql'] = implode(',',$out_arr);

        $result['param'] = $param;
        return $result;
    }

    /**
     * order条件处理方法
     * @param array $order
     * return string
     * @return string
     */
    private function splitOrder($order){
        $str = ' ORDER BY ';
        foreach ($order as $key=>$value){
            if (is_int($key)){//只传入排序字段，默认升序
                $str .= $value.' ASC ';
            }elseif (is_string($key)){//指明字段排序方式
                $desc = $value ? 'DESC' : 'ASC';
                $str .= $key.' '.$desc.' ';
            }
        }
        return $str;
    }

    /**
     * limit条件处理方法
     * @param array $limit
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