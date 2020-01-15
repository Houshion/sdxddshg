<?php
namespace app\shop\controller;
use think\Session;
use think\Db;

class SaleController extends BaseController 
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
    public function statistics(){
		$bread = array(
            '0' => array(
                'name' => '营收管理',
                'url' => url('shop/sale/statistics'), 
            ),
			'1' => array(
                'name' => '数据统计',
                'url' => url('shop/sale/statistics'), 
            ),  
        );
		$this->assign('breadhtml', $this->getBread($bread));

		if($this->type == 1){
			//员工人数据
			$staff = Db::name("user")->where(['type'=>2,'shop_id'=>$this->id])->count() ? : 0;
			//销售总额
			$saleMoney =  Db::name("order")->where(['status'=>3,'shop_id'=>$this->id])->sum("total_price") ? : 0;
			//销售商品数
			$saleGoods =  Db::name("order")->where(['status'=>3,'shop_id'=>$this->id])->sum("num") ? : 0;
			//设备数量
			$saleDevice= Db::name('device')->where(['shop_id'=>$this->id])->count() ? : 0;
			//总订单数量
			$saleNumber = Db::name('order')->where(['status'=>3,'shop_id'=>$this->id])->count() ? : 0;

		}else{
			$device = Db::name('device')->where(['user_id'=>$this->id])->column('device_id');
            $device_id = implode(',',$device);
			//销售总额
			$saleMoney =  Db::name("order")->where(['status'=>3,'device_id'=>['in',$device_id]])->sum("total_price") ? : 0;
			//销售商品数
			$saleGoods =  Db::name("order")->where(['status'=>3,'device_id'=>['in',$device_id]])->sum("num") ? : 0;
			//设备数量
			$saleDevice= Db::name('device')->where(['user_id'=>$this->id])->count() ? : 0;
			//总订单数量
			$saleNumber = Db::name('order')->where(['status'=>3,'device_id'=>['in',$device_id]])->count() ? : 0;
		}
		$this->assign('staff',$staff);
		$this->assign('saleMoney',$saleMoney);
		$this->assign('saleGoods',$saleGoods);
		$this->assign('saleDevice',$saleDevice);
		$this->assign('saleNumber',$saleNumber);
		$this->assign('type',$this->type);
		echo $this->fetch('sale_statistics');
	}
}