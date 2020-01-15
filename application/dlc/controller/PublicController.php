<?php
namespace app\dlc\controller;

use think\Controller;
use think\Db;
use think\Request;
use think\View;
use think\Session;

class PublicController extends Controller
{
	protected static $SYS; //系统级全局静态变量
    protected static $CMS; //CMS全局静态变量
    protected static $SHOP; //Shop变量全局设置
	//默认跳转至登陆页面
    public function index()
    {
        $this->redirect('Public/login');
    }

    //通用注册页面
    public function reg()
    {
        $this->display();
    }

    //通用登陆页面
    public function login()
    {
        if (request()->isPost()) {
            $data = input('post.');
            $verify = new \verify\verify();
            if (!$verify->check($data['verify'])) {
                $this->error('请正确填写验证码！');
            }
            $user = Db::name('admin')
				->where('username', $data['username'])
				->where('password', md5($data['userpass']))
				->where('status',1)
                ->where('type',1)
				->find();
            if (!empty($user)) {
                    if(!empty($user['roleid'])){
						self::$CMS['uid'] = Session::set('CMS.uid',$user['id']);
						self::$CMS['user'] = Session::set('CMS.user',$user);
						self::$CMS['user'] = Session::set('CMS.user.nickname',$user['nickname']);
						self::$CMS['homeurl'] = Session::set('CMS.homeurl',url('dlc/index/index'));
						self::$CMS['backurl'] = Session::set('CMS.backurl',FALSE);
                    }else{
                        $this->error('您没有权限，请联系管理员分配！');
                    }

            } else {
                $this->error('用户不存在，或密码错误！');
            }
        }
        if (Session::has('CMS.uid')) {
            $this->redirect('dlc/index/index');
        }
        $arr = array(4, 5, 7, 7, 7, 10, 11, 12);
        $get = $arr[mt_rand(0, count($arr) - 1)];
        $wallpaper =  "/public/static/dlc/WallPage/" . $get . ".jpg";
        $this->assign('wallpaper', $wallpaper);
		return $this->fetch();
    }

    public function logout()
    {
		Session::clear();
        $this->redirect('dlc/public/login');
    }

    //通用验证码
    public function verify()
    {
		$Verify = new \verify\verify();
        $Verify->codeSet = '0123456789';
        $Verify->length = 4;
        $Verify->imageH = 0;
        $Verify->entry();
    }

    //百度地图
    public function baiduDitu()
    {
        $map['address'] = input('address');
        $map['lng'] = input('lng');
        $map['lat'] = input('lat');
        $this->assign('map', $map);
        return($this->fetch('baiduDitu'));
    }

   public function update_password(){
  	 $id = input('id');
  	 if($_POST) {
  	 	$old_password = input("old_password");
  	 	$password = input("password");
  	 	$password2 = input("password2");
  	 	if($password!=$password2)
  	 	{
  	 		  		$info['status'] = 0;
                    $info['msg'] = '密码和密码确认不一致！';
                    return($info);
  	 	}
  	 	 $user = Db::name('admin')
				->where('id',$this ->uid)
				->where('password', md5($old_password))
				->where('status',1)
				->find();
            if (!empty($user)) {
            	$user["password"]=md5($password);
				 $res=$user = Db::name('admin')
				->where('id',$this ->uid)
				->update($user);
  	 		  		$info['status'] = 1;
                    $info['msg'] = '修改成功';
                    return($info);
            } else {
  	 		  		$info['status'] = 0;
                    $info['msg'] = '原密码错误！修改失败';
                    return($info);
            }
  
  	 }
  	  echo $this->fetch();
  }

  
}