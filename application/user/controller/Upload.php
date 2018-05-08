<?php
/**
 * Created by PhpStorm.
 * User: wsq
 * Date: 2018/3/23
 * Time: 13:34
 */

namespace app\user\controller;


use app\exception\NoLogin;
use app\user\model\FileUpload;
use think\Request;
use think\Session;

class Upload
{
    public function headimg()
    {
        if(Session::has('user'))
        {
            if (Request::instance()->has('file'))
            {
                $re=FileUpload::upload();
                return json($re);
            }
            else
            {
                return json(['linecode'=>104,'msg'=>'请选择图片']);
            }
        }
        else
        {
            throw new NoLogin();
        }

    }
    public function upclassimg()
    {
        if(Session::has('user'))
        {
            if (Request::instance()->has('files'))
            {
                $re=FileUpload::classimg();
                return json($re);
            }
            else
            {
                return json(['linecode'=>104,'msg'=>'请选择图片']);
            }
        }
        else
        {
            throw new NoLogin();
        }
    }
}