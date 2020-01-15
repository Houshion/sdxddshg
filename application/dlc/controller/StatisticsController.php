<?php
namespace app\dlc\controller;
/**
 * 马远利
 */
use think\model;
use think\Db;
use think\Request;
class StatisticsController extends BaseController
{

    public function _initialize()
    {
        //你可以在此覆盖父类方法
        parent::_initialize();
    }

    //设备统计
	public function devicesList()
	{
		//设置面包导航，主加载器请配置
        $bread = array(
            '0' => array(
                'name' => '统计管理',
                'url' => url('dlc/Statistics/devicesList'),
            ),
			'1' => array(
                'name' => '设备统计',
                'url' => url('dlc/Statistics/devicesList'),
            ),
        );
		$this->assign('breadhtml', $this->getBread($bread));
		$start = input('start');
		$end   = input('end');
		if($end){
			$endT = $end.' 23:59:59';
		}
		if($end && $start){
			$map['ctime']=array("between",array(strtotime($start),strtotime($endT)));
		}elseif($end){
			$map['ctime'] = ['lt',strtotime($endT)];
		}elseif($start){
			$map['ctime'] = ['gt',strtotime($start)];
		}else{}
		$list = Db::name('order')->where($map)->field('order_id,device_id')->group('device_id')->select();

		// echo '<pre>';
		foreach ($list as $key => $value) {
			$device =  Db::name('device')->where('device_id',$value['device_id'])->find();
			// print_r($device);exit;
			if($device){
				$shop   = Db::name('shop')->where('shop_id='.$device['shop_id'])->find();
				$list[$key]['num']  = Db::name('order')->where('device_id='.$value['device_id'])->count()?:0;

				$list[$key]['name'] = $device['title'];
				$list[$key]['macno']= $device['macno'];
				$list[$key]['shop_name'] = $shop['user_name'];
			}else{
                unset($list[$key]);
            }
		}
//        print_r($list);
		foreach ($list as $k => $v) {
			$key_arrays[]=$v['num'];
		}

		if($key_arrays){
			array_multisort($key_arrays,SORT_DESC,SORT_NUMERIC,$list);
			$count = count($list);
			for($i= 0; $i<=$count;$i++){
				if($i>19){
				    unset($list[$i]);
				}
			}
		}

        $this->assign('list', $list);
        $this->assign('end',$end);
        $this->assign('start',$start);
        echo $this->fetch('devicesList');
	}
 	
	//商品统计
	public function eventList()
	{

		//设置面包导航，主加载器请配置
        $bread = array(
            '0' => array(
                'name' => '统计管理',
                'url' => url('dlc/Statistics/devicesList'),
            ),
			'1' => array(
                'name' => '商品统计',//会员统计
                'url' => url('dlc/Statistics/eventList'),
            ),
        );
		$this->assign('breadhtml', $this->getBread($bread));
		$start = input('start');
		$end   = input('end');
		if($end){
			$endT = $end.' 23:59:59';
		}
		if($end && $start){
			$map['a.ctime']=array("between",array(strtotime($start),strtotime($endT)));
		}elseif($end){
			$map['a.ctime'] = ['lt',strtotime($endT)];
		}elseif($start){
			$map['a.ctime'] = ['gt',strtotime($start)];
		}else{}
        $map['a.status'] =3;

        $shop = Db::name('order')->alias('a')->join('dlc_order_info b','b.order_id=a.order_id','left')->join('dlc_goods c','c.goods_id=b.goods_id','left')->where($map)->field('a.*,sum(b.num) as goods_num,c.title ')->group('b.goods_id')->select();

//		$shop  = Db::name('goods')->select();

		$p = 0;
//		foreach ($shop as $ke => $va) {
//			$shop[$ke]['goods_num'] = 0;
//			foreach ($order as $key => $value) {
//				$num = Db::name('order_info')->where(['order_id'=>$value['order_id'],'goods_id'=>$va['goods_id']])->sum('num') ? : 0;
//				$shop[$ke]['goods_num'] += $num;
//			}
////
//		}
//        var_dump($shop);
//        die;
		$key_arrays = $shop;
		if($key_arrays){
			array_multisort($key_arrays,SORT_DESC,SORT_NUMERIC,$shop);
			$count = count($shop);
			for($i= 0; $i<=$count;$i++){
				if($i>19){
				    unset($shop[$i]);
				}else{
					$shop[$i]['name'] = $shop[$i]['title'];
				}
				
			}
		}
		// echo '<pre>';

        $this->assign('list',$shop);
        $this->assign('end',$end);
        $this->assign('start',$start);
        echo $this->fetch('eventList');
	}
	
