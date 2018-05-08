<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/4/10
 * Time: 16:41
 */

namespace app\index\model;
use think\Model;

class Resource extends model
{
    protected $auto = ['create_time'];
    public function getCreateTimeAttr($time)
    {
        return $time;
    }
}