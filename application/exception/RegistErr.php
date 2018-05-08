<?php
/**
 * Created by PhpStorm.
 * User: wsq
 * Date: 2017/11/7
 * Time: 15:52
 */

namespace app\exception;


class RegistErr extends BaseException
{
    public $code=200;
    public $msg="邮箱地址或者用户id已经存在!";
    public $linecode=406;
}