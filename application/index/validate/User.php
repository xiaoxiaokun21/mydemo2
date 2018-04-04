<?php

namespace app\index\validate;
use think\Validate;

class  User extends Validate{
//    规则
    protected $rule=[
        ['username','require|username|unique:users','用户名为必填项|用户名以字母开头,允许3-20字节,只能包含字母数字下划线|用户名已存在'],
        ['password','require|password','密码为必填项|密码以字母开头，长度在5-18之间，只能包含字母、数字和下划线'],
    ];
//    自定义正则
     protected $regex = [
         'username'=>'^[a-zA-Z][a-zA-Z0-9_]{2,19}$',
         'password'=>'^[a-zA-Z]\w{4,17}$',
     ];

//    场景设置
    protected  $scene=[
        'register'=>['username','password'],//添加
    ];
}

