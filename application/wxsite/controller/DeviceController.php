<?php
namespace app\wxsite\controller;
/** 
 * 马远利
 */

use \think\Loader;
use \think\Db;
use \think\Model;

use app\apk\controller\IndexController; 

    class DeviceController extends BaseController
{
    public $appUrl;
    public $user_id;
    public function _initialize()
    {
        // $this->appUrl = request()->root(true);
        $this->appUrl = 'http://'.$_SERVER['HTTP_HOST'].'/';
    }

    /**
     *接口入口需要token
     */
    public function api($params = array())
    {
        $api_name =$api_name = input('api_name') ? : $params['api_name'];
        $this->user_id = $this->get_user_id();
        if ($api_name) {
            switch ($api_name) {
				 case 'checkDoor':
                    $this->checkDoor();        //检查设备门的状态
                    break;
                case 'staffLogin':
                    $this->staffLogin();       //员工登录
                    break;
                case 'getDevice':
                    $this->getDevice();        //获取员工设备列表
                    break;
                case 'deviceGoods':
                    $this->deviceGoods();      //获取设备商品列表 
                    break;
                case 'retrievalDoor':
                    $this->retrievalDoor();    //补货开门
                    break;
                case 'closeGoods':
                    $this->closeGoods();       //补货关门之后的商品列表
                    break;
                case 'verifyRetrieval':
                    $this->verifyRetrieval();  //确认补货
                    break;
                case 'removeGoods':
                    $this->removeGoods();      //清除商品
                    break;
                case 'removeGoodsNotify':
                    $this->removeGoodsNotify($params);      //清除商品
                    break;
                case 'addFault':
                    $this->addFault();         //添加设备故障
                    break;
                case 'closeDoor':
                    $this->closeDoor($params);        //补货关门
                    break;
                case 'retrievalUnusual':
                    $this->retrievalUnusual(); //补货异常
                    break;
				case 'userDoor':
                    $this->userDoor();         //用户购物关门
                    break;
                case 'staffReplenish':
                    $this->staffReplenish();         //员工补货记录
                    break;

                default:
                    $info['code'] = 404;
                    $info['msg'] = '接口不存在';
                    return $info;
                    break;

            }
        }else{
            $info['code'] = 404;
            $info['msg'] = '接口不能为空';
            $info['data'] = $api_name;
            return $info;
        }
    }
        /**
         *接口入口
         */
        public function api_apk($params = array())
        {
            $api_name =$api_name = input('api_name') ? : $params['api_name'];

            if ($api_name) {
                switch ($api_name) {
                    case 'addFault':
                        $this->addFault();         //添加设备故障
                        break;
                    case 'closeDoor':
                        $this->closeDoor($params);        //补货关门
                        break;
                    case 'retrievalUnusual':
                        $this->retrievalUnusual(); //补货异常
                        break;
                    case 'userDoor':
                        $this->userDoor();         //用户购物关门
                        break;

                    default:
                        $info['code'] = 404;
                        $info['msg'] = '接口不存在';
                        return $info;
                        break;

                }
            }else{
                $info['code'] = 404;
                $info['msg'] = '接口不能为空';
                $info['data'] = $api_name;
                return $info;
            }
        }
	protected function checkDoor(){
		$macno = input('macno');
		$this->_return(1,'登录成功',$macno);
	}
	
	
	public function testSocket($content){
		$staff_id = input('user_id');
		$url = 'http://adm.hbfyun.com/message/sendmessage';
		$data['data'] = $content;
		$data['udid']  = "sdxddshg_1";
		$json = json_encode($data);
		$new_data['data'] = $json;
		$re = $this->postCurl($url,$new_data);
		var_dump($re);
	}
	
    /**
     * 员工登录
     * @param  int      $mobile   | 手机号
     * @param  string   $pass     | 密码
     * @return array 
     */
    public function staffLogin()
    {
        $mobile = input('mobile');
        $pass   = input('pass');
        if(empty($mobile)) $this->_return(-1,'帐号不能为空',(object)array());
        if(empty($pass)) $this->_return(-1,'密码不能为空',(object)array());
        $user = Db::name('user')->where(['mobile'=>$mobile])->field('user_id,mobile,userpass,type')->find();
        if(empty($user)) $this->_return(-1,'帐号有误',(object)array());
        if($user['userpass'] != md5($pass)) $this->_return(-1,'密码有误',(object)array());
        if($user['type'] != 2) $this->_return(-1,'此帐号不是员工',(object)array());
        $this->_return(1,'登录成功',$user);
    }


    /**
     * 获取员工设备列表
     * @param  int     $page            | 分页，默认为 1
     * @param  int     $pagesize        | 每页条数，默认为10
     * @param  int     $user_id         | 员工ID
     * @return array 
     */
    public function getDevice()
    {
        $page     = input('page') ? : 1;
        $pagesize = input('pagesize') ? : 10;
//        $shop_id = input('shop_id');
        if(empty($this->user_id)) $this->_return(10001,'补货员ID不能为空',(object)array());
//        $user     = $this->get_staff_info($staff_id);
        $shop_id=db('user')->where('user_id',$this->user_id)->value('shop_id');
        $list = Db::name('device')->alias('a')
                  ->join('dlc_device_goods c','c.device_id=a.device_id','left')
                  ->join('dlc_network b','b.network_id = a.network_id','left')
                  ->field(['a.device_id','a.status','a.htime','a.macno','b.address','sum(c.inventory) as inventory' ])
                  ->where(['a.shop_id'=>['in',$shop_id]])
                  ->page($page,$pagesize)
                  ->order('a.ctime desc')->select();
       $warn_inventory= db('shop')->where('shop_id',$shop_id)->value('warn_inventory');
        foreach ($list as $k=>$v){
            if($warn_inventory){
                if($v['inventory']<$warn_inventory){
                    $list[$k]['status_name']='缺货';
                }else{
                    $list[$k]['status_name']='';
                }
            }else{
                $list[$k]['status_name']='';
            }
            $ntime = time();
            if($v['status']==1){
                if($ntime - $v["htime"]<60){
                    $list[$k]['line']="在线";
                }else{
                    $list[$k]['line']= "离线";
                }
            }else{
                 $list[$k]['line']= "异常";
            }



        }
        $this->_return(1,'获取成功',$list);
    }

    /**
     * 获取设备商品列表
     * @param  string  $macno           | 设备编号
     * @param  int     $user_id         | 员工ID
     * @param  int     $page            | 分页，默认为 1
     * @param  int     $pagesize        | 每页条数，默认为10
     * @return 
     */
    public function deviceGoods()
    {
        $page     = input('page') ? : 1;
        $pagesize = input('pagesize') ? : 10;
        $macno    = input('macno');
//        $staff_id = input('user_id');
//        $token = input('token');

//        $token = input('token');
//        $staff_id= $this->decodeToken($token);
//        $user  = $this->get_staff_info($staff_id);

        if(empty($macno)) $this->_return(-1,'设备编号不能为空',(object)array());
        if(empty($this->user_id)) $this->_return(10001,'补货员ID不能为空',(object)array());
        $device = Db::name('device')->where(['macno'=>$macno])->find();
        if(empty($device)) $this->_return(-1,'此设备不存在',(object)array());
//        if(empty($token)) $this->_return(-401,'token不能为空',(object)array());
//        //查看当前补货员是否有未确认的补货订单
//       $find= db('user')->where('token',$token)->find();
//       if(empty($find)){
//           $this->_return(-401,'未登入',(object)array());
//       }

        $find= db('device_order')->where(array('device_id'=>$device['device_id'],'staff_id'=>$this->user_id,'status'=>['in',[1,2]]))->find();
        if($find){
            $data1['order_number']=$find['order_number'];
            $this->_return(1000,'获取成功',$data1);
        }


        $network = Db::name('network')->where(['network_id'=>$device['network_id']])->find();
        $list = Db::name('device_goods')->alias('a')
                ->join('dlc_goods b','b.goods_id=a.goods_id','left')
                ->field('a.device_goods_id,a.inventory,b.title,b.img')
                ->where(['device_id'=>$device['device_id'],'inventory'=>['neq',0]])
                ->order('a.inventory asc')
                ->page($page,$pagesize)
                ->select();
        $data['device_id'] = $device['device_id'];
        $data['macno']     = $macno;
        $data['address']   = $network['address'];
        $data['goods']     = $list;
        $ntime = time();
        if($device['status']==1){
            if($ntime - $device["htime"]<60){
                $data['line']="在线";
            }else{
                $data['line']= "离线";
            }
        }else{
            $data['line']= "异常";
        }


        $inventory=0;
        $warn_inventory= db('shop')->where('shop_id',$device['shop_id'])->value('warn_inventory');
        if(empty($list)) $this->_return(1,'获取成功',$data);
        foreach ($list as $key => $value) {
            $list[$key]['img'] = $this->appUrl.'public/'.$value['img'];
            $inventory += $value['inventory'];
        }

        if($warn_inventory){
            if($inventory<$warn_inventory){
                $data['status_name']='缺货';
            }else{
                $data['status_name']='';
            }
        }else{
            $data['status_name']='';
        }


        $data['goods'] = $list;
        $this->_return(1,'获取成功',$data);
    }

