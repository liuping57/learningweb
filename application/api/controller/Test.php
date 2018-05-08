<?php
/**
 * Created by PhpStorm.
 * User: wsqer
 * Date: 2018/4/11
 * Time: 18:26
 */

namespace app\api\controller;


use app\exception\NoLogin;
use think\Db;
use think\Request;
use think\Session;

class Test
{
    //选取试题
    public function gotest()
    {
        if(Session::has('user'))
        {
            $course_id=Request::instance()->post('course_id');
            $user=Session::get("user");
            $user_id=$user['user_id'];
            $getdata=Db::query("select * from study where user_id='$user_id' and course_id=$course_id");
            if($getdata)
            {
                if($getdata[0]['test'] == 0)
                {
                    $test=Db::query("select id,title,a,b,c,d from test where course_id='$course_id' order by RAND() limit 50");
                    return json($test);
                }
                else
                {
                    return json(['linecode'=>1024,'msg'=>'你的分数为：'.$getdata[0]['score']]);
                }
            }
            else
            {
                return json(['linecode'=>1023,'msg'=>'你未学习这门课程不可以参加考试']);
            }

        }
        else
        {
            throw new NoLogin();
        }

    }
    //评分试题

    public function valtest()
    {
        if(Session::has('user'))
        {
            $course_id=Request::instance()->post('course_id');
            $user=Session::get("user");
            $user_id=$user['user_id'];
            $getdata=Db::query("select * from study where user_id='$user_id' and course_id=$course_id");
            if($getdata)
            {
                if($getdata[0]['test'] == 0)
                {
                    $res=json_decode(Request::instance()->post('test'),true);
                    $score=0;
                    for($i=0;$i<sizeof($res);$i++)
                    {
                        $id=$res[$i]['id'];
                        $result=$res[$i]['result'];
                        if(Db::query("select * from test where id=$id AND result=$result"))
                        {
                            $score +=2;
                        }
                    }
                    Db::query("update study set test=1,score=$score where user_id='$user_id' and course_id=$course_id");
                    return json(['linecode'=>200,'msg'=>'考试完成你的分数为：'.$score]);

                }
                else
                {
                    return json(['linecode'=>1024,'msg'=>'你的分数为：'.$getdata[0]['score']]);
                }
            }
            else
            {
                return json(['linecode'=>1023,'msg'=>'你未学习这门课程不可以参加考试']);
            }

        }
        else
        {
            throw new NoLogin();
        }
    }

}