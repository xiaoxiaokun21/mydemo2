<?php
namespace app\index\controller;
use think\Controller;
class Register extends  Controller{
    /**
     * 注册
     * @return type
     */
    public function index(){
        if(request()->isPost()){
            //获取相关的数据
            $data = input('post.');
            //tp5验证注册内容
            $validate=validate('User');
            if(!$validate->scene('register')->check($data)){
                $this->error($validate->getError());
            }
            //入库
            $data['create_time']=time();
//            // 自动生成 密码的加盐字符串
//            $data['code'] = mt_rand(100, 10000);
//            //md5加密
//            $data['password']=md5($data['password'] . $data['code']);
            $res=model('user')->insert($data);
            if($res){
                $this->success('注册成功','index/login/index');
            }else{
                $this->error('注册失败');
            }
        }else{
            return $this->fetch();
        }
    }
}

