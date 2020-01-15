<?php

namespace app\dlc\controller;
use think\Db;

class AdminController extends BaseController
{
    //主页
    public function index(){
        return view();
    }
	
	/**
     * 后台管理员、角色添加
	 * @return [none] [description]
     */
	public function adminEdit(){
		$bread = array(
            '0' => array(
                'name' => '菜单设置',
                'url' => url('Dlc/role/authDetail')
            ),
            '1' => array(
                'name' => '菜单列表',
                'url' => url('Dlc/role/roleList')
            ),
            '2' => array(
                'name' => '帐号编辑',
                'url' => url('Dlc/admin/adminEdit')
            )
        );
        $this->assign('breadhtml', $this->getBread($bread));
		$id = input('id');
		$roleid = input('role_id');
		$m = model('admin');
        if(request()->isPost()){
			$data = input('post.');
            if (!$data['roleid']){
                $info['status'] = 0;
                $info['msg'] = '请选择类型！';
            }
            if (!empty($id)) {
                $re = $m->where('id',$id)->update($data);
                if (FALSE !== $re) {
                    $info['status'] = 1;
                    $info['msg'] = '设置成功！';
                } else {
                    $info['status'] = 0;
                    $info['msg'] = '设置失败1！';
                }
            } else {
                $data['ctime'] = time();
                $data['password'] = md5($data['password']);
                $re = $m->insert($data);
                if (FALSE !== $re) {
                    $info['status'] = 1;
                    $info['msg'] = '设置成功！';
                } else {
                    $info['status'] = 0;
                    $info['msg'] = '设置失败！';
                }
            }
            return($info);
		}
		if (!empty($id)){
            $cache = $m->where('id = ' . $id)->find();
			$this->assign('cache', $cache);
        }
        $where['role_id']=['<>',1];
        $list = model('role')->where($where)->select();
        $this->assign('list', $list);
        $this->assign('role_id',$roleid);
		echo $this->fetch('admin_adminEdit');
	}
	
	
	/**
     * 后台管理员列表
	 * @return [none] [description]
    */
    public function adminList(){
        $bread = array(
            '0' => array(
                'name' => '菜单设置',
                'url' => url('Dlc/role/authDetail')
            ),
            '1' => array(
                'name' => '管理员列表',
                'url' => url('Dlc/admin/adminList')
            )
        );
        $p = input('page')?:1;
		$psize = input('psize')?:10;
        $this->assign('breadhtml', $this->getBread($bread));
//        $list = model('role')->where('role_id = 1')->select();
//		$count = model('role')->where('role_id = 1')->count();
//		$this->getPage($count, $psize, 'App-loader', '管理员列表', 'App-search');
//        foreach ($list as $k => $v) {
//            $oath = model('role_oath')->where(array('oath_id'=>array('in',$v['auth']),'parent_id'=>0))->column('name');
//            $str = implode('、',$oath);
//            $list[$k]['auth'] = rtrim($str,"、");
//            $list[$k]['count'] = model('admin')->where('roleid='.$v['role_id'])->count();
//        }
        $list = Db::name('admin')->page($p,$psize)->select();
//        foreach ($list as $k => $v){
//            $list[$k]['ctime'] = date('Y-m-d H:i:s',$v['ctime']);
//        }
        $count = model('admin')->count();
        $a = model('admin')->column('ctime');
        $this->getPage($count, $psize, 'App-loader', '管理员列表', 'App-search');
        $this->assign('list',$list);
		echo $this->fetch('admin_adminList');
    }

    public function roleDel(){
        $role_id = input('role_id');
        if(!$role_id){
            $info['status'] = 0;
            $info['msg'] = '缺少id参数！';
            return($info);
        }
        $find = Db::name('device')->where(['shop_id'=>$role_id])->find();
        if($find){
            $info['status'] = 0;
            $info['msg'] = '该商家下有关联的设备请先解绑设备关联！';
            return($info);
        }
        $staff_user = model('user')->where(['shop_id'=>$role_id,'type'=>2])->find();
        if($staff_user){
            $info['status'] = 0;
            $info['msg'] = '该商家下有关联员工信息,请先解除绑定在删除！';
            return($info);
        }
        $re = model('admin')->where(['id'=>['in',$role_id]])->delete();
        if($re !== false){
            $info['status'] = 1;
            $info['msg'] = '删除成功！';
            return($info);
        }else{
            $info['status'] = 0;
            $info['msg'] = '删除失败！';
            return($info);
        }
    }
}