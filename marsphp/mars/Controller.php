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
    /**
     * html页面加载方法
     * @param $data
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

}