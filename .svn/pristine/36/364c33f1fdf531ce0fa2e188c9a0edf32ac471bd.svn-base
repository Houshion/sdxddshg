<?php
namespace app\wxsite\controller;

use think\Controller;
use think\Model;
use think\Db;
class BaseController extends Controller
{ 
    protected $user_id;//用户id
    protected $user;//用户信息
    protected $openid; 

    public function _initialize(){
//        $this->get_user_id();
//       $token= input('token');
//        $user_id=$this->decodeToken($token);
//        if($user_id){
//            $this->user_id;
//        }else{
//            abort(json(["msg" => "未登陆", "code" => 401]));
//        }
    }

    // public function get_code(){
    //     if (!$_GET['auth_code']) {
    //         $url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    //         $appid = '2018050302627045';
    //         $redirect_uri = urlencode ( $url );
    //         $url ="https://openauth.alipay.com/oauth2/publicAppAuthorize.htm?app_id={$appid}&scope=auth_userinfo&redirect_uri={$redirect_uri}";
    //         header("location: $url");
    //     }
    //     echo $_GET['auth_code'];

    // }

//    //公众号授权登录
//    public function wx_oauth(){
//        if (!$_GET['code']) {
//            $this->_return(-1,'code不能为空');
//        }
//        vendor("dodgepudding.wechat-php-sdk.wechat#class");
//        $wxpay = Db('wxpay')->find();
//        $options['appid'] = $wxpay['wxappid'];
//        $options['appsecret'] = $wxpay['wxappsecret'];
////        $wx = new \Util\Wx\Wechat($options);
//        $wx = new wechat($options);
//        print_r();die;
//        $re = $wx->getOauthAccessToken(input('code'));
//        $access_token = $re['access_token'];
//        $openid = $re['openid'];
//        $user = $wx->getOauthUserinfo($access_token, $openid);
//        if ($user) {
//            $mvip = Db('user');
//            //容错，防止重复注册VIP
//            $vip = $mvip->where(array('openid' => $openid))->find();
//            if ($vip) {
//                $data['openid'] = $vip['openid'];
//                $data['token'] = md5(time().rand(1000,9999));
//                $data['nickname'] = $vip['nickname'];
//                $data['sex'] = $vip['sex'];
//                $data['head_img'] = $vip['headimg'];
//                $data['ctime'] = $vip['ctime'];
//                $mvip->where(array('openid' => $openid))->update(['token'=>$data['token'] ]);//更新token
//                $this->_return(1,'获取成功',$data);
//            }else{
//                $data['openid'] = $user['openid'];
//                $data['token'] = md5(time().rand(1000,9999));
//                $data['nickname'] = $user['nickname'];
////                if($user['sex']=='男'){
////                    $user['sex'] = 1;
////                }elseif ($user['sex']=='女'){
////                    $user['sex'] = 2;
////                }else{
////                    $user['sex'] = 0;
////                }
//                $data['sex'] = $user['sex'];
//                $data['head_img'] = $user['headimgurl'];
//                $data['ctime'] = time();
//                $rvip = $mvip->add($data);
//                $this->_return(1,'获取成功',$data);
//            }
//
//        } else {
//            $this->_return(-1,'获取微信信息失败',(object)[]);
//        }
//    }

     /**
     * 小程序登陆处理
     * @param $userInfo
     * @return array|\think\response\Json
     */
    public function weixin_login($userInfo)
    {
        $User = model('user')->where('openid', $userInfo["openid"])->find();
        if ($User) {
            $data['token'] = $User["openid"];
            $dada['user_id']= $User['user_id'];
            return ['data' => $data, 'msg' => '登录成功！', 'code' => 1];
        } else {
            $User = model('user')->insertGetId([
                'token' => $userInfo["openid"],
                'openid' => $userInfo["openid"],
                'username' => $userInfo['nickName'],
                'nickname' => $userInfo['nickName'],
                'sex' => $userInfo['sex'],
                'ctime'=> time(),
                'head_img' => $userInfo['headimgurl'],
                'user_type' => 1,
            ]);
            $data['token'] = $userInfo["openid"];
            $dada['user_id']= $User;
            return ['data' => $data, 'msg' => '登录成功！', 'code' => 1];
        }
    }

    /**
     * 获取用户信息
     * @return [type] [description]
     */
    public function get_user_info()
    {
        return $this->get_user_id();
    }

    /**
     * 判断用户是否登录,根据token获取用户的user_id
     * @return [type] [description]
     */
    public function get_user_id(){
        $token = input('token');
        if(empty($token)) $this->_return(402,'token不能为空');
//        print_r($token);
        $user_id= $this->decodeToken($token);


//        $user = model('user')->where(['token'=>$token])->find();

        $user = model('user')->where(['user_id'=>$user_id])->find();
        if($user){
            $this->get_user_info = $user;
            return $user['user_id'];
        }else{
           abort(json(["msg" => "未登陆", "code" => 401]));
        }
    }

