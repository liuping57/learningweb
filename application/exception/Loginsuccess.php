<?php
/**
 * Created by PhpStorm.
 * User: wsq
 * Date: 2017/11/7
 * Time: 10:55
 */

namespace app\exception;


class Loginsuccess extends BaseException
{
    public $code=200;
    public $msg="登陆成功！";
    public $linecode=201;
}