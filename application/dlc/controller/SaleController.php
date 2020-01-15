<?php
namespace app\dlc\controller;

use Think\Db;

class SaleController extends BaseController
{
    public function statistics(){
		$bread = array(
            '0' => array(
                'name' => '营收管理',
                'url' => "#", 
            ),
			'1' => array(
                'name' => '数据统计',
                'url' => url('dlc/sale/statistics'), 
            ),  
        );
		$this->assign('breadhtml', $this->getBread($bread));
		//用户数
		$user = Db::name("user")->where("type",1)->count();
		//员工
		$staff = Db::name("user")->where("type",2)->count();
		//商家
		$shop =  Db::name("shop")->count();
		//销售总额
		$saleMoney =  Db::name("order")->where("status",3)->sum("total_price");
		//总订单数
		$saleNumber =  Db::name("order")->where("status",3)->count();
		//销售商品数
		$saleGoods =  Db::name("order")->where("status",3)->sum("num");
		//充值总额
		$recharge =  Db::name("cash_log")->where("type",2)->sum("money");
		//平台收入
		
		//商家收入
		
		//补货员收入
		
		$this->assign("user",$user);
		$this->assign("staff",$staff);
		$this->assign("shop",$shop);
		$this->assign("saleMoney",$saleMoney);
		$this->assign("saleNumber",$saleNumber);
		$this->assign("saleGoods",$saleGoods);
		$this->assign("recharge",$recharge);
		echo $this->fetch('sale_statistics');
	}
}