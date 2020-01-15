<?php
/**
 * Created by PhpStorm.
 * User: 韩令恺
 * Date: 2018/5/19 0019
 * Time: 13:54
 */

namespace app\wxsite\controller;
use \think\Db;

class ShopController extends BaseController
{
    public $appUrl = "";
    public $shop_id;
    public function _initialize()
    {
        $this->appUrl = request()->root(true).'/public/';

        // $this->appUrl = 'http://'.$_SERVER['HTTP_HOST'];
    }



    public function api(){
        $api_name = input('api_name');
        $this->shop_id = $this->get_shop_id();

        if ($api_name){
            switch ($api_name){
                case 'shopLogin':
                    $this->shopLogin(); //商家登录
                    break;
                case 'shopReplenish':
                    $this->shopReplenish(); //商家补货记录列表
                    break;
                case 'shopReplenishDetail':
                    $this->shopReplenishDetail(); //商家补货详情
                    break;
                case 'shopOrderList':
                    $this->shopOrderList(); //商家补货详情
                    break;
                case 'shopOrderDetail':
                    $this->shopOrderDetail(); //商家补货详情
                    break;
                default:
                    $info['code'] = 404;
                    $info['msg'] = '接口不存在';
                    return $info;
                    break;
            }
        }else{
//            $info['code'] = 404;
//            $info['msg'] = '接口不能为空';
//            $info['data'] = $api_name;
//            return $info;
            $this->_return(404,'接口名不能为空',$api_name);
        }
    }


    //商家登录
    public function shopLogin(){
        if (!$_POST['account'] || !$_POST['password']) $this->_return(-1,'缺少参数');

        if (!Db::name('shop')->where(['account'=>$_POST['account']])->find()) $this->_return(-1,'账号不存在');
        //获取商家信息
        $shopInfo = Db::name('shop')->where(['account'=>$_POST['account'],'password'=>md5($_POST['password'])])
                        ->field('shop_id')->find();
        if (!$shopInfo) $this->_return(-1,'密码错误');

        //今日开始时间
        $begintime = strtotime(date('Y-m-d',time()).' 00:00:00');
        //今日结束时间
        $endtime = strtotime(date('Y-m-d',time()).' 23:59:59');

        $orderMap = array(
            'status'    =>  3,
            'shop_id'   =>  $shopInfo['shop_id'],
            'pay_time'  =>  ['between',[$begintime,$endtime]],
        );
        $todayEarnings = Db::name('order')->where($orderMap)->sum('profit_shop')? : '0.00';

        $todayOrder    = Db::name('order')->where($orderMap)->count() ? : 0;
        $openCondition = array(
            'shop_id'   =>  $shopInfo['shop_id'],
            'status'      =>  3,
            'close_time'     =>  ['between',[$begintime,$endtime]]
        );
        $todayOpenTotal = Db::name('device_order')->where($openCondition)->count();


        $result['shop_id'] = $shopInfo['shop_id'];
        $result['todayEarnings'] = $todayEarnings; //今日收益
        $result['todayOrder']    = $todayOrder; //今日订单总数
        $result['todayOpen']     = $todayOrder+$todayOpenTotal; //今日开门次数
        $this->_return(1,'获取成功',$result);
    }



    //商家补货记录列表
    public function shopReplenish(){
        $page = $_POST['page']?$_POST['page']:1; //页码
        $pagesize = $_POST['pagesize']?$_POST['pagesize']:10; //每页条数
        if (empty($this->shop_id)) $this->_return(10000,'缺少参数');
        $res = Db::name('device_order')->alias('a')
              ->join('dlc_device b','b.device_id=a.device_id','left')
              ->where(['a.shop_id'=>$this->shop_id,'a.staff_type'=>1,'a.status'=>3])
              ->field('a.order_id,a.order_number,a.close_time,b.macno')->page($page,$pagesize)
                ->order('a.close_time desc')
            ->select();
        foreach ($res as $k=>$v){
            $res[$k]['close_time']=date('Y-m-d H:i:s',$v['close_time']);
        }
        $this->_return(1,'获取成功',$res);
    }

