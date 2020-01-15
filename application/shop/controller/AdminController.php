<?php

namespace app\shop\controller;
use think\Db;
use think\Session;
class AdminController extends BaseController
{
    public $id;
    public $type;
    public function _initialize()
    {
        $this->type = Session::get('MMS.type');//子后台登录帐号类型（1：商家 2：员工） 
        if($this->type == 1){
            $aid=Session::get('MMS.uid');
            $this->id=Db::name('shop')->where(['aid'=>$aid])->value('shop_id');//商家ID
        }else{
            $this->id = Session::get('MMS.uid');//员工ID
        }
        $this->assign('type',$this->type);
    }
    //主页
    public function index(){
        return view();
    }
	
	/**
     * 账号信息编辑
	 * @return [none] [description]
     */
	public function adminEdit(){
		$bread = array(
            '0' => array(
                'name' => '菜单设置',
                'url' => url('shop/role/authDetail')
            ),
            '1' => array(
                'name' => '菜单列表',
                'url' => url('shop/role/roleList')
            ),
            '2' => array(
                'name' => '帐号编辑',
                'url' => url('shop/admin/adminEdit')
            )
        );
        $this->assign('breadhtml', $this->getBread($bread));
		$id = input('id');
        if(request()->isPost()){
            $data=input('post.');
            if($this->type==1){
                $dataArr=[
                    'nickname'=>$data['nickname'],
                    'user_phone'=>$data['mobile']
                ];
                $result=Db::name('shop')->where('shop_id',$id)->update($dataArr);
            }else{
                $dataArr=[
                    'nickname'=>$data['nickname'],
                    'mobile'=>$data['mobile']
                ];
                $result=Db::name('user')->where('user_id',$id)->update($dataArr);
            }
           if($result){
                $info['status']=1;
                $info['msg']='编辑成功';
           }else{
               $info['status']=0;
               $info['msg']='编辑失败';
           }
           return($info);
		}
		if($this->type==1){
            $result=Db::name('shop')->field('shop_id as id,nickname,user_name,user_phone')->where('shop_id',$this->id)->find();
        }else{
            $result=Db::name('user')->field('user_id as id,nickname,username,user_phone')->where('user_id',$this->id)->find();
        }
        $this->assign('result',$result);
		echo $this->fetch('admin_adminEdit');
	}
	
	
	/**
     * 后台管理员列表
	 * @return [none] [description]
    */
    public function adminList()
    {
        $bread = array(
            '0' => array(
                'name' => '菜单设备',
                'url' => url('shop/Admin/adminList'),
            ),
            '1' => array(
                'name' => '管理员信息',
                'url' => url('shop/Admin/adminList'),
            ),
        );
        if($this->type == 1){//商家信息
            $map['shop_id']=$this->id;
            $result = Db::name('shop')->alias('a')
                ->join('admin b', 'b.id=a.aid', 'left')
                ->where($map)->field('a.*,b.username,b.nickname,b.mobile,b.id')->find();
            $result['pay_price']=db('order')->where(['shop_id'=>$this->id,'status'=>3,'pay_style'=>1])->sum('pay_price')?:0;
        }else{//员工信息
            $map['user_id'] = $this->id;
            $result = Db::name('user')->where($map)->find();
        }
        $this->assign('result', $result);
        $this->assign('breadhtml', $this->getBread($bread));
        echo $this->fetch('adminList');
        $this->assign('type',$this->type);
    }
}