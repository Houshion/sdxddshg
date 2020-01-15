<?php
namespace app\apk\controller;

use app\apk\controller\MqttController; 

use think\Model;
use think\Db;
use app\wxsite\controller\DeviceController;
/* phpMQTT */

class IndexController 
{
	protected $server = "120.77.72.190";     // 服务代理地址(mqtt服务端地址)
	
	protected $port = 1883;                // 通信端口
	
	protected $username = 'dlc';          // 用户名(如果需要)
	
	protected $password = '123456';       // 密码(如果需要）
	
	protected $url = 'http://10.27.204.40/message/sendmessage';  //webSocket请求地址

    /**
     * Mqtt 发布主题
     * @param string  $topic        发布的主题
     * @param json    $data         要发送的内容
     * @param int     $qos          模式 0.发送不保证收到    1.最少收到1次  2.收到并且只收到1次
     * @param string  $client_id    唯一
     * @return [true] [false]
     */
    public function publish($topic = "xls001/box_001/event",$data = '',$qos = 0,$client_id = ''){
        $c = new \Mosquitto\Client();
        $c->setCredentials($this->username,$this->password);
        $c->connect($this->server,$this->port,5);
        $c->loop();
        $c->publish($topic, $data, 0);
        $c->loop();
        $c->disconnect();
        write_log('mqtt-publish', $topic.': '.$data);
    }

    public function test($topic){
		// 发送给订阅号信息,创建socket,无sam队列
		$server = $this->server;     
		$port = $this->port;                     
		$username = $this->username;                
		$password = $this->password;                 
		$mqtt = new MqttController($server, $port, time()); //实例化MQTT类
		if ($mqtt->connect(true, NULL, $username, $password)) { 
		   //如果创建链接成功
		   // {"doorOpen":"customer"}
		   write_log('openDoor',"补货发送开门命令: {'doorOpen':'customer'} 主题topic： ".$topic);
		   $re = $mqtt->publish($topic,'{"doorOpen":"customer"}',0); 
		   // 发送到 xxx3809293670ctr 的主题 一个信息 内容为 setr=3xxxxxxxxx Qos 为 0 
		   $mqtt->close();    //发送后关闭链接
		   //return true;
		   echo 'OK';
		} else {
			echo "Time out!\n"; 
		}
	}
    //设备心跳
    public function deviceStatus($params = array()){
        write_log('mqtt',"mqtt心跳上来刚开始的时间：".date('Y-m-d H:i:s',time()));

        $macno = input('macno') ? : $params['macno'];
        $version= input('version') ? : $params['version'];
        write_log('mqtt',"设备号：".$macno." 版本：".$version." 时间：".date('Y-m-d H:i:s',time()));

        if($macno){
            $find= db('device')->where(array('macno' => $macno))->find();
            if($find['status']==1){
               $res= Db::name('device')->where(array('macno' => $macno))->update(array( 'htime' => time(),'version'=>$version));
            }else{
                $res=  Db::name('device')->where(array('macno' => $macno))->update(array('status' => 0, 'htime' => time(),'version'=>$version));
            }
            if($res){

                $json = '{"deviceManager":"heartbeat"}';
                $client_id = time();
                 $this->publish($macno,$json,0,$client_id);
                write_log('mqtt',"mqtt推送的时间：".date('Y-m-d H:i:s',time()));


            }
        }
    }

