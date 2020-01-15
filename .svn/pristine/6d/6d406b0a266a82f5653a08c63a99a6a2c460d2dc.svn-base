<?php
/**
 * Created by PhpStorm.
 * User: 马远利
 * Date: 2018/3/9
 * Time: 16:07
 */

namespace app\wxsite\controller;
use \think\Loader;
use \think\Db;
use \think\Model;
use think\Controller;
//BaseController
class WxpayController extends BaseController
{
    public $appUrl = "";
    public $user_id;
    
    public function _initialize()
    {
        $this->appUrl = request()->root(true);
      
    }

	
	//消费微信回调
    public function wxNotify(){
        Vendor("WxPayPubHelper.WxPayPubHelper");
        $config = Db::name('wxpay')->find();
        //使用通用通知接口
        $notify = new \Notify_pub($config["wxappid"], $config["wxappsecret"], $config["wxmchid"], $config["wxmchkey"]);

        //存储微信的回调
        if (version_compare(PHP_VERSION, '7.0.0', '>')){
            $xml = file_get_contents("php://input");//php7下
        }else{
            $xml = $GLOBALS['HTTP_RAW_POST_DATA'];
        }
        // Db::name('test')->insert(['conter'=>'微信回调2']);
        $notify->saveData($xml);
        $data = $notify->getData();
        //验证签名，并回应微信。
        //对后台通知交互时，如果微信收到商户的应答不是成功或超时，微信认为通知失败，
        //微信会通过一定的策略（如30分钟共8次）定期重新发起通知，
        //尽可能提高通知的成功率，但微信不保证通知最终能成功。
        if ($notify->checkSign() == FALSE) {
            $notify->setReturnParameter("return_code", "FAIL");//返回状态码
            $notify->setReturnParameter("return_msg", "签名失败");//返回信息
        } else {
            $notify->setReturnParameter("return_code", "SUCCESS");//设置返回码
        }
        // Db::name('test')->insert(['conter'=>'微信回调1out_trade_no='.$data['out_trade_no'].',transaction_id='.$data['transaction_id']]);
        // Db::name('test')->insert(['conter'=>'微信回调']);
        $this->payReturn($data['out_trade_no'],$data['transaction_id'],1,$data['pay_style']);
        $returnXml = $notify->returnXml();

        echo 'success';    }

