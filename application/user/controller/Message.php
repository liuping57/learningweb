<?php
/**
 * Created by PhpStorm.
 * User: wsqer
 * Date: 2018/4/21
 * Time: 15:54
 */

namespace app\user\controller;


use app\exception\NoLogin;
use think\Request;
use think\Session;

class Message
{
    public function getmsg()
    {
        if(Session::has('user'))
        {
            $user=Session::get("user");
            $msg=\app\user\model\Message::all([
                'user_id'=>$user['user_id']
            ]);
            return json($msg);
        }
        else
        {
            throw new NoLogin();
        }
    }
    public function delmsg()
    {
        if(Session::has('user'))
        {
            $user=Session::get("user");
            $id=Request::instance()->post('id');
            $msg=\app\user\model\Message::destroy([
                'user_id'=>$user['user_id'],
                'id'=>$id
            ]);
            return json([
                'linecode'=>200,
                'msg'=>'删除成功！'
            ]);
        }
        else
        {
            throw new NoLogin();
        }
    }
}