	//收藏统计
	public function collect()
	{
		//设置面包导航，主加载器请配置
        $bread = array(
            '0' => array(
                'name' => '统计管理',
                'url' => url('dlc/Statistics/devicesList'),
            ),
			'1' => array(
                'name' => '收藏统计',//会员统计
                'url' => url('dlc/Statistics/collect'),
            ),
        );
		$this->assign('breadhtml', $this->getBread($bread));
		$start = input('start');
		$end   = input('end');
		if($end){
			$endT = $end.' 23:59:59';
		}
		if($end && $start){
			$map['ctime']=array("between",array(strtotime($start),strtotime($endT)));
		}elseif($end){
			$map['ctime'] = ['lt',strtotime($endT)];
		}elseif($start){
			$map['ctime'] = ['gt',strtotime($start)];
		}else{}
		$device  = Db::name('device')->select();
		$p = 0;
		foreach ($device as $ke => $va) {
			$num = Db::name('favorite')->where(['device_id'=>$va['device_id']])->where($map)->count() ? : 0;
			$device[$ke]['goods_num'] = $num;
			
			
		}
		$key_arrays = $device;
		if($key_arrays){
			array_multisort($key_arrays,SORT_DESC,SORT_NUMERIC,$device);
			$count = count($device);
			for($i= 0; $i<=$count;$i++){
				if($i>19){
				    unset($device[$i]);
				}else{
					$device[$i]['name'] = $device[$i]['macno'];
				}
				
			}
		}
		// echo '<pre>';
		// print_r($shop);
        $this->assign('list',$device);
        $this->assign('end',$end);
        $this->assign('start',$start);
        echo $this->fetch('collect');
	}

