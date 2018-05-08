<?php
/**
 * Created by PhpStorm.
 * User: wsqer
 * Date: 2018/4/6
 * Time: 15:29
 */

namespace app\admin\controller;


use think\Controller;

class Error extends Controller
{
    public function nologin()
    {
        return $this->fetch();
    }
    public function nochmod()
    {
        return $this->fetch();
    }
}