    //设备开门状态
    public function doorOpen(){
        $post= input('post.');
        write_log('get_open_json',"接受数据: ".json_encode($post,true));
        $user_id= db('order')->where('order_number',$post['oid'])->value('user_id');
        write_log('get_open_json',"get_open_arr----user_id--one--=: "."sdxddshg_".$user_id);
        if(!$user_id){
            $user_id=  db('device_order')->where('order_number',$post['oid'])->value('staff_id');
            write_log('get_open_json',"get_open_arr----user_id--two--=: "."sdxddshg_".$user_id);
        }

        //开门状态返回
        if($post['door_type']==1){
            $macno= str_replace('com.dlc.thinkingvalley_','',$post['macno']);
            switch ($post['type']){
                case 1:
                    $where['b.macno'] = $macno;
                    $where['a.status'] = 1;
                    $user_id = Db::name('order')->alias('a')->join('dlc_device b','a.device_id = b.device_id')->where($where)->find();
                    if($post['status'] == 1){
                        $list=array();
                        $list['type']=0;
                        $re1= $this->notifyH5(1,'购买商品开门成功',"sdxddshg_close_".$user_id['user_id'],$list,$user_id['order_number']);

                        write_log('doorOpen',"购物开门成功 设备编号：".$macno." 开门状态：".$post['status']." 开门类型：".$openType." 用户id：".$user_id['user_id'].'---soket--'.json_encode($re,true));

                    }else{

                        $list=array();
                        $list['type']=0;
                        $re1= $this->notifyH5(-1,'购物开门失败',"sdxddshg_close_".$user_id['user_id'],$list,$user_id['order_number']);

//                        $re= $this->notifyH5Message(-1,'购物开门失败',"sdxddshg_".$user_id['user_id'],$user_id['order_number']);
                        rite_log('doorOpen',"购物开门成功 设备编号：".$macno." 开门状态：".$post['status']." 开门类型：".$openType." 用户id：".$user_id['user_id'].'---soket--'.json_encode($re,true));
                        $this->addMessage($macno);
                    }
                break;
                case 2:
                    $where['b.macno'] = $macno;
                    $where['a.status'] = 1;
                    if($post['status'] == 1){

                        $re = Db::name('device_order')->alias('a')->join('dlc_device b','a.device_id = b.device_id')->where($where)->find();
                        //通知前端开门成功
                        $list=array();
                        $list['type']=0;
                        $re1=$this->notifyH5(1,'补货开门成功',"sdxddshg_close_".$re['staff_id'],$list,$re['order_number']);
                        write_log('doorOpen',"发送返回数据1".$re1);
                    }else{

                        $this->addMessage($macno);
                        $wap['macno'] = $macno;
                        $wap['status'] = 1;
                        $map['device_id'] = Db::name('device')->where($wap)->value('device_id');
                        $staff_id = Db::name('device_order')->where($map)->value('staff_id');
                        $re = Db::name('device_order')->where($map)->delete();
                        write_log('userDoor',"补货成功失败: qzqianpa_open_".$staff_id);
                        //通知前端开门成功
                        write_log('doorOpen',"补货开门失败 设备编号：".$macno." 开门状态：".$status." 开门类型：".$openType." 补货员id：".$staff_id);
                        $list=array();
                        $list['type']=0;
                       $re1= $this->notifyH5(-1,'补货开门失败',"sdxddshg_close_".$staff_id,$list,$re['order_number']);
                        write_log('doorOpen',"发送返回数据".$re1);
                    }
                    break;
                case 4:

                    break;
                case 5:
                    $this->notifyH5Message(1,'商品清空开门成功',"sdxddshg_".$post['oid'],$post['oid']);
                    write_log('get_open_json',"商品清空开门通知前端websocket的udid: "."sdxddshg_".$post['oid']);
                    break;
            }
        }

        elseif ($post['door_type']==2){
            $macno= str_replace('com.dlc.thinkingvalley_','',$post['macno']);
            switch ($post['type']){
                case 1:

//                    if($post['status']==1){
////                        db('order')->where(array('user_id'=>$user_id,'num'=>0))->update(array('status'=>-1));
////                        $mqtt->notifyH5(1,'购买商品成功',"sdxddshg_close_".$user_id,array(),$post['oid']);
//                    }else{
//                        write_log('OpenDoor',"购买商品关门失败通知前端websocket的udid: "."sdxddshg_close_".$user_id);
//                        $mqtt->notifyH5(1,'购买商品关门门失败',"sdxddshg_close_".$user_id,array(),$post['oid']);
//                        write_log('get_open_json',"购买商品关门失败通知前端websocket的udid: "."sdxddshg_close_".$user_id);
//
//                    }
                    break;
                case 2:
                    if($post['status']==1){
                        $device_id= db('device_order')->where('order_number',$post['oid'])->value('device_id');
                        if($device_id){
                            $res=  db('device')->where('device_id',$device_id)->update(array('doorstatus'=>0,'open_status'=>3));
                        }

//                     $mqtts=  $mqtt->notifyH5(1,'补货关门成功',"sdxddshg_close_".$user_id,array(),$post['oid']);
                        write_log('get_open_json',"补货关门成功成功通知前端websocket的udid-----: "."sdxddshg_".$user_id.'--设备号----'.$macno.'--------sql----');


                        write_log('retrievalDoor',"补货关门成功成功通知前端websocket的udid-----: "."sdxddshg_".$user_id.'--设备号----'.$macno.'--------修改设备状态sql执行结果----'.$res.'----socket---返回数据');

                    }else{

//                       $mqtt->notifyH5(1,'补货关门失败',"sdxddshg_close_".$user_id,array(),$post['oid']);
                        rite_log('retrievalDoor',"补货关门成功失败通知前端websocket的udid-----: "."sdxddshg_".$user_id.'--设备号----'.$macno);
                        write_log('get_open_json',"补货关门失败通知前端websocket的udid: "."sdxddshg_close_".$user_id);

                    }
                    break;
                case 4:
                    break;
                case 5:
                    $this->notifyH5(1,'商品清空成功',"sdxddshg_close_".$post['oid'],array(),$post['oid']);
                    write_log('get_open_json',"盘点成功通知前POST数据".json_encode($post,true));
                    write_log('get_open_json',"商品清空通知前端websocket的udid: "."sdxddshg_close_".$post['oid']);
                    break;
            }
        }else{
            write_log('get_open_json',"不做处理开门状态返回不对door_type=".$post['door_type'].'------设备开启状态status='.$post['status']);
        }



//       dump($user_id);die;


    }
    /*
 * 调取机器云向下协议透传
 * @param $macno  设备号
 * @param $type  类型  （1：购买商品 2：补货 3：补货异常 5：清空商品 ）
 * @param $msg  提示
 * @param $notify_url  地址
 */
    public function set_device($macno,$type,$order_number){
        $arr['type']=$type;
        $arr['notify_url']='http://sdxddshg.app.xiaozhuschool.com/wxsite/Public/get_open_arr';
        $arr['order_number']=$order_number;
        $json_str=json_encode($arr,true);
        $data['macno'] = $macno;
        $data['version'] = 2;
        $data['sign'] = md5('dlcshouhuogui');
        $data['data']=$json_str;
        $res  = httpPost('http://10.27.204.40/shouhuogui/operate',$data);
        $res = json_encode($res,true);
        return $res;

    }

