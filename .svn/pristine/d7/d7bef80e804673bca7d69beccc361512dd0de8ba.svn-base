<?php
namespace app\shop\controller;
/**
 * 马远利
 */
use think\model;
use think\Db;
use think\Session;
class DeviceController extends BaseController
{
    public $id;
    public $type;
    public function _initialize() 
    {
        $this->type = Session::get('MMS.type');//子后台登录帐号类型（1：商家 2：员工）
        $aid=Session::get('MMS.uid');
        if($this->type == 1){
            $this->id=Db::name('shop')->where(['aid'=>$aid])->value('shop_id');//商家ID
        }else{
            $this->id = $aid;//员工ID
        }
        $this->assign('type',$this->type);
    }
/*************************  设备管理开始 ****************************/
    //设备列表
	public function index()
    {
       $bread = array(
            '0' => array(
                'name' => '设备管理',
                'url' => url('shop/Device/index'), 
            ), 
            '1' => array(
                'name' => '设备列表',
                'url' => url('shop/Device/index'), 
            ), 
        );
        $this->assign('breadhtml', $this->getBread($bread));
        $title  = trim(input('title'));
        $macno  = trim(input('macno'));
        $address= trim(input('address'));
        $shop_id= input('shop_id');
        $status = input('status');
        $page   = input('page')? : 1;
        $size   =  self::$MMS['set']['pagesize']?:20;
        $map    = [];
        if($title){
            $map['a.title'] = ['like','%'.$title.'%'];
            $this->assign('title',$title);
        }
        if($address){
            $map['b.address'] = ['like','%'.$address.'%'];
            $this->assign('address',$address);
        }
        if($macno){
            $map['a.macno'] = ['like','%'.$macno.'%'];
            $this->assign('macno',$macno);
        }
        if($shop_id){
            $map['a.shop_id'] = $shop_id;
            $this->assign('shop_id',$shop_id);
        }
        if($status){
            if($status == '-1'){
                 $map['a.status'] = 0;
            }else{
                $map['a.status'] = $status;
            }
            $this->assign('status',$status);
        }

        $map['a.shop_id']=$this->id;

        $join = [['network b','b.network_id = a.network_id','left'],
                 ['shop c','c.shop_id=a.shop_id','left'],
                 ['user d','d.user_id=a.user_id','left']];
        $field= ['a.*,b.address,c.user_name,d.username'];
        $order= 'a.ctime desc';
		$result = Db::name('device')->alias('a')
                ->join($join)->where($map)
                ->order($order)->page($page,$size)
                ->field($field)->select();

        $count = Db::name('device')->alias('a')
                ->join($join)
                ->where($map)
                ->count();
        foreach ($result as $key => $value) { 
            $where['device_id'] = $value['device_id'];
            $result[$key]['inventory']      = Db::name('device_goods')->where($where)->sum('inventory') ? : 0;  //剩余商品库存
            $money = Db::name('device_goods')->where($where)->select();
            $inventoryMoney = 0;
            foreach ($money as $k => $v) {
                $inventoryMoney += ($v['price'] * $v['inventory']);
            }
             $open1 = Db::name('device_order')->where(['device_id'=>$value['device_id'],'status'=>3])->count();
            $open2 = Db::name('order')->where(['device_id'=>$value['device_id'],'status'=>3])->count();
            $result[$key]['open_num'] = $open1 + $open2;
            $result[$key]['inventoryMoney'] = $inventoryMoney;                                            //剩余商品价值总金额
            // $result[$key]['sales']          = Db::name('order')->where([$where])->sum('num');             //售买的商品数量
            $result[$key]['salesMoney']     = Db::name('order')->where($where)->sum('total_price') ? : '0.00';     //售买的商品总金额
            $result[$key]['salesPMoney']    = Db::name('order')->where($where)->sum('pay_price') ? : '0.00';       //售买的商品支付总金额
            $result[$key]['salesDMoney']    = Db::name('order')->where($where)->sum('discount_money') ? : '0.00';  //售买的商品优惠总金额
            $ntime = time();

            if($ntime - $value["htime"]<60){
                //write_log('online',"心跳返回结果：在线");
                $result[$key]['line']="<font color='#99CC33'>在线</font>";
            }else{
                $result[$key]['line']= "<font color='#FF3366'>离线</font>";
                //write_log('online',"心跳返回结果：未在线");
            }

//
//            $dataarr['macno']='com.dlc.thinkingvalley_'.$value['macno'];
//            $res  = httpPost('http://120.77.72.190/shouhuogui/mac_status',$dataarr);
//            $arr=json_decode($res,true);
//            if($arr['code']==1){
//                $result[$key]['line']='设备在线';
//            }else{
//                $result[$key]['line']='设备离线';
//            }
            $result[$key]['ss'] = "http://sdxddshg.app.xiaozhuschool.com/wxsite/public/shareQrcode?device_number=".$value['macno'];
        }
        $shop = Db::name('shop')->select();
        $this->getPage($count, $size, 'App-loader', '设备列表', 'App-search');
        $this->assign('empty','<tr><td colspan="12" style="line-height:32px;text-align:center;">暂无数据！</td></tr>');
        $this->assign('result',$result);
        $this->assign('p',$page);
        $this->assign('shop',$shop);
        $this->assign('date',date('Y-m-d'));
		echo $this->fetch('');
    }
    //设备对接rfid差距列表
    public function deviceError()
    {
        $id = input('device_id');
        $p  = input('page');
        $bread = array(
            '0' => array(
                'name' => '设备管理',
                'url' => url('shop/Device/index'),
            ),
            '1' => array(
                'name' => '设备对接rfid差距列表',
                'url' => url('shop/Device/deviceError'),
            ),
        );
        $page = input('p') ? : 1;
        $size = 20;
        $title= input('title');
        if($title){
            $map['c.title'] = ['like','%'.$title.'%'];
            $this->assign('title',$title);
        }
        $rfid= input('rfid');
        if($rfid){
            $map['a.rfid'] = ['like','%'.$rfid.'%'];
            $this->assign('rfid',$rfid);
        }
        $this->assign('breadhtml', $this->getBread($bread));

        $result = Db::name('device_error')->alias('a')
            ->join('dlc_goods c','c.goods_id=a.goods_id','left')
            ->where($map)
            ->field('a.*,c.title')
            ->order('error_id desc')
            ->page($page,$size)->select();

        $count = Db::name('device_error')->alias('a')
            ->join('dlc_goods c','c.goods_id=a.goods_id','left')
            ->where($map)->count();
        $this->getPage($count, $size, 'App-loader', '所属商品', 'App-search');
        $this->assign('empty','<tr><td colspan="9" style="line-height:32px;text-align:center;">暂无数据！</td></tr>');
        $this->assign('result',$result);
        $this->assign('pages',$p);
        $this->assign('device_id',$id);
        echo $this->fetch();
    }
//
    public function errorrfid(){
        $bread = array(
            '0' => array(
                'name' => '查看异常rfid商品',
                'url' => url('dlc/Device/errorrfid'),
            ),

        );
        $page = input('page') ? : 1;
        $size = 20;
        $rfid= input('rfid');
        $where['a.rfid']=['in',$rfid];

        $list= db('rfid')->alias('a')->join('dlc_goods b','b.goods_id=a.goods_id','left')->where($where)->field('a.*,b.title,b.img')->page($page,$size)->select();
        foreach ($list as $k=>$v){
            $list[$k]['img']=   $this->url.$v['img'];
        }
        $count= db('rfid')->alias('a')->join('dlc_goods b','b.goods_id=a.goods_id','left')->where($where)->count();
        $this->getPage($count, $size, 'App-loader', '所属商品', 'App-search',['rfid'=>$rfid]);
        $this->assign('empty','<tr><td colspan="9" style="line-height:32px;text-align:center;">暂无数据！</td></tr>');
        $this->assign('list',$list);

        echo $this->fetch();
    }
    /*
    * 获取版本更新
    */
    public function updateversion(){
        $macno= input('macno');
        if(empty($macno)){
            $info['status'] = 0;
            $info['msg'] = '设备号不能为空';
            return($info);
        }
        $device = Db::name('device')->where(['macno'=>$macno])->find();
        if ($device['htime']+60<time()){
            $info['status'] = 0;
            $info['msg'] = '该设备不在线，不能更新！';
            return($info);
        }

        $where['macno']=$macno;
        $where['doorstatus']=['<>',0];
        $where['open_status']=['<>',3];

        $find= db('device')->where($where)->find();
        if($find){
            $info['status'] = 0;
            $info['msg'] = '该设备有人正在使用，不能更新！';
            return($info);
        }
        $mqtt = new \app\apk\controller\IndexController();
        $json = '{"update":"manager"}';
        $client_id = time();
        $mqtt->publish($macno,$json,2,$client_id);
        $info['status'] = 1;
        $info['msg'] = '发送更新指令成功';
        return($info);
    }
    //设备生成补货清单
    public function createRecord(){
        $device_id= input('device_id');
        $find= db('device_order')->where(array('device_id'=>$device_id,'status'=>3))->order('ctime desc')->limit(1)->find();//查找出最近一次确认补货的时间
        //查找补货时间到当前时间中产生的用户未付款和已支付的订单
        db()->startTrans();
        if($find){
            $where['a.status']=['in',[2,3]];
            $where['a.device_id']=$device_id;
            $where['a.ctime']=['between',[$find['ctime'],time()]];
            $orderlist= db('order')->alias('a')->join('dlc_order_info b','a.order_id=b.order_id','left')->where($where)->field('b.goods_id,b.num')->select();//查找子订单下的商品
            if($orderlist){
                $data['device_id']=$device_id;
                $data['shop_id']=$find['shop_id'];
                $data['ctime']=time();
                $rid= db('device_record')->insertGetId($data);
                $data1['record_id']=$rid;
                $data1['ctime']=$data['ctime'];
                foreach ($orderlist as $k=>$v){
                    $data1['goods_id']=$v['goods_id'];
                    $data1['num']=$v['num'];
                    db('device_recordinfo')->insert($data1);
                    db()->commit();
                }
                $info['status'] =1 ;
                $info['msg'] = '生成补货清单成功';
                return($info);
            }else{
                db()->rollback();
                $info['status'] =0 ;
                $info['msg'] = '没有用户购物生成失败';
                return($info);
            }
        }else{
            db()->rollback();
            $info['status'] = 0;
            $info['msg'] = '没有补货记录';
            return($info);
        }

    }
    //查看生成的补货清单
    public function devicerecord(){
        $bread = array(
            '0' => array(
                'name' => '设备销售清单',
                'url' => url('dlc/Device/deviceRecord'),
            ),

        );
        $this->assign('breadhtml', $this->getBread($bread));
        $p  = input('page');
        $device_id= input('device_id');
        $page = input('p') ? : 1;
        $size = 20;
        $list= db('device_record')->where('device_id',$device_id) ->page($page,$size)
            ->order('ctime desc ')->select();

        $count= db('device_record')->where('device_id',$device_id) ->count();
        foreach ($list as $k=>$v){
            $where['a.record_id']=$v['record_id'];
            $list[$k]['goodslist'] =  db('device_recordinfo')->alias('a')->join('dlc_goods b','b.goods_id=a.goods_id','left')->where($where)->field('b.title,a.num,a.goods_id')->select();
        }
        $this->getPage($count, $size, 'App-loader', '设备销售清单', 'App-search');
        $this->assign('empty','<tr><td colspan="9" style="line-height:32px;text-align:center;">暂无数据！</td></tr>');
        $this->assign('list',$list);
        $this->assign('pages',$p);
        $this->assign('device_id',$device_id);
        echo $this->fetch();
    }
    public function uploadlog(){
        $macno= input('macno');
        $mqtt = new \app\apk\controller\IndexController();
        $json = '{"uploadFile":"manager"}';
        $client_id = time();
        $mqtt->publish($macno,$json,2,$client_id);
        $info['status'] = 1;
        $info['msg'] = '上传成功';
        return($info);
    }
    public function updateBanner(){
        $macno= input('macno');
        if(empty($macno)){
            $info['status'] = 0;
            $info['msg']    = '设备号不能为空';
            return($info);
        }
       $find= db('device')->where('macno',$macno)->find();
       $device_order= db('device_order')->where(array('device_id'=>$find['device_id'],'status'=>array('in',['1','2'])))->select();
       if($device_order){
           $info['status'] =0;
           $info['msg'] = '有员工正在补货，不能发生该指令!!';
           return($info);
       }

      $order= db('order')->where(array('device_id'=>$find['device_id'],'status'=>1))->select();
       if($order){
           $info['status'] =0;
           $info['msg'] = '有用户正在购买商品，不能发生该指令！！';
           return($info);
       }
        if($find['doorstatus'] === 1 && $find['open_status'] === 1) {
            $info['status'] =0;
            $info['msg'] = '设备还未关门，请先关门';
            return($info);
        }
        $arr['type']=7;
        $arr['notify_url']='http://sdxddshg.app.xiaozhuschool.com/wxsite/Public/get_open_arr';
        $arr['order_number']='';
        $json_str=json_encode($arr,true);
        $data['macno'] = 'com.dlc.thinkingvalley_'.$macno;
        $data['version'] = 3;
        $data['sign'] = md5('dlcshouhuogui');
        $data['data']=$json_str;
        $res  = httpPost('http://10.27.204.40/shouhuogui/n_operate',$data);
        $res = json_decode($res,true);
        write_log('banner','发送数据--'.json_encode($res,true));
        write_log('banner','发送数据--'.json_encode($data,true));
//        $info['status'] =1;
//        $info['msg'] = '更新成功';
//        return($info);
        if($res['code']==1){
            $info['status'] =1;
            $info['msg'] = '更新成功';
//        die(json_encode($info,true));
            return($info);
        }else{
            $info['status'] =0;
            $info['msg'] = '更新失败';
//        die(json_encode($info,true));
            return($info);
        }
    }
    public function bindingDevice()
    {

    }
	
