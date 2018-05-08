<?php
/**
 * Created by PhpStorm.
 * User: wsqer
 * Date: 2018/4/21
 * Time: 14:03
 */

namespace app\teacher\controller;


use app\exception\NoLogin;
use app\user\model\Message;
use think\Db;
use think\Request;
use think\Session;

class Score
{
    public function getscore()
    {
        if(Session::has('user'))
        {
            $user=Session::get("user");
            if ($user['chmod'] >=2)
            {
                $user_id=$user['user_id'];
                $data=Db::query("select study.id,study.user_id,headimg,test,score,course.course_id,course_name from user_info,study,course WHERE course.user_id='$user_id'AND study.user_id=user_info.user_id AND study.course_id=course.course_id");
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
    public function retest()
    {
        if(Session::has('user'))
        {
            $user=Session::get("user");
            if ($user['chmod'] >=2)
            {
                $id=Request::instance()->post('id');
                Db::query('update study set test=0,score=0 WHERE id='.$id);
                return json(['linecode'=>200,'msg'=>'更新成功，请提醒学生考试！']);
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
    public function sendmsg()
    {
        if(Session::has('user'))
        {
            $user=Session::get("user");
            if ($user['chmod'] >=2)
            {
                $send=$user['user_id'];
                $user_id=Request::instance()->post('user_id');
                $msg=Request::instance()->post('msg');
                $message=new Message();
                $message->data([
                    'send'=>$send,
                    'user_id'=>$user_id,
                    'type'=>'考试通知',
                    'msg'=>$msg
                ]);
                $message->save();
                return json(['linecode'=>200,'msg'=>'消息已发送成功']);
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