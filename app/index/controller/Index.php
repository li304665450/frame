<?php
/**
 * Created by PhpStorm.
 * User: lilei
 * Date: 2018/6/12
 * Time: 上午11:42
 */

namespace app\index\controller;

use mars\DB\driveModel;
use mars\DB\Query;
use mars\DB\Sql;

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
        $start = time();
        for ($i = 0; $i < 10000; $i++) {
            $test = model('Test');
            $where = ['name' => 'Jack', 'age' => 44];
            $order = ['id' => 'desc', 'age' => 'desc'];
            $limit = [0, 3];
//        $id = $test->insert(['name' => 'Mark','age' => 24]);
//        var_dump($id);
//        $result = $test->update(['id'=>13],['name'=>'Sandy','age'=>17]);
//        var_dump($test->getLastSql());
//        $result = $test->delete(['id'=>20,'name'=>'Sandy']);
//        var_dump($result);
//        var_dump($test->getLastSql());
            $result = $test->get($where);
        }
        $end = time();
        deBug($end - $start);
//        echo json_encode($result);
//        var_dump($test->getLastSql());
    }

    public function test2(){
        $cc = new driveModel('ims_test','default');
        $where = ['name' => 'Jack','age' => 44];
        $result = $cc->get($where);
        var_dump($result);
    }
    
    public function test3(){

        $query = new Sql('ims_test');

//        debug($query);
//        die();

//        $query->select([
//            'name' => 'Jack',
//            'age' => 44,
//            '_ext' => ['day > 2018-08-30','mm != 3'],
//        ]);
        $query->select();
        debug( $query->outSql );
        debug($query->doSql);
        debug($query->sqlParam);

    }

    public function test4(){
        $query = new Query('default', 'test', '*');

//        debug( $query->get(['name' => 'Jack', 'age' => 44],[2,5],'',  '',['id','name']));

//        debug($query->insert(['name' => 'JackLove','age' => 24]));

//        debug($query->update(['id'=>19],['name'=>'fast']));

        debug($query->delete(['id'=>18]));

    }



}