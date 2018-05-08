<?php
/**
 * Created by PhpStorm.
 * User: wsq
 * Date: 2017/10/12
 * Time: 11:34
 */

namespace app\user\validata;


use think\Exception;
use think\Request;
use think\Validate;
class BaseValidate extends Validate
{
    function gocheck()
    {
        //获取到传入的所有参数
        $res=Request::instance();
        $params=$res->param();
        $ress=$this->check($params);
        if(!$ress)
        {
            $err=$this->error;
            throw  new Exception($err);
        }
        else
        {
            return true;
        }
    }

}