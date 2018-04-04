<?php
namespace app\common\model;
use think\Db;
use think\Model;
use think\Paginator;
class User extends Model 
{
//    database配置里的auto_timestamp字段同理
//    protected $autoWriteTimestamp=true;
//    protected $createTime = 'create_time';
    protected $table='users';
    /**
     * 获取用户表    
     * status=1  显示正常   status=-1  显示已删除
     * 用户数
     * @param type $status
     * @return type
     */
    public function getUsersByStatus($status){
        $data=[
            'status'=>$status,
        ];
        $order=[
          'user_id'=>'desc',  
        ];
        $users= $this->where($data)->paginate(5);
        $users_num= $users->total();
        $result= array($users,$users_num);
        return $result;
    }
    /**
     * 获取用户表
     * 条件不明确
     * @param array $datas
     * @return type
     */
    public function getUsersByDatas($datas){
        if(empty($datas['startTime'])){
            $datas['startTime']='1970-1-1 00:00:00';
        }
        if(empty($datas['endTime'])){
            $datas['endTime']='2099-1-1 00:00:00';
        }
        //select * from users where create_time>=1562362 and create_time<=1589313 and (username like "%hgk%" or phone="15879082660" or email="807906863@qq.com") and status=1
        //分页传参,原生sql要绑参预处理
        $users= $this->where('create_time>='.strtotime($datas['startTime']).' and create_time<='.strtotime($datas['endTime']).' and status=:status and (username like :searchContent or phone=:phone or email=:email)',['searchContent'=>'%'.$datas['searchContent'].'%','phone'=>$datas['searchContent'],'email'=>$datas['searchContent'],'status'=>$datas['status']])
                     ->paginate(5,false,['query'=>$datas]);
        $users_num= $users->total();
        $result= array($users,$users_num);
        return $result;
    }
    
    /**
     * 查看用户详情
     * @param type $user_id
     * @return type
     */
    public function getUserDetails($user_id){
        $data=[
            'user_id'=>$user_id,
        ];
        $result=$this->where($data)->select();
//        var_dump($result);exit;
        return $result;
    }
    /**
     * 用户新增
     * @param type $data
     * @return string
     */
    public function add($data){
         $data['status']=1;
         $data['create_time']=time();
         //根据生日 计算出虚岁
         $data['age']=date("Y")-explode('-',$data['date_of_birth'])[0]+1;
          //tp5验证 至少1虚岁
        if($data['age']<2){
            return "birth_error";
        }
        $result=$this->insert($data);
        return $result;
    }
    /**
     * 更新最后登录时间
     * @param type $data
     * @param type $id
     * @return type
     */
    public function updateById($data, $id) {
        // allowField 过滤data数组中非数据表中的数据
        return $this->allowField(true)->save($data, ['user_id'=>$id]);
    }
    /**
     * 获取男女比例
     * @return type
     */
    public function getUsersProportion(){
        /*sql语句
         * select sum(case when sex='男' then 1 else 0 end) manNum,sum(case when sex='女' then 1 else 0 end) womanNum,
                round(sum(case when sex='男' then 1 else 0 end)/count(*),2) manPro,round(sum(case when sex='女' then 1 else 0 end)/count(*),2) womanPro,count(*) 总数 from users where status=1
         */
        $rel=Db::query("select sum(case when sex='男' then 1 else 0 end) manNum,sum(case when sex='女' then 1 else 0 end) womanNum,round(sum(case when sex='男' then 1 else 0 end)/count(*),2) manPro,round(sum(case when sex='女' then 1 else 0 end)/count(*),2) womanPro,count(*) num  from users where status=1");
        return $rel;
    }
}
