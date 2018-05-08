<?php
/**
 * Created by PhpStorm.
 * User: wsq
 * Date: 2018/3/11
 * Time: 6:23
 */

namespace app\user\model;



use think\Db;
use think\Model;

class Index_courses extends Model
{
    public static function excellent()
    {
        $datas=Db::query('select index_courses.type_id, course.course_id as id,course_name as class_name,img_url as image,synopsis ,rank from course,index_courses WHERE course.course_id=index_courses.course_id and index_type=1 ORDER  by rank asc');
        return $datas;
    }
    public static function recommend()
    {
        $datas=Db::query('select index_courses.type_id, course.course_id as id,course_name as class_name,img_url as image,synopsis ,rank from course,index_courses WHERE course.course_id=index_courses.course_id and index_type=2 ORDER  by rank asc');
        return $datas;
    }
    public static function interest()
    {
        $datas=Db::query('select course_id as id,course_name as class_name,img_url as image,synopsis from course WHERE course_id IN (SELECT course_id FROM index_courses where index_type=3)');
        return $datas;
    }
    public static function elaborate_works()
    {
        $datas=Db::query('select index_courses.type_id, course.course_id as id,course_name as class_name,img_url as image,synopsis ,rank from course,index_courses WHERE course.course_id=index_courses.course_id and index_type=4 ORDER  by rank asc');
        return $datas;
    }

}