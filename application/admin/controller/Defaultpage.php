<?php
/**
 * Created by PhpStorm.
 * User: wsqer
 * Date: 2018/4/5
 * Time: 16:41
 */

namespace app\admin\controller;


use app\user\model\Banner;
use app\user\model\FileUpload;
use app\user\model\Index_courses;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;

class Defaultpage extends Controller
{

    public function banner()
    {
        if(Session::has('user'))
        {
            $user=Session::get("user");
            if ($user['chmod'] >=3)
            {


        if(Request::instance()->has('cid1'))
        {
            $banner=new Banner();
            $banner->save(
                [
                    'course_id'=>Request::instance()->post('cid1'),
                    'rank'=>Request::instance()->post('crank1')
                ],
                ['banner_id'=>1]
            );
            $banner->save(
                [
                    'course_id'=>Request::instance()->post('cid2'),
                    'rank'=>Request::instance()->post('crank2')
                ],
                ['banner_id'=>2]
            );
            $banner->save(
                [
                    'course_id'=>Request::instance()->post('cid3'),
                    'rank'=>Request::instance()->post('crank3')
                ],
                ['banner_id'=>3]
            );
       }
       if(Request::instance()->has('banner_id'))
       {
           $returndata=FileUpload::bannerupload();
           echo "<script>alert('$returndata');</script>";
       }
        $datas=Db::query("select banner_id,banner.course_id,course.course_name,banner.img_url,rank from banner,course where banner.course_id=course.course_id ORDER BY banner_id asc");
        $this->assign('data',$datas);
        //return json($datas);
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
    public function excellent()
    {
        if(Session::has('user'))
        {
            $user=Session::get("user");
            if ($user['chmod'] >=3)
            {
        if (Request::instance()->has("type_id"))
        {
            $typeid=Request::instance()->post("type_id");
            $course_id=Request::instance()->post("course_id");
            $rank=Request::instance()->post("rank");
            $datt=Db::query("select COUNT(*) as num  from index_courses where index_type=1 and $course_id=course_id AND type_id != $typeid");
            if($datt[0]['num'] <1)
            {
                $cc=Db::query("select count(*) as num from course where course_id=$course_id");
                if($cc[0]['num'] >=1)
                {
                    $index=new Index_courses();
                    $index->save(
                        [
                            'course_id'=>$course_id,
                            'rank'=>$rank
                        ],
                        [
                            'type_id'=>$typeid
                        ]
                    );
                    echo "<script>alert('修改成功');</script>";
                }
                else
                {
                    echo "<script>alert('课程不存在');</script>";
                }
            }
            else
            {
                echo "<script>alert('课程不能重复');</script>";
            }
            //if()
        }
        $data=Index_courses::excellent();
        $noadd=Db::query('select * from index_courses WHERE course_id NOT IN (select course_id from course) and index_type=1');
        $this->assign('dds',$noadd);
        $this->assign('it',0);
        $this->assign('data',$data);
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
    public function recommend()
    {
        if(Session::has('user'))
        {
            $user=Session::get("user");
            if ($user['chmod'] >=3)
            {
        if (Request::instance()->has("type_id"))
        {
            $typeid=Request::instance()->post("type_id");
            $course_id=Request::instance()->post("course_id");
            $rank=Request::instance()->post("rank");
            $datt=Db::query("select COUNT(*) as num  from index_courses where index_type=2 and $course_id=course_id AND type_id != $typeid");
            if($datt[0]['num'] <1)
            {
                $cc=Db::query("select count(*) as num from course where course_id=$course_id");
                if($cc[0]['num'] >=1)
                {
                    $index=new Index_courses();
                    $index->save(
                        [
                            'course_id'=>$course_id,
                            'rank'=>$rank
                        ],
                        [
                            'type_id'=>$typeid
                        ]
                    );
                    echo "<script>alert('修改成功');</script>";
                }
                else
                {
                    echo "<script>alert('课程不存在');</script>";
                }
            }
            else
            {
                echo "<script>alert('课程不能重复');</script>";
            }
            //if()
        }

        $data=Index_courses::recommend();
        $noadd=Db::query('select * from index_courses WHERE course_id NOT IN (select course_id from course) and index_type=2');
        $this->assign('dds',$noadd);
        $this->assign('it',0);
        $this->assign('data',$data);
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
    public function elaborate()
    {
        if(Session::has('user'))
        {
            $user=Session::get("user");
            if ($user['chmod'] >=3)
            {
        if (Request::instance()->has("type_id"))
        {
            $typeid=Request::instance()->post("type_id");
            $course_id=Request::instance()->post("course_id");
            $rank=Request::instance()->post("rank");
            $datt=Db::query("select COUNT(*) as num  from index_courses where index_type=4 and $course_id=course_id AND type_id != $typeid");
            if($datt[0]['num'] <1)
            {
                $cc=Db::query("select count(*) as num from course where course_id=$course_id");
                if($cc[0]['num'] >=1)
                {
                    $index=new Index_courses();
                    $index->save(
                        [
                            'course_id'=>$course_id,
                            'rank'=>$rank
                        ],
                        [
                            'type_id'=>$typeid
                        ]
                    );
                    echo "<script>alert('修改成功');</script>";
                }
                else
                {
                    echo "<script>alert('课程不存在');</script>";
                }
            }
            else
            {
                echo "<script>alert('课程不能重复');</script>";
            }
            //if()
        }
        $data=Index_courses::elaborate_works();
        $noadd=Db::query('select * from index_courses WHERE course_id NOT IN (select course_id from course) and index_type=4');
        $this->assign('dds',$noadd);
        $this->assign('it',0);
        $this->assign('data',$data);
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