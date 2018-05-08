<?php
/**
 * Created by PhpStorm.
 * User: wsqer
 * Date: 2018/4/9
 * Time: 10:25
 */

namespace app\admin\controller;


use think\Controller;
use think\Cookie;
use think\Db;
use think\Request;
use think\Session;

class Comment extends Controller
{
    public function comment()
    {
        if(Session::has('user'))
        {
            $user=Session::get("user");
            if ($user['chmod'] >=3)
            {
                if (Request::instance()->has('course_id'))
                {
                    $course_id=Request::instance()->get('course_id');
                    $course_name=Request::instance()->get('course_name');
                    Cookie::set('gpt',['course_name'=>$course_name,'course_id'=>$course_id]);
                }
                $sds=Cookie::get('gpt');
                $comm = Db::name('comments')->where('course_id',$sds['course_id'])->paginate(5);
                $this->assign('comment',$comm);
                $page = $comm->render();
                $this->assign('page',$page);
                $this->assign('course_name',$sds['course_name']);
                return $this->fetch();
            }
            else if ($user['chmod'] >=2)
            {
               return $this->fetch();
            }
            else
            {
                return $this->fetch('error/nochmod');
            }
        }
        else
        {
            return $this->fetch('error/nologin');
        }

    }
}