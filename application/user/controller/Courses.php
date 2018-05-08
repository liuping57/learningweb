<?php
/**
 * Created by PhpStorm.
 * User: wsq
 * Date: 2018/1/23
 * Time: 16:10
 */

namespace app\user\controller;

use app\user\model\chapters;
use app\user\model\chapters_detail;
use app\user\model\Course;
use app\user\validata\valnumber;
use think\Controller;
use think\Cookie;
use think\Request;
class Courses extends Controller
{
    public function getChapters()
    {
        if(Request::instance()->has("course_id"))
        {
            if(Request::instance()->post("course_id")=="")
            {
                return json([]);
            }
            else{
                $chapters=chapters::all(function($query){
                    $query->where('course_id',Request::instance()->post("course_id") )->order('rank', 'asc');
                });
                return json($chapters);
            }

        }
        else
        {
            return json(['code'=>200,'msg'=>'请提交courseid']);
        }
    }

    public function detail()
    {
        if(Request::instance()->has("id"))
        {

            $detail=chapters_detail::all(function($query){
                $query->where('chapters_id',Request::instance()->post("id") )->order('rank', 'asc');
            });
            return json($detail);
        }
        else
        {
            return json(['code'=>200,'msg'=>'请提交id']);
        }
    }

    public function findclass()
    {
        if(Request::instance()->has("course_name"))
        {
            $course=Course::all(function ($query){
                $course_name=Request::instance()->post("course_name");
                $where['course_name']=['like','%'.$course_name.'%'];
                $query->where($where);
            });
            return json($course);
        }
        return json(['code'=>'1000','msg'=>'请输入课程名c']);
    }
    public function course()
    {
        if(Request::instance()->has("course_id"))
        {
            $course=Course::get($course_name=Request::instance()->post("course_id"));
            return json($course);
        }
        return json(['code'=>'1023','msg'=>'请输入课程id']);
    }
    public function browser()
    {
        $course_id=Request::instance()->post("course_id");
        (new valnumber())->gocheck();
        if(Cookie::has("browser"))
        {
            $bro=Cookie::get("browser");
            for($i=0;$i<sizeof($bro);$i++)
            {
                if ($bro[$i] != $course_id)
                {
                    array_push($bro,$course_id);
                    Cookie::set("browser",$bro);
                    $updates=new Course();
                    $updates->where('course_id',$course_id)->setInc('browser');
                }
            }
        }
        else
        {
            $updates=new Course();
            $updates->where('course_id',$course_id)->setInc('browser');
            $data=array($course_id);
            Cookie::set("browser",$data,1800);
        }

    }

    //获取课程以分类
    public function getCoursebyType()
    {
        $type= input("type");
        $course = new Course();
        $sql= "select * from course where type_id in (select type_id  from course_type where type_name= '$type')";
        $list = $course->Query($sql);
        $this->assign('list',$list);
        return $this->fetch();
    }
}