     /**
     * 补货开门
     * @param  string  $macno           | 设备编号
     * @param  int     $type            | 开门类型（1：员工 2：商家）
     * @param  int     user_id          | 员工id
     * @return 
     */
    public function retrievalDoor()
    {
        write_log('retrievalDoor','补货开门开始！！！！');
        $pay_type = 1;
        $macno = input('macno');
        $type  = input('type');

        if(empty($macno)) $this->_return(-1,'设备编号不能为空',(object)array());
        if(empty($type)) $this->_return(-1,'开门类型不能为空',(object)array());
//        if(empty($user_id)) $this->_return(-1,'员工ID不能为空',(object)array());
//        if(empty($token)) $this->_return(-401,'token不能为空',(object)array());
//        $find= db('user')->where('token',$token)->find();
        if(empty($this->user_id)){
            $this->_return(-401,'未登入',(object)array());
        }
        if($type == 1){      //员工开门
            $pay_type = 1;
            $this->get_staff_info($this->user_id);
            $data2['type']=1;
        }elseif($type == 2){ //商家开门
            $pay_type = 3;
            $this->get_shop_info($this->user_id);
            $data2['type']=3;

        }else{
            $this->_return(-1,'开门类型不对',(object)array());
        }
        //检查设备是否存在

        $device = Db::name('device')->where(['macno'=>$macno])->find();
        if(empty($device)) $this->_return(-1,'设备不存在',(object)array());
        if ($device['htime']+60<time())$this->_return(-1,'设备不在线',(object)array());
        if($device['status'] == 1) $this->_return(-1,'设备异常，请先检测！',(object)array());
        if($device['doorstatus'] === 1 && $device['open_status'] === 1) $this->_return(-1,'设备还未关门，请先关门！',(object)array());

        //先检查用户是否有未支付的订单
        /*$orderMap['status']    = ['in',1,2];             //订单状态
        $orderMap['device_id'] = $device['device_id'];  //设备ID
        $order = Db::name('order')->where($orderMap)->order('ctime desc')->find();
        if(!empty($order)){
            _return(-1,'还有人在购买商品，请稍后再补货！',(object)array());
        }*/
        //查看是否有为确认的补货订单
        //先检查是否有不是当前员工补货的未完成的订单,
        $checkMap['status']   = ['in',1,2];             //补货状态（1：开门中 2：未确认 3：已确认）
        $checkMap['staff_id'] = ['neq',$this->user_id];       //补货员工ID
        $checkMap['device_id']= $device['device_id'];   //设备ID
        $checkOrder = Db::name('device_order')->where($checkMap)->order('ctime desc')->find();
        if(!empty($checkOrder)) $this->_return(-1,'有员工正在补货',(object)array());

        $checkMap1['status']   =['in',1,2];            //补货状态（1：开门中 2：未确认 3：已确认）
        $checkMap1['staff_id'] =$this->user_id;       //补货员工ID
        $checkMap1['device_id']= $device['device_id'];   //设备ID
        $check1Order = Db::name('device_order')->where($checkMap1)->order('ctime desc')->find();
        if(!empty($check1Order)){
            $data1['order_number']=$check1Order['order_number'];
            $this->_return(1000,'获取成功',$data1);
        }



        //检查员工是否有开门中的订单
        $openMap['staff_id']  = $this->user_id;              //用户ID
        $openMap['status']    = 1;                     //订单状态
        $openMap['device_id'] = $device['device_id'];  //设备ID
        $openOrder = Db::name('device_order')->where($openMap)->order('ctime desc')->find();
        if($openOrder){
            write_log('retrievalDoor','检查员工有开门中的订单未补货的，修改订单号');
            $data['order_number'] = 'B'.date('Ymd',time()).mt_rand(1000,9999);      //补货订单编号
            $data['ctime']        = time();                                         //创建时间
            $result = Db::name('device_order')->where($openMap)->update($data);
        }else{
            $data['order_number'] = 'B'.date('Ymd',time()).mt_rand(1000,9999);      //补货订单编号
            $data['ctime']        = time();                                         //创建时间
            $data['device_id']    = $device['device_id'];                           //设备ID
            $data['shop_id']      = $device['shop_id'];                             //所属商家ID
            $data['staff_id']     = $this->user_id;                                       //补货员工ID
            $data['staff_type']   = $type;                                          //补货员工类型（1：员工补货 2：商家补货）
            $data['status']       = 1;                                              //补货状态（1：开门中 2：未确认 3：已确认）
            $data['open_time']    = time();                                              //
            $result = Db::name('device_order')->insert($data);

            $data2['user_id']=$this->user_id;
            $data2['shop_id']=$device['shop_id'];
            $data2['device_id']=$device['device_id'];
            $data2['network_id']   = $device['network_id'];
            $data2['ctime']=time();

            db('device_open_log')->insert($data2);
            write_log('retrievalDoor','检查员工没有有开门中的订单未补货的，新增订单号');
        }
        if($result !== false){
            $mqtt = new IndexController();
            //设备开门条件
            $post['macno']         = $macno;                //设备编号
            $post['order_number']  = $data['order_number']; //订单编号
            $post['type']          = 2;                     //补货
            $post['sign']          = md5('yzsell');
            //开门日志信息
//            $arr['user_id']    = $user_id;              //补货员ID
//            $arr['network_id'] = $device['network_id']; //网点ID
//            $arr['shop_id']    = $device['shop_id'];    //商家ID
//            $arr['device_id']  = $device['device_id'];  //柜子ID
//            $arr['type']       = $pay_type;             //开门类型（1：员工 2：用户 3：商家）
//
////			$json = '{"doorOpen":"manager"}';
////			$client_id = time();
////			$mqtt->publish($macno,$json,0,$client_id);
//
//            $res =$this->set_device($macno,2,$data['order_number']);
//
//            $reslist= json_decode(json_decode($res,true),true);
//
//            if($reslist['code']!=1){
//                $this->_return(-1,'设备不在线',$reslist);
//            }
            $json = '{"doorOpen":"manager"}';
            $client_id = time();
            $res= $mqtt->publish($macno,$json,0,$client_id);
            write_log('retrievalDoor','请求开门中---设备号---'.$macno.'-----订单编号----'.$data['order_number'].'---返回--'.$res);
			$this->_return(1,'请求开门中',['macno'=>$macno,'order_number'=>$data['order_number']]);
//            $newDoor->openDoor($post,1,$arr);
        }else{
            $this->_return(-1,'补货订单生成失败',(object)array());
        }     
    }


     /**
     * 补货关门后的商品列表
     * @param  string  $macno           | 设备编号
     * @param  string  $order_number    | 补货编号
     * @param  int     $type            | 查看类型（1：员工 2：商家）
     * @param  int     user_id          | 员工id
     * @param  int     $page            | 分页，默认为 1
     * @param  int     $pagesize        | 每页条数，默认为10
     * @return 
     */
    public function closeGoods()
    {
        $page         = input('page') ? : 1;
        $pagesize     = input('pagesize') ? : 10;
        $macno        = input('macno');
        $order_number = input('order_number');
        $type         = input('type');
//        $user_id      = input('user_id');
//        $token      = input('token');
        if(empty($macno)) $this->_return(-1,'设备编号不能为空',(object)array());
        if(empty($type)) $this->_return(-1,'查看类型不能为空',(object)array());
        if(empty($order_number)) $this->_return(-1,'补货编号不能为空',(object)array());
//        if(empty($user_id)) $this->_return(-1,'员工id不能为空',(object)array());
//        if(empty($token)) $this->_return(-401,'token不能为空',(object)array());
//        $find= db('user')->where('token',$token)->find();
        if(empty($this->user_id)){
            $this->_return(-401,'未登入',(object)array());
        }
        if($type == 1){//员工开门
            $pay_type = 1;
            $this->get_staff_info($this->user_id);
        }elseif($type == 2){//商家开门
            $pay_type = 3;
            $this->get_shop_info($this->user_id);
        }else{
            $this->_return(-1,'查看类型不对');
        }
        //检查设备是否存在
        $device = Db::name('device')->where(['macno'=>$macno])->find();
        if(empty($device)) $this->_return(-1,'设备不存在',(object)array());
        if($device['status'] == 1)  $this->_return(-1,'设备异常，请先检测！',(object)array());
        if($device['doorstatus'] === 1 && $device['open_status'] === 1) _return(-1,'设备还未关门，请先关门！',(object)array());

        //获取设备对应的网点信息
        $network = $this->getNetworkInfo($device['network_id']);

        //检查是否有未确认补货订单
        $deviceMap['order_number'] = $order_number;
        $deviceMap['status']       = 2;
        $deviceMap['staff_id']     = $this->user_id;
        $deviceOrder = Db::name('device_order')->where($deviceMap)->find();
        $data['order_number'] = $order_number;
        $data['type']         = $type;
        $data['macno']        = $macno;
        $data['address']      = $network['address'];
        $data['goods']        = [];

        if(empty($deviceOrder)) $this->_return(1,'获取成功',$data);
        $list = Db::name('device_orderinfo')->alias('a')
                ->where(['order_id'=>$deviceOrder['order_id']])
                ->join('dlc_goods b','b.goods_id=a.goods_id','left')
                ->field('a.num,b.title,b.img')
                ->select();
        foreach ($list as $key => $value) {

            $list[$key]['img'] = $this->appUrl.'public/'.$value['img'];

        }

        $data['goods'] = $list;
        $this->_return(1,'获取成功',$data);
    }