    //设备新增或修改
    public function set()
    {
        $id = input('device_id');
        $p  = input('p');
        $bread = array(
            '0' => array(
                'name' => '设备管理',
                'url' => url('shop/Device/index'), 
            ), 
            '1' => array(
                'name' => $id ? '设备编辑' : '设备列表',
                'url' => url('shop/Device/index?device_id='.$id), 
            ), 
        );
        $this->assign('breadhtml', $this->getBread($bread));
        if($_POST){
            $post = input('post.');
            if($id){
                unset($post['device_id']);
                $post['qrcode'] = 'http://' . $_SERVER['HTTP_HOST'] . '/wxsite/order/staffRQCode?macno='.$post['macno'];
                $res = Db::name('device')->where(['device_id'=>$id])->update($post);
            }else{
                $post['qrcode'] = 'http://' . $_SERVER['HTTP_HOST'] . '/wxsite/order/staffRQCode?macno='.$post['macno'];
                $post['ctime'] = time();
                $res = Db::name('device')->insert($post);
            }
            if (FALSE !== $res) {
                $info['status'] = 1;
                $info['msg'] = '设置成功！';
            } else {
                $info['status'] = 0;
                $info['msg'] = '设置失败！';
            }
            return($info);
        }
        if($this->type==1){
            $shop = Db::name('shop')->where('shop_id',$this->id)->find();
        }else{
            $shop = Db::name('user')->where('user_id',$this->id)->find();
        }

        $result = Db::name('device')->alias('a')
                ->join('shop b ','b.shop_id=a.shop_id','left')
                ->join('network c','c.network_id = a.network_id')
                ->where(['a.device_id'=>$id])
                ->field('a.*,c.title as network_name')->find();
                // var_dump($result);
                //  var_dump($id);
        $this->assign('result',$result);
        $this->assign('device_id',$id);
        $this->assign('p',$p);
        $this->assign('shop',$shop);
        echo $this->fetch('set'); 
    }
    public function setStatus(){
        $device_id= input('device_id');
        if(empty($device_id)){
            $info['status'] = 0;
            $info['msg']    = '设备id不能为空';
            return($info);
        }
//         var_dump($macno);die;
//	   $find= db('device')->where('device_id',$device_id)->find();
//	  if(empty($find)){
//          $info['status'] = 0;
//          $info['msg'] = '没有该设备';
//          return($info);
//      }
        db('device')->where('device_id',$device_id)->update(['doorstatus'=>0,'open_status'=>3,'status'=>0]);
        $info['status'] =1;
        $info['msg'] = '重置成功';
//        die(json_encode($info,true));
        return($info);

    }
    //设备删除
    public function del()
    {
        $id = input('device_id');
        if(empty($id)){
            $info['status'] = 0;
            $info['msg']    = 'ID不能为空';
            return($info);
        }
        $res1 = Db::name('device')->where(['device_id'=>['in',$id]])->delete();
        $res2 = Db::name('device_goods')->where(['device_id'=>['in',$id]])->delete();
        if($res1 !== false && $res2 !== false){
            $info['status'] = 1;
            $info['msg']    = '删除设备成功';
        }else{
            $info['status'] = 0;
            $info['msg']    = '删除设备失败';
        }
        return($info);
    }


