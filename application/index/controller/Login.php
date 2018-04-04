<?php
namespace app\index\controller;
use think\Controller;
class Login extends  Controller{
    /**
     * 登录
     * @return type
     */
    public function index(){
        if(request()->isPost()){
            //获取相关的数据
            $data = input('post.');
            // 判断用户名是否存在
            $ret = model('User')->get(['username'=>$data['username']]);
//            var_dump($ret);exit;
            if(!$ret || $ret->status !=1 ) {
                $this->error('该用户不存在');
            }
            if($ret->password !=$data['password']) {
                $this->error('密码不正确');
            }
             //更新最后登陆时间
            model('User')->updateById(['login_time'=>time()], $ret->user_id);
//            // 保存用户信息 
            session('userInfo', $ret, 'index');
            
            if($ret->is_admin){
                //管理员界面
                return $this->success('管理员登录成功', url('admin/index/index'));
            }else{
                //用户界面
                return $this->success('用户登录成功', url('user/index/index'));
            }
            
        }else{
            // 一登网址先看有没有session
            $Info = session('userInfo', '', 'index');
            //判断身份
            if($Info && $Info->is_admin=='1') {
                return $this->redirect(url('admin/index/index'));
            }else if($Info && $Info->is_admin=='0'){
                return $this->redirect(url('user/index/index'));
            }
            //没有session的话,再到登录页面
            return $this->fetch();
        }
    }
    /**
     * 退出用户
     * @return type
     */
    public function logout(){
        //清除session
        session(null,'index');
        return $this->redirect('index/login/index');
    }
}

