<?php
/**
 * Created by PhpStorm.
 * User: wsq
 * Date: 2017/11/2
 * Time: 10:11
 */

namespace app\user\model;


use app\exception\LoginError;
use app\exception\Loginsuccess;
use app\exception\Logout;
use app\exception\ValicodeErr;
use think\Db;
use think\Request;
use think\Session;

class LoginModel
{
    public static function login()
    {
        $username=Request::instance()->post("username");
        $userpwd=md5(Request::instance()->post("userpwd"));
        $valicode=Request::instance()->post("valicode");
        if ($valicode==Session::pull("valicode"))
        {
            $userlogin=Db::query( "select chmod,user_name from user_login WHERE user_id='$username' AND user_pwd='$userpwd'");
            if ($userlogin)
            {
                Session::set("user",[
                    'user_id'=>$username,
                    'chmod'=>$userlogin[0]["chmod"],
                    'user_name'=>$userlogin[0]["user_name"]
                ]);
                $data=date("Y-m-d H:i:s");
                Db::query("UPDATE `user_info` SET `login_time` = '$data' WHERE `user_info`.`user_id` = '$username';");
                throw new Loginsuccess();
            }
            else
            {
                throw new LoginError();
            }
        }
        else
        {
            throw new ValicodeErr();
        }
    }
    public static function logout()
    {
        Session::delete("user");
        throw new Logout();
    }
}