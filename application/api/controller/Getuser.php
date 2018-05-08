<?php
/**
 * Created by PhpStorm.
 * User: wsqer
 * Date: 2018/4/11
 * Time: 14:12
 */

namespace app\api\controller;


use app\exception\NoLogin;
use think\Db;
use think\Request;
use think\Session;

class Getuser
{
    public function user()
    {
        if(Session::has('user'))
        {
            $user=Session::get("user");
            if ($user['chmod'] >=3)
            {
                $str=Request::instance()->post('str');
                $data=Db::query("select * from user_info where user_id like '%$str%' or user_name like '%$str%' or email like '%$str%'");
                return json($data);
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