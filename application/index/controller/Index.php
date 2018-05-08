<?php
namespace app\index\controller;
use think\Db;
use app\index\model\Resource;
use think\Controller;

class Index extends Controller
{
    public function index()
    {
        return '<html>
                    <head>  
                        <meta http-equiv="refresh" content="0;url=index/">   
                    </head> 
                    <body bgcolor="#5f9ea0">
                    </body>
                </html>';
    }
    //资源中心的展示页
    public function show(){

        // DB写法
        // $show = Db::name('data')->where('id','>',0)->order('id', 'desc')->paginate(10,80);

        // dump($show);
        // 模型写法
        $show = Resource::where('id','>',0)->order('id', 'asc')->paginate(10);

        // $show = $show->toArray();

        // dump($show);
        // exit();
        $this->assign('show', $show);
        // 渲染模板输出

        return $this->fetch();


    }
    //资源中心的展示详情页
    public function view(){



        //echo input('param.id');

        $id  = input('id');

        if ($id<>'') {


            // 查询数据 - 查询留言详情内容
            $list = Db::name('Resource')
                ->where('id','=', $id )
                ->select();
            //dump($list);
            //查询数据--查询资源下载地址
//        $address=Db::name('Resource')
//         ->where('id','=',$id)
//         ->select('downloadAddress');

            // 查询数据 - 上一页
            //echo $id;
            $up = Db::name('Resource')
                ->where('id','>', $id )
                ->order('id', '')
                ->limit(1)
                ->value('id');
            //dump($up);

            // 查询数据 - 下一页
            $next = Db::name('Resource')
                ->where('id','<', $id )
                ->order('id', 'desc')
                ->limit(1)
                ->value('id');

            //dump($next);

            $this->assign('up',$up);
            $this->assign('next',$next);
//        $this->assign('address',$address);
            $this->assign('list',$list);


            // 渲染模板输出
            return $this->fetch();


        }
        return $this->fetch('no');
        return "资源不存在";

    }
    //资源中心的增加
    public function add(){


        $title   = input('param.title');
        $type = input('param.type');
        $courseName = input('param.courseName');



        if ($title<>'') {


            // 插入记录 - 去掉表前缀
            // $result = Db::name('data')
            // ->insert(['title' => $title, 'content' => $content, 'create_time' => time()]);
            //dump($result);

            // 模型的 静态方法
            $user = Resource::create([
                'title'   =>  $title,
                'type' =>  $type,
                'courseName'=>$courseName
            ]);



            return $this->success('恭喜您发布课程成功^_^','index/show');

        }

        return $this->fetch();
    }

    //资源中心的搜索
    //资源中心的搜索
    public function search()
    {
        $search=input('search/s');
        $db= Resource::where('name|title','=',$search)->select();
        $show  =  Resource::where('courseName|name|title','like','%'.$search.'%')->paginate(10);
        if (!sizeof($show))
        {
            return $this->fetch('error');
        }
        $this->assign('show', $show);
        $this->assign('date', date('Ymdhis'));
        // 渲染模板输出
        return $this->fetch();
    }
}