    //商家补货详情
    public function shopReplenishDetail(){
        if (!$_POST['order_id']) $this->_return(-1,'缺少参数');
        $replenishInfo = Db::name('device_order')->alias('a')->join('user b','a.staff_id=b.user_id')
                            ->join('device c','a.device_id=c.device_id')
                            ->where(['a.order_id'=>$_POST['order_id']])
                            ->field('a.order_id,a.order_number,a.close_time,b.nickname,c.network_id')->find();
        $addr = Db::name('network')->where(['network_id'=>$replenishInfo['network_id']])->value('address');
        $replenishInfo['addr'] = $addr?$addr:'';
        if (!$replenishInfo) $this->_return(-1,'找不到此补货订单');
        $replenishInfo['goods'] = Db::name('device_orderinfo')->alias('a')
                                    ->join('goods b','a.goods_id=b.goods_id')
                                    ->where(['a.order_id'=>$replenishInfo['order_id']])
                                    ->field('a.num,b.title,b.img')->select();
        if (!$replenishInfo['goods']) $this->_return(-1,'此补货订单缺少详情数据');
        foreach ($replenishInfo['goods'] as $k=>$v){
            $replenishInfo['goods'][$k]['img'] = $this->appUrl.$v['img'];
        }

        $this->_return(1,'获取成功',$replenishInfo);
    }
    //商家订单
    public function shopOrderList(){
//       $shop_id= input('shop_id')?:
        if(empty($this->shop_id))$this->_return(10000,'商家id不能为空');
        $page = $_POST['page']?$_POST['page']:1; //页码
        $pagesize = $_POST['pagesize']?$_POST['pagesize']:10; //每页条数
        $field = 'order_id,order_number,status,num,pay_price,pay_time,total_price';
        $condition['shop_id'] = $this->shop_id;
        $condition['status'] = ['<>',1];
        $orderList = Db::name('order')->where($condition)->field($field)->page($page,$pagesize)->select();
        foreach ($orderList as $k=>$v){
            $orderList[$k]['goods'] = Db::name('order_info')->alias('a')
                ->join('goods b','a.goods_id=b.goods_id')
                ->field('a.price,a.num,b.title,b.img')
                ->where(['a.order_id'=>$v['order_id']])
                ->select();
            if ($orderList[$k]['goods']){
                foreach ($orderList[$k]['goods'] as $key=>$val){
                    $orderList[$k]['goods'][$key]['img'] = $this->appUrl.'/'.$val['img'];
                }
            }
//            if(!$shop_id){
//                $find= db('feedback')->where(array('user_id'=>$this->user_id,'order_no'=>$v['order_number']))->find();
//                if($find){
//                    $orderList[$k]['f_status']=$find['status'];
//                    $orderList[$k]['feedback_id']=$find['id'];
//                }else{
//                    $orderList[$k]['f_status']=2;
//                    $orderList[$k]['feedback_id']=0;
//                }
//            }

        }

        $this->_return(1,'获取成功',$orderList);
    }
    //订单详情
    public function shopOrderDetail(){

        if (!$_POST['order_id']) $this->_return(-1,'缺少参数');
        $order_id=$_POST['order_id'];
        $field = 'a.order_id,a.order_number,a.status,a.num,a.pay_price,a.pay_time,a.discount_id,a.discount_money,a.total_price,b.macno';
        $orderRow = Db::name('order')->alias('a')
            ->join('dlc_device b ','b.device_id=a.device_id','left')
            ->where(['a.order_id'=>$order_id])->field($field)->find();
//        print_r( $orderRow);
//        die;
        $orderRow['goods'] = Db::name('order_info')->alias('a')
            ->join('goods b','a.goods_id=b.goods_id')
            ->field('a.price,a.num,b.title,b.img')
            ->where(['order_id'=>$orderRow['order_id']])
            ->select();
        $orderRow['mobile'] = '';
        if ($orderRow['goods']){
            foreach ($orderRow['goods'] as $key=>$val){
                $orderRow['goods'][$key]['img'] = $this->appUrl.'/'.$val['img'];
            }
        }
//        if($orderRow){
//            $find= db('feedback')->where(array('user_id'=>$this->user_id,'order_no'=>$orderRow['order_number']))->find();
//            if($find){
//                $orderRow['f_status']=$find['status'];
//                $orderRow['feedback_id']=$find['id'];
//            }else{
//                $orderRow['f_status']=2;
//                $orderRow['feedback_id']=0;
//            }
//        }

        $this->_return(1,'获取成功',$orderRow);
    }
}