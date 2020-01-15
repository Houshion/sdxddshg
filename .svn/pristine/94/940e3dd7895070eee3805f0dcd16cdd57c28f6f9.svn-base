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
use \think\Controller;


class AlipayController extends Controller
{
    public $appUrl = "";
    public $user_id;
    public function _initialize()
    {
        $this->appUrl = request()->root(true);
    }
   
    public function cz_notify_url(){
        /* *
        * 功能：支付宝服务器异步通知页面
        * 版本：2.0
        * 修改日期：2016-11-01
        * 说明：
        * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。

        *************************页面功能说明*************************
		
        * 创建该页面文件时，请留心该页面文件中无任何HTML代码及空格。
        * 该页面不能在本机电脑测试，请到服务器上做测试。请确保外部可以访问该页面。
        * 如果没有收到该页面返回的 success 信息，支付宝会在24小时内按一定的时间策略重发通知
        */
        vendor("alilogin.wappay.service.AlipayTradeService");
        $config = config('alipay');
        $arr=$_POST;
        $alipaySevice = new \AlipayTradeService($config);
        $alipaySevice->writeLog(var_export($_POST,true));
      //  $result = $alipaySevice->check($arr);
        $result = true;
        /* 实际验证过程建议商户添加以下校验。
        1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号，
        2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额），
        3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）
        4、验证app_id是否为该商户本身。
        */
        if($result) {//验证成功
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //请在这里加上商户的业务逻辑程序代


            //——请根据您的业务逻辑来编写程序（以下代码仅作参考）——

            //获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表

            //商户订单号

            $out_trade_no = $_POST['out_trade_no'];

            //支付宝交易号

            $trade_no = $_POST['trade_no']; 

            //交易状态
            $trade_status = $_POST['trade_status'];


            if($_POST['trade_status'] == 'TRADE_FINISHED') {

                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //请务必判断请求时的total_amount与通知时获取的total_fee为一致的
                //如果有做过处理，不执行商户的业务程序

                //注意：
                //退款日期超过可退款期限后（如三个月可退款），支付宝系统发送该交易状态通知
            }
            else if ($_POST['trade_status'] == 'TRADE_SUCCESS') {
                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //请务必判断请求时的total_amount与通知时获取的total_fee为一致的
                //如果有做过处理，不执行商户的业务程序
                //注意：
                //付款完成后，支付宝系统发送该交易状态通知
               // Db::name('test')->insert(['conter'=>json_encode($_POST)]);
                $this->cz_payTrue($out_trade_no,$trade_no);
            }
           // Db::name('test')->insert(['conter'=>json_encode($_POST)]);
            //$this->cz_payTrue('20180321150253791702','111111');
            //——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
            //Db::name('test')->insert(['conter'=>'进入成功']);
            echo "success";		//请不要修改或删除

        }else {
           // Db::name('test')->insert(['conter'=>'进入失败']);
            //验证失败
            echo "fail";	//请不要修改或删除

        }
	}

    public function order_notify_url(){ 
        /* *
         * 功能：支付宝服务器异步通知页面
         * 版本：2.0
         * 修改日期：2016-11-01
         * 说明：
         * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。

         *************************页面功能说明*************************
         * 创建该页面文件时，请留心该页面文件中无任何HTML代码及空格。
         * 该页面不能在本机电脑测试，请到服务器上做测试。请确保外部可以访问该页面。
         * 如果没有收到该页面返回的 success 信息，支付宝会在24小时内按一定的时间策略重发通知
         */
            
        vendor("alilogin.wappay.service.AlipayTradeService");
        $config = config('alipay');
        $arr=$_POST;
        $alipaySevice = new \AlipayTradeService($config);
        $alipaySevice->writeLog(var_export($_POST,true));
        //$result = $alipaySevice->check($arr);
        $result = true;
        /* 实际验证过程建议商户添加以下校验。
        1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号，
        2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额），
        3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）
        4、验证app_id是否为该商户本身。
        */
        if($result) {//验证成功
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //请在这里加上商户的业务逻辑程序代


            //——请根据您的业务逻辑来编写程序（以下代码仅作参考）——

            //获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表

            //商户订单号

            $out_trade_no = $_POST['out_trade_no'];

            //支付宝交易号

            $trade_no = $_POST['trade_no'];

            //交易状态
            $trade_status = $_POST['trade_status'];


            if($_POST['trade_status'] == 'TRADE_FINISHED') {
                // Db::name('test')->insert(array('conter'=>$out_trade_no,'time'=>45611));
                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //请务必判断请求时的total_amount与通知时获取的total_fee为一致的
                //如果有做过处理，不执行商户的业务程序

                //注意：
                //退款日期超过可退款期限后（如三个月可退款），支付宝系统发送该交易状态通知
            }else if ($_POST['trade_status'] == 'TRADE_SUCCESS') {
                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //请务必判断请求时的total_amount与通知时获取的total_fee为一致的
                //如果有做过处理，不执行商户的业务程序
                //注意：
                //付款完成后，支付宝系统发送该交易状态通知
                // Db::name('test')->insert(array('conter'=>$out_trade_no,'time'=>4569));
               
            }
             $pay = new WxpayController();
            $pay->payReturn($out_trade_no,$trade_no,2);
            //——请根据您的业务逻辑来编写程序（以上代码仅作参考）——

            echo "success";		//请不要修改或删除

        }else {

            //验证失败
            echo "fail";	//请不要修改或删除

        }
    }
  
    //回调修改订单
    public function cz_payTrue($out_trade_no,$transaction_id){
        model('user_orders_pay')->startTrans();
        //修改订单支付状态
        $condition['pay_id'] = $out_trade_no;
        $update_pay['success_paytime'] = time();
        $update_pay['pay_number'] = $transaction_id;
        $update_pay['status'] = 8;
        $res_pay = model('user_orders_pay')->user_update($condition,$update_pay);

        //添加用户余额变动日志
        $data_pay = model('user_orders_pay')->where($condition)->field('user_id,pay_money,pay_id,pid')->find();
        $add_money['from_uid'] = $data_pay['user_id'];
        $add_money['create_time'] = time();
        $add_money['money'] = $data_pay['pay_money'];
        $add_money['operate_type'] = 1;
        $add_money['memo'] = '用户充值，商户订单号'.$data_pay['pay_id'];
        $res_money = model('user_money_log')->user_insert($add_money);

        //增加用户余额
        $res_user = model('user')->where('id',$data_pay['user_id'])->setInc('money',$data_pay['pay_money']);

        //增加套餐成功购买次数
        $res_package = model('recharge_package')->where('id',$data_pay['pid'])->setInc('success_num',1);

        if($res_pay && $res_money && $res_user && $res_package){
            model('user_orders_pay')->commit();
        }else{
            $str = "充值订单号：" . $data_pay['pay_id'] . "支付成功但未更新订单状态！";
            file_put_contents($this->appUrl . '/data/notify_url.log', '支付宝付款支付报警:' . date('Y-m-d H:i:s') . PHP_EOL . '通知信息:' . $str . PHP_EOL . PHP_EOL . '交易类型:TRADE_SUCCESS' . PHP_EOL . PHP_EOL, FILE_APPEND);
            model('user_orders_pay')->rollback();
        }
    }

}