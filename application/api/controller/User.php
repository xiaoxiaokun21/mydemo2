<?php
namespace app\api\controller;
use think\Controller;
use think\Request;
class User extends Controller
{
    public $obj;
    public  function _initialize(){
        $this->obj=model('user');
    }
    public function getUsersProportion(){  
        //获取男女用户比例
        $rel=$this->obj->getUsersProportion();
        if(!$rel){
            return show(0,'error');
        }
        return show(1,'success',$rel);
    }
}