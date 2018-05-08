<?php
/**
 * Created by PhpStorm.
 * User: wsqer
 * Date: 2018/4/21
 * Time: 9:59
 */

namespace app\teacher\controller;


use app\exception\NoLogin;
use think\Db;
use think\Session;

class Getclass
{
    public function getclasslist()
    {
        if(Session::has('user'))
        {
            $user=Session::get("user");
            if ($user['chmod'] >=2)
            {
                $user_id=$user['user_id'];
                $data=Db::query("select course.user_id ,course.course_id,course_name,belong_author,count(id) as num from course,study where course.course_id=study.course_id AND course.user_id='$user_id' GROUP BY course.course_id");
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