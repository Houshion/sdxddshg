<?php

namespace app\alisite\controller;

use think\Controller;
use think\Model;
use think\Db;
use think\Config;
use think\Request;
use think\View;
use think\Session;

class BaseController extends Controller
{
    protected $user_id;//用户id
    protected $user;//用户信息
    protected $openid; 

    public function _initialize(){
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
        $user = model('user')->where(['token'=>$token])->find();
        if($user){
            $this->get_user_info = $user;
            return $user['user_id'];
        }else{
           abort(json(["msg" => "未登陆", "code" => 401]));
        }
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
     * 判断商家/补货员是否登录
     * [judge_user_login description]
     * @param  [type] $id   [description] 商家/补货员ID
     * @param  [type] $type [description] 状态（1：商家 2：补货员）
     * @return [type]       [description]
     */
    public function judge_user_login($id,$type)
    {
        if($id){
            if($type ==1){
                $result = model('seller')->where(array('seller_id'=>$id,'status'=>1))->find();
                if($result){
                    return $result;
                }
                $this->_return(101,'此用户不是商家',101);
            }else{
                $result = model('user')->user_field(array('id'=>$id,'user_type'=>3));
                if($result){
                    return $result;
                }
                $this->_return(101,'此用户不是补货员',101);
            }
        }
        $this->_return(101,'未登陆',101);
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
        $info['data'] =$data?:(object)array();
        exit(json_encode($info));
    }

    /**
     * 手机号正则判断 正确返回false，错误返回true
     * [check_mobile description]
     * @param  [type] $phone [description] 手机号
     * @return [type]        [description]
     */
    protected function check_mobile($phone){
        if(preg_match("/^1[34578]\d{9}$/", $phone)){
            return false;
        }
        return true;
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
            if($info){
                return '/uploads/imgs/'.$info->getSaveName();
            }else{
                _return(-1,"".$files->getError()."",(object)array());
            }
        }else{//多图上传
            $str =  '';
            foreach($files as $file){
                $info = $file->validate(array('size'=>20000000,'ext'=>'jpg,png,gif,jpeg'))->move(ROOT_PATH .'public'. DS . 'uploads/imgs');
                if($info){
                   $str   .='/uploads/imgs/'.$info->getSaveName().',';
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

}
?>