    //设备所属商品列表
    public function goods()
    {
        $id = input('device_id');
        $p  = input('page');
        $bread = array(
            '0' => array(
                'name' => '设备管理',
                'url' => url('shop/Device/index'), 
            ), 
            '1' => array(
                'name' => '所属商品',
                'url' => url('shop/Device/goods'), 
            ), 
        );
        $page = input('p') ? : 1;
        $size = 20;
        $title= input('title');
        if($title){
            $map['c.title'] = ['like','%'.$title.'%'];
            $this->assign('title',$title);
        }
        $this->assign('breadhtml', $this->getBread($bread));
        $map['a.device_id'] = $id;
        $map['a.inventory'] = ['<>',0];
        $result = Db::name('device_goods')->alias('a')
                  ->join('goods c','c.goods_id=a.goods_id','left')
                  ->where($map)
                  ->field('a.*,c.img,c.title')
                  ->page($page,$size)->select();
        $count = Db::name('device_goods')->alias('a')
                  ->join('goods c','c.goods_id=a.goods_id','left')
                  ->where($map)->count();
        $shop = Db::name('shop')->select();
        $this->getPage($count, $size, 'App-loader', '所属商品', 'App-search');
        $this->assign('empty','<tr><td colspan="9" style="line-height:32px;text-align:center;">暂无数据！</td></tr>');
        $this->assign('result',$result);
        $this->assign('pages',$p);
        $this->assign('device_id',$id);
        echo $this->fetch();
    }


