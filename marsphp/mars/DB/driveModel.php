<?php
/**
 * Created by PhpStorm.
 * User: lilei
 * Date: 2018/8/7
 * Time: 下午4:04
 */

namespace mars\DB;


class driveModel extends Model
{
    public function __construct($table,$database,$otherDB = '')
    {
        $this->table = $table;
        $this->database = $database;
        $this->db = new DB($this->database,$this->otherDB);
    }

}