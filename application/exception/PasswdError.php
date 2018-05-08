<?php
/**
 * Created by PhpStorm.
 * User: wsq
 * Date: 2017/11/7
 * Time: 15:48
 */

namespace app\exception;


class PasswdError extends BaseException
{
    public $code=200;
    public $msg="两次密码不一致";
    public $linecode=403;
}