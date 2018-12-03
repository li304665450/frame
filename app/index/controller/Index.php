<?php
/**
 * Created by PhpStorm.
 * User: lilei
 * Date: 2018/6/12
 * Time: 上午11:42
 */

namespace app\index\controller;

use app\common\controller\BaseController;
use mars\DB\Query;

class Index extends BaseController
{
    protected $model = 'User';

    public function index()
    {
        echo '<style type="text/css">*{ padding: 0; margin: 0; } .think_default_text{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:)</h1><p> MarsPHP V1<br/><span style="font-size:30px">深藏身与名 - 为API开发设计的高性能框架</span></p><span style="font-size:22px;">[ V1.0 版本由 <a href="https://github.com/li304665450/frame.git">李磊</a> 独家发布 ]</span></div><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script><script type="text/javascript" src="http://ad.topthink.com/Public/static/client.js"></script>';
    }

    public function view(){
        $tpl['content'] = 'Hello Mars';
        $tpl['age'] = 333;
        $tpl['arr1'] = [
            ['text' => '111'],
            ['text' => '222']
        ];
        $this->display($tpl);
    }

}