<?php
/**
 * Created by PhpStorm.
 * User: wsqer
 * Date: 2018/4/21
 * Time: 10:33
 */

namespace app\teacher\controller;


use app\user\model\Course_type;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;

class course extends Controller
{
    public function add()
    {
        if(Session::has('user'))
        {
            $user=Session::get("user");
            if ($user['chmod'] >=2)
            {
                $type=Course_type::all();
                $this->assign('types',$type);
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
    public function courselist()
    {
        if(Session::has('user'))
        {
            $user=Session::get("user");
            if ($user['chmod'] >=3)
            {
                $datas=Db::name('course')->paginate(6);
                $this->assign('pagelist',$datas);
                return $this->fetch();
            }
            else if ($user['chmod'] >=2)
            {
                $datas=Db::name('course')->where(['user_id'=>$user['user_id']])->paginate(4);
                $this->assign('pagelist',$datas);
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
    public function courseedit()
    {
        if(Session::has('user'))
        {
            $user=Session::get("user");
            if ($user['chmod'] >=3)
            {
                $course_id=Request::instance()->get('id');
                $data=Db::query("select * from course where course_id=$course_id");
                $this->assign('data',$data);
                $type=Course_type::all();
                $this->assign('types',$type);
                return $this->fetch();
            }
            else if ($user['chmod'] >=2)
            {
                $user_id=$user['user_id'];
                $course_id=Request::instance()->get('id');
                $data=Db::query("select * from course where course_id=$course_id AND user_id='$user_id'");
                $this->assign('data',$data);
                $type=Course_type::all();
                $this->assign('types',$type);
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