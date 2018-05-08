<?php
/**
 * Created by PhpStorm.
 * User: wsqer
 * Date: 2018/4/22
 * Time: 11:05
 */

namespace app\teacher\controller;


use app\exception\NoLogin;
use app\user\model\Message;
use think\Db;
use think\Request;
use think\Session;

class Homework
{
    public function sendhomework()
    {
        if(Session::has('user'))
        {
            $user=Session::get("user");
            if ($user['chmod'] >=2)
            {
                $user_id=$user['user_id'];
                $msg=Request::instance()->post('msg');
                $course_id=Request::instance()->post('course_id');
                $data=Db::query("select user_id from study WHERE course_id=$course_id");
                $list=[];

                for ($i=0;$i<sizeof($data);$i++)
                {
                    $list[$i]=[
                        'msg'=>$msg,
                        'send'=>$user_id,
                        'user_id'=>$data[$i]['user_id'],
                        'type'=>'课堂作业'
                    ];
                }
                $message=new Message();
                $message->saveAll($list);
                return json(['linecode'=>200,'msg'=>'作业发布成功']);
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
    public function getmycourse()
    {
        if(Session::has('user'))
        {
            $user=Session::get("user");
            if ($user['chmod'] >=2)
            {
                $user_id=$user['user_id'];
                $data=Db::query("select course_id,course_name from course where user_id='$user_id'");
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