    //修改设备商品单价
    public function updateGoods()
    {
        $id = input('device_id');
        $p  = input('page');
        $device_goods_id = input('device_goods_id');
        if(empty($device_goods_id)){
            $info['status'] = 0;
            $info['msg']    = 'ID不能为空';
            return($info);
        }
        $bread = array(
            '0' => array(
                'name' => '设备管理',
                'url' => url('shop/Device/index'), 
            ), 
            '1' => array(
                'name' => '编辑设备商品单价',
                'url' => url('shop/Device/updateGoods'), 
            ), 
        );
        $this->assign('breadhtml', $this->getBread($bread));
        if($_POST){
            $post = input('post.');
            $res = Db::name('device_goods')->where('device_goods_id',$device_goods_id)->update(['price'=>$post['price']]);
            if($res !== false ){
                $info['status'] = 1;
                $info['msg']    = '编辑设备商品单价成功';
            }else{
                $info['status'] = 0;
                $info['msg']    = '编辑设备商品单价失败';
            }
            return($info);
        }
        $result = Db::name('device_goods')->where('device_goods_id',$device_goods_id)->find();
        $this->assign('result',$result);
        $this->assign('pages',$p);
        $this->assign('device_id',$id);
        $this->assign('device_goods_id',$device_goods_id);
        echo $this->fetch('updateGoods');
    }

    //设备订单列表
    public function order()
    {
        $id = input('device_id');
        $p  = input('page');

//        if(empty($id)){
//            $info['status'] = 0;
//            $info['msg']    = 'ID不能为空';
//            return($info);
//        }
        $bread = array(
            '0' => array(
                'name' => '设备管理',
                'url' => url('shop/Device/index'), 
            ), 
            '1' => array(
                'name' => '设备订单列表',
                'url' => url('shop/Device/updateGoods'), 
            ), 
        );
        $this->assign('breadhtml', $this->getBread($bread));
        $page         = input('page')? : 1;
        $username     = trim(input('username'));
        $order_number = input('order_number');
        $pay_type     = input('pay_type');
        $status       = input('status');
        $size = 20;
        $start = input('start');
        $end   = input('end');
        if($end){
            $endT = $end.' 23:59:59';
        }
        if($end && $start){
            $map['a.ctime']=array("between",array(strtotime($start),strtotime($endT)));
            $this->assign('start',$start);
            $this->assign('end',$end);
        }elseif($end){
            $map['a.ctime'] = ['lt',strtotime($endT)];
            $this->assign('end',$end);
        }elseif($start){
            $map['a.ctime'] = ['gt',strtotime($start)];
            $this->assign('start',$start);
        }else{}
        if($username){
            $map['c.nickname'] = ['like','%'.$username.'%'];
            $this->assign('username',$username);
        }
        if($order_number){
            $map['a.order_number'] = ['like','%'.$order_number.'%'];
            $this->assign('order_number',$order_number);
        }
        if($pay_type){
            $map['a.pay_type'] = $pay_type;
            $this->assign('pay_type',$pay_type);
        }
        if($status){
            $map['a.status'] = $status;
            $this->assign('status',$status);
        }
        $map['a.device_id'] = $id;
        $map['a.pay_type'] = 1;
//        $map['a.num'] = ['<>',0];
        $result = Db::name('order')->alias('a')
                 ->join('device b','b.device_id=a.device_id','left')
                 ->join('user c','c.user_id=a.user_id','left')
                 ->field('a.*,b.macno,c.nickname')
                 ->where($map)->page($page,$size)->order('a.order_id desc')->select();
        $count = Db::name('order')->alias('a')
                 ->join('device b','b.device_id=a.device_id','left')
                 ->join('user c','c.user_id=a.user_id','left')
                 ->where($map)->count();
        foreach ($result as $key => $value) {
            $goods = Db::name('order_info')->alias('a')
                    ->join('goods b','b.goods_id=a.goods_id','left')
                    ->where(['order_id'=>$value['order_id']])->field('a.*,b.title')->select();
            $result[$key]['goods'] = $goods;
            $result[$key]['qrcode'] = "http://sdxddshg.app.xiaozhuschool.com/Dlc/Device/shareQrcode?device_number=".$value['macno'];
        }
        $this->getPage($count, $size, 'App-loader', '设备订单列表', 'App-search',['device_id'=>$id]);
        $this->assign('empty','<tr><td colspan="15" style="line-height:32px;text-align:center;">暂无数据！</td></tr>');
        $this->assign('result',$result);
        $this->assign('pages',$p);
        $this->assign('device_id',$id);
        echo $this->fetch();
    }

