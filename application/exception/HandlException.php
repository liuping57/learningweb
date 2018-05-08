<?php
/**
 * Created by PhpStorm.
 * User: wsq
 * Date: 2017/8/1
 * Time: 20:49
 */

namespace app\exception;


use Exception;
use think\exception\Handle;
use think\Request;

class HandlException extends Handle
{
    private $code;
    private $msg;
    private $linecode;
    public function render(Exception $e)
    {
        if($e instanceof BaseException)
        {
            $this->code=$e->code;
            $this->msg=$e->msg;
            $this->linecode=$e->linecode;
        }
        else
        {
            $this->code=200;
            $this->msg=$e->getMessage();
            $this->linecode=1000;
        }
        $request=Request::instance();
        $res=[
            'linecode'=>$this->linecode,
            'msg'=>$this->msg,
        ];
        return json($res,$this->code);
    }
}