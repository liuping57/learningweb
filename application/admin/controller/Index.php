<?php
namespace app\admin\controller;

use app\index\model\Resource;
use think\Db;
use think\Request;
use think\Session;

class Index extends \think\Controller
{
    public function save()
    {
        $id = input("param.id");
        $name = input('param.name');
        $title = input('param.title');
        $type = input('param.type');
        $courseName = input("courseName");
        $content = input('param.content');
        $downloadAddress = input('param.downloadAddress');

        if (!$id) {
            // 模型的 静态方法
            $user = Resource::where('id',$id)
                ->update([
                'name' => $name,
                'type' => $type,
                'title' => $title,
                'courseName' => $courseName,
                'content' => $content,
                'downloadAddress' => $downloadAddress,
            ]);

            return $this->success('恭喜您更改资源成功^_^', 'show');
        }
    }
    public function index(){



        // DB写法
        // $show = Db::name('data')->where('id','>',0)->order('id', 'desc')->paginate(10,80);

        // dump($show);
        // 模型写法
//        $show = Shop::where('id','>',0)->order('sort', 'desc')->paginate(5,30);
//
//		// $show = $show->toArray();
//
//        // dump($show);
//        // exit();
//		$this->assign('show', $show);
//		// 渲染模板输出
        if(Session::has('user'))
        {
            $user=Session::get("user");
            if ($user['chmod'] >=3)
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
    public function update(){
        $id=input("param.id");
        if (!$id) {
            return "资源不存在";
        }
        // 取出主键为1的数据
        $list = Resource::all($id);
        $this->assign('user',$list);
        // 渲染模板输出
        return $this->fetch();
    }
    public function show(){

        // 模型写法
        $show = Resource::where('id','>',0)->paginate(5);
		$this->assign('show', $show);
		// 渲染模板输出

        return $this->fetch();
		

    }
    public function upload(){
    // 获取表单上传文件 例如上传了001.jpg
    $file = request()->file('image');
    
    // 移动到框架应用根目录/public/uploads/ 目录下
    if($file){
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
        if($info){
            // 成功上传后 获取上传信息
            // 输出 jpg
            echo $info->getExtension();
            // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
            echo $info->getSaveName();
            // 输出 42a79759f284b767dfcb2a0197904287.jpg
            echo $info->getFilename(); 
        }else{
            // 上传失败获取错误信息
            echo $file->getError();
        }
    }
}
    public function header(){
 
 
        $this->assign('show', "header");
        // 渲染模板输出
        return $this->fetch();
        

    }
    public function footer(){
 
 
        // 渲染模板输出
        return $this->fetch();
        

    }
    public function add(){

        $name   = input('param.name');
        $title   = input('param.title');
        $type   = input('param.type');
        $courseName =input("courseName");
        $content = input('param.content');
        $downloadAddress = input('param.downloadAddress');


        $lesson  = "";
        //dump($title);

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

       return $this->fetch();
    }

    public function del(){



        //echo input('param.id');

        $id  = input('id');



        if ($id<>'') {


        // 或者直接调用静态方法
        Resource::destroy($id);

        }
        return $this->success('删除成功^_^','show');

    }

    public function ajax(){

    	 
    	return $this->fetch();
    	

    }
}
 