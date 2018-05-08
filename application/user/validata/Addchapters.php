<?php
/**
 * Created by PhpStorm.
 * User: wsqer
 * Date: 2018/4/6
 * Time: 17:42
 */

namespace app\user\validata;


class Addchapters extends BaseValidate
{
    protected $rule=[
        'chapters_name'=>'require|chsDash|max:40',
        'chapters_rank'=>'require|number|max:4',
        'course_id'=>'require|number|max:11'
    ];
}