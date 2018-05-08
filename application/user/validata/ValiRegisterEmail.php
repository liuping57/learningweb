<?php
/**
 * Created by PhpStorm.
 * User: wsq
 * Date: 2017/11/7
 * Time: 19:40
 */

namespace app\user\validata;


class ValiRegisterEmail extends BaseValidate
{
    protected $rule=[
        'subrand|随机验证码'=>'require|alphaNum|length:15,25'
    ];
}