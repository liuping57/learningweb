<?php
/**
 * Created by PhpStorm.
 * User: wsq
 * Date: 2018/3/20
 * Time: 18:06
 */

namespace app\user\controller;


use app\exception\NoLogin;
use think\Request;
use think\Session;

class Comments
{
    public function comments()
    {
        if(Request::instance()->has('course_id'))
        {
            $data=\app\user\model\Comments::getComment(Request::instance()->post("course_id"));
            if ($data)
            {
                return json($data);
            }
            else
            {
                return json(['code'=>1019,'msg'=>'暂时没有评论']);
            }

        }
        else
        {
            return json(['code'=>1018,'msg'=>'请输入课程号']);
        }
    }
    public function praise()
    {

        if(Session::has('user'))
        {
            if (Request::instance()->has("comment_id"))
            {
                $user=Session::get("user");
                $id=Request::instance()->post("comment_id");
                $updates=new \app\user\model\Comments();
                $updates->where('comment_id',$id)->setInc('praise');
                return json(['linecode'=>200,'msg'=>"点赞成功"]);
            }
            else
            {
                return json(['linecode'=>1022,'msg'=>'评论id不存在']);
            }

        }
        else
        {
            throw new NoLogin();
        }
    }
    public function subcomment()
    {
        if(Session::has('user'))
        {
            if (Request::instance()->has("course_id")&&Request::instance()->has("comment"))
            {
                $user=Session::get("user");
                $id=Request::instance()->post("course_id");
                $comment=Request::instance()->post("comment");
                $updates=new \app\user\model\Comments();
                $updates->data(['user_id'=>$user['user_id'],'course_id'=>$id,'comment'=>$comment]);
                $updates->save();
                return json(['linecode'=>200,'msg'=>"评论成功"]);
            }
            else
            {
                return json(['linecode'=>1022,'msg'=>'提交不存在']);
            }

        }
        else
        {
            throw new NoLogin();
        }
    }
}