<?php
/**
 * Created by PhpStorm.
 * User: wsq
 * Date: 2017/8/1
 * Time: 20:13
 */

namespace app\exception;


use think\Exception;

class BaseException extends Exception
{
    public $code;
    public $linecode;
    public $msg;

}