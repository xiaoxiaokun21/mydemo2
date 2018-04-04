<?php

namespace app\user\validate;
use think\Validate;

class  Passenger extends Validate{
    /** @var type 规则 */
    protected $rule=[  
        //unique后面是表名,不是字段
        ['name','require|name','姓名为必填项|姓名为2-8位中文'],
        ['id_card','require|id_card','证件号为必填项|证件号格式不正确'],
        ['phone','require|phone','手机号为必填项|手机号格式不正确'],
        ['email','require|email','邮箱为必填项|邮箱格式不正确'],
    ];
    /** @var type 自定义正则 */
     protected $regex = [
         //身份证
        'id_card'  => '(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)',
         //匹配中文  正常情况下匹配中文是这样写的\u4e00-\u9fa5，php不兼容，改为\x{4e00}-\x{9fa5}并且最后要加u
         'name'    => '/^[\x{4e00}-\x{9fa5}]{2,8}$/u',
         'phone'   => '/^1[34578]\d{9}$/'
     ];

     /** @var type 场景设置 */
    protected  $scene=[
        //添加
        'add'=>['name','id_card','phone','email'],
    ];
}

