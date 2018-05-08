<?php
/**
 * Created by PhpStorm.
 * User: wsq
 * Date: 2017/11/7
 * Time: 15:30
 */

namespace app\user\validata;


class RegisterVali extends BaseValidate
{
    protected $rule=[
        'user_id|用户名'=>'require|chsDash|length:6,15',   //用户账号
        'user_name|昵称'=>'chsDash|length:0,20',          //用户昵称不能作为唯一标识
        'pwd1|密码'=>'require|alphaDash|length:8,15',    //密码
        'pwd2|确认密码'=>'require|alphaDash|length:8,15',    //第二次验证密码
        'email|邮箱地址'=>'require|email',                   //邮箱验证
        'valicode|验证码'=>'require|alphaNum|length:4'     //验证码验证
    ];
    protected $message=[
        'user_id.length'=>'用户名的长度只能是6~15个字符',
        'user_name.length'=>'昵称最多不能超过12个字符',
        'pwd1.length'=>'密码长度只能8~15个字符',
        'pwd2.length'=>'密码长度只能8~15个字符',
        'valicode.length'=>'验证码只能是4个字符'
    ];
}