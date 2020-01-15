<?php
namespace app\shop\controller;
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
                    $role_oath2[$k]['url'] = url('shop/'.$v['url']);
                }
            }
            $auth  = model('set')->find();
            $auth['name'] = '小豆丁代理端';
        }
       // echo '<pre>';
       // print_r($role_auth);
       //  print_r($role_oath1);
         // print_r($role_auth);
        // foreach ($role_oath2 as $k => $v) {
        // }
        $role_oath1['0']['url'] = 'main2';
        $array = array($role_oath1[0]);
        $this->assign('auth',$auth);
        $this->assign('roleid',Session::get('MMS.user.roleid'));
        $this->assign('type',Session::get('MMS.type'));
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
                'url' => url('shop/Index/main'),
            ),
        );
        $breadhtml = $this->getBread($bread);
        $this->assign('breadhtml', $breadhtml);

        $type = Session::get('MMS.type');//子后台登录帐号类型（1：商家 2：员工）
        if($type == 1){
            $aid=Session::get('MMS.uid');
            $id=Db::name('shop')->where(['aid'=>$aid])->value('shop_id');//商家ID
        }else{
            $id = Session::get('MMS.uid');//员工ID
        }
        $this->assign('type',$type);

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

        if($type == 1){
            //员工分布
            $mvip = Db::name('user');//M('Vip')
            $vipMap['type'] = 2;
            $vipMap['shop_id'] = $id;
            $viptotal = $mvip->where($vipMap)->count();
            $viplist= $mvip->where($vipMap)->field('user_id')->select();
            $user_id = implode(',',$viplist);
            $vipsub = Db::name('device')->where(['shop_id'=>$id,'user_id'=>['in',$user_id]])->group('user_id')->count();//$mvip->where('subscribe=1')->count();
            $vipdissub = $viptotal - $vipsub;
            
        }else{
            //补货记录分布
            $mvip = Db::name('device_order');
            $vipMap['staff_type'] = 1;
            $vipMap['staff_id']   = $id;
            $viptotal = $mvip->where($vipMap)->count();//总补货数量
            $vipMap['status'] = 3;
            $vipsub = $mvip->where($vipMap)->count();//已确认补货的数量
            $vipdissub = $viptotal - $vipsub;
        }
        //新数据
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
        $this->assign('viptotal', $viptotal);
        $this->assign('vipsub', $vipsub);
        $this->assign('vipdissub', $vipdissub);
        $this->assign('newvipToday', $newvipToday);
        $this->assign('newvipYesterday', $newvipYesterday);
        $this->assign('newviprate', $newviprate);
        $this->assign('newviptotalrate', $newviptotalrate);
        //dump($mapToday);
        
        //订单分布
        if($type=1){
            $orderMap['shop_id']= $id;
        }else{
            $device    = Db::name('device')->where(['user_id'=>$id])->field('device_id')->select();//获取员工所管理的设备ID
            $device_id = implode(',',$device);//把设备ID分割成字符串
            $orderMap['device_id'] = ['in',$device_id];
        }
        $morder = Db::name('order');
        $ordertotal = $morder->where($orderMap)->count();
        $this->assign('ordertotal', $ordertotal);
        for ($i = 1; $i <= 4; $i++) {
            $name = 'order' . $i;
            $num = $morder->where($orderMap)->where('status=' . $i)->count();
            $this->assign($name, $num);
        }
        //订单
        $neworderToday = $morder->where($orderMap)->where($mapToday)->count();
        $neworderYesterday = $morder->where($orderMap)->where($mapYesterday)->count();
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
        if($type == 1){
            $myjMap['shop_id'] = $id;
        }else{
            $myjMap['user_id'] = $id;
        }
        $yjtotal = $myj->where($myjMap)->count();
        //今日设备
        $yjToday = $myj->where($myjMap)->where($mapToday)->count();
        $yjYesterday = $myj->where($myjMap)->where($mapYesterday)->count();
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