     /**
     * 确认补货
     * @param  string  $macno           | 设备编号
     * @param  string  $order_number    | 补货编号
     * @param  int     $type            | 开门类型（1：员工 2：商家）
     * @param  int     user_id          | 员工id
     * @return 
     */
    public function verifyRetrieval()
    {

        $macno        = input('macno');
        $order_number = input('order_number');
        $type         = input('type');
//        $user_id      = input('user_id');
//        $token      = input('token');
        if(empty($macno)) $this->_return(-1,'设备编号不能为空',(object)array());
        if(empty($type)) $this->_return(-1,'查看类型不能为空',(object)array());
        if(empty($order_number)) $this->_return(-1,'补货编号不能为空',(object)array());
//        if(empty($user_id)) $this->_return(-1,'员工ID不能为空',(object)array());
//        if(empty($token)) $this->_return(-401,'token不能为空',(object)array());
//        $find= db('user')->where('token',$token)->find();
        if(empty($this->user_id)){
            $this->_return(-401,'未登入',(object)array());
        }
        if($type == 1){//员工开门
            $pay_type = 1;
            $this->get_staff_info($this->user_id);
        }elseif($type == 2){//商家开门
            $pay_type = 3;
            $this->get_shop_info($this->user_id);
        }else{
            $this->_return(-1,'查看类型不对');
        }
        //检查设备是否存在
        $device = Db::name('device')->where(['macno'=>$macno])->find();
        if(empty($device)) $this->_return(-1,'设备不存在',(object)array());
        if($device['status'] == 1)  _return(-1,'设备异常，请先检测！',(object)array());
        if($device['doorstatus'] === 1 && $device['open_status'] === 1) _return(-1,'设备还未关门，请先关门！',(object)array());
        $deviceMap['order_number'] = $order_number;
        $deviceMap['status']       = 1;
        $deviceMap['staff_id']     = $this->user_id;
        $deviceOrder = Db::name('device_order')->where($deviceMap)->find();
        if($deviceOrder) {
            Db::name('device_order')->where($deviceMap)->update(array('status'=>-1));
            $this->_return(1,'补货已完成，没有补进商品！');
        }
        //检查是否有未确认补货订单
        $deviceMap['order_number'] = $order_number;
        $deviceMap['status']       = 2;
        $deviceMap['staff_id']     = $this->user_id;
        $deviceOrder = Db::name('device_order')->where($deviceMap)->find();
        if(empty($deviceOrder))  $this->_return(-1,'没有这个补货订单');
        //检查是否有开门中补货订单

		//$deviceOrderInfo = Db::name('device_orderinfo')->where(['order_id'=>$deviceOrder['order_id']])->select();
        $deviceOrderInfo = json_decode($deviceOrder['new_rfid'], true);
		
		//清空原来的商品//修改rfid的状态
		$rfidWhere = [
				'status' => 2,
				'device_id' => $device['device_id'],
		];
		Db::name('rfid')->where($rfidWhere)->update(['status' => 1]);
		Db::name('device_goods')->where(['device_id'=>$device['device_id']])->update(array('rfid' => '', 'inventory' => 0));

        if(!$deviceOrderInfo){//如果没有补进商品的话就订单状态改为3
            Db::name('device_order')->where($deviceMap)->update(['status'=>3]);
            $this->_return(1,'补货已完成，没有补进商品！');
        }
        write_log('affirm',"确认补货 设备：".$macno." 补货订单".json_encode($deviceOrder));
        //Db::startTrans();//开启事务
        //try{
            foreach ($deviceOrderInfo as $key => $value) {
                //新增一条补货操作日志表
                $goodsLog['order_id']  = $deviceOrder['order_id'];    //订单ID
                $goodsLog['device_id'] = $device['device_id'];  //设备ID
                $goodsLog['goods_id']  = $key;    //商品ID
                $goodsLog['shop_id']   = $deviceOrder['shop_id'];     //商家ID
                $goodsLog['num']       = $value['num'];         //补货数量
                $goodsLog['rfid']      = $value['rfid'];        //商品rfid
                $goodsLog['ctime']     = time();            
                Db::name('device_goodslog')->insert($goodsLog);
//                $find=db('rfid')->where(['rfid'=>['in',$value['rfid']]])->find();
//                if($find['status']==3){
//                  $info_order_id= db('device_orderinfo')->where(['rfid'=>['in',$value['rfid']]])->value('order_id');
//                    db('order')->where('order_id',$info_order_id)->update(['is_red'=>2]);
//                }
                //修改rfid的状态
                $rfid['device_id'] = $device['device_id'];//设备ID
                $rfid['shop_id']   = $deviceOrder['shop_id'];   //商品ID
                $rfid['status']    = 2;
                $rfidWhere = "find_in_set(rfid, '".$value['rfid']."')>0";
                Db::name('rfid')->where($rfidWhere)->update($rfid);

                //获取商品信息
                $goods = Db::name('goods')->where(['goods_id'=>$key])->find();
                //新增或修改设备的rfid
                $deviceGoods = Db::name('device_goods')->where(['device_id'=>$device['device_id'],'goods_id'=>$key])->find();
                if(!empty($deviceGoods)){
//					$addGoods = array();
////                    $addGoods['rfid']      = $value['rfid'];
////                    $addGoods['inventory'] = $value['num'];
//                    if($deviceGoods['goods_id']==$key){
//                        $addGoods['rfid']      = $value['rfid'].','.$deviceGoods['rfid'];
//                        $addGoods['inventory'] = $value['num']+$deviceGoods['inventory'];
//                    }else{
//                        $addGoods['rfid']      = $value['rfid'];
//                        $addGoods['inventory'] = $value['num'];
//                    }
                    $addGoods = array();
                    $addGoods['rfid']      = $value['rfid'];
                    $addGoods['inventory'] = $value['num'];
                    $re1 = Db::name('device_goods')->where(['device_goods_id'=>$deviceGoods['device_goods_id']])->update($addGoods); 					
                    write_log('affirm',"确认补货 设备：".$macno."  rfid:". $value['rfid']." 确认修改SQL：".Db::name('device_goods')->getlastSql());
                }else{
					$addGoods = array();
                    $addGoods['inventory'] = $value['num'];
                    $addGoods['rfid']      = $value['rfid'];
                    $addGoods['device_id'] = $device['device_id'];
                    $addGoods['goods_id']  = $key;
                    $addGoods['price']     = $goods['price'];
                    $addGoods['ctime']     = time();
                    $re1 = Db::name('device_goods')->insert($addGoods);
                    write_log('Retrieval','补货查询数据-addGoods-2-'.json_encode($addGoods,true));
                    write_log('Retrieval','补货查询数据-re1-2-'.json_encode($re1,true));
                    write_log('Retrieval','补货查询数据-sql-2-'. Db::name('device_goods')->where(array('device_goods_id'=>$deviceGoods['device_goods_id']))->fetchSql()->insert($addGoods));
                }
            }
            //修改补货订单状态

            Db::name('device_order')->where($deviceMap)->update(['status'=>3]);
             write_log('Retrieval','修改补货订单状态--'.json_encode($deviceMap,true));
             write_log('Retrieval','修改补货订单状态-sql-'.Db::name('device_order')->where($deviceMap)->fetchSql()->update(['status'=>3]));
            //Db::commit();    //事务提交
            $this->_return(1,'补货成功');
        //}catch (\Exception $e) {
           // Db::rollback();// 回滚事务
            //$this->_return(-1,'补货失败',$e);
        //}
    }


