<?php
namespace app\common\model;

use think\Model;
use think\db;
class Order extends Model
{
	protected $resultSetType = 'collection';
	protected $autoWriteTimestamp = 'timestamp';
    // 定义时间戳字段名
    protected $createTime = 'ctime';
    protected $updateTime = 'updated_at';
    protected $append  = ['payment'];

    protected $type = [
        'stores'      =>  'array',
        'coupon'      =>  'array',
        'totalprice'      =>  'float',
    ];

    protected function getPayStatusAttr($value, $data)
    {
        $pay_status = $data['pay_status'];
        if ($pay_status == 1) {
            $pay_status = '已支付';
        }else{
            $pay_status = '未支付';
        }
        return $pay_status;
    }
    protected function getStatusAttr($value, $data)
    {
        $status = $data['status'];
        if ($status == -3) {
            $status = '已退款';
        } elseif ($status == -2) {
            $status = '待退款';
        } elseif ($status == -1) {
            $status = '已取消';
        } elseif ($status == 0) {
            $status = '待发货';
        } elseif ($status == 1) {
            $status = '已发货';
        } elseif ($status == 2) {
            $status = '已完成';
        } elseif ($status == 3) {
            $status = '已评价';
        } else {
            $status = '未知状态';
        }
        return $status;
    }
    protected function getPaymentAttr($value, $data)
    {
        return model('Payment')->where('id',$data['payment_id'])->value('name');
    }

	public function user()
    {
        return $this->hasOne('User','id','user_id');
    }

    public function contact()
    {
        return $this->hasOne('OrderContact','order_id','id');
    }
    public function delivery()
    {
        return $this->hasOne('Delivery','id','delivery_id');
    }
    public function detail()
    {
        return $this->hasMany('OrderDetail');
    }
    public function fee()
    {
        return $this->hasMany('OrderFee');
    }


