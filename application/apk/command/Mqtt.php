<?php
namespace app\apk\command;

use think\console\Command;
use think\console\Input;
use think\console\Output;

class Mqtt extends Command {
	protected $server = "120.77.72.190";     // 服务代理地址(mqtt服务端地址)	
	protected $port = 1883;                // 通信端口	
	protected $username = 'dlc';          // 用户名(如果需要)	
	protected $password = '123456';       // 密码(如果需要）
	protected $appUrl = '';

    protected function configure()
    {
        $this->setName('Mqtt')->setDescription('Here is the Mqtt');
    }
	
	//中文文档https://www.kancloud.cn/liao-song/mosquitto-php/500403
    protected function execute(Input $input,Output $output){
		$this->appUrl =  $_SERVER['HTTP_HOST'] ? 'https://'.str_replace('.app.', '.https.', $_SERVER['HTTP_HOST']).'/' : 'https://qzqianpa.https.xiaozhuschool.com/';
		try{
			write_log('mqtt', 'start');
			$c = new \Mosquitto\Client();
			$c->setCredentials($this->username,$this->password);
			$c->connect($this->server,$this->port,5);
			$c->subscribe('qzqianpa_api /#', 2);
			write_log('mqtt', 'startok');
			$c->onMessage(function($m) use ($input, $output){
					write_log('mqtt', 'message');
					$output->writeln("\n".date('Y-m-d H:i:s')." : ".json_encode($m)."\n");
					try{
						$api = explode('/', $m->topic, 2);
						$api = trim($api[1], '/');
						if(!$api)$api = 'wxsite/Device/api';
						$payload = json_decode($m->payload, true);
						if(is_array($payload)){
							//action($api, ['params' => $payload]);
							@post_url($this->appUrl.$api, $payload);
							//$output->writeln("payload: ".var_export($payload, true));
							//$output->writeln("api: ".$api);
							$output->writeln("\n".$api." : ".date('Y-m-d H:i:s')." : ".json_encode($m)."\n");
							write_log('mqtt', $api." : ".date('Y-m-d H:i:s')." : ".json_encode($m));
						}
					}catch(\Exception $e1){
						write_log('mqtt', 'error1: '.$e1->getMessage());
						$output->writeln("\n".$e1->getMessage()."\n");
					}
					write_log('mqtt', 'done');
			});
			$c->loopForever();
		}catch(\Exception $e2){
			write_log('mqtt', 'error2: '.$e2->getMessage());
			$output->writeln("\n".$e2->getMessage()."\n");
		}
    }
}
?>