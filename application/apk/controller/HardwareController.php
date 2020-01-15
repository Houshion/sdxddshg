<?php
namespace app\apk\controller;

use app\apk\controller\MqttController; 
/* phpMQTT */

class HardwareController 
{
	protected $server = "47.98.238.36";     // 服务代理地址(mqtt服务端地址)
	
	protected $port = 61613;                // 通信端口
	
	protected $username = 'admin';          // 用户名(如果需要)
	
	protected $password = 'password';       // 密码(如果需要）
	
	
	/**
     * Mqtt 发布主题
	 * @param string  $topic        发布的主题
	 * @param json    $data         要发送的内容
	 * @param int     $qos          模式 0.发送不保证收到    1.最少收到1次  2.收到并且只收到1次
	 * @param string  $client_id    唯一通信代理id
	 * @return [true] [false]
     */
 	public function publish($topic = "xls001/box_001/event",$data = '',$qos = 0,$client_id = ''){
		// 发送给订阅号信息,创建socket,无sam队列
		$server = $this->server;     
		$port = $this->port;                     
		$username = $this->username;                
		$password = $this->password;                 
		$mqtt = new MqttController($server, $port, $client_id); //实例化MQTT类
		if ($mqtt->connect(true, NULL, $username, $password)) { 
		   //如果创建链接成功
		   // {"doorOpen":"customer"}
		   $re = $mqtt->publish($topic,$data,$qos); 
		   // 发送到 xxx3809293670ctr 的主题 一个信息 内容为 setr=3xxxxxxxxx Qos 为 0 
		   $mqtt->close();    //发送后关闭链接
		   
		} else {
			echo "Time out!\n"; 
		}
	}  
	
	/**
     * Mqtt 安卓订阅成功主题，操作成功，返回http请求
	 * @param string  $topic        发布的主题
	 * @param json    $data         要发送的内容
	 * @param int     $qos          模式 0.发送不保证收到    1.最少收到1次  2.收到并且只收到1次
	 * @param string  $client_id    唯一通信代理id
	 * @return [json] code = 1 成功  其它请求重发
     */
	public function getSubscribe(){
		$info['code'] = 1;
		$info['msg']  = "成功";
		return ($info);
	}
	
}