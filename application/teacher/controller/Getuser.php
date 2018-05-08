<?php
/**
 * Created by PhpStorm.
 * User: wsqer
 * Date: 2018/4/21
 * Time: 13:30
 */

namespace app\teacher\controller;


use app\exception\NoLogin;
use think\Db;
use think\Session;

class Getuser
{
    public function userinfo()
    {
        if(Session::has('user'))
        {
            $user=Session::get("user");
            if ($user['chmod'] >=2)
            {
                $user_id=$user['user_id'];
                $data=Db::query("select study.user_id,sex,headimg,login_time,course.course_id,course_name from user_info,study,course WHERE course.user_id='$user_id'AND study.user_id=user_info.user_id AND study.course_id=course.course_id");
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