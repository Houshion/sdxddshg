<?php
namespace app\dlc\controller;

use think\Session;
use think\Db;
class indexController extends BaseController
{
	//CMS总入口
    public function index()
    {
        $role_auth = model('role')->where(array('role_id' => $this->role_id))->value('auth');
        $role_oath1 = model('role_oath')->where("oath_id in (".$role_auth.") and module='Dlc' and parent_id=0")->field("oath_id,name,url,icon")->order(array('order' => 'desc'))->select();
        if($role_oath1) {
            $role_oath2 = model('role_oath')
						->where("oath_id in (".$role_auth.") and module='Dlc' and parent_id<>0 and is_menu=1")
						->field("oath_id,name,url,parent_id")
						->order(array('order' => 'desc'))
						->select();
            if($role_oath2) {
                foreach ($role_oath2 as $k => $v) {
                    $role_oath2[$k]['url'] = url('Dlc/'.$v['url']);
                }
            }
            $auth  = model('set')->find();
        }
        foreach ($role_oath2 as $k => $v) {
        }
        $role_oath1['0']['url'] = 'main2';
        $array = array($role_oath1[0]);
        $this->assign('auth',$auth);
        $this->assign('roleid',Session::get('CMS.user.roleid'));
        $this->assign('main',$array?:array());
        $this->assign('role_oath1',$role_oath1?:array());
        $this->assign('role_oath2',$role_oath2?:array());
		//var_dump(session('CMS.user'));
        return $this->fetch();
    }
	
	
	public function main()
    {
        //设置面包导航，主加载器请配置
        $bread = array(
            '0' => array(
                'name' => '主控面板',
                'url' => url('dlc/Index/main'),
            ),
        );
        $breadhtml = $this->getBread($bread);
        $this->assign('breadhtml', $breadhtml);

        //今日起始
        $beginToday = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        $endToday = mktime(0, 0, 0, date('m'), date('d') + 1, date('Y')) - 1;
        $mapToday['ctime'] = array('between', array($beginToday, $endToday));
        //昨日起始
        $beginYesterday = mktime(0, 0, 0, date('m'), date('d') - 1, date('Y'));
        $endYesterday = mktime(0, 0, 0, date('m'), date('d'), date('Y')) - 1;
        $mapYesterday['ctime'] = array('between', array($beginYesterday, $endYesterday));
        //上周起始
        $beginLastweek = mktime(0, 0, 0, date('m'), date('d') - date('w') + 1 - 7, date('Y'));
        $endLastweek = mktime(23, 59, 59, date('m'), date('d') - date('w') + 7 - 7, date('Y'));
        $mapLastweek['ctime'] = array('between', array($beginLastweek, $endLastweek));
        //本月起始
        $beginThismonth = mktime(0, 0, 0, date('m'), 1, date('Y'));
        $endThismonth = mktime(23, 59, 59, date('m'), date('t'), date('Y'));
        $mapThismonth['ctime'] = array('between', array($beginThismonth, $endThismonth));

        //用户分布
        $mvip = Db::name('user');//M('Vip')
        $viptotal = $mvip->where('type=1')->count();
        $vipsub = $mvip->where("type=1 and mobile != ''")->count();//$mvip->where('subscribe=1')->count();
        $vipdissub = $viptotal - $vipsub;
        $this->assign('viptotal', $viptotal);
        $this->assign('vipsub', $vipsub);
        $this->assign('vipdissub', $vipdissub);
        
        //新会员
        $newvipToday = $mvip->where($mapToday)->count();
        $newvipYesterday = $mvip->where($mapYesterday)->count();
        //环比
        if ($newvipYesterday) {
            $newviprate = intval(($newvipToday - $newvipYesterday) / $newvipYesterday * 100);
        } else {
            $newviprate = $newvipToday * 100;
        }
        //总共
        if ($viptotal) {
            $newviptotalrate = intval($newvipToday / $viptotal * 100);
        } else {
            $newviptotalrate = $newvipToday * 100;
        }

        $this->assign('newvipToday', $newvipToday);
        $this->assign('newvipYesterday', $newvipYesterday);
        $this->assign('newviprate', $newviprate);
        $this->assign('newviptotalrate', $newviptotalrate);
        //dump($mapToday);
        
        //订单分布
        $morder = Db::name('order');
        $ordertotal = $morder->count();
        $this->assign('ordertotal', $ordertotal);
        for ($i = 1; $i <= 4; $i++) {
            $name = 'order' . $i;
            $num = $morder->where('status=' . $i)->count();
            $this->assign($name, $num);
        }
        //订单
        $neworderToday = $morder->where($mapToday)->count();
        $neworderYesterday = $morder->where($mapYesterday)->count();
        //环比
        if ($neworderYesterday) {
            $neworderrate = intval(($neworderToday - $neworderYesterday) / $neworderYesterday * 100);
        } else {
            $neworderrate = $neworderToday * 100;
        }
        //总共
        if ($ordertotal) {
            $newordertotalrate = intval($neworderToday / $ordertotal * 100);
        } else {
            $newordertotalrate = $neworderToday * 100;
        }

        $this->assign('neworderToday', $neworderToday);
        $this->assign('neworderYesterday', $neworderYesterday);
        $this->assign('neworderrate', $neworderrate);
        $this->assign('newordertotalrate', $newordertotalrate);


        //设备分布
        $myj = Db::name('device');
        $yjtotal = $myj->count();
        //今日设备
        $yjToday = $myj->where($mapToday)->count();
        $yjYesterday = $myj->where($mapYesterday)->count();
        //环比
        if ($yjYesterday) {
            $yjrate = intval(($yjToday - $yjYesterday) / $yjYesterday * 100);
        } else {
            $yjrate = $yjToday * 100;
        }
        //总共
        if ($yjtotal) {
            $yjtotalrate = intval($yjToday / $yjtotal * 100);
        } else {
            $yjtotalrate = $yjToday * 100;
        }

        $this->assign('yjtotal', $yjtotal);
        $this->assign('yjToday', $yjToday);
        $this->assign('yjYesterday', $yjYesterday);
        $this->assign('yjrate', $yjrate);
        $this->assign('yjtotalrate', $yjtotalrate);

        //已绑定
        $fx1 = $myj->where('status= 0')->count();
        //异常
        $fx2 = $myj->where('status = 1')->count();
        //未绑定
//        $fx3 = $myj->where('user_id = 0')->count();
        $this->assign('fx1', $fx1);
        $this->assign('fx2', $fx2);
//        $this->assign('fx3', $fx3);
        
        //订单日志
        $viplog = Db::name('order')->alias('a')
                  ->join('dlc_user b','b.user_id=a.user_id','left')
                  ->where(['a.status'=>3])->limit(5)->order('a.ctime desc')
                  ->field('a.*,b.username,b.head_img,b.sex')
                  ->select();
        foreach ($viplog as $k => $v) {
            if (strpos($v['head_img'] ,"http")!==false){
                $viplog[$k]['head_img'] = $v['head_img'];
            }else{
                $viplog[$k]['head_img'] = 'http://'.$_SERVER['HTTP_HOST'].'/public' . $v['head_img'];
            }
        }
        // echo '<pre>';
        // print_r($viplog);
        $this->assign('order', $viplog);

        //订单支付日志
        $orderlog = Db::name('cash_log')->alias('a')
                  ->join('dlc_user b','b.user_id=a.user_id','left')
                   ->field('a.*,b.username,b.head_img,b.sex,b.mobile')
                  ->limit(5)->order('ctime desc')->select();
        foreach ($viplog as $k => $v) {
            if (strpos($v['head_img'] ,"http")!==false){
                $viplog[$k]['head_img'] = $v['head_img'];
            }else{
                $viplog[$k]['head_img'] = 'http://'.$_SERVER['HTTP_HOST'].'/public' . $v['head_img'];
            }
        }
        $this->assign('orderlog', $orderlog);


        //设备补货日志
        $fxlog = Db::name('device_order')->limit(5)->order('ctime desc')->select();
        foreach ($fxlog as $k => $v) {
            $fxlog[$k]['num'] = Db::name('device_orderinfo')->where('order_id',$v['order_id'])->sum('num');
        }
        $this->assign('fxlog', $fxlog);

        //设备异常消息日志
        $tjlog = Db::name('device_fault')->limit(5)->order('ctime desc')->select();
        // foreach ($tjlog as $k => $v) {
        //     $goods  = M('goods')->where('goods_id='.$v['goods_id'].'')->find();
        //     $tjlog[$k]['title'] = $goods['title']; 
        // }
        $this->assign('tjlog', $tjlog);


        //总销售额
        $zxse = Db::name('order')->where('status=3')->sum('total_price');
        //总成交额
        $zcje =  Db::name('order')->where('status=3')->sum('pay_price');
        //总销量
        $zxl = 0;
        $zxl = Db::name('order')->where('status=3')->sum('num')?: 0;
        //总设备
        $zyj = Db::name('device')->count();
        //总员工
        $ztx = Db::name('user')->where(array('type' => 2))->count();
        $this->assign('zxse', $zxse);
        $this->assign('zcje', $zcje);
        $this->assign('zxl', $zxl);
        $this->assign('zyj', $zyj);
        $this->assign('ztx', $ztx);
        // //计算系统运行时间
        // $datetime1 = date_create('2015-1-25');
        // $datetime2 = date_create(date('Y-m-d', time()));
        // $interval = date_diff($datetime1, $datetime2);
        // $remaindays = $interval->format('%a');
        // $this->assign('remaindays', $remaindays);
        // $this->display();
		echo $this->fetch();
	}