    /**
     * @param $transaction_id 交易编号
     *
     */
    public function payOk($transaction_id,$out_trade_no,$pay_ment = 1,$money=0)
    {

//       $paystyle= input('pay_style');
//        if(empty($paystyle)){
//            $paystyle=1;//没有支付类型 就默认为调起平台微信支付
//        }
        $pay_style=1;
//        $recharge_order = Db::name('recharge')->where(['order_number'=>$out_trade_no])->find();
        $expense_order  = Db::name('order')->where(['order_number'=>$out_trade_no])->find();

                if($expense_order){
                    $shop_id= db('device')->where(array('device_id'=>$expense_order['device_id']))->value('shop_id');
//                    $find= db('shop_wxset')->where('shop_id',$shop_id)->find();
//                    if($find){
//                        $pay_style=2;
//                    }
//                    if($pay_style==1){
//                    $shopmoney=  db('shop')->where(array('shop_id'=>$shop_id))->value('money');
//                    $shopm= $money+$shopmoney;
//                    db('shop')->where(array('shop_id'=>$shop_id))->update(array('money'=>$shopm));
//                    write_log('OpenDoor',"payok--pay_style--". $pay_style);
//                    }
                    $shopmoney=  db('shop')->where(array('shop_id'=>$shop_id))->value('money');
                    $shopm= $money+$shopmoney;
                    db('shop')->where(array('shop_id'=>$shop_id))->update(array('money'=>$shopm));
                    write_log('OpenDoor',"payok--pay_style--". $pay_style);
                }

                write_log('OpenDoor',"payok--pay_style--". $pay_style);
//
//        if($recharge_order){//充值订单
//            write_log('payReturn','充值消费数据----transaction_id----'.$transaction_id);
//            //新增一条消费记录
//            $cash_log['order_number'] = $out_trade_no;
//            $cash_log['user_id']      = $recharge_order['user_id'];
//            $cash_log['money']		  = $recharge_order['money'];
//            $cash_log['type']		  = 2;
//            $cash_log['pay_type']     = $pay_ment;
//            $cash_log['ctime']		  = time();
//            $res1 = Db::name('cash_log')->insert($cash_log);
////    		//修改用户余额
//            $res2 = Db::name('user')->where(['user_id'=>$recharge_order['user_id']])->setInc('money',$recharge_order['money']);
//            //修改充值订单状态
//            $res3 = Db::name('recharge')->where(['order_number'=>$out_trade_no])->update(['status'=>2,'pay_succeed'=>time()]);
//            if($res1 !== false && $res2 !== false && $res3 !== false){
//                return true;
//            }else{
//                return false;
//            }
//        }else{//消费订单


            //修改商品统计收益
            $sWhere = ['shop_id'=>$expense_order['shop_id'],'cdate'=>date('Ymd',time())];
            $shopCount['shop_id']  = $expense_order['shop_id'];
            $shopCount['cdate']    = date('Ymd',time());
            $shopCount['order_num']= 1;
            $shopCount['income']   = $expense_order['pay_price'];
            $res2 = new \app\wxsite\controller\OrderController();
            $res2->shopCount($sWhere,$shopCount);
            //修改消费订单状态
            $oUdata['pay_time'] = time();
            $oUdata['status']   = 3;
            $oUdata['pay_style']   = $pay_style;
            $oUdata['trade_number'] = $transaction_id;
//            if($pay_ment != 3){
//                $oUdata['trade_number'] = $transaction_id;
//            }
            if($expense_order['status']==2){
                $res3 = Db::name('order')->where(['order_number'=>$out_trade_no])->update($oUdata);

                if($res3){
                    //新增一条消费记录  修改订单状态成功后新增消费记录
                    $cash_log['order_number'] = $out_trade_no;
                    $cash_log['user_id']      = $expense_order['user_id'];
                    $cash_log['money']		  = $expense_order['pay_price'];
                    $cash_log['type']		  = 1;
                    $cash_log['pay_type']     = 1;
                    $cash_log['ctime']		  = time();
                    $cash_log['pay_style']		  = $pay_style;
                    $cash_log['shop_id']		  = $expense_order['shop_id'];
                    $res1 = Db::name('cash_log')->insert($cash_log);
                    db('user')->where(array('user_id'=>$expense_order['user_id']))->setInc('order_count',1);
                    $wecaht = new \app\dlc\controller\WechatController();
                    $wecaht->sendTplMsgOrder($out_trade_no);
                }
            }
            if($pay_style==1){
                db('shop')->where('shop_id',$expense_order['shop_id'])->setInc('money',$expense_order['pay_price']);
            }

            //商品销售分佣
			$this->getProfit($out_trade_no);
            //修改用户余额
//            if($pay_ment == 3){
//                Db::name('user')->where(['user_id'=>$expense_order['user_id']])->setDec('money',$expense_order['pay_price']);
//            }
            //修改优惠卷状态
            if($expense_order['discount_id']){
                Db::name('coupon_log')->where(['id'=>$expense_order['discount_id']])->update(['status'=>1]);
            }
            if($res1 !== false && $res3 !== false){
                return true;
            }else{
                return false;
            }

//        }
//        echo 'success';
    }
    public function getProfit($out_trade_no){
        $order = Db::name("order")->where("a.order_number",$out_trade_no)->find();
        if(empty($order))return false;
        $find= db('shop')->where('shop_id',$order['shop_id'])->find();
        $profit_web   = 0;//此订单平台可以得分佣
        $profit_shop  = 0;//该订单商家所得收益'
        if($find['scale']){
           $coupon_logfind= db('coupon_log')->where('discount_id',$order['discount_id'])->find();
            $scale= $find['scale']/100;
           if($coupon_logfind['coupon_id']==0&&$coupon_logfind['shop_id']==0){
               //用了平台的优惠券 所以要算入金额分成
               $profit_web= ($order['pay_price']+$order['discount_money']) * $scale;//平台分成金额
               $profit_shop=($order['pay_price']+$order['discount_money'])- $profit_web;//商家分成金额
           }else{
               //用了商家的优惠券不要算优惠券金额
               $profit_web= $order['pay_price'] * $scale;//平台分成金额
               $profit_shop=$order['pay_price']- $profit_web;//商家分成金额
           }
            $data["profit_web"]   = $profit_web;
            $data["profit_shop"] = $profit_shop ;
            Db::name("order")->where("order_number",$out_trade_no)->update($data);//修改订单
            db('shop')->where('shop_id',$order['shop_id'])->setInc('money',$profit_shop);
        }
        return true;
    }
}