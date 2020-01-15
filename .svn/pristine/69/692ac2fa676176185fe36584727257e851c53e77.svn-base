<?php
namespace app\shop\controller;
/**
 * 马远利
 */
use think\Controller;
use think\Session;
use think\model;
use think\Db;

class StatisticsController extends BaseController
{
	private $id;
    private $type;
    public function _initialize()
    {
        $this->type = Session::get('MMS.type');//子后台登录帐号类型（1：商家 2：员工）
        $aid=Session::get('MMS.uid');
        $this->id=Db::name('shop')->where(['aid'=>$aid])->value('shop_id');
        $this->assign('type',$this->type);
        if(empty($_SESSION['SYS'])){
            self::$CMS['set']=  model('Set')->find();
        }

    }
    
    //设备统计
	public function devicesList()
	{
		//设置面包导航，主加载器请配置
        $bread = array(
            '0' => array(
                'name' => '统计管理',
                'url' => url('shop/Statistics/devicesList'), 
            ), 
			'1' => array(
                'name' => '设备统计',
                'url' => url('shop/Statistics/devicesList'),
            ),
        );
		$this->assign('breadhtml', $this->getBread($bread));
		$string = ''; 
		if($this->type == 1){
			$string .= 'shop_id ='.$this->id;
		}
		$start = input('start');
		$end   = input('end');
		if($end){
			$endT = $end.' 23:59:59';
		}

        $map['shop_id']=$this->id;
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
                $list[$key]['num']  = Db::name('order')->where('device_id='.$value['device_id'])->count();
                $list[$key]['name'] = $device['title'];
                $list[$key]['macno']= $device['macno'];
                $list[$key]['shop_name'] = $shop['user_name'];
            }else{
                unset($list[$key]);
            }
        }
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
            $map['a.device_id']=['in', trim($device_id,',')];
            $this->assign('device_list',trim($device_id,','));

        }

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
        $map['a.shop_id']= $this->id;
        $map['b.status']= 3;

        $where=[];
        $where['title']=['like',"%$title%"];
        if($title){

            $this->assign('title',$title);
        }
        $where['shop_id']=$this->id;

        $device= db('device')->where($where)->field('device_id,macno')->select();
        $total_num=0;
        $total_price=0;
        $result = Db::name('order_info')->alias('a')
            ->join('dlc_goods c','c.goods_id=a.goods_id','left')
            ->join('dlc_order b','b.order_id=a.order_id','left')
            ->where($map)
            ->field('a.*,c.title,sum(a.num) as total_num,sum(a.count_price) as total_price,c.price as goods_price')
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
//        print_r(Db::name('order_info')->alias('a')->getLastSql());
        $totalsum=  Db::name('order_info')->alias('a')
            ->join('dlc_goods c','c.goods_id=a.goods_id','left')
            ->join('dlc_order b','b.order_id=a.order_id','left')
            ->where($map)->sum('a.count_price');
//        print_r( Db::name('order_info')->alias('a')
//            ->join('dlc_goods c','c.goods_id=a.goods_id','left')
//            ->join('dlc_order b','b.order_id=a.order_id','left')
//            ->where($map)->fetchSql()->sum('b.pay_price'));
        $count = Db::name('order_info')->alias('a')
            ->join('dlc_goods c','c.goods_id=a.goods_id','left')
            ->join('dlc_order b','b.order_id=a.order_id','left')
            ->group('a.goods_id')
            ->where($map)->count();
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
        $map['a.shop_id']= $this->id;
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
	//商品统计
	public function eventList()
	{ 
		//设置面包导航，主加载器请配置
        $bread = array(
            '0' => array(
                'name' => '统计管理',
                'url' => url('shop/Statistics/devicesList'),
            ),
			'1' => array(
                'name' => '商品统计',//会员统计
                'url' => url('shop/Statistics/eventList'),
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
        $map['a.shop_id'] = $this->id;
		$field = 'b.title as name,sum(a.num) as goods_num';
		$list = Db::name('order_info')->alias('a')
				->join('dlc_goods b','b.goods_id=a.goods_id')
				->where($map)
				->field($field)
				->group('a.goods_id')
				->order('goods_num desc')
				->limit(20)->select();
		$count = count($list);

        $arr=[];
		if($count < 20){
			for ($i=$count; $i <(20 - $count) ; $i++) { 
				$arr[$i]['name'] = '--';
				$arr[$i]['goods_num'] = 0;
			}
			$list = array_merge($list,$arr);
		}
        $this->assign('list',$list);
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
                'url' => url('shop/Statistics/devicesList'),
            ),
			'1' => array(
                'name' => '收藏统计',//会员统计
                'url' => url('shop/Statistics/collect'),
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
 	
	
}