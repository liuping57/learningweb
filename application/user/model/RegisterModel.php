<?php
/**
 * Created by PhpStorm.
 * User: wsq
 * Date: 2017/11/7
 * Time: 15:23
 */

namespace app\user\model;


use app\exception\PasswdError;
use app\exception\RegistErr;
use app\exception\RegistSuccess;
use app\exception\ValicodeErr;
use think\Db;
use think\Request;
use think\Response;
use think\Session;

class RegisterModel
{
    public static function regist()
    {
        //获取表单数据
        $userid=Request::instance()->post('user_id');
        $username=Request::instance()->post( 'user_name');
        $pwd1=Request::instance()->post('pwd1');
        $pwd2=Request::instance()->post('pwd2');
        $email=Request::instance()->post('email');
        $valicode=Request::instance()->post('valicode');
        if ($valicode==Session::pull("valicode"))
        {
            if ($pwd1==$pwd2)
            {
                $querydata=Db::query("select * from user_info WHERE  user_id='$userid' OR email='$email'");
                if ($querydata)
                {
                    throw new RegistErr();
                }
                else
                {
                    $pwd=md5($pwd2);
                    $subrand=self::sunstrval(20);
                    Db::execute("insert into user_login 
                                      (user_id,user_name,user_pwd,valiemail)
                                      VALUES
                                       ('$userid','$username','$pwd','$subrand')");
                    Db::execute("insert into user_info (user_id,user_name,email)
                                      VALUES 
                                      ('$userid','$username','$email')");
                    (new MailModel())->send($email,"请确认注册信息！","<H1>欢迎注册</H1>请点击下面的链接完成注册：<a href='http://dc.wsqer.cn/index.php?s=/emailvali&subrand=$subrand'>确认加入我们</a><p>如果不是您的操作请忽略此邮件");
                }

            }
            else
            {
                throw new PasswdError();
            }
        }
        else
        {
            throw new ValicodeErr();
        }
    }
    public static function checkemail()
    {
        $subrand=Request::instance()->get("subrand");
            $info=Db::execute("update user_login set chmod=1 WHERE  valiemail='$subrand' AND chmod=0");
            if ($info)
            {
                return true;
            }
            else
            {
                return false;
            }

    }
        public static function sunstrval( $length = 16 )
        {
            // 密码字符集，可任意添加你需要的字符
            $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            $password = "";
            for ( $i = 0; $i < $length; $i++ )
            {
                // 这里提供两种字符获取方式
                // 第一种是使用 substr 截取$chars中的任意一位字符；
                // 第二种是取字符数组 $chars 的任意元素
                // $password .= substr($chars, mt_rand(0, strlen($chars) – 1), 1);
                $password .= $chars[ mt_rand(0, strlen($chars) - 1) ];
            }
            return $password;
        }

}