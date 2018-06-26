<?php
/**
 * Created by PhpStorm.
 * User: lilei
 * Date: 2018/6/12
 * Time: 上午11:42
 */

namespace app\index\controller;


use mars\DB;

class Index
{
    public function index(){
        echo 'Welcome to MarsPhp!';
    }

    public function test(){
//        $user = new User();
//        echo  $user->get();
//        echo config('database.default.type');
//        echo get_dir();
//        $user = model('User');
//        echo $user->database;
//        $db = DB::getInstance();
//        $sql1 = "INSERT INTO test (name1, age) VALUES (:name, :age)";
//        $param1 = [':name' => 'Jack33',':age' => 11];
//        $sql2 = "update test set age = :age where name = :name";
//        $param2 = [':name' => 'Jack',':age' => 44];
//        $sql3 = "delete from test where name = :name";
//        $param3 = [':name' => 'Jack'];
//        $sql4 = "select * from test";
//        try{
//            $result = $db->query($sql1,$param1);
//            var_dump($result);
//        }catch (\Exception $exception){
//            trigger_error($exception->getMessage(),E_USER_ERROR);
//        }
//        $user = model('User');
//        var_dump($user->insert(['name' => 'Jack33','age' => 11]));
        $test = model('Test');
        $where = ['name' => 'Jack','age' => 44];
        $order = ['id'=>'desc','age'=>'desc'];
        $limit = [0,3];
//        $id = $test->insert(['name' => 'Mark','age' => 24]);
//        var_dump($id);
//        $result = $test->update(['id'=>13],['name'=>'Sandy','age'=>17]);
//        var_dump($test->getLastSql());
//        $result = $test->delete(['id'=>20,'name'=>'Sandy']);
//        var_dump($result);
//        var_dump($test->getLastSql());
        $result = $test->get($where);
        var_dump($result);
        var_dump($test->getLastSql());
    }

}