    /**
     * 清除商品
     * @param  string  $macno           | 设备编号
     * @param  int     $type            | 开门类型（1：员工 2：商家）
     * @param  int     user_id          | 员工id
     * @return 
     */
    public function removeGoods()
    { 
        $macno   = input('macno');
        $type    = input('type');
//        $user_id = input('user_id');
//        $token = input('token');
        $pay_type= 1;
        if(empty($macno)) $this->_return(-1,'设备编号不能为空',(object)array());
        if(empty($type)) $this->_return(-1,'查看类型不能为空',(object)array());
        if(empty($user_id)) $this->_return(-1,'员工ID不能为空',(object)array());
//        if(empty($token)) $this->_return(-401,'token不能为空',(object)array());
//        $find= db('user')->where('token',$token)->find();
        if(empty($this->user_id)){
            $this->_return(-401,'未登入',(object)array());
        }
        write_log('removeGoods','开始清除商品');
        if($type == 1){//员工开门
            $pay_type= 1;
            $this->get_staff_info($this->user_id);
        }elseif($type == 2){//商家开门
            $pay_type= 3;
            $this->get_shop_info($this->user_id);
        }else{
            $this->_return(-1,'查看类型不对');
        }

        //检查设备是否存在
        $device = Db::name('device')->where(['macno'=>$macno])->find();
        if(empty($device)) $this->_return(-1,'设备不存在',(object)array());
        if ($device['htime']+60<time())$this->_return(-1,'设备不在线',(object)array());
        if($device['status'] == 1)_return(-1,'设备异常，请先检测！',(object)array());
        if($device['doorstatus'] === 1 && $device['open_status'] === 1) $this->_return(-1,'设备还未关门，请先关门！',(object)array());
        //查找是否还有用户在购买商品
        $where['status'] = 1;
        $where['device_id'] = $device['device_id'];
        $order = Db::name("order")->where($where)->find();
        if(!empty($order)) $this->_return(-1,'该设备还有用户正在购物，请稍后再清空',(object)array());
//        if($device){
//            //发送清空命令时把补货员id存青睐
//            Db::name('device')->where(['device_id'=>$device['device_id']])->update(['user_id'=>$user_id]);
//        }
//        $mqtt = new IndexController();
//        $json = '{"removeGoods":"manager"}';
//        $client_id = time();
//        $mqtt->publish($macno,$json,0,$client_id);
        write_log('removeGoods','设备号------'.$macno);
        write_log('removeGoods','用户id------'.$user_id);
//         $res= $this->set_device($macno,5,$user_id);
//        write_log('removeGoods','返回数据------'.$res);
//        $reslist= json_decode(json_decode($res,true),true);
//        if($reslist['code']!=1){
//            $this->_return(-1,'设备不在线',$reslist);
//        }
        db('device')->where(array('macno'=>$macno))->update(array('user_id'=>$user_id));
        $mqtt = new IndexController();
        $json = '{"removeGoods":"manager"}';
        $client_id = time();
        $mqtt->publish($macno,$json,0,$client_id);
        $this->_return(1,'请求开门中',(object)array());

        // if($device['doorstatus'] === 1 && $device['open_status'] === 1) _return(-1,'设备还未关门，请先关门！',(object)array());
        // $newDoor = new OrderController();
        // //设备开门条件
        // $post['macno']         = $macno;                //设备编号
        // $post['order_number']  = 4564545;               //订单编号    
        // $post['type']          = 5;                     //清除商品
        // $post['sign']          = md5('yzsell');
        // //开门日志信息
        // $arr['user_id']    = $user_id;              //补货员ID
        // $arr['network_id'] = $device['network_id']; //网点ID
        // $arr['shop_id']    = $device['shop_id'];    //商家ID
        // $arr['device_id']  = $device['device_id'];  //柜子ID
        // $arr['type']       = $pay_type;             //开门类型（1：员工 2：用户 3：商家）
        // $newDoor->openDoor($post,3,$arr);
        // $res1 = Db::name('device_goods')->where(['device_id'=>$device['device_id']])->update(['rfid'=>'','inventory'=>0]);
        // $res2 = Db::name('rfid')->where(['device_id'=>$device['device_id'],'status'=>2])->update(['status'=>1]);
    }

        /**
         * APK清除商品回调
         * @param  string  $macno           | 设备编号
         * @param  int     $status          | 开门状态（1为成功 0为失败）
         * @param  int     user_id          | 员工id
         * @return
         */
  public function removeGoodsNotify($params = array()){
         write_log('removeGoodsNotify',"清空商品进来了时间---".date('Y-m-d H:i:s',time()));
            $macno = input('macno')  ? : $params['macno'];
            $status = input('status') ? : $params['status'];
            write_log('removeGoodsNotify',"deivce:清除商品 设备号".$macno);
            $where['b.macno'] = $macno;
            $re = Db::name('device_order')->alias('a')->join('dlc_device b','a.device_id = b.device_id')->where($where)->find();
//            $url = $this->url;
            $device = Db::name('device')->where(array('macno'=>$macno))->find();

            $res1 = Db::name('device_goods')->where('device_id',$device['device_id'])->update(array('inventory'=>0,'rfid'=>''));
            $res2 = Db::name('rfid')->where(array('device_id'=>$device['device_id'],'status'=>2))->update(array('status'=>1,'device_id'=>0));
            //设备所有补货订单置为取消
            $wap['status'] = array('IN','1,2');
            $wap['device_id'] = $device['device_id'];
            $res3 = Db::name('device_order')->where($wap)->update(array('status'=>-1));
            $info['code'] = 1;
            $info['msg'] = "清空商品成功";
            $data['data'] = json_encode($info);
            $data['udid']  = "sdxddshg_close_".$device['user_id'];
            $json = json_encode($data);
            $new_data['data'] = $json;
            write_log('removeGoodsNotify',"deivce:清除商品之后返回给安卓的  data=".$json);
            $mqtt = new IndexController();
            $list=array();
            $list['type']=1;
            $res= $mqtt->notifyH5(1,'商品清空成功',"sdxddshg_close_".$device['user_id'],$list);
       write_log('removeGoodsNotify',"数据返回".json_encode($res,true)."--时间---".date('Y-m-d H:i:s',time()));
//            $re = $this->postCurl('http://10.27.204.40/message/sendmessage',$new_data);
            return;//echo json_encode($rejson);
        }
     /**
     * 添加设备故障
     * @param  string  $macno           | 设备编号
     * @param  int     $token           | 用户标识
     * @param  int     $mobile          | 手机号
     * @param  string  $img             | 上传的故障图片
     * @param  string  $content         | 故障内容
     * @return 
     */
    public function addFault()
    {
        $user_id  = $this->get_user_id();
        $macno  = input('macno');
        $mobile = input('mobile');
        $content= input('content');
        if(empty($macno))  $this->_return(-1,'设备编号不能为空',(object)array());
        if(empty($mobile)) $this->_return(-1,'手机号不能为空',(object)array());
        if(empty($content)) $this->_return(-1,'故障内容不能为空',(object)array());
        if(!empty($_FILES['img'])){
            $img = $this->upload(img,2);
            $data['img'] = substr($img,0,-1);
        }
        if(!($this->check_mobile($mobile))){
            $this->_return(-1,'手机号码格式不正确！！');
        }

        $data['user_id'] = $user_id;
        $data['macno']   = $macno;
        $data['mobile']  = $mobile;
        $data['ctime']   = time();
        $data['content'] = $content;
        $result =  Db::name('device_fault')->insert($data);
        if($result !== false){
            $this->_return(1,'提交故障信息成功',(object)array());
        }else{
            $this->_return(-1,'提交故障信息失败',(object)array());
        }
    }


    /**
     * 获取设备对应的网点信息
     * @param  int  $id | 网点ID
     * @return 
     */
    public function getNetworkInfo($id = '')
    {
        return Db::name('network')->find($id);
    }

     /**
     * 设备关门
     * @param  string  $macno           | 设备编号
     * @param  string  $order_number    | 订单编号
     * @param  string  $rfid            | rfid
     * @param  int     $type            | 类型（1：购买商品 2：补货 6：补货异常 5：清空商品）
     * @return 
     */
    public function closeDoor($params = array())
    {
        $macno        = input('macno')? : $params['macno'];
        $rfid         = input('nowRfid') ? : $params['nowRfid'];
//        $rfid         = input('rfid') ? : $params['rfid'];
        $type         = input('type')? : $params['type'];
		$closeType    = input('closeType')? : $params['closeType'];
		write_log('userDoor',"设备：".$macno."补货开始: ".$rfid);
        write_log('closeDoor',"上传过来的数据".json_encode(input('post.'),true));
        if(empty($macno)){
			write_log('closeDoor',"设备编号不能为空");
			$this->_return(1,'设备编号不能为空',(object)array());
		}
        if(empty($rfid)){
			write_log('closeDoor',"rfid不能为空");
			$this->_return(1,'rfid不能为空',(object)array());
		}
        if(empty($type)){
			write_log('closeDoor',"状态类型不能为空");
			$this->_return(1,'状态类型不能为空',(object)array());
		}
        $device = Db::name('device')->where(array('macno'=>$macno))->find();
        if(empty($device)){
			write_log('closeDoor',"此设备不存在");
			$this->_return(-1,'此设备不存在',(object)array());
		}
		
		$where['b.macno'] = $macno;
        $where['a.status'] = ['in', [1,2]];
//		if($closeType == 1){    //首次补货
//			$where['a.status'] = 1;
//		}else{                  //补货异常
//			$where['a.status'] = 2;
//            write_log('abnormal',"补货异常：rfid=".$rfid);
//		}
		$orderGoods = Db::name('device_order')->alias('a')->join('dlc_device b','a.device_id = b.device_id')->where($where)->find();
		if(empty($orderGoods)){
			write_log('closeDoor',"此订单不存在");
			$this->_return(-1,'此订单不存在',(object)array());
		}
        $this->buhuoDoor($orderGoods,$rfid,$closeType,$type,$device);

    }