	//商家统计
	public function shop()
	{
		//设置面包导航，主加载器请配置
        $bread = array(
            '0' => array(
                'name' => '统计管理',
                'url' => url('dlc/Statistics/devicesList'),
            ),
			'1' => array(
                'name' => '商家统计',//会员统计
                'url' => url('dlc/Statistics/shop'),
            ),
        );
		$this->assign('breadhtml', $this->getBread($bread));
		$start = input('start');
		$end   = input('end');
		if($end){
			$endT = $end.' 23:59:59';
		}
		if($end && $start){
			$map['ctime']=array("between",array(strtotime($start),strtotime($endT)));
		}elseif($end){
			$map['ctime'] = ['lt',strtotime($endT)];
		}elseif($start){
			$map['ctime'] = ['gt',strtotime($start)];
		}else{}

		$p = 0;
        $shop  = Db::name('shop')->select();
		foreach ($shop as $ke => $va) {
			$num = Db::name('order_info')->where(['shop_id'=>$va['shop_id']])->where($map)->count('num') ? : 0;
//			$shop[$ke]['goods_num'] = $num;
            if($num==0){
                unset($shop[$ke]);
            }else{
                $shop[$ke]['goods_num'] = $num;
            }

		}


//        $shop  = Db::name('shop')->alias('a')->join('dlc_order_info b','a.shop_id=b.shop_id','left')->field('sum("num") as goods_num,a.*')->group('a.shop_id')->select();
//        print_r($shop);

		$key_arrays = $shop;
//        print_r($key_arrays);

		if($key_arrays){
			array_multisort($key_arrays,SORT_DESC,SORT_NUMERIC,$shop);
//            print_r(count($shop));
			$count = count($shop);
			for($i= 0; $i<$count;$i++){
				if($i>$count){
				    unset($shop[$i]);
				}else{
					$shop[$i]['name'] = $shop[$i]['user_name'];
				}
				
			}
		}
//		print_r($shop);
		// echo '<pre>'`;
		// print_r($shop);
        $this->assign('list',$shop);
        $this->assign('end',$end);
        $this->assign('start',$start);
        echo $this->fetch('shop');
	}
	/*
	 * 销售统计
	 */
	public function saleslist(){
        $p  = input('page');
        $bread = array(
            '0' => array(
                'name' => '销售统计',
                'url' => url('dlc/Statistics/saleslist'),
            ),

        );
         $device_id= input('device_id');
         $map=[];
         if($device_id){
//             var_dump($device_id);
             $map['a.device_id']=['in', trim($device_id,',')];
             $this->assign('device_list',trim($device_id,','));
//             var_dump($map);
//             die;
         }
//        var_dump($device_id);
        $this->assign('breadhtml', $this->getBread($bread));
        $page = input('page') ? : 1;
        $size = self::$CMS['set']['pagesize']?:20;
        $start = input('start');
        $end   = input('end');
        $title   = input('title')?:'';
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
        $map['b.status']= 3;
        $total_num=0;
        $total_price=0;
        $where=[];
        $where['title']=['like',"%$title%"];
        if($title){

            $this->assign('title',$title);
        }
        $device= db('device')->where($where)->field('device_id,macno')->select();
//        print_r($device);
        $result = Db::name('order_info')->alias('a')
            ->join('dlc_goods c','c.goods_id=a.goods_id','left')
            ->join('dlc_order b','b.order_id=a.order_id','left')
            ->where($map)
            ->field('a.*,c.title,sum(a.num) as total_num,sum(a.count_price) as total_price')
            ->group('a.goods_id')
            ->page($page,$size)->select();
        foreach ($result as $k=>$v){
            $total_num +=$v['total_num'];
            $total_price +=$v['total_price'];
        }
       $totalcount= Db::name('order_info')->alias('a')
            ->join('dlc_goods c','c.goods_id=a.goods_id','left')
           ->join('dlc_order b','b.order_id=a.order_id','left')
            ->where($map)->sum('a.num');
        $totalsum=  Db::name('order_info')->alias('a')
            ->join('dlc_goods c','c.goods_id=a.goods_id','left')
            ->join('dlc_order b','b.order_id=a.order_id','left')
            ->where($map)->sum('a.count_price');

//        print_r(Db::name('order_info')->alias('a')
//            ->join('dlc_goods c','c.goods_id=a.goods_id','left')
//            ->join('dlc_order b','b.order_id=a.order_id','left')
//            ->where($map)->fetchSql()->sum('a.count_price'));
        $count = Db::name('order_info')->alias('a')
            ->join('dlc_goods c','c.goods_id=a.goods_id','left')
            ->join('dlc_order b','b.order_id=a.order_id','left')
            ->group('a.goods_id')
            ->where($map)->count();
//        return(array('status' => 1,'msg' => '操作成功'));
//        print_r($result);
        $this->getPage($count, $size, 'App-loader', '销售统计', 'App-search',['title'=>$title,'device_id'=>$device_id,'start'=>$start,'end'=>$end]);
        $this->assign('empty','<tr><td colspan="9" style="line-height:32px;text-align:center;">暂无数据！</td></tr>');
        $this->assign('result',$result);
        $this->assign('device',$device);
        $this->assign('total_num',$total_num);
        $this->assign('total_price',$total_price);
        $this->assign('totalcount',$totalcount);
        $this->assign('totalsum',$totalsum);
        $this->assign('pages',$p);
        echo $this->fetch();
    }
    /*
	 * 当日销售统计
	 */
    public function samedaysales(){
        $p  = input('p');
        $bread = array(
            '0' => array(
                'name' => '当日销售统计',
                'url' => url('dlc/Statistics/samedaysales'),
            ),

        );
        $device_id=  input('device_id');
        $map=[];
        $this->assign('breadhtml', $this->getBread($bread));
        $page = input('page') ? : 1;
        $size = self::$CMS['set']['pagesize']?:20;
        $map['a.ctime']=array("between",array(strtotime(date("Y-m-d"),time()),strtotime(date('Y-m-d'.' 23:59:59'))));

//        print_r( strtotime(date('Y-m-d'.' 23:59:59')));
        if($device_id){
            $map['a.device_id']=$device_id;
        }
        $total_num=0;
        $total_price=0;

        $device= db('device')->field('device_id,macno')->select();
        $result = Db::name('order_info')->alias('a')
            ->join('dlc_goods c','c.goods_id=a.goods_id','left')
            ->where($map)
            ->field('a.*,c.title,sum(a.num) as total_num,sum(a.price) as total_price')
            ->group('a.goods_id')
            ->page($page,$size)->select();

        foreach ($result as $k=>$v){
            $total_num +=$v['total_num'];
            $total_price +=$v['total_price'];
        }

        $totalcount= Db::name('order_info')->alias('a')
            ->join('dlc_goods c','c.goods_id=a.goods_id','left')
            ->where($map)->sum('a.num');
        $totalsum=  Db::name('order_info')->alias('a')
            ->join('dlc_goods c','c.goods_id=a.goods_id','left')
            ->where($map)->sum('a.price');
        $count = Db::name('order_info')->alias('a')
            ->join('dlc_goods c','c.goods_id=a.goods_id','left')
            ->group('a.goods_id')
            ->where($map)->count();
//        print_r($result);
        $this->getPage($count, $size, 'App-loader', '销售统计', 'App-search');
        $this->assign('empty','<tr><td colspan="9" style="line-height:32px;text-align:center;">暂无数据！</td></tr>');
        $this->assign('result',$result);
        $this->assign('device',$device);
        $this->assign('total_num',$total_num);
        $this->assign('total_price',$total_price);
        $this->assign('totalcount',$totalcount);
        $this->assign('totalsum',$totalsum);
        $this->assign('pages',$p);
        echo $this->fetch();
    }
	// public function webList()
	// {
	// 	//设置面包导航，主加载器请配置
 //        $bread = array(
 //            '0' => array(
 //                'name' => '数据统计',
 //                'url' => U('Admin/Statistics/userList'),
 //            ),
	// 		'1' => array(
 //                'name' => '网站统计',
 //                'url' => U('Admin/Statistics/userList'),
 //            ),
 //        );
	// 	$this->assign('breadhtml', $this->getBread($bread));
	// 	$m = M('weiba');
	// 	$where['is_delete'] = 0;
	// 	$list = $m->field('weiba_id,type,count(weiba_id) as sum')->group('type')->order('sum desc')->select();
	// 	$score = 0;
	// 	foreach($list as $k=>$v){
	// 		if($v['type'] == 1){
	// 			$list[$k]['weiba_name'] = '市工商联';
	// 		}elseif($v['type'] == 2){
	// 			$list[$k]['weiba_name'] = '镇工商联';
	// 		}elseif($v['type'] == 3){
	// 			$list[$k]['weiba_name'] = '商会';
	// 		}else{
	// 			$list[$k]['weiba_name'] = '协会';
	// 		}
	// 		$score = $score + $v['sum'];
	// 	}
	// 	foreach($list as $k=>$v){
	// 		$list[$k]['per_score'] = ($v['sum']/$score)*100;
	// 	}
 //        $this->assign('list', $list);
 //        $this->display();
	// }
	