    //CMS后台图片浏览器
    public function appImgviewer()
    {
        $ids = input('ids');
        $type = input('type')?:0; 
        if($type) {
            $imgs = [];
            if(strpos($ids,",")) {
                $imgs = explode(",",$ids);
            } else {
                $imgs = [$ids];
            }
            $cache = $imgs;
        } else {
            $m = Db::name('upload');
            $map['id'] = array('in',parse_str($ids));
            $cache = $m->where($map)->select();

        }
        //dump($ids);
        $this->assign('type',$type);
        $this->assign('cache', $cache);
        return($this->fetch('appImgviewer'));
    }
	
	
	//修改用户密码
	public function modifypass(){
		//设置面包导航，主加载器请配置
        $bread = array(
            '0' => array(
                'name' => '修改密码',
                'url' => url('dlc/Index/modifypass'),
            ),
        );
		$this->assign('breadhtml', $this->getBread($bread));
		//处理POST提交
		$data = I('post.');
        if ($data) {
            if (!is_string($data['password'])){
                $info['status'] = 0;
                $info['msg'] = '请输入正确数据！';
                $this->ajaxReturn($info);
            }
            $data['password'] = md5($data['password']);
            $re = $m->where('id='.$data['id'])->update($data);
            if (FALSE !== $re) {
                $info['status'] = 1;
                $info['msg'] = '设置成功！';
            } else {
                $info['status'] = 0;
                $info['msg'] = '设置失败！';
            }
            $this->ajaxReturn($info);
        }
		echo ($this->fetch('modifypass'));
	}
}
