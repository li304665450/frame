<?php
/**
 * Created by PhpStorm.
 * User: lilei
 * Date: 2019/1/11
 * Time: 3:42 PM
 */

namespace lib\exception;


class Response
{

    /**
     * post请求方法
     * @param $url
     * @param null $data
     * @return mixed
     */
    public static function sendUrl($url, $data = null)
    {
        // 初始化一个新的会话，返回一个cURL句柄，供curl_setopt(), curl_exec()和curl_close() 函数使用。 顾客
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (!empty($data)){
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }

}