<?php
namespace app\user\controller;
use think\Cache;
use think\Controller;
class Personal extends Controller{
    /**
     * 显示个人信息
     * @return type
     */
    public function myInfo(){
        //获取用户id
        $myInfo = session('userInfo', '', 'index');
        if(empty($myInfo['user_id'])||intval($myInfo['user_id'])<1){
            return $this->error('ID错误');
        }
        //获取最新数据
        $user=model('user')->get($myInfo['user_id']);
        return $this->fetch('',[
            'myInfo'=>$user,
        ]);
    }
    /**
     * 保存提交表单    到修改个人信息
     * @return type
     */
    public function save(){
        /**
         * 做下严格判定
         */
        if(!request()->isPost()){
            $this->error('请求失败');
        }
        //获取表单数据
        $data=input('post.');
        //tp5验证
        $validate=validate('User');
        if(!$validate->scene('add')->check($data)){
            $this->error($validate->getError());
        }
//        var_dump($data);exit;
        //user_id有值，说明要更新
        if(!empty($data['user_id'])){
            return $this->update($data);
        }
    }
    /**
        * 修改个人信息
        * @param type $data
        */
        public function update($data){
             //根据生日 计算出虚岁
             $data['age']=date("Y")-explode('-',$data['date_of_birth'])[0]+1;
              //tp5验证 至少1虚岁
            if($data['age']<2){
                $this->error('出生日期不合法');
            }
          //model类的save方法的第二个参数为更新条件
            $res=model('user')->save($data,['user_id'=>intval($data['user_id'])]);
            if($res){
                $this->success('更新成功');
            }else{
                $this->error('更新失败');
            }
        }
}