    public function shareQrcode($device_number,$type='string'){
        if(!$device_number) {
            $device_number=input('post.device_number');
        }
        $text=$device_number;
        vendor("phpqrcode.phpqrcode");
        $errorCorrectionLevel = "H";
        $matrixPointSize = "8";
        ob_clean();//这个一定要加上，清除缓冲区
        if($type == 'string'){
            ob_start();
        }
        $url='http://'.$_SERVER['HTTP_HOST'].'/h5/dist/#/scan?macno='.$device_number;
        \QRcode::png($url, false, $errorCorrectionLevel, $matrixPointSize, 4, false);
        if($type == 'string'){
            $image = ob_get_contents();
            ob_end_clean();
            if($text){
                $im = imagecreatefromstring($image);
                $width = imagesx($im);
                $height = imagesy($im);
                $newimg = imagecreatetruecolor($width, $height + 20);
//                $newbg = imagecolorallocatealpha($newimg, 0, 0, 0, 127);
//                imagealphablending($newimg, false);
//                imagefill($newimg, 0, 0, $newbg);
                imagefill($newimg, 0, 0, imagecolorallocate($newimg, 255, 255, 255));//白色背景
                imagecopyresampled($newimg, $im, 0, 0, 0, 0, $width, $height, $width, $height);
                $fontfile = './public/texb.ttf';
                $fontinfo = imagettfbbox(18, 0, $fontfile, $text);
                $fontwidth = abs($fontinfo[4] - $fontinfo[0]);
                //$fontheight = abs($fontinfo[5] - $fontinfo[1]);
                imagefttext($newimg, 18, 0, floor(($width - $fontwidth) / 2), $height, imagecolorallocate($newimg, 0, 0, 0), $fontfile, $text);
                imagesavealpha($newimg, true);
                ob_start();
                imagepng($newimg);
                $image = ob_get_contents();
                //ob_end_clean();
            }

            return $image;
        }
    }
    //所有设备故障列表
    public function fault()
    {
        $bread = array(
            '0' => array(
                'name' => '设备管理',
                'url' => url('shop/Device/index'), 
            ), 
            '1' => array(
                'name' => '设备故障列表',
                'url' => url('shop/Device/fault'), 
            ), 
        );
        $this->assign('breadhtml', $this->getBread($bread));
        $page = input('page') ? :1;
        $size =  self::$MMS['set']['pagesize']?:20;
        $username = trim(input('username'));
        $macno    = trim(input('macno'));
        if($username){
            $map['b.username'] = ['like','%'.$username.'%'];
            $this->assign('username',$username);
        }
        if($macno){
            $map['a.macno'] = ['like','%'.$macno.'%'];
            $this->assign('macno',$macno);
        }
        if($this->type==1){
            $map['a.shop_id']=$this->id;
        }else{
            $device_id = Db::name('device')->where(['user_id'=>$this->id])->field('macno')->select();
            $device_ids = implode(',',$device_id);
            $map['a.macno'] = ['in',$device_ids];
        }
        $result = Db::name('device_fault')->alias('a')
                 ->join('user b','b.user_id=a.user_id','left')
                 ->field('a.*,b.username')->where($map)
                 ->page($page,$size)->order('a.ctime desc')->select();
        foreach ($result as $key => $value) {
            if($value['img'] != ''){
                $img = explode(',',$value['img']);
                $result[$key]['img'] = $img;
            }
        }
        $count = Db::name('device_fault')->alias('a')
                 ->join('user b','b.user_id=a.user_id','left')
                 ->field('a.*,b.username')->where($map)->count();
        $this->getPage($count, $size, 'App-loader', '设备列表', 'App-search');
        $this->assign('empty','<tr><td colspan="9" style="line-height:32px;text-align:center;">暂无数据！</td></tr>');
        $this->assign('result',$result);
        echo $this->fetch('');
    } 

    //删除设备故障列表
    public function faultDel()
    {
        $id = input('fault_id');
        if(empty($id)){
            $info['status'] = 0;
            $info['msg']    = 'ID不能为空';
            return($info);
        }
        $res1 = Db::name('device_fault')->where(['fault_id'=>['in',$id]])->delete();
        if($res1 !== false){
            $info['status'] = 1;
            $info['msg']    = '删除设备成功';
        }else{
            $info['status'] = 0;
            $info['msg']    = '删除设备失败';
        }
        return($info);
    }

