<?php
/**
 * Created by PhpStorm.
 * User: wsqer
 * Date: 2018/4/21
 * Time: 12:04
 */

namespace app\teacher\controller;


use app\user\model\Resource;
use think\Controller;
use think\Request;

class Res extends Controller
{
    public function add()
    {
        $name   = input('param.name');
        $title   = input('param.title');
        $type   = input('param.type');
        $courseName =input("courseName");
        $content = input('param.content');
        $downloadAddress = input('param.downloadAddress');

        if ($title<>'') {
            // 模型的 静态方法
            $user = Resource::Create([
                'name' => $name,
                'type' => $type,
                'title'   =>  $title,
                'courseName'  =>  $courseName,
                'content' =>  $content,
                'downloadAddress' =>  $downloadAddress,
            ]);

            return $this->success('恭喜您添加资源成功^_^','add');
        }
        $name=Request::instance()->get('course_name');
        $this->assign('course_name',$name);
        return $this->fetch();
    }
}