     /**
     * 补货异常
     * @param  string  $macno           | 设备编号
     * @param  string  $order_number    | 补货编号
     * @param  int     $type            | 开门类型（1：员工 2：商家）
     * @param  int     user_id          | 员工id
     * @return 
     */
    public function retrievalUnusual()
    {
        $macno        = input('macno');
        $order_number = input('order_number');
        $type         = input('type');
//        $user_id      = input('user_id');
//        $token      = input('token');
        if(empty($macno)) $this->_return(-1,'设备编号不能为空',(object)array());
        if(empty($type)) $this->_return(-1,'查看类型不能为空',(object)array());
        if(empty($order_number)) $this->_return(-1,'补货编号不能为空',(object)array());
//        if(empty($user_id)) $this->_return(-1,'员工ID不能为空',(object)array());
//        if(empty($token)) $this->_return(-401,'token不能为空',(object)array());
//        $find= db('user')->where('token',$token)->find();
        if(empty($this->user_id)){
            $this->_return(-401,'未登入',(object)array());
        }
        if($type == 1){//员工开门
            $pay_type = 1;
            $this->get_staff_info($this->user_id);
        }elseif($type == 2){//商家开门
            $pay_type = 3;
            $this->get_shop_info($this->user_id);
        }else{
            $this->_return(-1,'查看类型不对');
        }
        //检查设备是否存在
        $device = Db::name('device')->where(['macno'=>$macno])->find();
        if(empty($device)) $this->_return(-1,'设备不存在',(object)array());
        if($device['status'] == 1)  _return(-1,'设备异常，请先检测！',(object)array());
        if($device['doorstatus'] === 1 && $device['open_status'] === 1) _return(-1,'设备还未关门，请先关门！',(object)array());
        //检查是否有未确认补货订单
        $deviceMap['order_number'] = $order_number;
        $deviceMap['status']       = 2;
        $deviceMap['staff_id']     = $this->user_id;
        $deviceOrder = Db::name('device_order')->where($deviceMap)->find();

        if(empty($deviceOrder))  $this->_return(-1,'没有这个补货订单',(object)array());
//		$mqtt = new IndexController();
//		$json = '{"goods":"manager"}';
//		$client_id = time();
//		$mqtt->publish($macno,$json,0,$client_id);

//        $res =$this->set_device($macno,4,$order_number);
        $mqtt = new IndexController();
        $json = '{"goods":"manager"}';
        $client_id = time();
        $mqtt->publish($macno,$json,0,$client_id);
        write_log('retrievalDoor','正在请求重新盘点商品'.$macno.'订单编号'.$order_number.'--时间--'.date('Y-m-d H:i;s',time()));
        $this->_return(1,'正在请求重新盘点商品',(object)array());
        /*$openOrder = new OrderController();
        $post['macno']         = $macno;                //设备编号
        $post['order_number']  = $order_number;          //订单编号
        $post['type']          = 3;                     //购买
        $post['sign']          = md5('yzsell'); 
        $openOrder->openDoor($post,2);*/
    }

