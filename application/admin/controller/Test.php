<?php
/**
 * Created by PhpStorm.
 * User: wsqer
 * Date: 2018/4/9
 * Time: 21:18
 */

namespace app\admin\controller;


use app\exception\NoLogin;
use think\Controller;
use think\Cookie;
use think\Request;
use think\Session;

class Test extends Controller
{
    public function testlist()
    {
        if(Session::has('user'))
        {
            $user=Session::get("user");
            if ($user['chmod'] >=3)
            {
                if (Request::instance()->has('course_id'))
                {
                    $course_id=Request::instance()->post('course_id');
                    $course_name=Request::instance()->post('course_name');
                    Cookie::set('course',['course_name'=>$course_name,'course_id'=>$course_id]);
                }
                $coo=Cookie::get('course');
                $course=\app\admin\model\Test::where('course_id',$coo['course_id'])->paginate(6);
                $this->assign('course_name',$coo['course_name']);
                $this->assign('course_id',$coo['course_id']);
                $this->assign('tik',1);
                $this->assign('data',$course);
                return $this->fetch();
            }
            else if($user['chmod'] >=2)
            {

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
    public function add()
    {
        if(Session::has('user'))
        {
            $user=Session::get("user");
            if ($user['chmod'] >=3)
            {
                if(Cookie::has('course'))
                {
                    (new \app\user\validata\Test())->gocheck();
                    $cc=Cookie::get('course');
                    $test=new \app\admin\model\Test();
                    $test->data([
                        'title'=>Request::instance()->post('title'),
                        'a'=>Request::instance()->post('a'),
                        'b'=>Request::instance()->post('b'),
                        'c'=>Request::instance()->post('c'),
                        'd'=>Request::instance()->post('d'),
                        'result'=>Request::instance()->post('result'),
                        'course_id'=>$cc['course_id']
                    ]);
                    $test->save();
                    return json(['linecode'=>200,'msg'=>'添加成功']);
                }
                else
                {
                    return json(['linecode'=>200,'msg'=>'暂无课程信息']);
                }

            }
            else if($user['chmod'] >=2)
            {

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
    public function deltest()
    {
        if(Session::has('user'))
        {
            $user=Session::get("user");
            if ($user['chmod'] >=3)
            {
                if(Cookie::has('course'))
                {
                    //$cc=Cookie::get('course');
                    $tid=Request::instance()->post('tid');
                    \app\admin\model\Test::destroy($tid);
                    return json(['linecode'=>200,'msg'=>'删除成功']);
                }
                else
                {
                    return json(['linecode'=>200,'msg'=>'暂无课程信息']);
                }

            }
            else if($user['chmod'] >=2)
            {

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
    public function edittest()
    {
        if(Session::has('user'))
        {
            $user=Session::get("user");
            if ($user['chmod'] >=3)
            {
                if(Cookie::has('course'))
                {
                    //$cc=Cookie::get('course');
                    $tid=Request::instance()->post('tid');
                    (new \app\user\validata\Test())->gocheck();
                    $test=new \app\admin\model\Test();
                    $test->save([
                        'title'=>Request::instance()->post('title'),
                        'a'=>Request::instance()->post('a'),
                        'b'=>Request::instance()->post('b'),
                        'c'=>Request::instance()->post('c'),
                        'd'=>Request::instance()->post('d'),
                        'result'=>Request::instance()->post('result'),
                    ],[
                        'id'=>$tid
                    ]);
                    return json(['linecode'=>200,'msg'=>'修改成功']);
                }
                else
                {
                    return json(['linecode'=>200,'msg'=>'暂无课程信息']);
                }

            }
            else if($user['chmod'] >=2)
            {

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