    //所有设备补货列表
    public function replenishment()
    {
        $bread = array(
            '0' => array(
                'name' => '设备管理',
                'url' => url('shop/Device/index'), 
            ), 
            '1' => array(
                'name' => '设备补货列表',
                'url' => url('shop/Device/fareplenishmentult'), 
            ), 
        );
        $this->assign('breadhtml', $this->getBread($bread));
        $page = input('page') ? :1;
        $size =  self::$MMS['set']['pagesize']?:20;
        $staff_type = input('staff_type');
        $macno    = trim(input('macno'));
        $username    = trim(input('username'));
        $order_number    = trim(input('order_number'));
        $status   = input('status');
        if($staff_type){
            $map['a.staff_type'] = $staff_type;
            $this->assign('username',$staff_type);
        }
        if($status){
            $map['a.status'] = $status;
            $this->assign('status',$status);
        }
        if($macno){
            $map['c.macno'] = ['like','%'.$macno.'%'];
            $this->assign('macno',$macno);
        }
        if($username){
            $map['d.username'] = ['like','%'.$username.'%'];
            $this->assign('username',$username);
        }
        if($order_number){
            $map['a.order_number'] = ['like','%'.$order_number.'%'];
            $this->assign('order_number',$order_number);
        }
//        if($this->type==1){ //商家
//            $map['a.staff_id']=$this->id;
//            $map['a.staff_type'] = 2;
//        }elseif ($this->type==2){ //员工
//            $map['a.staff_id']=$this->id;
//            $map['a.staff_type'] = 1;
//        }
        $map['a.shop_id']=$this->id;
        $result = Db::name('device_order')->alias('a')
                  ->join('shop b','b.shop_id=a.shop_id','left')
                  ->join('device c','c.device_id=a.device_id','left')
                  ->join('user d','d.user_id=a.staff_id','left')
                  ->field('a.*,b.user_name,c.macno,d.username,c.title')
                  ->order('a.ctime desc')
                  ->where($map)
                  ->page($page,$size)->select();
        $count = Db::name('device_order')->alias('a')
                  ->join('shop b','b.shop_id=a.shop_id','left')
                  ->join('device c','c.device_id=a.device_id','left')
                  ->join('user d','d.user_id=a.staff_id','left')
                  ->field('a.*,b.user_name,c.macno,d.username')
                  ->where($map)->count();
        foreach ($result as $key => $value) {
            $goods = Db::name('device_orderinfo')->alias('a')
                     ->join('goods b','b.goods_id=a.goods_id','left')
                     ->where('order_id',$value['order_id'])
                     ->field('a.*,b.title,b.img,b.price')
                     ->select();
            $result[$key]['goods'] = $goods;
        }
        $this->getPage($count, $size, 'App-loader', '设备补货列表', 'App-search');
        $this->assign('empty','<tr><td colspan="13" style="line-height:32px;text-align:center;">暂无数据！</td></tr>');
        $this->assign('result',$result);
        echo $this->fetch('');  
    }

    //删除所有设备补货列表
    public function replenishmentDel()
    {
        $id = input('id');
        if(empty($id)){
            $info['status'] = 0;
            $info['msg']    = 'ID不能为空';
            return($info);
        }
        $res1 = Db::name('device_order')->where(['order_id'=>['in',$id]])->delete();
        $res2 = Db::name('device_orderinfo')->where(['order_id'=>['in',$id]])->delete();
        if($res1 !== false  && $res2 !== false){
            $info['status'] = 1;
            $info['msg']    = '设备补货成功';
        }else{
            $info['status'] = 0;
            $info['msg']    = '设备补货失败';
        }
        return($info);
    }

    //网点列表
    public function network()
    {
        $bread = array(
            '0' => array(
                'name' => '设备管理',
                'url' => url('shop/Device/index'), 
            ), 
            '1' => array(
                'name' => '网点列表',
                'url' => url('shop/Device/network'), 
            ), 
        );
        $this->assign('breadhtml', $this->getBread($bread));
        $title  = trim(input('title'));
        $address= trim(input('address'));
        $shop_id= input('shop_id');
        $page   = input('page')? : 1;
        $size   =   self::$MMS['set']['pagesize']?:20;
        $map    = [];
        if($title){
            $map['a.title'] = ['like','%'.$title.'%'];
            $this->assign('title',$title);
        }
        if($address){
            $map['a.address'] = ['like','%'.$address.'%'];
            $this->assign('address',$address);
        }
        if($shop_id){
            $map['a.shop_id'] = $shop_id;
            $this->assign('shop_id',$shop_id);
        }
        if($this->type==1){
            $map['a.shop_id'] = $this->id;
        }
        $field= ['a.*,b.user_name ,c.name as p_name,d.name as c_name,e.name as a_name'];
        $order= 'a.ctime desc';
        $result = Db::name('network')->alias('a')
                ->join('shop b','b.shop_id=a.shop_id','left')
                ->join('location c','c.location_id=a.province','left')
                ->join('location d','d.location_id=a.city','left')
                ->join('location e','e.location_id=a.area','left')
                ->where($map)
                ->order($order)->page($page,$size)
                ->field($field)->select();

        $count =  Db::name('network')->alias('a')
                ->join('shop b','b.shop_id=a.shop_id','left')
                ->join('location c','c.location_id=a.province','left')
                ->join('location d','d.location_id=a.city','left')
                ->join('location e','e.location_id=a.area','left')
                ->where($map)
                ->order($order)->count();
        $shop = Db::name('shop')->select();
        $this->getPage($count, $size, 'App-loader', '网点列表', 'App-search');
        $this->assign('empty','<tr><td colspan="9" style="line-height:32px;text-align:center;">暂无数据！</td></tr>');
        // echo '<pre>';
        // print_r($result);
        $this->assign('result',$result);
        $this->assign('p',$page);
        $this->assign('shop',$shop);
        echo $this->fetch('network');
    }