    /**
     * 用户购买后设备关门
     * @param array  $order  | 用户订单
     * @param string $rfid   | rfid
     * @return 
     */
    public function   userDoor($params = array())
    {

        $macno        = input('macno') ? : $params['macno'];
        $rfid         = input('rfid') ? : $params['rfid'];
        $order_number         = input('order_number') ? : $params['order_number'];
		$mqtt = new IndexController();
        $count     = 0;
        write_log('OpenDoor','接受数据时间1--'.date('Y-m-d H:i:s:u',time()));
        write_log('OpenDoor','接受rfid--'.$rfid);
		if(empty($macno))   return;//$this->_return(-1,'设备号不能为空',(object)array());
        $device = Db::name('device')->where(array('macno'=>$macno))->find();
        if(empty($device)) return;//$this->_return(-1,'此设备不存在',(object)array());
//        $where['b.macno'] = $macno;
//        $where['a.status'] = 1;
//        $where['a.order_number'] = $order_number;
//        write_log('mianmi',"用户扫码开门2121212121: "."刚进来userDoor方法222--查询提交WHERE".json_encode($where,true));
//        write_log('OpenDoor',"用户扫码开门2121212121: "."刚进来userDoor方法222--查询提交WHERE".json_encode($where,true));
//        $order = Db::name('order')->alias('a')->join('dlc_device b','a.device_id = b.device_id')->where($where)->field("a.*,b.network_id,b.shop_id,b.title,b.macno,b.user_id as staff_id,b.img")->find();

        $where['b.macno'] = $macno;
        $where['a.status'] = 1;
        $order = Db::name('order')->alias('a')->join('dlc_device b','a.device_id = b.device_id')->where($where)->field("a.*,b.network_id,b.shop_id,b.title,b.macno,b.user_id as staff_id,b.img")->find();
		if(empty($order))
		{
            return;
//		    $this->_return(-1,'此订单不存在',(object)array());
		}
        db('device')->where(array('macno'=>$macno))->update(array('doorstatus'=>0,'open_status'=>3));
        Db::name('order')->where(array('order_id'=>$order['order_id']))->update(array('status'=>2));
		//获取用户信息
        $user = Db::name('user')->where(array('user_id'=>$order['user_id']))->find();
		$udid = "sdxddshg_close_".$order['user_id'];
        $goodClass = array();
        $money     = 0;
        if(empty($rfid)){//如果rfid为空就把订单改为已取消并修改设备的状态

            //修改设备状态
           $de= Db::name('device')->where(array('macno'=>$macno))->update(array('doorstatus'=>0,'open_status'=>3));

            //订单
            Db::name('order')->where(array('order_id'=>$order['order_id']))->update(array('status'=>-1));
//            $mqtt->notifyH5Message(1,'关门成功，此订单已取消',$udid);
            $arr=array();
            $arr['type']=1;
			$res1=$mqtt->notifyH5(-1,'关门成功，未购买商品，此订单已取消',$udid,$arr,$order['order_number']);


            return;
//            $this->_return(1,'关门成功，查询不到商品，此订单已删除',(object)array());
        }else{

			$map['status'] = 2;
			$map['rfid'] = array("IN",$rfid);
            $map['device_id'] =$device['device_id'];
			$goodClass = Db::name('rfid')
//                ->alias('a')
//                ->join('dlc_goods b','b.goods_id=a.goods_id','left')
//                ->join('dlc_goods_type c','b.type_id=c.type_id','left')
                ->where($map)
//                ->field('a.*,c.start_time,c.end_time,c.sale')
                ->order("goods_id desc")->select();
            write_log('OpenDoor','查询rfid数据--1'.json_encode($goodClass,true));
			$count =Db::name('rfid')
//                ->alias('a')
//                ->join('dlc_goods b','b.goods_id=a.goods_id','left')
//                ->join('dlc_goods_type c','b.type_id=c.type_id','left')
                ->where($map)->count();
			if(empty($goodClass)){
                write_log('OpenDoor','查询rfid数据--2--goodClass--为空'.json_encode($goodClass,true));
					 //修改设备状态 关门 修改订单状态（改为已取消）
                    $result3  =  Db::name('device')->where(array('device_id'=>$order['device_id']))->update(array('doorstatus'=>0,'open_status'=>3));
                    $result4  =  Db::name('order')->where(array('order_id'=>$order['order_id'],'status'=>1))->update(array('status'=>-1));
					if($result3 !== false && $result4 !==false){
//                        $mqtt->notifyH5Message(1,'关门成功，此订单没有存在库存中的rfid',$udid);
                        write_log('OpenDoor','查询rfid数据--3--'.json_encode($goodClass,true));
                        $arr=array();
                        $arr['type']=1;
                        $res= $mqtt->notifyH5(-1,'关门成功，未查询到商品，订单已取消',$udid,$arr,$order['order_number']);
                        return;
//                    	$this->_return(1,'关门成功，此订单没有存在库存中的rfid',(object)array());
					}else{
                        write_log('OpenDoor','查询rfid数据--4--'.json_encode($goodClass,true));
                        $arr=array();
                        $arr['type']=1;
                        $res= $mqtt->notifyH5(-1,'关门失败',$udid,$arr,$order['order_number']);
                        return;

					}
			}

            $money = 0;
            $sale_total_price = 0;
            $insertAll = [];
            $goods = [];
            $device_goods = [];
            $rfid = [];
            $rfid2 = [];
            $list = [];
            write_log('OpenDoor','查询rfid数据--5--'.json_encode($goodClass,true));
            foreach ($goodClass as $k => $v) {
                if($v['status']!=2) continue;
                // $count += 1;
                //获取柜子商品价格跟数据
                $rfid[$v['goods_id']][] = $v['rfid'];
                $rfid2[]= $v['rfid'];
                //添加子订单数据
//                $goods = Db::name('goods')->where(array('goods_id'=>$v['goods_id']))->find();
                $goods = Db::name('device_goods')->where(array('goods_id'=>$v['goods_id'],'device_id'=>$order['device_id']))->find();
                $where1['b.start_time']=['<=',date('H:i',time())];
                $where1['b.end_time']=['>=',date('H:i',time())];
                $where1['a.shop_id']=$order['shop_id'];
                $where1['a.goods_id']=$v['goods_id'];
//                $sale= db('goods_time')
//                    ->alias('a')
//                    ->join('dlc_shop_time b','b.time_id=a.time_id','left')
//                    ->where($where1)->value('a.sale');
                write_log('OpenDoor','订单折扣--sale--'.$sale);
                if (isset($insertAll[$v['goods_id']])){
//                    if($sale!=0){
//                        $sale1= $sale/10;
//                        $insertAll[$v['goods_id']]['count_price']+= $goods['price'] * $sale1;
//                        $insertAll[$v['goods_id']]['original_price']+=$goods['price'];
//                        $insertAll[$v['goods_id']]['price']=$goods['price'];
//                        $insertAll[$v['goods_id']]['sale']=$sale;
//                        $sale_total_price+=$goods['price']-($goods['price'] * $sale1);
//                    }else{
//                        $insertAll[$v['goods_id']]['count_price']+= $goods['price'];
//                        $insertAll[$v['goods_id']]['original_price'] = $goods['price'];
//                        $insertAll[$v['goods_id']]['sale'] =0;
//                        $list[$v['goods_id']]['price'] = $goods['price'];
//                    }
                    $insertAll[$v['goods_id']]['count_price']+= $goods['price'];
                    $insertAll[$v['goods_id']]['original_price'] = $goods['price'];
                    $insertAll[$v['goods_id']]['sale'] =0;
                    $list[$v['goods_id']]['price'] = $goods['price'];
                    $insertAll[$v['goods_id']]['num']   += 1;
                    $list[$v['goods_id']]['num']      += 1;
                    $insertAll[$v['goods_id']]['rfid']       .= ",".$v['rfid'];
                }else{
                    //获取柜子商品价格跟数据

                    $device_goods[$v['goods_id']] = Db::name('device_goods')->where(array('goods_id'=>$v["goods_id"],'device_id'=>$order['device_id']))->find();
                    $insertAll[$v['goods_id']]['order_id']   = $order['order_id'];
                    $insertAll[$v['goods_id']]['goods_id']   = $goods['goods_id'];
                    $insertAll[$v['goods_id']]['shop_id']    = $order['shop_id'];
                    $insertAll[$v['goods_id']]['device_id']  = $order['device_id'];
                    $insertAll[$v['goods_id']]['network_id'] = $order['network_id'];
                    $insertAll[$v['goods_id']]['num']        = 1;
                    $insertAll[$v['goods_id']]['ctime']      = time();
                    $insertAll[$v['goods_id']]['rfid']       = $v['rfid'];

//                    if($sale!=0){
//                        $sale1= $sale/10;
//                        $insertAll[$v['goods_id']]['count_price']= $goods['price'] * $sale1;
//                        $insertAll[$v['goods_id']]['price']      = $goods['price'] * $sale1;
//                        $insertAll[$v['goods_id']]['original_price']+=$goods['price'];
//                        $insertAll[$v['goods_id']]['sale']=$sale;
//                        $list[$v['goods_id']]['price']      = $goods['price'] * $sale1;
//                        $sale_total_price =$goods['price']-($goods['price'] * $sale1);//计算出折扣价格
//                    }else{
//                        //商品类型折扣等于0的时候，不计算商品折扣价
//                        $insertAll[$v['goods_id']]['price']      = $goods['price'];
//                        $insertAll[$v['goods_id']]['count_price'] += $goods['price'];
//                        $insertAll[$v['goods_id']]['original_price']+=$goods['price'];
//                        $insertAll[$v['goods_id']]['sale']=0;
//                        $list[$v['goods_id']]['price']      = $goods['price'];
//                    }
                    $insertAll[$v['goods_id']]['price']      = $goods['price'];
                    $insertAll[$v['goods_id']]['count_price'] += $goods['price'];
                    $insertAll[$v['goods_id']]['original_price']+=$goods['price'];
                    $insertAll[$v['goods_id']]['sale']=0;
                    $list[$v['goods_id']]['price']      = $goods['price'];
                    $list[$v['goods_id']]['num']      = 1;
                    $list[$v['goods_id']]['title']      = $goods['title'];
                    $list[$v['goods_id']]['img']      = $this->appUrl.'public'.$goods['img'];
                }
                $arr_rfid_box = array_filter(explode(',',$device_goods[$v['goods_id']]['rfid']));
                $device_goods[$v['goods_id']]['rfid'] = trim(implode(',',array_diff($arr_rfid_box,$rfid[$v['goods_id']])), ',');
                $device_goods[$v['goods_id']]['inventory']  = $device_goods[$v['goods_id']]['inventory']-1 ;
                $device_goods[$v['goods_id']]['sales']= $device_goods[$v['goods_id']]['sales'] + 1;
                $price    = $goods['price'];
                $money += $price;
//                $salemoney += $sale_total_price;//累加折扣价格
            }
            write_log('OpenDoor','查询金额---'.$money);
            write_log('OpenDoor','查询rfid数据--insertAll'.json_encode($insertAll,true));
            if($insertAll){
                $res = Db::name('order_info')->insertAll(array_values($insertAll));
                //修改rfid表的状态
                $res2 = Db::name('rfid')->where(['rfid'=>['in',$rfid2]])->update(['status'=>3]);
                //修改设备商品的rfid
                $res3 = model('device_goods')->isUpdate()->saveAll(array_values($device_goods));
                if  (!$res || !$res2 || !$res3){
                    write_log('','更新失败'.$res.','.$res2.','.$res3);
                    write_log('','OpenDoor'.$res.','.$res2.','.$res3);
                }else{
                    write_log('wxpay','更新成功'.$res.','.$res2.','.$res3);
                    write_log('OpenDoor','更新成功'.$res.','.$res2.','.$res3);
                }
            }
                write_log('OpenDoor','查询rfid数据--6--'.json_encode($goodClass,true));
//            $money=0.01 * 100;
//            $data['close_time'] = time();
//            $data['total_price'] = $money ;
//            $data['sale_money'] =  $sale_total_price;
//            $data['pay_price'] = $money - $sale_total_price;
//            $data['num'] = $count;
//            $data['status'] = 2;


            $data['close_time'] = time();
            $data['total_price'] = $money ;
            $data['pay_price'] = $money;
            $data['num'] = $count;
            $data['status'] = 2;
            write_log('OpenDoor','修改订单数据--data--1'.json_encode($data,true));
            write_log('OpenDoor','修改订单数据--data--6--'.json_encode($data,true));
            /*是否有优惠券start*/
            $couponwhere=[];
            $couponwhere['user_id']=$order['user_id'];
            $couponwhere['shop_id']=$order['shop_id'];
            $couponwhere['coupon_money']=['<',$money];
            $coupon_log = Db::name('coupon_log')->where($couponwhere)->order('coupon_money','desc')->find();
            if($coupon_log){
                $money -= $coupon_log['coupon_money'];
                $data['discount_id']    = $coupon_log['id'];            //优惠ID
                $data['discount_money'] = $coupon_log['coupon_money'];  //优惠金额
                if($money >0){
                    $data['pay_price'] = $money-$sale_total_price;

                }else{
                    $data['pay_price'] = 0;
                    $data['status']     = 3;
                    Db::name('coupon_log')->where(['id'=>$coupon_log['id']])->update(['status'=>1]);
                }
//                db('user')->where(array('user_id'=>$order['user_id']))->setInc('coupon_count',1);
            }
            /*是否有优惠券end*/
            write_log('OpenDoor','修改订单数据--data--2'.json_encode($data,true));
            $res1 = Db::name('order')->where(['order_id'=>$order['order_id']])->update($data);
            write_log('OpenDoor','修改订单数据--data--7--'.json_encode($data,true));
            write_log('OpenDoor','修改订单数据--data--8--'.$res1);
            //修改设备的状态
            $device = Db::name('device')->where(['device_id'=>$order['device_id']])->find();
            $sales  = $device['sales'] + $count;
            $res2 = Db::name('device')->where(['device_id'=>$order['device_id']])->update(['doorstatus'=>0,'open_status'=>3,'sales'=>$sales]);

            //查询是否有优惠券可以用
            $money1=0;
            //微信免密支付
            $pay_status = 0;//支付状态
            if($order['pay_type'] == 1 && $res1 !== false && $res2 !== false && $money >0){
                write_log('OpenDoor','修改订单数据--data--9--'.$res1);
                $pay_style=1;
                //开始微信免密支付
                write_log('wxpay','开始微信免密支付');
                import("WxpaymentController");
                $wxpayment = new WxpaymentController;
//                $find= db('shop_wxset')->where('shop_id',$device['shop_id'])->find();
                $wxdata=[];
//                if($find){
//                    $pay_style=2;
//                    $wxdata['appid']=$find['wxappid'];
//                    $wxdata['appsecret']=$find['wxappsecret'];
//                    $wxdata['mchid']=$find['wxmchid'];
//                    $wxdata['mchsecret']=$find['wxmchkey'];
//                    $wxdata['plan_id']=$find['wxplanid'];
//                    $wxpayment->loadWxpayConfig($wxdata);
//                }
                $user = Db::name('user')->where(array('user_id'=>$order['user_id']))->find();
                $check_contract = $wxpayment->querycontract($user['openid']);
                if(!$check_contract){ //已开通免密支付
                    write_log('OpenDoor','修改订单数据--data--10--'.$res1);
//                    $money1=$data['pay_price'];
//                    $money1=0.01;
//                      $money=0.01 * 100;
                    write_log('OpenDoor','免密支付金额---'.$money1);
                    $pay_result = $wxpayment->pappayapply($user['contract_id'],$order['order_number'],$order['order_id'],$money,$order['user_id']);
                    write_log('wxpay','调取免密返回参数'.json_encode($pay_result,true));
//                    if($pay_result['return_code'] == "SUCCESS"){
                    if($pay_result['result_code'] == "SUCCESS"){
                        $pay_status = 1;
                        write_log('OpenDoor',"userDoor--免密扣款成功--pay_style--". $pay_style);
                        write_log('wxpay','微信免密支付扣款成功，关门成功,订单结束');
                    }else{

                        Db::name('order')->where('order_id',$order['order_id'])->update(['reason'=>$pay_result['err_code_des']]);
                        if($pay_result['return_code']=='FAIL'){
                            Db::name('order')->where('order_id',$order['order_id'])->update(['reason'=>$pay_result['return_msg']]);
                        }
                        write_log('wxpay','微信免密支付扣款失败，订单结束');
                    }
                }else{
                    write_log('wxpay','用户未开通微信免密支付，关门成功,订单结束');
                }
            }
            if($res1 !== false && $res2 !== false){
                //通知前端关门成功
//                $list = Db::name('order_info')->alias('a')
//                    ->where(array('order_id'=>$order['order_id']))
//                    ->join('dlc_goods b','b.goods_id = a.goods_id','left')
//                    ->field('a.num,b.title,b.img,a.price')
//                    ->select();
//                foreach ($list as $key => $value) {
//                    $list[$key]['img'] = $this->appUrl.'public'.$value['img'];
//                }
                $url = 'http://10.27.204.40/message/sendmessage';
                $list['type']=1;
                $list['pay_status']=$pay_status;
                $res= $mqtt->notifyH5(1,'关门成功',$udid,$list,$order['order_number'],$url,$order['order_id']);
                write_log('OpenDoor',"---推送时间--".date('Y-m-d H:i:s:u',time()).'---返回信息---'.$res);
                
                return;
//                $this->_return(1,'关门成功',(object)array());
            }else{
//                $mqtt->notifyH5Message(-1,'关门失败',$udid);

                $arr=array();
                $arr['type']=1;
                $res= $mqtt->notifyH5(-1,'关门失败',$udid,$arr,$order['order_number']);
                write_log('OpenDoor',"---购物关门失败时间--".date('Y-m-d H:i:s',time()).'---返回信息---'.$res);

                return;
//                $this->_return(-1,'关门失败',(object)array());
            }

//            if($res1 !== false && $res2 !== false){
//				//通知前端关门成功
//       			$list = Db::name('order_info')->alias('a')
//					->where(array('order_id'=>$order['order_id']))
//					->join('dlc_goods b','b.goods_id = a.goods_id','left')
//					->field('a.num,b.title,b.img,a.price')
//					->select();
//				foreach ($list as $key => $value) {
//					$list[$key]['img'] = $this->appUrl.'public/'.$value['img'];
//				}
//				$url = 'http://adm.hbfyun.com/message/sendmessage';
////				$mqtt->notifyH5(1,'关门成功',$udid,$list,$order['order_number'],$url,$order['order_id']);
//                $this->_return(1,'关门成功1',(object)array());
//            }else{
////				$mqtt->notifyH5(-1,'关门失败',$udid,array(),$order['order_number']);
//                $this->_return(-1,'关门失败',(object)array());
//            }
        }
    }




