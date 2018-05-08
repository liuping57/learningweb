<?php
/**
 * Created by PhpStorm.
 * User: wsq
 * Date: 2018/3/23
 * Time: 13:26
 */

namespace app\user\model;

use think\validate;
use think\Request;
use think\Session;

class FileUpload
{
    public static function upload()
    {
        $base64_img = trim(Request::instance()->post('file'));
        $up_dir = 'static/images/userimg/';//路径

        if(!file_exists($up_dir)){
            mkdir($up_dir,0777);
        }

        if(preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_img, $result)){
            $type = $result[2];
            if(in_array($type,array('pjpeg','jpeg','jpg','gif','bmp','png'))){
                $new_file = $up_dir.date('YmdHis_').'.'.$type;
                if(file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64_img)))){
                    $img_path = str_replace('../../..', '', $new_file);
                    $userdata=new User_info();
                    $user=Session::get("user");
                    $userdata->save([
                        'headimg'=>$img_path
                    ],['user_id'=>$user['user_id']]);
                    return ['linecode'=> 200, 'file'=>$img_path,'msg'=>'上传成功'];
                }else{
                    return ['linecode'=>102,'msg'=>'图片上传失败了'];

                }
            }else{
                //文件类型错误
                return ['linecode'=>103,'msg'=>'图片上传类型错误'];
            }

        }else{
            //文件错误
            return ['linecode'=>103,'msg'=>'文件错误'];
        }
    }
    public static function bannerupload()
    {
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('images');
        $banner_id=request()->post('banner_id');
        // 移动到框架应用根目录
        $info = $file->validate(['ext'=>'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'static'.DS.'images'.DS.'banner',$banner_id);
        if($info){
            // 成功上传后 获取上传信息
            // 输出 jpg
            $filename= $info->getFilename();
            $banner =new Banner();
            $banner->save([
                'img_url'=>'static/images/banner/'.$filename
            ],['banner_id'=>$banner_id]);
            return "上传成功！";
        }else{
            // 上传失败获取错误信息
            return $file->getError();
        }

    }
    public static function classimg()
    {
        $base64_img = trim(Request::instance()->post('files'));
        $up_dir = 'static/images/classimg/';//路径

        if(!file_exists($up_dir)){
            mkdir($up_dir,0777);
        }

        if(preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_img, $result)){
            $type = $result[2];
            if(in_array($type,array('pjpeg','jpeg','jpg','gif','bmp','png'))){
                $new_file = $up_dir.date('YmdHis_').'.'.$type;
                if(file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64_img)))){
                    $img_path = str_replace('../../..', '', $new_file);
                    $userdata=new Course();
                    $user=Session::get("user");
                    $course_id=Request::instance()->post('course_id');
                    $userdata->save([
                        'img_url'=>$img_path
                    ],['course_id'=>$course_id]);
                    return ['linecode'=> 200, 'file'=>$img_path,'msg'=>'上传成功'];
                }else{
                    return ['linecode'=>102,'msg'=>'图片上传失败了'];

                }
            }else{
                //文件类型错误
                return ['linecode'=>103,'msg'=>'图片上传类型错误'];
            }

        }else{
            //文件错误
            return ['linecode'=>103,'msg'=>'文件错误'];
        }
    }
}