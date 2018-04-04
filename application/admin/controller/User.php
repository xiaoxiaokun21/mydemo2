<?php
namespace app\admin\controller;
use think\Controller;
class User extends  Controller
{
    /** @var type  模型 */
    public $obj;
    /**
     * 初始化模型
     */
    public function _initialize(){
        $this->obj=model('User');
    }
    /**
     * 显示用户列表
     * @param type $status
     * @return type
     */
    public function userList($status)
    {
        $res= $this->obj->getUsersByStatus($status);
        return $this->fetch('',[
            'users'=>$res[0],
            'users_num'=>$res[1],
            'status'=>$status
        ]);
    }
    /**
     * 添加用户
     * @return type
     */
    public function userAdd(){
        return $this->fetch();
    }
    /**
     * 修改用户
     * @param type $user_id
     * @return type
     */
    public function  userEdit($user_id=0){
//        var_dump($user_id);exit;
//        var_dump(input('get.user_id'));exit;
        if(empty($user_id)||intval($user_id)<1){
            return $this->error('ID错误');
        }
        $user=$this->obj->get($user_id);//获取某一条记录，这里条件必须是主键id   
        return $this->fetch('',[
            'user'=>$user
        ]);
   
    }
    /**
     * 用户详情
     * @param type $user_id
     * @return type
     */
    public function userDetails($user_id){
        $userdetails= $this->obj->getUserDetails($user_id);
        return $this->fetch('',[
            'userdetails'=>$userdetails[0],
        ]);
    }
    /**
     * 保存提交表单    新增 或 调用更新方法update
     * @return type
     */
    public function save(){
//        print_r($_POST);
//        print_r(input('post.'));exit;
//        print_r(request()->post());
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
        //入库
        $res=$this->obj->add($data);
        if($res=="birth_error"){
            $this->error('出生日期不合法');
        }else if($res){
            $this->success('新增成功');
        }else{
            $this->error('新增失败');
        }

    }
    /**
     * 更新用户
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
        $res=$this->obj->save($data,['user_id'=>intval($data['user_id'])]);
        if($res){
            $this->success('更新成功');
        }else{
            $this->error('更新失败');
        }
    }
    /**
     *更新用户状态   1.单个更新  2.批量更新
     * @return type
     */
    public function status(){
        //get获取失败，param自动判别
        $data=input('param.');
        //如果有checked参数，说明要选中删除
        if(isset($data['checked'])){
            //字符串转数组
            $checked=explode(',',$data['checked']); 
            //sql拼接
            $sql='update users set status='.-$data['status'].' where';
            foreach ($checked as $value){
                $sql.=' user_id='.$value.' or';
//                $res=$this->obj->where(['user_id'=>$value])->setField('status', -1);
            }
            $sql= rtrim($sql,'or');
            $res=$this->obj->query($sql,[],false,true);
        }else{
            $res=$this->obj->save(['status'=>$data['status']],['user_id'=>$data['user_id']]);
        }
         if($res){
            return $this->success('状态更新成功');
         }else{
            return $this->error('状态更新失败');
         }
    }
    /**
     * 用户图表
     * @return type
     */
    public function userchart(){
        return $this->fetch();
    }
}