    //添加异常消息
    public function addMessage($macno='867732032956948')
    {
        $find = Db::name('device a')
            ->join('dlc_network b','b.network_id=a.network_id')
            ->where('macno',$macno)->field('a.*,b.address')->find();
        if($find){
            $arr['type'] = 2;
            $arr['user_id'] = $find['user_id'];
            $arr['macno']   = $find['macno'];
            $arr['describe']= '开锁异常，请尽快维修';
            $arr['ctime']   = time();
            $arr['address'] = $find['address'] ? : '';
            Db::name('message')->insert($arr);
        }
    }
	public function notifyH5($code = 0,$msg = '',$udid = '',$list = '',$order_number = '',$url = 'http://10.27.204.40/message/sendmessage',$order_id = 0){
		$info['code'] = $code;
		$info['msg'] = $msg;
		$info['order_number'] = $order_number;
		if($order_id != 0)$info['order_id'] = $order_id;
		$info['data'] = $list;
		$data['data'] = $info;
		$data['udid']  = $udid;
		$new_data['data'] = json_encode($data);
		write_log('userDoor',"安卓notifyH5  data=".json_encode($data));
		//Db::name("test")->insert(array("content"=>"安卓notifyH5  data=".json_encode($data),"ctime"=>time()));
		$re = $this->postCurl($url,$new_data);
        write_log('userDoor',"--notifyH5---soket发送数------".$re);
		$rejson['code'] = 1;
		$rejson['msg'] = "请求成功";
		$rejson['data'] = $re;
		echo json_encode($rejson);
		return json_encode($rejson,true);
	}
	