    //新增/编辑网点
    public function networkSet()
    {   
        $id = input('id');
        $p  = input('p');
        $bread = array(
            '0' => array(
                'name' => '设备管理',
                'url' => url('shop/Device/index'), 
            ), 
            '1' => array(
                'name' => $id? '编辑网点' : '新增网点',
                'url' => url('shop/Device/networkSet?id='.$id), 
            ), 
        );
        if($_POST){
            if($id){
                $data = input('post.');
                unset($data['id']);
                $re = Db::name('network')->where('network_id',$id)->update($data);
                // $rs = Db::name('device')->where('network_id',$id)->update(['shop_id'=>$data['shop_id']]);
            }else{
                $data = input('post.');
                $data['ctime'] =  time();
                unset($data['id']);
                $re = Db::name('network')->insert($data);
            }
            if($re !== false){
                $info['status'] = 1;
                $info['msg']    = $id ? '编辑网点成功':'添加网点成功';
            }else{
                $info['status'] = 0;
                $info['msg']    =  $id ? '编辑网点失败':'添加网点失败';
            }
            return($info);
        }
        $shop = Db::name('shop')->select();
        $result=Db::name('network')->alias('a')
                ->join('location c','c.location_id=a.province','left')
                ->join('location d','d.location_id=a.city','left')
                ->join('location e','e.location_id=a.area','left')
                ->field(['a.*,c.name as p_name,d.name as c_name,e.name as a_name'])
                ->where('network_id',$id)->find();
        $province= Db::name('location')->where('pid',0)->select();
        $this->assign('breadhtml', $this->getBread($bread));
        $this->assign('result',$result);
        $this->assign('province',$province);
        $this->assign('p',$p);
        $this->assign('id',$id);
        $this->assign('shop',$shop);
        echo $this->fetch('networkSet');
    }

    //删除网点
    public function networkDel()
    {
        $id = input('id');
        if(empty($id)){
            $info['status'] = 0;
            $info['msg']    = 'ID不能为空';
            return($info);
        }
        $res1 = Db::name('network')->where(['network_id'=>['in',$id]])->delete();
        $res2 = Db::name('device')->where(['network_id'=>['in',$id]])->update(['shop_id'=>'-1','network_id'=>0]);
        if($res1 !== false  && $res2 !== false){
            $info['status'] = 1;
            $info['msg']    = '删除网点成功';
        }else{
            $info['status'] = 0;
            $info['msg']    = '删除网点失败';
        }
        return($info); 
    }

    //获取城市信息
    public function city()
    {
        $id = input('pid');
        if(empty($id)){
            $info['status'] = 0;
            $info['msg']    = 'ID不能为空';
           $this->ajaxReturn($info);
        }
        $city =Db::name('location')->where('pid',$id)->select();
        return($city);
    }

    //获取区县信息
    public function cityAare()
    {
        $id = input('pid');
        if(empty($id)){
            $info['status'] = 0;
            $info['msg']    = 'ID不能为空';
           $this->ajaxReturn($info);
        }
        $area =Db::name('location')->where('pid',$id)->select();
        return($area);
    }

    //获取网点
    public function networks()
    {   
        $id = input('id');
        if(empty($id)){
            $info['status'] = 0;
            $info['msg']    = 'ID不能为空';
           $this->ajaxReturn($info);
        }
        $network = Db::name('network')->where(['shop_id'=>$id])->select();
        return($network);
    }

    //设备收藏列表
    public function collect()
    {
        $bread = array(
            '0' => array(
                'name' => '帐号管理',
                'url' => url('shop/User/index'), 
            ), 
            '1' => array(
                'name' => '收藏列表',
                'url' => url('shop/Device/collect'), 
            ), 
        );
        $this->assign('breadhtml', $this->getBread($bread));
        $macno  = input('macno');
        $username= input('username');
        $page   = input('p')? : 1;
        $size   =  self::$CMS['set']['pagesize']?:20;
        $map    = [];
        if($macno){
            $map['c.macno'] = ['like','%'.$macno.'%'];
            $this->assign('macno',$macno);
        }
        if($username){
            $map['b.username'] = ['like','%'.$username.'%'];
            $this->assign('username',$username);
        }
        $field= ['a.*,b.username ,c.macno'];
        $order= 'a.ctime desc';
        $result = Db::name('favorite')->alias('a')
                ->join('shop_user b','b.user_id=a.user_id','left')
                ->join('shop_device c','c.device_id=a.device_id','left')
                ->where($map)
                ->order($order)->page($page,$size)
                ->field($field)->select();

        $count =  Db::name('favorite')->alias('a')
                ->join('shop_user b','b.user_id=a.user_id','left')
                ->join('shop_device c','c.device_id=a.device_id','left')
                ->where($map)
                ->order($order)->page($page,$size)
                ->field($field)->count();
        $this->getPage($count, $size, 'App-loader', '收藏列表', 'App-search');
        $this->assign('empty','<tr><td colspan="9" style="line-height:32px;text-align:center;">暂无数据！</td></tr>');
        $this->assign('result',$result);
        $this->assign('p',$page);
        $this->assign('shop',$shop);
        echo $this->fetch('collect');
    }

