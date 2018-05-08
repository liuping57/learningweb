<?php
/**
 * Created by PhpStorm.
 * User: wsqer
 * Date: 2018/4/23
 * Time: 9:47
 */

namespace app\api\controller;


use app\api\model\Notes;
use app\exception\NoLogin;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;

class Note extends Controller
{
    public function getnote()
    {
        if(Session::has('user'))
        {
            $user=Session::get("user");
            $user_id=$user['user_id'];
            $course_id=Request::instance()->post('course_id');
            $data=Db::query("select * from notes where user_id='$user_id' and course_id=$course_id");
            return json($data);
        }
        else
        {
            throw new NoLogin();
        }
    }
//写入课堂笔记
    public function subnote()
    {
        if(Session::has('user'))
        {
            $user=Session::get("user");
            $user_id=$user['user_id'];
            $course_id=Request::instance()->post('course_id');
            $note=Request::instance()->post('note');
            $notes=new Notes();
            $notes->save(
                [
                    'note'=>$note
                ],
                [
                    'user_id'=>$user_id,
                    'course_id'=>$course_id
                ]);
            return json([
                'linecode'=>200,
                'msg'=>'保存成功'
            ]);
        }
        else
        {
            throw new NoLogin();
        }
    }
    //创建笔记分享
    public function sharenote($id)
    {
            $data=Db::query("select note,notes.user_id,course.course_id,course.course_name from notes,course where notes.course_id=course.course_id and id=$id");
            $this->assign('note',$data);
            return $this->fetch();
    }
}