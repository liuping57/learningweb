<?php
/**
 * Created by PhpStorm.
 * User: wsqer
 * Date: 2018/3/26
 * Time: 13:23
 */

namespace app\user\validata;


class UserInfo extends BaseValidate
{
    protected $rule=[
        'username|昵称'=> 'chsDash|length:0,20',
        'qq'=>'number|max:11',
        'tel|电话'=>'number|max:11',
        'sex|性别'=>'boolean',
        'email|邮箱'=>'require|email'
    ];
    protected $message=[
        'username.length'=>'昵称最多不能超过12个字符',
        'qq.max'=>'qq好长度不合适',
        'tel.max'=>'电话号码长度不合适',
    ];
}