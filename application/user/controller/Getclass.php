<?php
/**
 * Created by PhpStorm.
 * User: wsqer
 * Date: 2018/4/12
 * Time: 14:29
 */

namespace app\user\controller;


use app\user\model\Course;
use think\Controller;
use think\Db;
use think\Session;

class Getclass extends Controller
{
    public function course($id)
    {
        if(Session::has('user'))
        {
            $user=Session::get("user");
            $user_id=$user['user_id'];
            $user_info=Db::query("select * from user_info where user_id='$user_id'");
            $this->assign('user_name',$user_id);
            $this->assign('test','<a href="#" class="flexitems listitem2" onclick="exam1()" id="listitem5">考试</a>');
            $this->assign('user','<a href="#" class="listitem22" onclick="logout()"  style="margin-left: 3px;display: inline">注销登录</a><a href="__ROOT__/personal/" class="listitem23" id="username1" style="margin-left: 2px;display: inline">'.$user['user_id'].'</a><a href="__ROOT__/personal/" class="listitem24" id="userimage" style="margin-left: 1px;display: inline"><img src="__STATIC__/../'.$user_info[0]['headimg'].'" width="60px" height="54px"></a>');
            if($ssd=Db::query("select * from study where user_id='$user_id' and course_id=$id"))
            {
                $this->assign('fav','<a  class="flexitems listitem3"><img width="20px" height="20px" align="left" src="__STATIC__/class/images/remove_fav.png">&nbsp;&nbsp;&nbsp;&nbsp;取消收藏</a>');
            }
            else
            {
                $this->assign('fav','<a href="#" class="flexitems listitem3" onclick="addfav()"><img width="20px" height="20px" align="left" src="__STATIC__/class/images/add_fav.png">&nbsp;&nbsp;&nbsp;&nbsp;收藏</a>');
            }
        }
        else
        {
            $this->assign('fav','<a href="#" class="flexitems listitem3" onclick="addfav()"><img width="20px" height="20px" align="left" src="__STATIC__/class/images/add_fav.png">&nbsp;&nbsp;&nbsp;&nbsp;收藏</a>');
            $this->assign('user_name',null);
            $this->assign('test',' ');
            $this->assign('user','<a href="#" class="listitem" onclick="register()" id="lg2">注册</a><a href="#" class="listitem" onclick="login2()" id="lg1">登录</a>');
        }

        $course=Course::all($id);
        $this->assign('course',$course);
        $course_list="";
        $selectlist="";
        $chapters=Db::query("select * from chapters where course_id=$id");
        for($a=0;$a<sizeof($chapters);$a++)
        {
            $chapters_id=$chapters[$a]['chapters_id'];
            $selectlist .='<option value="'.$chapters_id.'">'.$chapters[$a]['chapters_title'].'</option>';
            $detail=Db::query("select * from chapters_detail where chapters_id=$chapters_id");
            $course_list .='<div style="margin-left:5.6%;margin-top:2%;width:93%;margin-bottom:1px;"><hr size="1" color="#F0F0F0"/></div><div class="list2" id="list21"><span>'.$chapters[$a]['chapters_title'].'</span> <br/><ul id="fb" style="display: none;list-style-type: none;">  ';
            for ($b=0;$b<sizeof($detail);$b++)
            {
                $course_list .= '<li class="list11"><a href="#" class="a1" onclick="audio1(\''.$detail[$b]['chapter_detail_link'].'\')">&nbsp&nbsp'.$detail[$b]["chapters_detail_title"].'</a>
        	<span class="start"><a href="" onclick="audio1(\''.$detail[$b]['chapter_detail_link'].'\')"><img src="__STATIC__/class/images/mp4.png" title="视频"></a>
        	</span></li>  ';
            }
            $course_list .= '</ul></div>';
        }
        $this->assign('selectlist',$selectlist);
        $this->assign('courselist',$course_list);

        return $this->fetch();

    }
}