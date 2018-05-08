<?php
/**
 * Created by PhpStorm.
 * User: wsqer
 * Date: 2018/4/9
 * Time: 17:36
 */

namespace app\admin\controller;


use think\Controller;
use think\Db;
use think\Request;
use think\Session;

class User extends Controller
{
    public function userlist()
    {
        if(Session::has('user'))
        {
            $user=Session::get("user");
            if ($user['chmod'] >=3)
            {
               // $user=Db::query('select user_login.user_id,user_login.chmod,user_info.sex,user_info.headimg,login_time,email from user_info,user_login where user_info.user_id=user_login.user_id');
                //$user=Db::faled('user_login.user_id,user_login.chmod,user_info.sex,user_info.headimg,login_time,email')
                 //   ->table('user_info user_id,user_login user_id')
                 //   ->limit(10)->select();
                $user=Db::table('user_info')->join('user_login','user_login.user_id=user_info.user_id')->paginate(5);
                $this->assign('info',$user);
                return $this->fetch();
            }
            else if ($user['chmod'] >=2)
            {

                return $this->fetch();
            }
            else
            {
                return $this->fetch('error/nochmod');
            }
        }
        else
        {
            return $this->fetch('error/nologin');
        }
    }
    public function deluser()
    {
        if(Session::has('user'))
        {
            $user=Session::get("user");
            if ($user['chmod'] >=3)
            {
                $user_id=Request::instance()->post('user_id');
                Db::query("delete from user_login where user_id='$user_id' ");
                Db::query("delete from user_info where user_id='$user_id' ");
                return json(['linecode'=>200,'msg'=>'删除成功']);
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
    public function changeusermod()
    {
        if(Session::has('user'))
        {
            $user=Session::get("user");
            if ($user['chmod'] >=3)
            {
                $user_id=Request::instance()->post('user_id');
                $user_mod=Request::instance()->post('user_mod');
                Db::query('update user_login set chmod='.$user_mod.' where user_id="'.$user_id.'"');
                return json(['linecode'=>200,'msg'=>'权限已修改']);
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