<?php
/**
 * Created by PhpStorm.
 * User: wsq
 * Date: 2017/11/7
 * Time: 11:34
 */

namespace app\user\controller;


use app\exception\NoLogin;
use app\exception\RegistEmail;
use app\exception\RegistSuccess;
use app\user\model\RegisterModel;
use app\user\validata\RegisterVali;
use app\user\validata\ValiRegisterEmail;
use think\Session;

class Register
{
    public function regist()
    {
        (new RegisterVali())->gocheck();
        RegisterModel::regist();
        throw new RegistSuccess();
    }
    public function valiuser()
    {

            (new ValiRegisterEmail())->gocheck();
            if (RegisterModel::checkemail())
            {
                return "<html><head><script>alert('邮箱验证成功');document.location.href='http://dc.wsqer.cn';</script></head></html>";
            }
            else
            {
                throw new RegistEmail();
            }

    }
}