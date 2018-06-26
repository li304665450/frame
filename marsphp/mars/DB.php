<?php
/**
 * Created by PhpStorm.
 * User: lilei
 * Date: 2018/6/12
 * Time: 下午3:58
 */

namespace mars;


class DB
{
    private $database = 'default';      //数据库配置，默认为default
    private $otherDB = '';              //若需当前连接该地址下其他库，填写库名
    private $dsn = '';                  //数据库连接凭据
    private $dbh = '';                  //数据连接对象
    private $query = '';                //当前sql语句执行结果

    //静态变量保存全局实例
    private static $_instance = null;

    //静态方法，单例统一访问入口
    public static function getInstance($database = '', $otherDB = '') {
        if (!self::$_instance instanceof self) {
            self::$_instance = new self ($database, $otherDB);
        }
        return self::$_instance;
    }

    /**
     * DB constructor.
     * @param string $database 数据库配置，默认为default
     * @param string $otherDB  若需连接该地址下其他库，填写库名
     */
    function __construct($database, $otherDB)
    {
        !empty($database) && $this->database = $database;
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
     */
    public function connet(){
        try {
            $dbh = new \PDO($this->dsn, $this->user, $this->pass);                         //初始化一个PDO对象
            $dbh->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_WARNING);   //设置抛出异常模式处理错误
            $dbh->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);         //支持预处理
            $dbh->setAttribute(\PDO::ATTR_PERSISTENT,true);
            $dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->dbh = $dbh;
        } catch (PDOException $e) {
            die ("Error!: " . $e->getMessage() . "<br/>");
        }
    }

    /**
     * sql执行方法
     * 支持预处理
     * @param $sql 语句
     * @param array $param 参数
     * @return mixed 返回影响行数
     */
    public function query($sql,$param = []){
        if (empty($param)){
            $this->query = $this->dbh->query($sql);
        }else{
            $this->query = $this->dbh->prepare($sql);
            $this->query->execute($param);
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
     * sql执行方法
     * 处理select查询语句
     * 支持预处理;
     * @param $sql 语句
     * @param array $param 参数
     * @return mixed 查询语句返回内容，其他返回影响行数
     */
    /**
     * 处理select查询语句
     * 产生的结果集
     * @return array
     */
    public function getFetch(){

        $list = [];
        while ($row = $this->query->fetch()) {
            array_push($list,$row);
        }

        return $list;
    }

}