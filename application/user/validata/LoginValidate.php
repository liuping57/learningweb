<?php
/**
 * Created by PhpStorm.
 * User: wsq
 * Date: 2017/11/7
 * Time: 10:24
 */

namespace app\user\validata;


class LoginValidate extends BaseValidate
{
    protected $rule=[
        'username|用户名'=>'require|chsDash|length:6,15' ,  //用户id验证为6-15位得汉字或字母数字
        'userpwd|密码'=>'require|alphaDash|length:8,15', //用户密码验证8-15位字母数字下划线
        'valicode|验证码'=>'require|alphaNum|length:4'     //验证码验证4位字母数字
    ];
    protected $message=[
        'username.length'=>'用户名的长度只能是6~15个字符',
        'userpwd.length'=>'密码长度只能8~15个字符',
        'valicode.length'=>'验证码只能是4个字符'
    ];
}