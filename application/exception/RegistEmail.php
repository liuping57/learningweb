<?php
/**
 * Created by PhpStorm.
 * User: wsq
 * Date: 2017/11/7
 * Time: 20:11
 */

namespace app\exception;


class RegistEmail extends BaseException
{
    public $code=200;
    public $msg="验证失败，请重试";
    public $linecode=405;
}