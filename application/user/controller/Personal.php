<?php
/**
 * Created by PhpStorm.
 * User: wsq
 * Date: 2018/3/7
 * Time: 16:43
 */

namespace app\user\controller;


use app\exception\NoLogin;
use app\user\model\User_info;
use app\user\validata\UpdatePwd;
use app\user\validata\UserInfo;
use think\Db;
use think\Request;
use think\Session;

class Personal
{
    public function userinfo()
    {
        if(Session::has('user'))
        {
            $user=Session::get("user");
            $info=User_info::get(['user_id'=>$user['user_id']]);
            $info['chmod']=$user['chmod'];
            return json($info);
        }
        else
        {
           throw new NoLogin();
        }

    }
    public function UpdateUserInfo()
    {
        if(Session::has('user'))
        {
            (new UserInfo())->gocheck();

            $user=Session::get("user");
            $info=new User_info();
            $info->save([
                'user_name'=>Request::instance()->post('username'),
                'QQ'=>Request::instance()->post('qq'),
                'tel'=>Request::instance()->post('tel'),
                'sex'=>Request::instance()->post('sex'),
                'email'=>Request::instance()->post('email')
            ],['user_id'=>$user['user_id']]);
            return json(['linecode'=>200,'msg'=>'修改成功']);
        }
        else
        {
            throw new NoLogin();
        }
    }
    public function updateuserpwd()
    {
        if(Session::has('user'))
        {
            (new UpdatePwd())->gocheck();
            $pwd=md5(Request::instance()->post('pwd'));
            $pwd1=md5(Request::instance()->post('pwd1'));
            $pwd2=md5(Request::instance()->post('pwd2'));
            if ($pwd1==$pwd2)
            {
                $user=Session::get("user");
                $user_id=$user['user_id'];
                $res=Db::query("UPDATE `user_login` SET `user_pwd` = '$pwd2' WHERE `user_login`.`user_id` = '$user_id' AND user_pwd='$pwd' ");
                if($res !=0)
                {
                    return json(['linecode'=>200,'msg'=>'修改成功']);
                }
                else
                {
                    return json(['linecode'=>1007,'msg'=>'原始密码不正确']);
                }

            }
            else
            {
                return json(['linecode'=>1008,'msg'=>'两次密码不一致']);
            }
        }
        else
        {
            throw new NoLogin();
        }
    }
}