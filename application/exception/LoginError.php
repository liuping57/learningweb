<?php
/**
 * Created by PhpStorm.
 * User: wsq
 * Date: 2017/11/7
 * Time: 11:02
 */

namespace app\exception;


class LoginError extends BaseException
{
    public $code=200;
    public $msg="账号或密码错误";
    public $linecode=401;
}