	public function notifyH5Message($code = 0,$msg = '',$udid = '',$order_number = '',$url = 'http://120.77.72.190:9999:9999/message/sendmessage'){
		$info['code'] = $code;
		$info['msg'] = $msg;
		$info['order_number'] = $order_number;
		$data['data'] = $info;
		$data['udid']  = $udid;
		$new_data['data'] = json_encode($data);
		$re = $this->postCurl($url,$new_data);
		$rejson['code'] = 1;
		$rejson['msg'] = "请求成功";
		$rejson['data'] = $re;
        write_log('userDoor',"---notifyH5Message---soket发送数据------".$re);
        write_log('userDoor',"---notifyH5Message---soket返回数据------".json_encode($rejson,true));
		echo json_encode($rejson,true);
        return json_encode($rejson,true);
	}
    /*
         * 获取更新版本信息
         */
    public function updateversion(){
        $find= db('version_set')->where('version_id',1)->find();
        if(!empty($find['ctime'])){
            $find['ctime']=date('Y-m-d H:i:s',$find['ctime']);
        }
        if(!empty($find['url'])){
            $find['url']='http://'.$_SERVER['HTTP_HOST'].$find['url'];
        }
        $data['code']=1;
        $data['msg']='success';
        $data['data']=$find;
        die(json_encode($data));

    }
    /*
     * 设备上报故障
     */
    public function reportFault(){
        $macno= input('macno');
        $content= input('content');
        if(empty($macno)){
            $data['code']=-1;
            $data['msg']='设备号不能为空';
            $data['data']=$macno;
            die(json_encode($data));
        }
        if(empty($content)){
            $data['code']=-1;
            $data['msg']='故障信息不能为空';
            $data['data']=$content;
            die(json_encode($data));
        }
        $find= db('device')->where('macno',$macno)->find();
        if(empty($find)){
            $data['code']=-1;
            $data['msg']='设备不存在';
            $data['data']=$find;
            die(json_encode($data));
        }
        $data1['macno']=$macno;
        $data1['content']=$content;
        $data1['shop_id']=$find['shop_id'];
        $data1['ctime']=time();
        db('device_fault')->insertGetId($data1);
        db('device')->where('macno',$macno)->update(array('status'=>1,'reason'=>$content));
        $data['code']=1;
        $data['msg']='success';
        die(json_encode($data));
    }
	 /**
     * APK清除商品回调
     * @param  string  $macno           | 设备编号
     * @param  int     $status          | 开门状态（1为成功 0为失败）
     * @param  int     user_id          | 员工id 
     * @return 
     */
//    public function removeGoodsNotify($macno,$status){
////    	$macno = input('macno');
////		$status = input('status');
//    	$where['b.macno'] = $macno;
//		$re = Db::name('device_order')->alias('a')->join('dlc_device b','a.device_id = b.device_id')->where($where)->find();
//		write_log('removeGoodsNotify',"清除商品notifyH5  data=".json_encode($re,true));
//		$url = $this->url;
//		if($status == 1){
//        	$device = Db::name('device')->where(array('macno'=>$macno))->find();
//			$res1 = Db::name('device_goods')->where('device_id',$device['device_id'])->update(array('inventory'=>0,'rfid'=>''));
//        	$res2 = Db::name('rfid')->where(array('device_id'=>$device['device_id'],'status'=>2))->setField('status',1);
//        	$where1['device_id']=$device['device_id'];
//        	$where1['status']=['in',[1,2]];
//        	db('device_order')->where($where1)->update(array('status'=>4));
//			$info['code'] = 1;
//			$info['msg'] = "清空商品成功";
//			$data['data'] = json_encode($info);
//			$data['udid']  = "sdxddshg_close_".$re['staff_id'];
//			$json = json_encode($data);
//			$new_data['data'] = $json;
//			write_log('removeGoodsNotify',"清除商品之后返回给前端的  data=".$json);
//            $this->notifyH5(1,'清除商品开门成功',"sdxddshg_close_".$re['staff_id'],array(),'');
//            write_log('removeGoodsNotify',"清除商品之后返回给前端的  data="."sdxddshg_close_".$re['staff_id']);
////			$re = $this->postCurl($url,$new_data);
//            die( json_encode($info,true));
//		}else{
//			$info['code'] = -1;
//			$info['msg'] = "清空商品失败";
//			$data['data'] = json_encode($info);
//			$data['udid']  = "sdxddshg_close_".$re['staff_id'];
//			$json = json_encode($data);
//			$new_data['data'] = $json;
//            die(json_encode($info,true)) ;
//            $this->notifyH5(-1,'清除商品开门失败',"sdxddshg_close_".$re['staff_id'],array(),'');
////			$re = $this->postCurl($url,$new_data);
//		}
//		$rejson['code'] = 1;
//		$rejson['msg'] = "成功";
//		$rejson['data'] = $re;
//		Db::name('test')->insert(array('content'=>"通知H5清除商品成功".json_encode($rejson),'ctime'=>time()));
////		echo json_encode($rejson);
//        die( json_encode($rejson,true));
//	}
    public function removeGoodsNotify($params = array()){
        $macno = input('macno')  ? : $params['macno'];
        $status = input('status') ? : $params['status'];
        write_log('removeGoodsNotify',"deivce:清除商品 设备号".$macno);
        $where['b.macno'] = $macno;
        $re = Db::name('device_order')->alias('a')->join('dlc_device b','a.device_id = b.device_id')->where($where)->find();
        $url = $this->url;


        $device = Db::name('device')->where(array('macno'=>$macno))->find();

        $res1 = Db::name('device_goods')->where('device_id',$device['device_id'])->update(array('inventory'=>0,'rfid'=>''));
        $res2 = Db::name('rfid')->where(array('device_id'=>$device['device_id'],'status'=>2))->update(array('status'=>1,'device_id'=>0));
        //设备所有补货订单置为取消
        $wap['status'] = array('IN','1,2');
        $wap['device_id'] = $device['device_id'];
        $res3 = Db::name('device_order')->where($wap)->update(array('status'=>-1));
        $info['code'] = 1;
        $info['msg'] = "清空商品成功";
        $data['data'] = json_encode($info);
        $data['udid']  = "sdxddshg_close_".$device['user_id'];
        $json = json_encode($data);
        $new_data['data'] = $json;
        write_log('removeGoodsNotify',"deivce:清除商品之后返回给安卓的  data=".$json);
        $re = $this->postCurl($url,$new_data);
        return;//echo json_encode($rejson);
    }
	public function subscribe($client_id = "box_001"){
		set_time_limit(0);
		// 订阅信息,接收一个信息后退出
		$server = $this->server;     
		$port = $this->port;                     
		$username = $this->username;                
		$password = $this->password;                 
		$client_id = $client_id;   
		$mqtt = new MqttController($server, $port, $client_id);
		if(!$mqtt->connect(true, NULL, $username, $password)) { //链接不成功再重复执行监听连接
			exit(1);
		}
		$topics['xls001/box_001/event'] = array("qos" => 0, "function" => "procmsg");
		// 订阅主题为 testlink qos为0
		$mqtt->subscribe($topics, 0);
		while($mqtt->proc()){
		}
		//死循环监听
		$mqtt->close();
		function procmsg($topic, $msg){ //信息回调函数 打印信息
			echo "Msg Recieved: " . date("r") . "\n";
			echo "Topic: {$topic}\n\n";
			echo "\t$msg\n\n";
			$xxx = json_decode($msg);
			var_dump($xxx->aa);
			die;
		}
	}
	
