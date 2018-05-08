<?php
/**
 * Created by PhpStorm.
 * User: wsq
 * Date: 2018/3/20
 * Time: 18:06
 */

namespace app\user\model;


use think\Db;
use think\Model;

class Comments extends Model
{
    public static function getComment($course_id)
    {
        $data=Db::query("select comment_id,user_info.user_id as userid, user_info.user_name as username,
                              sex,headimg,comment_date as commenttime,comment,praise 
                              from comments,user_info WHERE 
                              comments.user_id=user_info.user_id and course_id='$course_id' 
                              ORDER BY praise DESC ");
        return $data;
    }
}