//        if($type ==1){
//            //已绑定
//            $fx1 = $myj->where('user_id != 0')->where($myjMap)->count();
//            //未绑定
//            $fx2 = $myj->where('user_id = 0')->where($myjMap)->count();
//
//        }else{
//            //正常
//            $fx1 = $myj->where('status = 0')->where($myjMap)->count();
//            //异常
//            $fx2 = $myj->where('status = 1')->where($myjMap)->count();
//        }
        $fx1 = $myj->where('status = 0')->where($myjMap)->count();
        //异常
        $fx2 = $myj->where('status = 1')->where($myjMap)->count();
        $this->assign('fx1', $fx1);
        $this->assign('fx2', $fx2);
       
        
        //订单日志
        if($type=1){
            $orderMapO['a.shop_id']= $id;
        }else{
            $device    = Db::name('device')->where(['user_id'=>$id])->field('device_id')->select();//获取员工所管理的设备ID
            $device_id = implode(',',$device);//把设备ID分割成字符串
            $orderMapO['device_id'] = ['in',$device_id];
        }
        $viplog = Db::name('order')->alias('a')
                  ->join('dlc_user b','b.user_id=a.user_id','left')
                  ->where($orderMapO)
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
        if($type == 1){
            $orderlMap['a.shop_id'] = $id;
            $orderlMap['a.type']         = 1;
        }else{
            $device    = Db::name('device')->where(['user_id'=>$id])->field('device_id')->select();//获取员工所管理的设备ID
            $device_id = implode(',',$device);//把设备ID分割成字符串
            $ordeMap['device_id'] = ['in',$device_id];
            $order = Db::name('order')->where($ordeMap)->field('order_number')->select();
            $order_id = implode(',',$order);
            $orderlMap['a.order_number'] = ['in',$order_number];
            $orderlMap['a.type']         = 1;
        }
        $orderlog = Db::name('cash_log')->alias('a')
                  ->join('dlc_user b','b.user_id=a.user_id','left')
                  ->where($orderlMap)
                  ->field('a.*,b.username,b.head_img,b.sex')
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
        $fxlog = Db::name('device_order')->limit(5)->where($orderMap)->order('ctime desc')->select();
        foreach ($fxlog as $k => $v) {
            $fxlog[$k]['num'] = Db::name('device_orderinfo')->where('order_id',$v['order_id'])->sum('num');
        }
        $this->assign('fxlog', $fxlog);

        //设备异常消息日志
        if($type == 1){
            $device = Db::name('device')->where(['shop_id'=>$id])->field('macno')->select();
            $device_id = implode(',',$device);
            $tjMap['macno'] = ['in',$device_id];
        }else{
            $device = Db::name('device')->where(['user_id'=>$id])->field('macno')->select();
            $device_id = implode(',',$device);
            $tjMap['macno'] = ['in',$device_id];
        }
        $tjlog = Db::name('device_fault')->limit(5)->where($tjMap)->order('ctime desc')->select();
        $this->assign('tjlog', $tjlog);

        $zxsMap['status'] = 3;
        if($type == 1){
            $zxsMap['shop_id'] = $id;
            $deviMap['shop_id'] = $id;
            //总销售额
            $zxse = Db::name('order')->where($zxsMap)->sum('total_price')?: 0;
            //总成交额
            $zcje =  Db::name('order')->where($zxsMap)->sum('pay_price')?: 0;
            //总销量
            $zxl = Db::name('order')->where($zxsMap)->sum('num')?: 0;
            //总员工
            $ztx = Db::name('user')->where(array('type' => 2,'shop_id'=>$id))->count();
        }else{
            $deviMap['user_id'] = $id;
        }
        //总设备
        $zyj = Db::name('device')->where($deviMap)->count();
       
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
        // $a = "300833B2DDD9014000000049,300833B2DDD9014000000086,300833B2DDD901400C040085,300833B2DDD9014000000058,300833B2DDD9014000000096,300833B2DDD9120400000000,300833B2DDD901406ACD0068,300833B2DDD9001100000000,300833B2DDD9120100000000,300833B2DDD9014000000110,300833B2DDD9014000000126,300833B2DDD901400000A249,300833B2DDD9014000000055,300833B2DDD9001700000000,300833B2DDD9014000000037,300833B2DDD9014000000121,300833B2DDD9014000000128";
        // $b = explode(',',$a);
        // var_dump(count($b));
		//设置面包导航，主加载器请配置
        $bread = array(
            '0' => array(
                'name' => '修改密码',
                'url' => url('shop/Index/modifypass'),
            ),
        );
		$this->assign('breadhtml', $this->getBread($bread)); 
		//处理POST提交
		$data = input('post.');
        if ($data) {
            if (!is_string($data['password'])){
                $info['status'] = 0;
                $info['msg'] = '请输入正确数据！';
                return($info);
            }
            $data['password'] = md5($data['password']);
            switch ($data['type']) {
                case '1':
                    $re = Db::name('admin')->where('id='.$data['id'])->update(['password'=>$data['password']]);
                    break;
                case '2':
                    $re = Db::name('user')->where('user_id='.$data['id'])->update(['userpass'=>$data['password']]);
                    break;
                default:
                    $info['status'] = 0;
                    $info['msg'] = '登录帐号类型不对';
                    return($info);
                    break;
            }
            if (FALSE !== $re) {
                $info['status'] = 1;
                $info['msg'] = '设置成功！';
            } else {
                $info['status'] = 0;
                $info['msg'] = '设置失败！';
            }
           return($info);
        }
		echo ($this->fetch('modifypass'));
	}
}
