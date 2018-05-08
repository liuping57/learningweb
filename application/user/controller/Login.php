<?php
/**
 * Created by PhpStorm.
 * User: wsq
 * Date: 2017/11/1
 * Time: 14:31
 */

namespace app\user\controller;

use app\user\model\chapters;
use app\user\model\LoginModel;
use app\user\model\MailModel;
use app\user\validata\LoginValidate;
use think\Db;
use think\Request;
use think\Session;

class Login
{
    public function login()
    {
        (new LoginValidate())->gocheck();
        LoginModel::login();
    }
    public function logout()
    {
        LoginModel::logout();
    }
//    public function send()
//    {
//        (new MailModel())->send("15182615610@163.com","测试一下","这是一封测试邮件！！！");
//        return "okk";
//    }

}