<?php
/**
 * Created by PhpStorm.
 * User: wsq
 * Date: 2017/11/7
 * Time: 10:41
 */

namespace app\user\controller;


use app\user\model\ValiCodeModel;

class Valicode
{
    function imgcode()
    {
        $code=new ValiCodeModel();
        $code->verifyImage();
        return response("imgcode", 200)->contentType("image/jpg");
    }
}