	 /**
     * @param $out_trade_no 商户订单号
     * @param $transaction_id 第三方支付订单号
     * @param $pay_style 订单支付获取的支付参数 1 为平台  2 为商家
     * @param $pay_ment 支付方式 1：微信 2：支付宝 3：余额
      */
    public function payReturn($out_trade_no= '',$transaction_id='',$pay_ment,$pay_style)
    {
        if(empty($pay_style)){
            $pay_style=1;//没有支付类型 就默认为调起平台微信支付
        }
    	$recharge_order = Db::name('recharge')->where(['order_number'=>$out_trade_no])->find();
    	$expense_order  = Db::name('order')->where(['order_number'=>$out_trade_no])->find();

        write_log('payReturn','消费订单查询--------'.json_encode($recharge_order,true));
        write_log('payReturn','的订单查询--------'.json_encode($expense_order,true));
        write_log('payReturn','$out_trade_no'.$out_trade_no.'-------$transaction_id----'.$transaction_id.'-----');
    	if($recharge_order){//充值订单
            write_log('payReturn','充值消费数据----transaction_id----'.$transaction_id);
    		//新增一条消费记录
    		$cash_log['order_number'] = $out_trade_no;
    		$cash_log['user_id']      = $recharge_order['user_id'];
    		$cash_log['money']		  = $recharge_order['money'];
    		$cash_log['type']		  = 2;
    		$cash_log['pay_type']     = $pay_ment;
    		$cash_log['ctime']		  = time();
    		$res1 = Db::name('cash_log')->insert($cash_log);
//    		//修改用户余额
    		$res2 = Db::name('user')->where(['user_id'=>$recharge_order['user_id']])->setInc('money',$recharge_order['money']);
    		//修改充值订单状态
    		$res3 = Db::name('recharge')->where(['order_number'=>$out_trade_no])->update(['status'=>2,'pay_succeed'=>time()]);
    		if($res1 !== false && $res2 !== false && $res3 !== false){
    			return true;
    		}else{
    			return false;
    		}
    	}else{//消费订单

    		//新增一条消费记录
    		$cash_log['order_number'] = $out_trade_no;
    		$cash_log['user_id']      = $expense_order['user_id'];
    		$cash_log['money']		  = $expense_order['pay_price'];
    		$cash_log['type']		  = 1;
    		$cash_log['pay_type']     = $pay_ment;
    		$cash_log['ctime']		  = time();
    		$cash_log['pay_style']		  = $pay_style;
    		$res1 = Db::name('cash_log')->insert($cash_log);
    		//修改商品统计收益
    		$sWhere = ['shop_id'=>$expense_order['shop_id'],'cdate'=>date('Ymd',time())];
    		$shopCount['shop_id']  = $expense_order['shop_id'];
    		$shopCount['cdate']    = date('Ymd',time());
    		$shopCount['order_num']= 1;
    		$shopCount['income']   = $expense_order['pay_price'];
    		$res2 = new OrderController();
    		$res2->shopCount($sWhere,$shopCount);
    		//修改消费订单状态
    		$oUdata['pay_time'] = time();
    		$oUdata['status']   = 3;
    		$oUdata['pay_style']   = $pay_style;
    		if($pay_ment != 3){
    			$oUdata['trade_number'] = $transaction_id;
    		}
            write_log('payReturn','订单消费数据--------'.json_encode($oUdata,true));

            $res3 = Db::name('order')->where(['order_number'=>$out_trade_no])->update($oUdata);
			//商品销售分佣
//			$this->getProfit($out_trade_no); //分佣暂时没有
     		//修改用户余额
     		if($pay_ment == 3){
     			Db::name('user')->where(['user_id'=>$expense_order['user_id']])->setDec('money',$expense_order['pay_price']);
     		}
     		//修改优惠卷状态
     		if($expense_order['discount_id']){
     			Db::name('coupon_log')->where(['id'=>$expense_order['discount_id']])->update(['status'=>1]);
     		}
     		if($res1 !== false && $res3 !== false){
    			return true;
    		}else{
    			return false;
    		}
    	}
    }

	public function getProfit($out_trade_no){
		$order = Db::name("order")->alias("a")->join("dlc_order_info b","a.order_id = b.order_id")->where("a.order_number",$out_trade_no)->select();
		if(empty($order))return false;
		$profit_web   = 0;
		$profit_staff = 0;
		$profit_shop  = 0;
		foreach($order as $k=>$v){
			$goods = Db::name("goods")->where("goods_id = ".$v["goods_id"])->find();
			$device_goods = Db::name("device_goods")->where("goods_id = ".$v["goods_id"])->find();
			if($goods["webrate"] != 0){
				$profit_web  = $profit_web + (($device_goods["price"] * $v["num"]))*($goods["webrate"]/100);
			}else{
				$profit_web  = $profit_web + 0;
			}
			if($goods["staffrate"] != 0){
				$profit_staff  = $profit_staff + (($device_goods["price"] * $v["num"]))*($goods["staffrate"]/100);
			}else{
				$profit_staff  = $profit_staff + 0;
			}
			$profit_shop = $profit_shop + $v["count_price"];
		}
		$data["profit_web"]   = $profit_web;
		$data["profit_staff"] = $profit_staff;
		$data["profit_shop"] = $profit_shop - $profit_web - $profit_staff;
		$re = Db::name("order")->where("order_number",$out_trade_no)->update($data);
		return true;
	}

    /**
     * 微信委托代扣申请解约
     * @param  none
     * @return none
     */
    public function deletecontract(){

    }

}