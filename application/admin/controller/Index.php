<?php
namespace app\admin\controller;
use think\Controller;
class Index extends  Controller
{
    public function index()
    {
        $userInfo = session('userInfo', '', 'index');
        
        if($userInfo&&$userInfo['is_admin']=='1'){
            //如果有session,并且判定是管理员
            return $this->fetch('',[
                'username'=>$userInfo['username'],
            ]);
        }else{
            session(null,'index');
            return $this->error("账户未登录,即将返回","index/login/index");
        }
        
    }
    public function welcome(){
        return "欢迎来到管理员后台";
    }
}