	// //员工统计
	// public function allUserList()
	// {
	// 	//设置面包导航，主加载器请配置
 //        $bread = array(
 //            '0' => array(
 //                'name' => '销售统计',
 //                'url' => U('Admin/Statistics/userList'),
 //            ),
	// 		'1' => array(
 //                'name' => '员工统计',
 //                'url' => U('Admin/Statistics/userList'),
 //            ),
 //        );
	// 	$this->assign('breadhtml', $this->getBread($bread));
	// 	$type = I('type');
	// 	$user = M('user')->where('type=2')->select();
	// 	//获取员工有管理那些设备
	// 	foreach ($user as $key => $value) {
	// 		$num = 0;
	// 		$shop_name = '';
	// 		$device = M('device')->where('user_id='.$value['user_id'])->select();
	// 		//查出员工管理设备的所有销售订单
	// 		foreach ($device as $k => $v) {
	// 			$shop      = M('shop')->where('shop_id='.$v['shop_id'])->find();
	// 			$shop_name = $shop['merchant_name'];
	// 			$order     = M('order')->where('facility_id='.$v['device_id'].' and type=3 and order_type=1')->select();
	// 			//获取员工所管理设备的销售数量
	// 			foreach ($order as $ke => $va) {
	// 				$num += array_sum(explode(',',$va['goods_num']));
	// 			}
	// 		}
	// 		$user[$key]['goods_num'] = $num;
	// 		$user[$key]['shop_name'] = $shop_name;
	// 	}
	// 	foreach ($user as $key => $value) {
	// 		$key_arrays[]=$value['goods_num'];
	// 	}
	// 	array_multisort($key_arrays,SORT_DESC,SORT_NUMERIC,$user);
	// 	$count = count($user);
	// 	for($i= 0; $i<=$count;$i++){
	// 		if($i>9){
	// 		    unset($user[$i]);
	// 		}else{
	// 			$user[$i]['name'] = $user[$i]['username'];
	// 		}	
	// 	}
 //        $this->assign('list', $user);
 //        $this->display();
	// }
}