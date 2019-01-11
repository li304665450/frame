<?php
/**
 * Created by PhpStorm.
 * User: lilei
 * Date: 2018/6/20
 * Time: 下午5:00
 */

namespace mars;


class Controller
{
    public $modelName;

    /**
     * html页面加载方法
     * @param $tpl
     * @param string $path
     */
    public function display($tpl, $path = ''){

        $this->assign($tpl);

        $group = $GLOBALS['group'];
        $controller = $GLOBALS['controller'];
        $action = $GLOBALS['action'];

        if (!empty($path)){
            $path_arr = explode('/',$path);
            $size = count($path_arr);

            switch ($size){
                case 1:
                    $action = $path;
                    break;
                case 2:
                    $controller = $path_arr[0];
                    $action = $path_arr[1];
                    break;
                case 3:
                    $group = $path_arr[0];
                    $controller = $path_arr[1];
                    $action = $path_arr[2];
                    break;
                default:
                    debug('模版路径不正确！');
                    exit();
            }
        }

        require APP_PATH.'/'.$group.'/view/'.$controller.'/'.$action.'.html';
    }

    /**
     * 变量传递加载方法
     * @param $tpl
     */
    public function assign($tpl){

        $type = [
            'string' => function ($key,$value){
                return "var $key = '$value';";
            },
            'integer' => function ($key,$value){
                return "var $key = $value;";
            },
            'array' => function ($key,$value){
                return "var $key = ".json_encode($value).";";
            },
        ];

        $js = "<script>\n";
        foreach ($tpl as $key=>$value){
            $js .= $type[gettype($value)]($key,$value);
            $js .= "\n";
        }
        $js .= '</script>';
        echo $js;

    }

    /**
     * api成功回调方法
     * @param array $data 回调数据
     */
    protected function success($data = []){
        apiResult(1,'success',$data,200);
    }

    /**
     * api错误回调方法
     * @param string $msg 提示信息
     */
    protected function error($msg = ''){
        apiResult(2,$msg,'',200);
    }

    /**
     * 外部的limit条件转为内部形式
     * @param $limit
     * @return array
     */
    public function doLimit($limit){

        if (!$limit)
            return [];

        $start = ($limit['page'] -1) * $limit['size'];
        return [$start,$limit['size']];
    }

    /**
     * 获取当前控制器名称
     * @return mixed
     */
    protected function getModelName(){
        return $this->modelName ?: getName('controller');
    }

}