    public function buhuoDoor($order,$rfid,$closeType= 1,$type = 1,$device)
    {
        write_log('closeDoor',"补货分类");

        $mqtt = new IndexController();
        $udid = "sdxddshg_close_".$order['staff_id'];
        Db::name('device_orderinfo')->where(['order_id'=>$order['order_id']])->delete();
        //修改主订单状态
        $data['close_time'] = time();
        $data['status']     = 2;
        $res1 = Db::name('device_order')->where(['order_id'=>$order['order_id']])->update($data);
        //修改设备的状态
        $res2 = Db::name('device')->where(['device_id'=>$order['device_id']])->update(['doorstatus'=>0,'open_status'=>3]);
        //
        if(is_array($rfid))$rfid = implode(',', array_filter($rfid));
        $rfid = str_replace(array('[', ']', '"'), '', $rfid);
        $rfid = trim($rfid, ',');
        write_log('closeDoor',"nowRfid:".$rfid);
//        $rfid_list = $rfid ? (array)db('rfid')->where("find_in_set(rfid, '".$rfid."')>0")->where(array("status"=>array("NEQ",3)))->select() : array();
        $rfid_list = $rfid ? (array)db('rfid')->where("find_in_set(rfid, '".$rfid."')>0 and status<>3")->select() : array();

//      $rfid_list = $rfid ? (array)db('rfid')->where("find_in_set(rfid, '".$rfid."')>0 and (status=1 or status =3) and (device_id=0 or device_id = ".$order['device_id']." )")->select() : array();//剔除掉已经其他柜子的rfid 查找多扣的rfid
		$new_rfid = $this->new_rfid($rfid_list,$order);
        $arrlist=array();
        $arrlist['type']=1;
        if($type==6){
            $arrlist['class']=2;//盘点

        }else{
            $arrlist['class']=1;//补货分类
        }
        write_log('closeDoor',"nowRfid:".$rfid);
        write_log('closeDoor',"计算后返回数据new_rfid:".json_encode($new_rfid,true));
        write_log('closeDoor',"计算后返回数据new_rfid:".empty($new_rfid));
		if(empty($new_rfid)){

            $arrlist['data']=[];
            Db::name('device_order')->where(['order_id'=>$order['order_id']])->update(['status'=>-1]);
            write_log('closeDoor',"计算后返回数据arrlist:".json_encode($arrlist,true));
            $mqtt->notifyH5(1,'关门成功,未补货!',$udid,$arrlist,$order['order_number']);
            $this->_return(1,'关门成功,未补货',(object)array());
        }
		//删除上次未完成数据
		Db::name('device_orderinfo')->where(['order_id'=>$order['order_id']])->delete();
		//修改设备的状态
		Db::name('device')->where(['device_id'=>$order['device_id']])->update(['doorstatus'=>0,'open_status'=>3]);
		//修改主订单状态
		$data['close_time'] = time();
		$data['status']     = 2;
		$data['new_rfid'] = json_encode($new_rfid);
		Db::name('device_order')->where(['order_id'=>$order['order_id']])->update($data);
        //获取原数据

		$deviceGoodsList = Db::name('device_goods')->alias('a')
			->join('dlc_goods b','a.goods_id = b.goods_id','left')
			->field('a.goods_id,a.inventory,a.rfid,b.title,b.img')
			->where(['a.device_id'=>$device['device_id'],'a.inventory'=>['>', 0],'a.rfid'=>['<>','']])
			->select();		
		//新数据
		$list = array();
		if($new_rfid){
			$list = Db::name('goods')->where(array('goods_id'=> array('in', array_keys($new_rfid)))) 
				->column('goods_id,title,img');
			foreach($new_rfid as $k => $v){
				$list[$k] = array(
					'goods_id' => $k,
					'inventory' => $v['num'],
					'title' => $list[$k]['title'],
					'rfid' => $v['rfid'],
					'img' => $list[$k]['img'],
				);
			}
			$list = array_values($list);
            write_log('closeDoor',"list".json_encode($list,true));
		}
		//对比数据
		function _pri_search($itemDeviceGoods, $listDeviceGoods){
			foreach($listDeviceGoods as $v){
				$v['rfid'] = array_filter(explode(',', $v['rfid']));
				if($v['goods_id'] == $itemDeviceGoods['goods_id'])return $v;
			}
			return false;
		}
		
		$newlist = array();

		foreach ($list as $value) {
			$value['rfid'] = array_filter(explode(',', $value['rfid']));
			$oldDeviceGoods = _pri_search($value, $deviceGoodsList);
			if($oldDeviceGoods){
				$inrfid = array_diff($value['rfid'], $oldDeviceGoods['rfid']);
				$outrfid = array_diff($oldDeviceGoods['rfid'], $value['rfid']);
				if(!$inrfid && !$outrfid)continue;
				if($inrfid)$newlist[] = array(
					'goods_id' => $value['goods_id'],
					'inventory' => count($inrfid),
					'title' => $value['title'],
					'img' => $this->appUrl.'public'.$value['img'],
					'outrfid' => array(),
					'inrfid' => $inrfid,
				);
				if($outrfid)$newlist[] = array(
					'goods_id' => $value['goods_id'],
					'inventory' => -1 * count($outrfid),
					'title' => $value['title'],
					'img' => $this->appUrl.'public'.$value['img'],
					'outrfid' => $outrfid,
					'inrfid' => array(),
				);
			}else{
				if($value['inventory'])$newlist[] = array(
					'goods_id' => $value['goods_id'],
					'inventory' => $value['inventory'],
					'title' => $value['title'],
					'img' => $this->appUrl.'public'.$value['img'],
					'outrfid' => array(),
					'inrfid' => $value['rfid'],
				);
			}
		}
        write_log('closeDoor',"list1".json_encode($list,true));
		foreach ($deviceGoodsList as $value) {

			$value['rfid'] = array_filter(explode(',', $value['rfid']));
//            if($value['inventory'] <= 0||$value['inventory']>0){
//                continue;
//            }else{
//                $newDeviceGoods = _pri_search($value, $list);
//            }
			if($value['inventory'] <= 0)continue;
			$newDeviceGoods = _pri_search($value, $list);
			if($newDeviceGoods){
				continue;
			}else{
				if($value['inventory'])$newlist[] = array(
					'goods_id' => $value['goods_id'],
					'inventory' => -1 * $value['inventory'],
					'title' => $value['title'],
					'img' => $this->appUrl.'public'.$value['img'],
					'outrfid' => $value['rfid'],
					'inrfid' => array(),
				);
			}
		}
        write_log('closeDoor',"deviceGoodsList".json_encode($deviceGoodsList,true));
        write_log('closeDoor',"---newlist---".json_encode($newlist,true));
		if($newlist){
			$orderInfos = array();
			foreach($newlist as $v){
				if(!$v['inventory'])continue;
				$orderInfos[] = array(
					'order_id' => $order['order_id'],
					'device_id' => $order['device_id'],
					'goods_id' => $v['goods_id'],
					'shop_id' => $order['shop_id'],
					'num' => $v['inventory'],
					'rfid' => implode(',', $v['inrfid']),
					'outrfid' => implode(',', $v['outrfid']),
					'ctime' => time(),
				);
			}
			Db::name('device_orderinfo')->insertAll($orderInfos);
		}
		//通知前端补货信息

        write_log('closeDoor',"orderInfos".json_encode($orderInfos,true));
//		$arrlist=array();
//        $arrlist['type']=1;
//        if($type==6){
//            $arrlist['class']=2;//盘点
//
//        }else{
//            $arrlist['class']=1;//补货分类
//        }
        write_log('closeDoor',"推送udid:---type----".$type);
		$arrlist['data']=$newlist;
        write_log('closeDoor',"推送udid:".$udid." 补货商品：".json_encode($arrlist)." 补货数量：".count($newlist)." 订单编号：".json_encode($order));
		$mqtt->notifyH5(1,'关门成功',$udid,$arrlist,$order['order_number']);
		return;
    }