    /**
     * 判断商家是否登录,根据token获取用户的user_id
     * @return [type] [description]
     */
    public function get_shop_id(){
        $token = input('token');
        if(empty($token)) $this->_return(402,'token不能为空');
//        print_r($token);
        $shop_id= $this->decodeToken($token);


//        $user = model('user')->where(['token'=>$token])->find();

        $shop = db('shop')->where(['shop_id'=>$shop_id])->find();
        if($shop){
            $this->get_shop_info = $shop;
            return $shop['shop_id'];
        }else{
            abort(json(["msg" => "未登陆", "code" => 401]));
        }
    }
//获取用户token
    public static function createToken($user_id, $key = 'sub'){
        $token = new \Gamegos\JWT\Token();

        $token->setClaim($key, $user_id);
        $token->setClaim('exp', time() + config('jwt_time'));

        $encoder = new \Gamegos\JWT\Encoder();
        $encoder->encode($token, config('jwt_key'), config('jwt_alg'));
        return  $token->getJWT();
    }


    public static function decodeToken($token, $key = 'sub') {
        try {

            $validator = new \Gamegos\JWT\Validator();
            $token = $validator->validate($token, config('jwt_key'));
            $data = $token->getClaims();

            if($data['exp'] < time()) {
                static::_return(401, 'token已失效');
            }
            return $data[$key];
        } catch (\Gamegos\JWT\Exception\JWTException $e) {
            static::_return(401, 'token错误');
        }
    }
    /**
     * 判断员工是否登录
     * @param  int    $id  | 员工ID
     * @return [type] [description]
     */
    public function get_staff_info($id)
    {
        $user = model('user')->where(['user_id'=>$id])->find();
        if(empty($user)) $this->_return(-1,'此帐号不存在');
        if($user['type'] != 2) $this->_return(-1,'此帐号不是员工');
        return $user;

    }


    /**
     * 判断商家是否登录
     * @param  int    $id  | 员工ID
     * @return [type] [description]
     */
    public function get_shop_info($id)
    {
        $user = Db::name('shop')->where(['shop_id'=>$id])->find();
        if(empty($user)) $this->_return(-1,'此帐号不存在');
        // if($user['type'] != 2) $this->_return(-1,'此帐号不是员工');
        return $user;

    }

     //获取用户token
    public function get_user_token($user_id){
        $token = new \Gamegos\JWT\Token();
        $token->setClaim('user_id', $user_id); // alternatively you can use $token->setSubject('someone@example.com') method
        $token->setClaim('exp', time() + config('jwt_time'));

        $encoder = new \Gamegos\JWT\Encoder();
        $encoder->encode($token, config('jwt_key'), config('jwt_alg'));
        return $token->getJWT();
    }

     /**
     * 直接ajax返回成功信息（返回类型仅适用于json格式）
     * @param int $code  状态
     * @param string $msg   提示信息
     * @param array $data  json数据
     */
    protected function _return($code,$msg,$data=array())
    {
        $info['code'] = $code;
        $info['msg'] = $msg;
        $info['data'] =$data?:array();
        exit(json_encode($info));
    }

    /**
     * 功能： 正则判断手机号
     * @param int $mobile 手机号码
     * @return boolean
     * 三大运营商最新号段 2018年3月1日
    移动号段：
    134 135 136 137 138 139 147 148 150 151 152 157 158 159 172 178 182 183 184 187 188 198
    联通号段：
    130 131 132 145 146 155 156 166 171 175 176 185 186
    电信号段：
    133 149 153 173 174 177 180 181 189 199
    虚拟运营商:
    170
     */
    protected function check_mobile($mobile){
        if(preg_match('#^13[\d]{9}$|^14[5,6,7,8,9]{1}\d{8}$|^15[0,1,2,3,5,6,7,8,9]{1}\d{8}$|^166[\d]{8}$|^17[0,1,2,3,4,5,6,7,8]{1}\d{8}$|^18[\d]{9}$|^19[8,9]{1}\d{8}$#', $mobile)){
            return true;
        }
        return false;
    }

    
    /**
     * 上传图片
     * @param  string  $name [description] 文件内容
     * @param  integer $type [description] 文件类型
     * @return [type]        [description]
     */
    protected function uploads($name='',$type=1){
        // 获取表单上传文件
        $files = request()->file($name);
        $data = array();
        foreach($files as $file){
            // 移动到框架应用根目录/public/uploads/ 目录下
            $info = $file->validate(['ext'=>'jpg,png,gif,jpeg'])->move(ROOT_PATH . 'public' . DS . 'uploads/imgs');
            if ($info) {
                if ($type==2) {
                    $item = array();
                    $item['name'] = $info->getInfo('name');
                    $item['type'] = $info->getInfo('type');
                    $item['savename'] = $info->getFilename();
                    $item['savepath'] = date("Ymd") .'/';
                }else{
                    $item['imgurl'] = '/public' . DS . 'uploads/imgs/'.date("Ymd") .'/'.$info->getFilename();
                    $item['base_imgurl'] = request()->root(true).$item['imgurl'];
                }
                array_push($data,$item);
            } else {
                // 上传失败获取错误信息
                $this->error($file->getError());
            }
        }
        if ($type==2) {
            model('File')->saveAll($data);
        }
        $this->_return(1,'文件上传成功', $data);
    }

