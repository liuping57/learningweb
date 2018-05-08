<?php
/**
 * Created by PhpStorm.
 * User: wsq
 * Date: 2017/11/7
 * Time: 11:01
 */

namespace app\exception;


class ValicodeErr extends BaseException
{
    public $code=200;
    public $msg="验证码错误";
    public $linecode=407;
}