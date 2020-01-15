<?php
namespace app\common\tool;
use Curl\Curl;
use think\Request;
use think\db;
class WecahtOfficialAccount
{

    /**
     * 取code
     */
    public static function getCode()
    {
        $auth_code = Request::instance()->param('auth_code');
        if($auth_code) {
//            return $auth_code;
            throw new \think\Exception('auth_code不能为空');
        }

        $url= Request::instance()->domain() . "/wxsite/public/getCode";

        $appid = config('wx_appid');
        $redirect_uri = urlencode ( $url );
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$appid}&redirect_uri={$redirect_uri}&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
        return $url;
    }


    /**
     * 通过CODE取 openID
     * @param $code
     * @return mixed
     * @throws \think\Exception
     */
    public static function getOpenid($code)
    {
        $curl = $curl = new \Curl\Curl();
        $curl->setOpt(CURLOPT_RETURNTRANSFER, TRUE);
        $curl->setOpt(CURLOPT_SSL_VERIFYPEER, FALSE);

        //通过code取openid
        $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . config('wx_appid') . '&secret='. config('wx_appsecret') .'&code=' . $code . '&grant_type=authorization_code';

        $curl->get($url);
        if ($curl->error) {
            throw new \think\Exception('获取失败,请稍候再试!');
        }

        return json_decode($curl->response);
    }


    public static function getUserInfo($accessToken, $openid)
    {
        $url = "https://api.weixin.qq.com/sns/userinfo?access_token={$accessToken}&openid={$openid}&lang=zh_CN";
        $curl = $curl = new \Curl\Curl();
        $curl->setOpt(CURLOPT_RETURNTRANSFER, TRUE);
        $curl->setOpt(CURLOPT_SSL_VERIFYPEER, FALSE);

        $curl->get($url);
        if ($curl->error) {
            throw new \think\Exception('获取失败,请稍候再试!');
        }

        return json_decode($curl->response);

    }


    /**
     * 刷新access_token
     * @param $refresh_token
     */
    public static function refreshToken($refresh_token) {
        $curl = $curl = new \Curl\Curl();
        $curl->setOpt(CURLOPT_RETURNTRANSFER, TRUE);
        $curl->setOpt(CURLOPT_SSL_VERIFYPEER, FALSE);

        $url = 'https://api.weixin.qq.com/sns/oauth2/refresh_token?appid=' . config('wx_appid') . '&grant_type=refresh_token&refresh_token=' . $refresh_token;

        $curl->get($url);
        if ($curl->error) {
            throw new \think\Exception('获取失败,请稍候再试!');
        }

        return json_decode($curl->response);
    }


    /**
     * 是否关注了公众号
     * @param $openid
     * @return mixed
     * @throws \think\Exception
     */
    public static function isSubscribe($openid)
    {
        $accessToken = static::getAccessToken();

        $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token={$accessToken}&openid={$openid}";

        $curl = $curl = new \Curl\Curl();
        $curl->setOpt(CURLOPT_RETURNTRANSFER, TRUE);
        $curl->setOpt(CURLOPT_SSL_VERIFYPEER, FALSE);

        $curl->get($url);
        if ($curl->error) {
            throw new \think\Exception('获取失败,请稍候再试!');
        }
        $result = json_decode($curl->response);
        return $result->subscribe;
    }


    /**
     * 取基本 access_token
     * @return mixed
     */
    public static function getAccessToken()
    {
        $jssdk = new \limx\tools\wx\JsSdk(config('wx_appid'),config('wx_appsecret'));
        $token = $jssdk->getAccessToken();
        return $token;
    }



    public static function sendTemplateMessage($openid = '', $template_id = 'huWi0wGI_HzfhUvXidsF_nTS1us9iG7Ouwcpfnm6D0o', $data = [])
    {
        $meesage = [
            'touser' => $openid,
            'template_id' => $template_id,
            'url' => '',
            'data' => [
                'first' => [
                    'value' => '恭喜你购买成功!',
                    'color' => '#173177',
                ],
                'product' => [
                    'value' => '步步高学习ji',
                    'color' => '#173177',
                ],
                'price' => [
                    'value' => '188.88',
                    'color' => '#173177',
                ],
                'time' => [
                    'value' => date('Y-m-d H:i'),
                    'color' => '#173177',
                ]
            ]
        ];


        $options = array(
            'token' => config(''), //填写你设定的key
            //'encodingaeskey' => $config ["encodingaeskey"], //填写加密用的EncodingAESKey
            'appid' => $config ["appid"], //填写高级调用功能的app id
            'appsecret' => $config ["appsecret"] //填写高级调用功能的密钥
        );

        self::$weObj = new \Wechat ($options);
    }




    /**
     * 生成公众号H5支付 参数
     * @param $data
     *  $data['body'] = '火影T2电脑';                                        // 商品描述
        $data['out_trade_no'] = 'test' . mt_rand(10000000,99999999); // 订单号
        $data['total_fee'] = 1;                                 // 订单总金额，单位为：分
        $data['openid'] = $openid;                              // 必须设置openid
     */
    public static function getH5PayParams($data)
    {
        write_log('payReturn','getH5PayParams=$data='.json_encode($data,true));
        $params = new \Yurun\PaySDK\Weixin\Params\PublicParams();
        //获取微信支付串
//        $shop_id= db('order')->where('order_number',$data['out_trade_no'])->value('shop_id');
//        $find= db('shop_wxset')->where('shop_id',$shop_id)->find();
//        if($find){
//
//            $params->mch_id = $find['wxmchid'];
//            $params->appID =$find['wxappid'];
//            $params->key = $find['wxmchkey'];
//            $pay_style=2;
//        }else{
//           $find= db('wxpay')->where('id',1)->find();
////            $params->mch_id = config('wx_mchid');
////            $params->appID = config('wx_appid');
////            $params->key = config('wx_key');
//            $params->mch_id = $find['wxmchid'];
//            $params->appID = $find['wxappid'];
//            $params->key = $find['wxmchkey'];
//            $pay_style=1;
//
//        }
        $find= db('wxpay')->where('id',1)->find();
//            $params->mch_id = config('wx_mchid');
//            $params->appID = config('wx_appid');
//            $params->key = config('wx_key');
        $params->mch_id = $find['wxmchid'];
        $params->appID = $find['wxappid'];
        $params->key = $find['wxmchkey'];
        $pay_style=1;
//        $pay_style=2;

        $pay = new \Yurun\PaySDK\Weixin\SDK($params);
        // 支付接口
        $request = new \Yurun\PaySDK\Weixin\JSAPI\Params\Pay\Request;
        $request->body = $data['body'];                                 // 商品描述
        $request->out_trade_no = $data['out_trade_no'];                 // 订单号
        $request->total_fee = $data['total_fee'] * 100;                 // 订单总金额，单位为：分
        $request->notify_url = config('pay_notify_url').'/pay_style/'.$pay_style;                // 异步通知地址
        $request->openid = $data['openid'];                             // 必须设置openid

        // 调用接口
        $result = $pay->execute($request);
        if($result['err_code_des']=='201 商户订单号重复'){
          $reason=  db('order')->where('order_number',$data['out_trade_no'])->value('reason');
            $str='';
           $str= $reason.'原订单号：'.$data['out_trade_no'].'重新修改订单号';
           $ordernuber= 'U'.date('YmdHis').mt_rand(1000,9999);
           db('order')->where('order_number',$data['out_trade_no'])->update(['order_number'=>$ordernuber,'reason'=> $str]);
            $dataarr['code']=-1;
//            $dataarr['msg']=''.$result['return_msg'].'商家参数配置错误';
            $dataarr['msg']=$result['err_code_des'].'请重新支付';
            die(json_encode($dataarr,true));

        }

        write_log('payReturn','$result='.json_encode($result,true));

        if($pay->checkResult())
        {
            $request = new \Yurun\PaySDK\Weixin\JSAPI\Params\JSParams\Request;
            $request->prepay_id = $result['prepay_id'];
            $jsapiParams = $pay->execute($request);
            return $jsapiParams;
        } else {
            //商家参数配置错误不需要调取平台支付
            $dataarr['code']=-1;
//            $dataarr['msg']=''.$result['return_msg'].'商家参数配置错误';
            $dataarr['msg']=$result['err_code_des'];
            die(json_encode($dataarr,true));
//            trace($pay->getError());
//            throw new \think\Exception('支付创建失败,请稍候再试');
//            $params->mch_id = config('wx_mchid');
//            $params->appID = config('wx_appid');
//            $params->key = config('wx_key');
//            $pay_style=1;
//            $pay = new \Yurun\PaySDK\Weixin\SDK($params);
//            // 支付接口
//            $request = new \Yurun\PaySDK\Weixin\JSAPI\Params\Pay\Request;
//            $request->body = $data['body'];                                 // 商品描述
//            $request->out_trade_no = $data['out_trade_no'];                 // 订单号
//            $request->total_fee = $data['total_fee'] * 100;                 // 订单总金额，单位为：分
//            $request->notify_url = config('pay_notify_url').'pay_style/'.$pay_style;                // 异步通知地址
//            $request->openid = $data['openid'];                             // 必须设置openid
//
//
//            // 调用接口
//            $result = $pay->execute($request);
//            if($pay->checkResult())
//            {
//                $request = new \Yurun\PaySDK\Weixin\JSAPI\Params\JSParams\Request;
//                $request->prepay_id = $result['prepay_id'];
//                $jsapiParams = $pay->execute($request);
//                return $jsapiParams;
//            } else {
//                $dataarr['code']=-1;
//                $dataarr['msg']=$result['return_msg'];
//                die(json_encode($dataarr,true));
//            }
        }
    }
    /**
     * 生成公众号H5支付 参数充值套餐
     * @param $data
     *  $data['body'] = '火影T2电脑';                                        // 商品描述
    $data['out_trade_no'] = 'test' . mt_rand(10000000,99999999); // 订单号
    $data['total_fee'] = 1;                                 // 订单总金额，单位为：分
    $data['openid'] = $openid;                              // 必须设置openid
     */
    public static function getH5PayRechargeParams($data)
    {
        write_log('payReturn','getH5PayRechargeParams=$data='.json_encode($data,true));
        $params = new \Yurun\PaySDK\Weixin\Params\PublicParams();
        //获取微信支付串
        $shop_id= db('recharge')->where('order_number',$data['out_trade_no'])->value('shop_id');
        $find= db('shop_wxset')->where('shop_id',$shop_id)->find();
        $params->mch_id = $find['wxmchid'];
        $params->appID =$find['wxappid'];
        $params->key = $find['wxmchkey'];
        $pay_style=2;
//        $pay_style=2;

        $pay = new \Yurun\PaySDK\Weixin\SDK($params);
        // 支付接口
        $request = new \Yurun\PaySDK\Weixin\JSAPI\Params\Pay\Request;
        $request->body = $data['body'];                                 // 商品描述
        $request->out_trade_no = $data['out_trade_no'];                 // 订单号
        $request->total_fee = $data['total_fee'] * 100;                 // 订单总金额，单位为：分
        $request->notify_url = 'http://'.$_SERVER['HTTP_HOST'].'/wxsite/public/wxnotify1/';
        $request->openid = $data['openid'];                             // 必须设置openid

        // 调用接口
        $result = $pay->execute($request);
//        if($result['err_code_des']=='201 商户订单号重复'){
//            $reason=  db('recharge')->where('order_number',$data['out_trade_no'])->value('reason');
//            $str='';
//            $str= $reason.'原订单号：'.$data['out_trade_no'].'重新修改订单号';
//            $ordernuber= 'R'.date('YmdHis').mt_rand(1000,9999);
//            db('recharge')->where('order_number',$data['out_trade_no'])->update(['order_number'=>$ordernuber,'reason'=> $str]);
//            $dataarr['code']=-1;
////            $dataarr['msg']=''.$result['return_msg'].'商家参数配置错误';
//            $dataarr['msg']=$result['err_code_des'].'请重新支付';
//            die(json_encode($dataarr,true));
//
//        }

        write_log('payReturn','$result='.json_encode($result,true));

        if($pay->checkResult())
        {
            $request = new \Yurun\PaySDK\Weixin\JSAPI\Params\JSParams\Request;
            $request->prepay_id = $result['prepay_id'];
            $jsapiParams = $pay->execute($request);
            return $jsapiParams;
        } else {
            //商家参数配置错误不需要调取平台支付
            $dataarr['code']=-1;
//            $dataarr['msg']=''.$result['return_msg'].'商家参数配置错误';
            $dataarr['msg']=$result['err_code_des'];
            die(json_encode($dataarr,true));
//            trace($pay->getError());
//            throw new \think\Exception('支付创建失败,请稍候再试');
//            $params->mch_id = config('wx_mchid');
//            $params->appID = config('wx_appid');
//            $params->key = config('wx_key');
//            $pay_style=1;
//            $pay = new \Yurun\PaySDK\Weixin\SDK($params);
//            // 支付接口
//            $request = new \Yurun\PaySDK\Weixin\JSAPI\Params\Pay\Request;
//            $request->body = $data['body'];                                 // 商品描述
//            $request->out_trade_no = $data['out_trade_no'];                 // 订单号
//            $request->total_fee = $data['total_fee'] * 100;                 // 订单总金额，单位为：分
//            $request->notify_url = config('pay_notify_url').'pay_style/'.$pay_style;                // 异步通知地址
//            $request->openid = $data['openid'];                             // 必须设置openid
//
//
//            // 调用接口
//            $result = $pay->execute($request);
//            if($pay->checkResult())
//            {
//                $request = new \Yurun\PaySDK\Weixin\JSAPI\Params\JSParams\Request;
//                $request->prepay_id = $result['prepay_id'];
//                $jsapiParams = $pay->execute($request);
//                return $jsapiParams;
//            } else {
//                $dataarr['code']=-1;
//                $dataarr['msg']=$result['return_msg'];
//                die(json_encode($dataarr,true));
//            }
        }
    }

    /**
     * 微信支付回调
     */
    public static function notify($orderClass)
    {
//        $params = new \Yurun\PaySDK\Weixin\Params\PublicParams();
//        $params->mch_id = config('wx_mchid');
//        $params->appID = config('wx_appid');
//        $params->key = config('wx_key');
//        $sdk = new \Yurun\PaySDK\Weixin\SDK($params);
//
//
//        $payNotify = new PayNotify;
//        $payNotify->orderClass = $orderClass;
//
//        try {
//
//            $sdk->notify($payNotify);
//
//        }catch (\Exception $err) {
//            $payNotify->reply('', $err->getMessage());
//        }catch (\think\Exception $err) {
//            $payNotify->reply('', $err->getMessage());
//        }
        $data = \Yurun\PaySDK\Lib\XML::fromString(file_get_contents('php://input'));
        $order = $orderClass::get(['order_number' => $data['out_trade_no']]);
//$agent = $order->agent;

//        $agent = Agent::get();

          $shop_wxset=  db('shop_wxset')->where('shop_id', $order['shop_id'])->find();


        $params = new \Yurun\PaySDK\Weixin\Params\PublicParams();
        $params->mch_id =$shop_wxset['wxmchid'];
        $params->appID = $shop_wxset['wxappid'];
        $params->key = $shop_wxset['wxmchkey'];
        $sdk = new \Yurun\PaySDK\Weixin\SDK($params);


        $payNotify = new PayNotify;
        $payNotify->orderClass = $orderClass;

        try {

            $sdk->notify($payNotify);

        }catch (\Exception $err) {
            $payNotify->reply('', $err->getMessage());
        }catch (\think\Exception $err) {
            $payNotify->reply('', $err->getMessage());
        }
    }




}


class PayNotify extends \Yurun\PaySDK\Weixin\Notify\Pay
{
    public $orderClass;
    /**
     * 后续执行操作
     * @return void
     */
    protected function __exec()
    {

        $data = $this->getNotifyData();

        trace('data');
        trace($data);

        trace('post');
        trace($_POST);

        $modelNmae = $this->orderClass;
        $order = $modelNmae::get(['order_number' => $data['out_trade_no']]);

        if(!$order) {
            throw new \Exception('定单未找到');
        }
        write_log('payReturn','后续执行操作json_'.json_encode($data['out_trade_no'],true));

        $order->payOk($data['transaction_id'],$data['out_trade_no']);
        $this->reply('SUCCESS', 'OK');
        return;
    }

}