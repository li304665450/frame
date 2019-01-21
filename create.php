<?php
if ($argc < 2) exit();

$group = "./app/{$argv[1]}";
$name = ucfirst($argv[2]);
$controller = "{$group}/controller/{$name}.php";
$model = "{$group}/model/{$name}.php";

!is_dir($group) && mkdir($group);
!is_dir($group."/controller") && mkdir($group."/controller");

if (in_array('no_model',$argv)){
    $controller_content = <<<eof
<?php

namespace app\\$argv[1]\controller;


use app\common\controller\QueryBaseController;

class {$name} extends QueryBaseController
{


}
eof;
    $fp = fopen($controller,'w');
    if (!fwrite($fp,$controller_content)){
        echo 'controller write field';
    }
    fclose($fp);

    exec("chmod 777 ".$controller);

}else{
    !is_dir($group."/model") && mkdir($group."/model");
    $controller_content = <<<eof
<?php

namespace app\\$argv[1]\controller;


use app\common\controller\BaseController;

class {$name} extends BaseController
{

}
eof;

    $fp = fopen($controller,'w');
    if (!fwrite($fp,$controller_content)){
        echo 'controller write field';
    }
    fclose($fp);

    exec("chmod 777 ".$controller);

    $model_content = <<<eof
<?php

namespace app\\$argv[1]\model;


use mars\DB\Model;

class {$name} extends Model
{

}
eof;

    $fp = fopen($model,'w');
    if (!fwrite($fp,$model_content)){
        echo 'controller write field';
    }
    fclose($fp);

    exec("chmod 777 ".$controller);

}

