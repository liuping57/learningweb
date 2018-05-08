<?php
/**
 * Created by PhpStorm.
 * User: wsqer
 * Date: 2018/4/6
 * Time: 16:26
 */

namespace app\api\controller;


use app\exception\NoLogin;
use app\user\model\chapters;
use app\user\model\chapters_detail;
use app\user\model\Course;
use app\user\validata\Addchapters;
use app\user\validata\AddClass;
use app\user\validata\Adddetail;
use think\Db;
use think\Request;
use think\Session;

class Addcourse
{
    public function addcourse()
    {
        if(Session::has('user'))
        {
            $user=Session::get("user");
            if ($user['chmod'] >=2)
            {
                (new AddClass())->gocheck();
                $course=new Course();
                $course->data([
                    'course_name'=>Request::instance()->post('course_name'),
                    'class_hours'=>Request::instance()->post('course_hours'),
                    'difficulty'=>Request::instance()->post('difficulty'),
                    'belong_author'=>Request::instance()->post('author'),
                    'type_id'=>Request::instance()->post('course_type'),
                    'synopsis'=>Request::instance()->post('course_info'),
                    'user_id'=>$user['user_id']
                ]);
                $course->save();
                return json(['linecode'=>200,'msg'=>'创建成功','course_id'=>$course->course_id]);
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
    public function addchapters()
    {
        if(Session::has('user'))
        {
            $user=Session::get("user");
            if ($user['chmod'] >=2)
            {
                (new Addchapters())->gocheck();
                $course=new chapters();
                $course->data([
                    'course_id'=>Request::instance()->post('course_id'),
                    'chapters_title'=>Request::instance()->post('chapters_name'),
                    'rank'=>Request::instance()->post('chapters_rank'),
                ]);
                $course->save();
                return json(['linecode'=>200,'msg'=>'创建成功']);
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
    public function delchapters()
    {
        if(Session::has('user'))
        {
            $user=Session::get("user");
            if ($user['chmod'] >=2)
            {
                $cha=Request::instance()->post('chapters_id');
                chapters::destroy($cha);
                chapters_detail::destroy(['chapters_id'=>$cha]);
                return json(['linecode'=>200,'msg'=>'删除成功']);
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
    public function adddetail()
    {
        if(Session::has('user'))
        {
            $user=Session::get("user");
            if ($user['chmod'] >=2)
            {
                (new Adddetail())->gocheck();
                $detail = new chapters_detail();
                $detail->data(
                    [
                        'chapters_detail_title'=>Request::instance()->post('title'),
                        'chapter_detail_link'=>Request::instance()->post('url'),
                        'chapters_id'           =>Request::instance()->post('chapters_id'),
                        'rank'                  =>Request::instance()->post('rank')
                    ]
                );
                $detail->save();
                return json(['linecode'=>200,'msg'=>'添加成功']);
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
    public function deldetail()
    {
        if(Session::has('user'))
        {
            $user=Session::get("user");
            if ($user['chmod'] >=2)
            {
                $cha=Request::instance()->post('id');
                chapters_detail::destroy($cha);
                return json(['linecode'=>200,'msg'=>'删除成功'.$cha]);
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

    public function delcourse()
    {
        if(Session::has('user'))
        {
            $user=Session::get("user");
            if ($user['chmod'] >=3)
            {
                $id=Request::instance()->post('course_id');
                $chapter=Db::query("select chapters_id from chapters where course_id=$id");
                //return json($chapter);
                foreach($chapter as $user){
                    chapters_detail::destroy(['chapters_id'=>$user['chapters_id']]);
                }
                chapters::destroy(['course_id'=>$id]);
                Course::destroy($id);
                return json(['linecode'=>200,'msg'=>'删除成功']);
            }
            else if ($user['chmod'] >=2)
            {
                $id=Request::instance()->post('course_id');
                $chapter=Db::query("select chapters_id from chapters where course_id=$id");
                //return json($chapter);
                foreach($chapter as $user){
                    chapters_detail::destroy(['chapters_id'=>$user['chapters_id']]);
                }
                chapters::destroy(['course_id'=>$id]);
                Course::destroy($id);
                return json(['linecode'=>200,'msg'=>'教师删除成功']);
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
    public function saveclass()
    {
        if(Session::has('user'))
        {
            $user=Session::get("user");
            if ($user['chmod'] >=2)
            {
                $id=Request::instance()->post('course_id');
                (new AddClass())->gocheck();
                $course=new Course();
                $course->save([
                    'course_name'=>Request::instance()->post('course_name'),
                    'class_hours'=>Request::instance()->post('course_hours'),
                    'difficulty'=>Request::instance()->post('difficulty'),
                    'belong_author'=>Request::instance()->post('author'),
                    'type_id'=>Request::instance()->post('course_type'),
                    'synopsis'=>Request::instance()->post('course_info'),
                ],[
                    'course_id'=>$id
                ]);
                return json(['linecode'=>200,'msg'=>'更新成功']);
            }
            else if ($user['chmod'] >=2)
            {
                return json(['linecode'=>200,'msg'=>'更新成功']);
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
    public function updatechapters()
    {
        if(Session::has('user'))
        {
            $user=Session::get("user");
            if ($user['chmod'] >=2)
            {
                $id=Request::instance()->post('id');
                (new Addchapters())->gocheck();
                $course=new chapters();
                $course->save([
                    'chapters_title'=>Request::instance()->post('chapters_name'),
                    'rank'=>Request::instance()->post('chapters_rank'),
                ],[
                    'chapters_id'=>$id
                ]);
                return json(['linecode'=>200,'msg'=>'更新成功']);
            }
            else if ($user['chmod'] >=2)
            {
                return json(['linecode'=>200,'msg'=>'更新成功']);
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
    public function updatedetail()
    {
        if(Session::has('user'))
        {
            $user=Session::get("user");
            if ($user['chmod'] >=2)
            {
                $id=Request::instance()->post('id');
                (new Adddetail())->gocheck();
                $course=new chapters_detail();
                $course->save([
                    'chapters_detail_title'=>Request::instance()->post('title'),
                    'rank'=>Request::instance()->post('rank'),
                    'chapter_detail_link'=>Request::instance()->post('url')
                ],[
                    'chapters_detail_id'=>$id
                ]);
                return json(['linecode'=>200,'msg'=>'更新成功']);
            }
            else if ($user['chmod'] >=2)
            {
                return json(['linecode'=>200,'msg'=>'更新成功']);
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
    public function delcomment()
    {
        if(Session::has('user'))
        {
            $user=Session::get("user");
            if ($user['chmod'] >=3)
            {
                $id=Request::instance()->post('comment_id');
                \app\user\model\Comments::destroy($id);
                return json(['linecode'=>200,'msg'=>'删除成功']);
            }
            else if ($user['chmod'] >=2)
            {
                return json(['linecode'=>200,'msg'=>'教师删除成功']);
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