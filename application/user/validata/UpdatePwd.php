<?php
/**
 * Created by PhpStorm.
 * User: wsqer
 * Date: 2018/3/26
 * Time: 16:02
 */

namespace app\user\validata;


class UpdatePwd extends BaseValidate
{
    protected $rule=[
        'pwd|原始密码'=>'require|alphaDash|length:8,15',
        'pwd1|密码'=>'require|alphaDash|length:8,15',    //密码
        'pwd2|确认密码'=>'require|alphaDash|length:8,15'    //第二次验证密码
    ];
    protected $message=[
        'pwd1.length'=>'密码长度只能8~15个字符',
        'pwd1.length'=>'密码长度只能8~15个字符',
        'pwd2.length'=>'密码长度只能8~15个字符'

    ];
}