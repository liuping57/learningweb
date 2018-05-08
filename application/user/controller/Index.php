<?php
/**
 * Created by PhpStorm.
 * User: wsq
 * Date: 2018/3/7
 * Time: 22:07
 */

namespace app\user\controller;




use app\user\model\Banner;
use app\user\model\Index_courses;

class Index
{
    public function banner()
    {
        $banner = Banner::all(function($query){
            $query->where('hidden', 0)->limit(3)->order('rank', 'asc');
        });
        return json($banner);
    }
    public function excellent()//精品课程
    {
        $data=Index_courses::excellent();
        return json($data);
    }
    public function recommend() //推荐课程接口
    {
        $data=Index_courses::recommend();
        return json($data);
    }
    public  function interest()//趣味课堂
    {
        $data=Index_courses::interest();
        return json($data);
    }
    public  function elaborate()//优课展示
    {
        $data=Index_courses::elaborate_works();
        return json($data);
    }
}