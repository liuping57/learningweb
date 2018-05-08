<?php
/**
 * Created by PhpStorm.
 * User: wsq
 * Date: 2017/11/7
 * Time: 19:31
 */

namespace app\exception;


class RegistSuccess extends BaseException
{
    public $code=200;
    public $msg="注册成功！";
    public $linecode=203;
}