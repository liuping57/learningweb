<?php
/**
 * Created by PhpStorm.
 * User: wsqer
 * Date: 2018/4/10
 * Time: 18:45
 */

namespace app\user\validata;


class Test extends BaseValidate
{
    protected $rule=[
        'title'=>'require|max:100',
        'a'=>'require|max:50',
        'b'=>'require|max:50',
        'c'=>'require|max:50',
        'd'=>'require|max:50',
        'result'=>'require|number'
    ];
}