    /*
     * 员工补货记录
     */

    public function staffReplenish(){
        $page = $_POST['page']?$_POST['page']:1; //页码
        $pagesize = $_POST['pagesize']?$_POST['pagesize']:10; //每页条数
        if (empty($this->user_id)) $this->_return(10000,'缺少参数');
        $res = Db::name('device_order')->alias('a')
            ->join('dlc_device b','b.device_id=a.device_id','left')
            ->where(['a.staff_id'=>$this->user_id,'a.staff_type'=>1,'a.status'=>3])
            ->field('a.order_id,a.order_number,a.close_time,b.macno')->page($page,$pagesize)
            ->order('a.close_time desc')
            ->select();

        foreach ($res as $k=>$v){
            $res[$k]['close_time']=date('Y-m-d H:i:s',$v['close_time']);
        }
        $this->_return(1,'获取成功',$res);
    }
        //补货订单
    public function new_rfid($goodClass,$order){
        write_log("closeDoor","订单编号：".$order['order_number']." 补货数量insert_rfid：".count($goodClass));
        write_log("closeDoor","订单编号：".$order['order_number']." 补货RFID数据：".json_encode($goodClass));
        $data = array();
        foreach ($goodClass as $k => $v) {
            //在柜子中的标签剔除
            if ($v['status']==2){
                if($v['device_id']!=$order['device_id']){
                    continue;
                }

            }
            elseif($v['status']==3){
                //漏读的标签查询到不是柜子中的也剔除
                if($v['device_id']!=$order['device_id']){
                    continue;
                }else{
                    //漏读的标签查询到是柜子中的重新补货
                    if(isset($data[$v['goods_id']])){
                        $data[$v['goods_id']]['rfid'] .= ','.$v['rfid'];
                        $data[$v['goods_id']]['num']  += 1;
                    }else{
                        $data[$v['goods_id']] = array();
                        $data[$v['goods_id']]['rfid']            = $v['rfid'];                  //补货的rfid记录
                        $data[$v['goods_id']]['num']             = 1;                           //补货数量
                    }
                }
            }
            if(isset($data[$v['goods_id']])){
                $data[$v['goods_id']]['rfid'] .= ','.$v['rfid'];
                $data[$v['goods_id']]['num']  += 1;
            }else{
                $data[$v['goods_id']] = array();
                //$data[$v['goods_id']]['order_id']        = $order['order_id'];          //补货日志id
                //$data[$v['goods_id']]['device_id']       = $order['device_id'];         //skuid
                //$data[$v['goods_id']]['shop_id']         = $order['shop_id'];           //skuid
                //$data[$v['goods_id']]['goods_id']        = $v['goods_id'];              //skuid
                //$data[$v['goods_id']]['ctime']           = time();                      //预警时间
                $data[$v['goods_id']]['rfid']            = $v['rfid'];                  //补货的rfid记录
                $data[$v['goods_id']]['num']             = 1;                           //补货数量
            }
        }
        write_log("closeDoor","rfidf返回数据：".json_encode($data));
        return $data;
    }

    private function insert_rfid($goodClass,$order){
        write_log("closeDoor","订单编号：".$order['order_number']." 补货数量insert_rfid：".count($goodClass));
        write_log("closeDoor","订单编号：".$order['order_number']." 补货RFID数据：".json_encode($goodClass));
        $data = array();
        foreach ($goodClass as $k => $v) {
            if(isset($data[$v['goods_id']])){
                $data[$v['goods_id']]['rfid'] .= ','.$v['rfid'];
                $data[$v['goods_id']]['num']  += 1;
            }else{
                $data[$v['goods_id']] = array();
                $data[$v['goods_id']]['order_id']        = $order['order_id'];          //补货日志id
                $data[$v['goods_id']]['device_id']       = $order['device_id'];         //skuid
                $data[$v['goods_id']]['shop_id']         = $order['shop_id'];           //skuid
                $data[$v['goods_id']]['goods_id']        = $v['goods_id'];              //skuid
                $data[$v['goods_id']]['ctime']           = time();                      //预警时间
                $data[$v['goods_id']]['rfid']            = $v['rfid'];                  //补货的rfid记录
                $data[$v['goods_id']]['num']             = 1;                           //补货数量
            }
        }
        if(!$data)return false;
        return Db::name('device_orderinfo')->insertAll(array_values($data));
    }


    // //补货异常订单
    // private function difference_rfid()
    // // private function difference_rfid($goodClass,$order)
    // {
    //     $orderInfo = Db::name('device_orderinfo')->where(['order_id'=>28])->field('rfid')->select();
    //     $this->_return(1,'',$orderInfo);
    // }
    /**
     * 修改设备的状态
     * @param array/string  $where  | 修改条件
     * @param array         $data   | 修改内容
     * @return 
     */
    public function updateDeivceSatuts($where= '',$data=array())
    {
        return Db::name('device')->where($where)->update($data);
    }

    public function open(){
        $macno='833a21350c5413a8';
        $user_id=77;
        $type=1;
        $data['macno']=$macno;
        $data['user_id']=$user_id;
        $data['type']=$type;

        $res=    $this->postCurl('http://sdxddshg.app.xiaozhuschool.com/wxsite/Device/retrievalDoor',$data);
        write_log('open',"安卓调试自己调取补货开门指令".$res);
       echo $res;
//        if($res['code']==1){
//            echo '成功';
//        }else{
//            echo '失败';
//        }
    }
    public function sao(){
        $macno='833a21350c5413a8';
        $token='eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjc5LCJleHAiOjE1MzU1MjMwNzd9.DxsjeCWI-BQGxScvkPmh24VOkgy16wO7AXqL1nlpu44';
        $type=2;
        $data['macno']=$macno;
        $data['token']=$token;
        $data['type']=$type;

        $res=    $this->postCurl('http://sdxddshg.app.xiaozhuschool.com/wxsite/Order/userOpenDoor',$data);
        write_log('open',"安卓调试自己调取补货开门指令".$res);
        echo $res;
//        if($res['code']==1){
//            echo '成功';
//        }else{
//            echo '失败';
//        }
    }

}