	public function websend($url, $post_data = array()){
		$url_array = parse_url($url);
		$hostname = $url_array['host'];
		$port = isset($url_array['port']) ? $url_array['port'] : 80;
		$requestPath = $url_array['path'] . "?" . $url_array['query'];
		$fp = fsockopen($hostname, $port, $errno, $errstr, 10);
		if (!$fp) {
			echo "$errstr ($errno)";
			return false;
		}
		$method = "GET";
		if (!empty($post_data)) {
			$method = "POST";
		}
		$header = "$method $requestPath HTTP/1.1\r\n";
		$header .= "Host: $hostname\r\n";
		if (!empty($post_data)) {
			$_post = strval(NULL);
			foreach ($post_data as $k => $v) {
				$_post[] = $k . "=" . urlencode($v);//必须做url转码以防模拟post提交的数据中有&符而导致post参数键值对紊乱
			}
			$_post = implode('&', $_post);
			$header .= "Content-Type: application/x-www-form-urlencoded\r\n";//POST数据
			$header .= "Content-Length: " . strlen($_post) . "\r\n";//POST数据的长度
			$header .= "Connection: Close\r\n\r\n";//长连接关闭
			$header .= $_post; //传递POST数据
		} else {
			$header .= "Connection: Close\r\n\r\n";//长连接关闭
		}
		fwrite($fp, $header);
		//-----------------调试代码区间-----------------
		/*$html = '';
		while (!feof($fp)) {
			$html.=fgets($fp);
		}
		echo $html;*/
		//-----------------调试代码区间-----------------
		fclose($fp);
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

    public function soket(){
        $mqtt = new IndexController();
        $re1=$this->notifyH5Message(1,'补货开门成功',"sdxddshg_101");
        $re2=$this->notifyH5(1,'补货关门门成功',"sdxddshg_close_101",array(),'B201811067942');
        echo $re1;
//        print_r($re2);
    }
	
}