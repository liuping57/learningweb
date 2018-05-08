<?php
/**
 * Created by PhpStorm.
 * User: wsqer
 * Date: 2018/4/22
 * Time: 20:41
 */

namespace app\api\controller;


use app\exception\NoLogin;
use think\Db;
use think\Session;

class Classinfo
{
    public function info()
    {
        if(Session::has('user'))
        {
            $user=Session::get("user");
            $user_id=$user['user_id'];
            $data=Db::query("select study.process,study.test,study.score,course.belong_author,course.user_id,course.course_name,course.course_id,belong_author,course.difficulty,course.class_hours from course,study where study.course_id=course.course_id and study.user_id='$user_id'");
            return json($data);
        }
        else
        {
            throw new NoLogin();
        }
    }
}