<?php

namespace app\admin\validate;
use think\Validate;

class  User extends Validate{
//    规则
    protected $rule=[
        ['username','require|username|unique:users','用户名为必填项|用户名以字母开头,长度在3-20之间,只能包含字母、数字和下划线|用户名已存在'],
        ['password','require|password','密码为必填项|密码以字母开头，长度在5-18之间，只能包含字母、数字和下划线'],
        ['date_of_birth','require|date','生日为必填项|日期格式不正确'],
        ['phone','phone','手机号格式不正确'],
        ['email','email'],
    ];
//    自定义正则
     protected $regex = [
        'password'=>'^[a-zA-Z]\w{4,17}$',
        'phone'    => '/^1[34578]\d{9}$/',
        'username'=>'^[a-zA-Z][a-zA-Z0-9_]{2,19}$'
     ];

//    场景设置
    protected  $scene=[
        'add'=>['username','password','date_of_birth','phone','email'],//添加
    ];
}

