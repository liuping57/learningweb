<?php
/**
 * Created by PhpStorm.
 * User: wsqer
 * Date: 2018/4/21
 * Time: 22:59
 */

namespace app\teacher\controller;


use app\exception\NoLogin;
use think\Db;
use think\Request;
use think\Session;

class Evaluation
{
    public function getevalution()
    {
        if(Session::has('user'))
        {
            $user=Session::get("user");
            if ($user['chmod'] >=2)
            {
                $user_id=$user['user_id'];
                $data=Db::query("select evaluation.user_id,msg,star,course.course_id,course_name from evaluation,course WHERE course.course_id=evaluation.course_id and course.user_id='$user_id'");
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
    public function subevaluation()
    {
        if(Session::has('user'))
        {
            $user=Session::get("user");
            $user_id=$user['user_id'];
            $course_id=Request::instance()->post("course_id");
            $msg=Request::instance()->post('msg');
            $star=Request::instance()->post("star");
            Db::query("insert into evaluation (course_id,user_id,msg,star)VALUES ($course_id,'$user_id','$msg',$star)");
            return json([
                'linecode'=>200,
                'msg'=>'教学评价已提交'
            ]);
        }
        else
        {
            throw new NoLogin();
        }
    }
}