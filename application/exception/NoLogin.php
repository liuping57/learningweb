<?php
/**
 * Created by PhpStorm.
 * User: wsq
 * Date: 2017/11/7
 * Time: 19:35
 */

namespace app\exception;


class NoLogin extends BaseException
{
    public $code=200;
    public $msg="未登录请登陆后操作";
    public $linecode=402;
}