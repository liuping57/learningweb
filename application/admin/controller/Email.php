<?php
/**
 * Created by PhpStorm.
 * User: wsqer
 * Date: 2018/4/11
 * Time: 10:26
 */

namespace app\admin\controller;

use app\admin\model\sendmail;
use think\Controller;
use think\Request;

class Email extends Controller
{
    public function editmailinfo()
    {
        if (Request::instance()->has('port'))
        {
            $updateInfo=new sendmail();
            $updateInfo->save([
                'smtpADD'=>Request::instance()->post('smtpadd'),
                'emailadd'=>Request::instance()->post('emailadd'),
                'passwd'=>Request::instance()->post('passwd'),
                'SMTPSecure'=>Request::instance()->post('secure'),
                'port'=>Request::instance()->post('port'),
                'FormName'=>Request::instance()->post('formname'),
                'web_url'=>Request::instance()->post('web_url')
            ],[
                'id'=>1
            ]);
            echo '<script>alert("更新成功");</script>';
        }
        $mail=sendmail::all();
        $this->assign('mailinfo',$mail);
        return $this->fetch();
    }
    public function sendTest()
    {
        return $this->fetch();
    }
    public function sendMessage()
    {
        return $this->fetch();
    }
    public function editModel()
    {
        return $this->fetch();
    }
}