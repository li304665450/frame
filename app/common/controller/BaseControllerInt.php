<?php

namespace app\common\controller;


interface BaseControllerInt
{
    public function fetchList();

    public function getInfo();

    public function update();

    public function create();

    public function delete();

    public function options();

}