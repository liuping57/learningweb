<?php
/**
 * Created by PhpStorm.
 * User: wsqer
 * Date: 2018/3/25
 * Time: 10:25
 */

namespace app\user\validata;


class valnumber extends BaseValidate
{
    protected $rule=[
        'course_id'=>'number'
    ];
}