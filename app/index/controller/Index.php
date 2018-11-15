<?php
/**
 * Created by PhpStorm.
 * User: lilei
 * Date: 2018/6/12
 * Time: 上午11:42
 */

namespace app\index\controller;

use mars\Controller;
use mars\DB\Query;

class Index extends Controller
{
    public function index()
    {
        echo '<style type="text/css">*{ padding: 0; margin: 0; } .think_default_text{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:)</h1><p> MarsPHP V1<br/><span style="font-size:30px">深藏身与名 - 为API开发设计的高性能框架</span></p><span style="font-size:22px;">[ V1.0 版本由 <a href="https://github.com/li304665450/frame.git">李磊</a> 独家发布 ]</span></div><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script><script type="text/javascript" src="http://ad.topthink.com/Public/static/client.js"></script>';
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
        $test = model('Test');
//        $test->setField(['id','name']);
        $where = ['name' => 'Jack', 'age' => 44, '_debug'=>0];
        $order = ['id' => 'desc', 'age' => 'desc'];
        $limit = [0, 3];
//        $id = $test->insert(['name' => 'Mark','age' => 24]);
//        var_dump($id);
//        $result = $test->update(['id'=>13],['name'=>'Sandy','age'=>17]);
//        var_dump($test->getLastSql());
//        $result = $test->delete(['id'=>20,'name'=>'Sandy']);
//        var_dump($result);
//        var_dump($test->getLastSql());
        $result = $test->get([],["name like '%Jack%'"]);
//        apiResult(1,'成功',$result,'500');
//        $this->success('成功',$result);
//        debug($test->getLastSql());
    }
    
    public function test3(){
        $query = new Sql('ims_test');

//        debug($query);
//        die();

        $query->select([
            'name' => 'Jack',
            'age' => 44,
            '_ext' => ['day > 2018-08-30','mm != 3'],
        ]);
        $query->select();
        debug( $query->outSql );
        debug($query->doSql);
        debug($query->sqlParam);

    }

    public function test4(){
        $query = new Query('default', 'test');

//        debug( $query->get(['name' => 'Jack', 'age' => 44],[2,5],'',  '',['id','name']));

//        debug($query->insert(['name' => 'JackLove','age' => 24]));

//        debug($query->update(['id'=>19],['name'=>'fast']));

//        debug($query->delete(['id'=>18]));

    }

    public function test5(){
        outTest(111);
    }

    public function test6(){
        $bi = \query('wxbi','wxa_game');
        $content = $bi->get();

        $this->success('成功',$content);

    }

    public function test7(){
//        $this->success('get',$_GET);
//        $this->success('post',$_POST);
    }



}