     /**
     * 上传图片....
     * @param  string  $filename 图片名称
     * @param  int     $type     返回的数据类型(1:单图 2:多图)
     * @return string            返回的图片路径
     */
    public function upload($filename,$type = 1){
        $files = request()->file($filename);
        if($type == 1){//单图上传
            $info = $files->validate(array('size'=>20000000,'ext'=>'jpg,png,gif,jpeg'))->move(ROOT_PATH .'public'. DS . 'uploads/imgs');
//            print_r($info);
            if($info){
                $item['name'] = $info->getInfo('name');
                $item['type'] = $info->getInfo('type');
                $item['savename'] = $info->getSaveName();
                $item['savepath'] = '/uploads/imgs/';
                $item['savename']= str_replace("\\", '/', $item['savename']);

                Db::name('upload')->insert($item);
                return '/uploads/imgs/'.$item['savename'];
            }else{
                _return(-1,"".$files->getError()."",(object)array());
            }
        }else{//多图上传
            $str =  '';
            foreach($files as $file){
                $info = $file->validate(array('size'=>20000000,'ext'=>'jpg,png,gif,jpeg'))->move(ROOT_PATH .'public'. DS . 'uploads/imgs');
                if($info){
                    $item = array();
                    $item['name'] = $info->getInfo('name');
                    $item['type'] = $info->getInfo('type');
                    $item['savename'] = $info->getSaveName();
                    $item['savepath'] = '/uploads/imgs/';
                    Db::name('upload')->insert($item);
                   $str   .='/uploads/imgs/'.str_replace("\\", '/', $info->getSaveName()).',';
                }else{
                    _return(-1,"".$file->getError()."",(object)array());
                }
            }
             return $str;
        }
        
    }


    //判断登录openid
    protected function checkOpenid(){
        $openid = $_GET['openid'];
        if(empty($openid))$openid = $_POST['openid'];
        if(empty($openid))$openid = $_SERVER['openid'];
        if(empty($openid))$openid = $_SERVER['HTTP_OPENID'];
        $this->openid = $openid; // token
        if(empty($this->openid))
            exit(json_encode(array('code'=>101,'msg'=>'openid不能为空')));
        $map['b.openid'] = $this->openid;
        $user = model('user')->user_info($map);
        $this->user = $user;
        $this->user_id = $user['user_id'];
        if(empty($this->user))
            exit(json_encode(array('code'=>101,'msg'=>'token错误')));
    }

    //获取省市县
    protected function get_area($xian_id){
        $city_id = substr($xian_id,0,4).'00';
        $area_id = substr($xian_id,0,2).'00';
        $xian_name = db('location')->where('id',$xian_id)->value('name');
        $city_name = db('location')->where('id',$city_id)->value('name');
        $area_name = db('location')->where('id',$area_id)->value('name');
        return [$area_name,$city_name,$xian_name];
    }
	
	/**
     * curl执行url
	 * @param string  $topic        请求的地址
	 * @param json    $data         要发送的内容
	 * @return [json] 
     */
	protected function postCurl($url,$json){
		//echo $json; die;
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_NOBODY, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS,$json);
		/*curl_setopt($curl, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Content-Length: ' . strlen($json))
		);*/
		$return_str = curl_exec($curl);
		curl_close($curl);
		// $this->ajaxReturn($return_str);
		return $return_str;
	}
    /*
   * 调取机器云向下协议透传
   * @param $macno  设备号
   * @param $type  类型  （1：购买商品 2：补货 3：补货异常 5：清空商品 , 6上传安卓日志  7 更新广告轮播  8 更新版本 ）
   * @param $msg  提示
   * @param $notify_url  地址
   */
    public function set_device($macno,$type,$order_number){
        $arr['type']=$type;
        $arr['notify_url']='http://sdxddshg.app.xiaozhuschool.com/wxsite/Public/get_open_arr';
        $arr['order_number']=$order_number;
        $json_str=json_encode($arr,true);
        $data['macno'] = 'com.dlc.thinkingvalley_'.$macno;
        $data['version'] = 3;
        $data['sign'] = md5('dlcshouhuogui');
        $data['data']=$json_str;

        $res  = httpPost('http://10.27.204.40/shouhuogui/n_operate',$data);
        $res = json_encode($res,true);
        write_log('retrievalDoor','发送数据'.json_encode($data,true));
        write_log('retrievalDoor','机器云返回数据'.$res);
        write_log('OpenDoor','机器云返回数据'.$res.'------发送数据----'.json_encode($data,true));

        return $res;

    }
}

