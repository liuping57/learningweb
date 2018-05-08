<?php
/**
 * Created by PhpStorm.
 * User: wsqer
 * Date: 2018/4/11
 * Time: 14:41
 */

namespace app\api\controller;


use app\exception\NoLogin;
use app\user\model\MailModel;
use think\Db;
use think\Model;
use think\Request;
use think\Session;

class sendmail
{
    public function sendtest()
    {
        if(Session::has('user'))
        {
            $user=Session::get("user");
            if ($user['chmod'] >=3)
            {
                $msg=(new MailModel())->send(Request::instance()->post('email'),Request::instance()->post('title'),Request::instance()->post('con'));
                return json($msg);
            }
            else
            {
                return json(['linecode'=>4000,'msg'=>'权限不够！']);
            }
        }
        else
        {
            throw new NoLogin();
        }
    }
}