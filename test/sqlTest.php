<?php

//框架入口
require_once __DIR__ . '/../public/index.php';

$result = [

];

function select($query){
    $query->select([
        'name' => 'Jack',
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
    debugCli( $query->outSql );
    debugCli($query->doSql);
    debugCli($query->sqlParam);
}

