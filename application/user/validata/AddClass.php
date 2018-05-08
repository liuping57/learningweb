<?php
/**
 * Created by PhpStorm.
 * User: wsqer
 * Date: 2018/4/6
 * Time: 16:12
 */

namespace app\user\validata;


class AddClass extends BaseValidate
{
    protected $rule=[
        'course_name'=>'require|max:40',
        'course_hours'=>'require|number|max:4',
        'difficulty'=>'require|number|between:1,100',
        'author'=>'require|chsDash|max:20',
        'course_type'=>'require|number|max:4',
        'course_info'=>'require|max:255'
    ];
}