<?php
/**
 * Created by PhpStorm.
 * User: wsqer
 * Date: 2018/4/7
 * Time: 17:24
 */

namespace app\user\validata;


class Adddetail extends BaseValidate
{
protected $rule=[
    'title'=>'require|chsDash|max:40',
    'url'=>'require|url',
    'rank'=>'require|number|max:4',
    'chapters_id'=>'require|number|max:11'
];
}