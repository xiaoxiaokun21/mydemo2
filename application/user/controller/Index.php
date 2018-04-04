<?php
namespace app\user\controller;
use think\Controller;
class Index extends Controller
{
    public function index()
    {
        $userInfo = session('userInfo', '', 'index');
        if($userInfo&&$userInfo['is_admin']=='0'){
            return $this->fetch('',[
                'username'=>$userInfo['username'],
            ]); 
        }else{
             session(null,'index');
             return $this->error("用户未登录",'index/login/index');
        }
        
    }
    public function welcome(){
        return "欢迎来到用户中心";
    }
}
