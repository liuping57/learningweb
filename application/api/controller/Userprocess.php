<?php
/**
 * Created by PhpStorm.
 * User: wsqer
 * Date: 2018/4/22
 * Time: 19:52
 */

namespace app\api\controller;


use app\exception\NoLogin;
use think\Db;
use think\Session;

class Userprocess
{
    public function process()
    {
        if(Session::has('user'))
        {
            $user=Session::get("user");
            $user_id=$user['user_id'];
            $data=Db::query("select study.process,course.course_name,course.course_id,study.test,study.score from course,study where study.course_id=course.course_id and study.user_id='$user_id'");
            return json($data);
        }
        else
        {
            throw new NoLogin();
        }
    }
}