<?php

//框架入口
require_once __DIR__ . '/../public/index.php';

$result = [

];

function select($query){
    $query->select([
        '_select' => [

        ],
        'name' => 'Jack',
        'day' => [
            '>' => '2018-12-20',
            '<' => '2018-12-22'
        ],
        'title' => [
            'like' => 'sss',
            '<>' => 'aaa',
            'in' => ['111','222','333'],
            '!=' => 'ccc'
        ],
        'age' => 44,
        '_ext' => ['day > 2018-08-30','mm != 5',"name like '%na%'"],
        '_limit' => [1,3],
        '_group' => ['id','age'],
        '_order' => ['id'=>1,'age']
    ]);
    return $query;
}

function insert($query){
    $query->insert(['name' => 'Mark','age' => 24]);
    return $query;
}

function update($query){
    $query->update(['name'=>'Sandy'],['name'=>'Tom','age'=>17]);
    return $query;
}

function delete($query){
    $query->delete(['id'=>20,'name'=>'Sandy']);
    return $query;
}

if ($argc > 1){
    $query = new \mars\DB\Sql('ims_test');
    $query = $argv[1]($query);
    debugCli( 'outSql' );
    debugCli( $query->outSql );
    debugCli( 'doSql' );
    debugCli($query->doSql);
    debugCli( 'sqlParam' );
    debugCli($query->sqlParam);
}

