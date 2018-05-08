<?php
/**
 * Created by PhpStorm.
 * User: wsq
 * Date: 2017/11/7
 * Time: 15:24
 */

namespace app\exception;


class Logout extends BaseException
{
    public $code=200;
    public $msg="注销成功！";
    public $linecode=202;
}