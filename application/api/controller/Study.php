<?php
/**
 * Created by PhpStorm.
 * User: wsqer
 * Date: 2018/4/12
 * Time: 12:32
 * 当用户收藏一门课程后添加一条记录
 */

namespace app\api\controller;


use app\api\model\Notes;
use app\exception\NoLogin;
use app\user\model\Message;
use think\Db;
use think\Request;
use think\Session;

class Study
{
    public function studystatus()
    {
        if(Session::has('user'))
        {
            $user=Session::get("user");
            $course_id=Request::instance()->post("course_id");
            $user_id=$user['user_id'];
            if($ssd=Db::query("select * from study where user_id='$user_id' and course_id=$course_id"))
            {
                return json($ssd);
            }
            else
            {
                return json(['linecode'=>400,'msg'=>'未收藏']);
            }

        }
        else
        {
            throw new NoLogin();
        }
    }
    public function addstudy()
    {
        if(Session::has('user'))
        {
            $user=Session::get("user");
            $course_id=Request::instance()->post("course_id");
            $user_id=$user['user_id'];
            if($ssd=Db::query("select * from study where user_id='$user_id' and course_id=$course_id"))
            {
                return json(['linecode'=>200,'msg'=>'已收藏']);
            }
            else
            {
                $study=new \app\api\model\Study();
                $study->data(
                    [
                        'user_id'=>$user_id,
                        'course_id'=>$course_id
                    ]
                );
                $study->save();
                $note=new Notes();
                $note->data([
                    'user_id'=>$user_id,
                    'course_id'=>$course_id
                ]);
                $note->save();
                return json(['linecode'=>400,'msg'=>'已收藏']);
            }
        }
        else
        {
            throw new NoLogin();
        }
    }

    //申请取消学习课程
    public function resetstudy()
    {
        if(Session::has('user'))
        {
            $user=Session::get("user");
            $send=$user['user_id'];
            $user_id=Request::instance()->post('user_id');
            $course_id=Request::instance()->post('course_id');
            $course_name=$msg=Request::instance()->post('course_name');
            $message=new Message();
            $message->data([
                    'send'=>$send,
                    'user_id'=>$user_id,
                    'type'=>'普通消息',
                    'msg'=>$user_id.'同学请求退出《'.$course_name.'》课程学习，是否同意：<a href="javascript:void(0)" class="btn btn-primary" onclick="delstudyinfo(\''.$send.'\','.$course_id.',\''.$course_name.'\')">同意</a>'
            ]);
            $message->save();
            return json(['linecode'=>200,'msg'=>'请求已发送成功，请耐心等待老师的回复']);
        }
        else
        {
            throw new NoLogin();
        }
    }

    //取消学习课程操作
    public function delstudy()
    {
        if(Session::has('user'))
        {
            $user=Session::get("user");
            if ($user['chmod'] >=2)
            {
                $user_id=Request::instance()->post('user_id');
                $course_id=Request::instance()->post('course_id');
                $course_name=Request::instance()->post('course_name');
                Db::query("delete from study where user_id='$user_id' and course_id=$course_id");
                Db::query("delete from notes where user_id='$user_id' and course_id=$course_id");
                $message=new Message();
                $message->data([
                    'send'=>'系统',
                    'user_id'=>$user_id,
                    'type'=>'系统消息',
                    'msg'=>$user_id.'同学，你好！你申请退出课程《'.$course_name.'》成功，现在你可以重新加入学习!'
                ]);
                $message->save();
               return json([
                   'linecode'=>200,
                   'msg'=>'操作成功'
               ]);
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
    //申请重新考试
    public function restest()
    {
        if(Session::has('user'))
        {
            $user=Session::get("user");
            $send=$user['user_id'];
            $user_id=Request::instance()->post('user_id');
            $course_id=Request::instance()->post('course_id');
            $course_name=$msg=Request::instance()->post('course_name');
            $message=new Message();
            $message->data([
                'send'=>$send,
                'user_id'=>$user_id,
                'type'=>'普通消息',
                'msg'=>$user_id.'同学申请《'.$course_name.'》课程的重新考试！，是否同意：&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" class="btn btn-primary" onclick="subretest(\''.$send.'\','.$course_id.',\''.$course_name.'\')">同意</a>'
            ]);
            $message->save();
            return json(['linecode'=>200,'msg'=>'请求已发送成功，请耐心等待老师的回复']);
        }
        else
        {
            throw new NoLogin();
        }
    }
    //重置分数
    public function subretest()
    {
        if(Session::has('user'))
        {
            $user=Session::get("user");
            if ($user['chmod'] >=2)
            {
                $user_id=Request::instance()->post('user_id');
                $course_id=Request::instance()->post('course_id');
                $course_name=Request::instance()->post('course_name');
                $study=new \app\api\model\Study();
                $study->save([
                    'process'=>0,
                    'test'=>0,
                    'score'=>0
                ],[
                    'user_id'=>$user_id,
                    'course_id'=>$course_id
                ]);
                $message=new Message();
                $message->data([
                    'send'=>'系统',
                    'user_id'=>$user_id,
                    'type'=>'系统消息',
                    'msg'=>$user_id.'同学，你好！你申请《'.$course_name.'》重新考试成功，现在你可以前往课程中心参加考试!'
                ]);
                $message->save();
                return json([
                    'linecode'=>200,
                    'msg'=>'操作成功'
                ]);
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