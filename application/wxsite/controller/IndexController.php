<?php
namespace app\wxsite\controller;
/** 
 * 马远利
 */
use think\Controller;
use \think\Loader;
use \think\Db;
use \think\Model;


class IndexController extends Controller{
    public $appUrl;
    public $user_id;
    public function _initialize()
    {
        // $this->appUrl = request()->root(true);
        $this->appUrl = 'http://'.$_SERVER['HTTP_HOST'].'/';
    }

    public function mach()
    {
	    $macno = input("macno");
	    $url = 'http://sdxddshg.app.xiaozhuschool.com/h5/html/opening.html?macno='.$macno;
        header("location: $url");   
    }

//    public function get_code(){
//        if (!$_GET['auth_code']) {
//            $url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
//            $appid = 'wx3a9ffa0767b67e9a';
//            $redirect_uri = urlencode($url);
//            $url ="https://openauth.alipay.com/oauth2/publicAppAuthorize.htm?app_id=".$appid."&scope=auth_userinfo&redirect_uri=".$url;
//            header("location: $url");
//        }
//        echo $_GET['auth_code'];
//
//    }

    public function get_userInfo(){

    }
	
	//读取显示log
	public function index($name){
		read_log($name);
	}

   public function clear($name){
		clear_log($name);
	}


    public function colseGoods(){
        Db::name('device_goods')->where('1=1')->delete();
        Db::name('device_order')->where('1=1')->delete();
        Db::name('device_orderinfo')->where('1=1')->delete();
        Db::name('rfid')->where('1=1')->update(['status'=>1]);
        Db::name('order')->where('1=1')->delete();
        Db::name('order_info')->where('1=1')->delete();
    }
}