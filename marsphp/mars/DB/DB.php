<?php
/**
 * Created by PhpStorm.
 * User: lilei
 * Date: 2018/6/12
 * Time: 下午3:58
 */

namespace mars\DB;


use lib\exception\ApiException;
use lib\Unit;

class DB
{
    private $database = '';             //数据库配置
    private $otherDB = '';              //若需当前连接该地址下其他库，填写库名
    private $dsn = '';                  //数据库连接凭据
    private $dbh = '';                  //数据连接对象
    private $query = '';                //当前sql语句执行结果

    /**
     * DB constructor.
     * @param string $database 数据库配置
     * @param string $otherDB 若需连接该地址下其他库，填写库名
     * @throws ApiException
     */
    function __construct($database, $otherDB)
    {
        $this->database = $database;
        $config = config('database.'.$this->database);
        !empty($otherDB) && $config['dbName'] = $otherDB && $this->otherDB = $otherDB;
        $this->dsn=$config['dbms'].":host=".$config['host'].";dbname=".$config['dbName'];
        $this->user = $config['user'];
        $this->pass = $config['pass'];
        $this->connet();
    }

    /**
     * @param string $database
     */
    public function setDatabase($database)
    {
        $this->database = $database;
    }

    /**
     * @param string $otherDB
     */
    public function setOtherDB($otherDB)
    {
        $this->otherDB = $otherDB;
    }

    /**
     * 连接数据库
     * @throws ApiException
     */
    public function connet(){
        try {
            $dbh = new \PDO($this->dsn, $this->user, $this->pass);                         //初始化一个PDO对象
            $dbh->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_WARNING);   //设置抛出异常模式处理错误
            $dbh->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);         //支持预处理
            $dbh->setAttribute(\PDO::ATTR_PERSISTENT,true);
            $dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->dbh = $dbh;
        } catch (\Exception $e) {
            throw new ApiException($e->getMessage());
        }
    }

    /**
     * sql执行方法
     * 支持预处理
     * @param $sql 语句
     * @param array $param 参数
     * @return mixed 返回影响行数
     * @throws \Exception
     */
    public function query($sql,$param = []){
        if (empty($param)){
            try{
                $this->query = $this->dbh->query($sql);
            }catch (\Exception $exception){
                throw new ApiException($exception->getMessage().' of '.$sql);
            }

        }else{
            try{
                $this->query = $this->dbh->prepare($sql);
                $this->query->execute($param);
            }catch (\Exception $exception){
                throw new ApiException($exception->getMessage().' of '.$sql);
            }
        }
        return $this->query;
    }

    /**
     * 获取插入操作，插入后的自增id
     * @return mixed
     */
    public function getRowCount(){
        return $this->query->rowCount();
    }

    /**
     * 获取操作影响行数
     * @return mixed
     */
    public function getInsertId(){
        return $this->dbh->lastInsertId();
    }

    /**
     * 处理select查询语句
     * 产生的结果集
     * @return array
     */
    public function getFetch(){

        $list = [];
        while ($row = $this->query->fetch(\PDO::FETCH_OBJ)) {
            array_push($list,Unit::objToArray($row));
        }

        return $list;
    }

}