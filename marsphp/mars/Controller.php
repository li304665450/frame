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
     *
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
     * api接口回调消息封装方法
     * @param $status 业务状态码
     * @param $msg 提示信息
     * @param array $data 数据
     * @param int $httpCode http状态码
     * @return \Json
     */
    public function apiResult($status, $msg, $data = [], $httpCode = 200){
        $result = [
            'status' => $status,
            'msg' => $msg,
            'data' => $data
        ];
        return json($result, $httpCode);
    }

    /**
     * 内部回调消息封装方法
     * @param $status 业务状态码
     * @param $msg 提示信息
     * @param array $data 数据
     * @return array
     */
    public function result($status, $msg, $data = []){
        return [
            'status' => $status,
            'msg' => $msg,
            'data' => $data
        ];
    }


}