    //设备收藏删除
    public function collectDel()
    {
        $id = input('id');
        if(empty($id)){
            $info['status'] = 0;
            $info['msg']    = 'ID不能为空';
            return($info);
        }
        $res1 = Db::name('favorite')->where(['id'=>['in',$id]])->delete();
        if($res1 !== false){
            $info['status'] = 1;
            $info['msg']    = '删除成功';
        }else{
            $info['status'] = 0;
            $info['msg']    = '删除失败';
        }
        return($info); 
    }

    //设备绑定员工
    public function binding()
    {
        $page = input('page');
        $device_id = input('device_id');
        $shop_id   = input('shop_id');
        $bread = array(
            '0' => array(
                'name' => '设备管理',
                'url' => url('shop/Device/index'), 
            ), 
            '1' => array(
                'name' => '绑定员工',
                'url' => url('shop/Device/binding'), 
            ), 
        );
        $this->assign('breadhtml', $this->getBread($bread));
        if($_POST){
            $user_id = input('user_id');
            $res = Db::name('device')->where('device_id',$device_id)->update(['user_id'=>$user_id]);
            if($res !== false){
                $info['status'] = 1;
                $info['msg']    = '绑定成功';
            }else{
                $info['status'] = 0;
                $info['msg']    = '绑定失败';
            }
            return($info);
        }
        $result = Db::name('user')->where(['type'=>2,'shop_id'=>['in',['-1',$shop_id]]])->field('username,user_id')->select();
        $this->assign('result',$result);
        $this->assign('shop_id',$shop_id);
        $this->assign('device_id',$device_id);
        $this->assign('page',$page);
        echo $this->fetch('binding');
    }

    //解绑员工 
    public function bindingDel()
    {
        $id = input('id');
        if(empty($id)){
            $ifno['status'] = 0;
            $info['msg'] = '设备ID不能为空';
            return($info);
        }
        $result = Db::name('device')->where('device_id',$id)->update(['user_id'=>0]);
        if($result !== false){
            $info['status'] = 1;
            $info['msg']    = '解绑成功';
        }else{
            $info['status'] = 0;
            $info['msg']    = '解绑失败';
        }
        return($info);
    }

    //设备订单列表
    public function order_list()
    {
        $id = input('device_id');
        $p  = input('page');
        if(empty($id)){
            $info['status'] = 0;
            $info['msg']    = 'ID不能为空';
            return($info);
        }
        $bread = array(
            '0' => array(
                'name' => '设备管理',
                'url' => url('shop/Device/index'),
            ),
            '1' => array(
                'name' => '设备销售列表',
                'url' => url('shop/Device/updateGoods'),
            ),
        );
        $this->assign('breadhtml', $this->getBread($bread));
        $page         = input('p')? : 1;
        $username     = trim(input('username'));
        $order_number = input('order_number');
        $pay_type     = input('pay_type');
        $status       = input('status');
        $start_time       = input('start_time');
        $end_time       = input('end_time');
        $size = 20;
        if($username){
            $map['c.nickname'] = ['like','%'.$username.'%'];
            $this->assign('username',$username);
        }
        if($order_number){
            $map['a.order_number'] = ['like','%'.$order_number.'%'];
            $this->assign('order_number',$order_number);
        }
        if($pay_type){
            $map['a.pay_type'] = $pay_type;
            $this->assign('pay_type',$pay_type);
        }
        if($status){
            $map['a.status'] = $status;
            $this->assign('status',$status);
        }
        if($start_time&&$end_time){
            $map['a.ctime'] = ['between',[strtotime($start_time),strtotime($end_time)]];
        }
        $map['a.device_id'] = $id;
        $map['a.status'] = 3;
        $result = Db::name('order')->alias('a')
            ->join('device b','b.device_id=a.device_id','left')
            ->join('user c','c.user_id=a.user_id','left')
            ->field('a.*,b.macno,c.nickname,b.title')
            ->where($map)->page($page,$size)->order('a.ctime desc')->select();
        $count = Db::name('order')->alias('a')
            ->join('device b','b.device_id=a.device_id','left')
            ->join('user c','c.user_id=a.user_id','left')
            ->where($map)->count();
        $money=0;
        foreach ($result as $key => $value) {
            $goods = Db::name('order_info')->alias('a')
                ->join('goods b','b.goods_id=a.goods_id','left')
                ->where(['order_id'=>$value['order_id']])->field('a.*,b.title')->select();
            $result[$key]['goods'] = $goods;
            $result[$key]['qrcode'] = "http://sdxddshg.app.xiaozhuschool.com/Dlc/Device/shareQrcode?device_number=".$value['macno'];
            $money+=$value['pay_price'];
        }
        $this->getPage($count, $size, 'App-loader', '设备订单列表', 'App-search');
        $this->assign('empty','<tr><td colspan="15" style="line-height:32px;text-align:center;">暂无数据！</td></tr>');
        $this->assign('result',$result);
        $this->assign('pages',$p);
        $this->assign('money',$money);
        $this->assign('summoney',Db::name('order')->alias('a')
            ->join('device b','b.device_id=a.device_id','left')
            ->join('user c','c.user_id=a.user_id','left')
            ->where($map)->sum('a.pay_price'));
        $this->assign('device_id',$id);
        echo $this->fetch();
    }
/*************************  设备管理结束 ****************************/

}