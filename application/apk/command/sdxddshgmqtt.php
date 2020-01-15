<?php
$c = new Mosquitto\Client;
$c->setCredentials('dlc','123456');
$c->connect('120.77.72.190',1883, 50);
$c->subscribe('sdxddshg_api/#', 1);
$c->onMessage(function($m) {
    $api = explode('/', $m->topic, 2);
    $api = trim($api[1], '/');
    if(!$api)$api = 'wxsite/Device/api';
    $payload = json_decode($m->payload, true);
    if(is_array($payload)){
        @post_url('http://sdxddshg.app.xiaozhuschool.com/'.$api, $payload);
    }

      var_dump($m);
});
$c->loopForever();

function post_url($url, $post = '', $files = '', $host = '', $referrer = '', $cookie = '', $proxy = '', $useragent = 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1)'){
    if(empty($post) && empty($files) && empty($host) && empty($referrer) && empty($cookie) && empty($proxy) && empty($useragent))return @file_get_contents($url);
    $method = 'POST';//empty($post) && empty($files) ? 'GET' : 'POST';
    if($post && is_array($post)){
      if(count($post) != count($post, 1))$post = http_build_query($post);
    }

    $ch = @curl_init();
    @curl_setopt($ch, CURLOPT_URL, $url);
    if($proxy)@curl_setopt($ch, CURLOPT_PROXY, 'http://'.$proxy);
    if($referrer)@curl_setopt($ch, CURLOPT_REFERER, $referrer);
    @curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
    if($cookie){
      @curl_setopt($ch, CURLOPT_COOKIE, $cookie);
      //@curl_setopt($ch, CURLOPT_COOKIEJAR, COOKIE_FILE_PATH);
      //@curl_setopt($ch, CURLOPT_COOKIEFILE, COOKIE_FILE_PATH);
    }
    @curl_setopt($ch, CURLOPT_HEADER, 0);
    @curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    @curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    @curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
    @curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    @curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);

    if ($method == 'POST') {
      @curl_setopt($ch, CURLOPT_POST, 1);
      //处理文件上传
      if($files){
        if(!$post)$post = array();
        foreach($files as $k => $v){
          if (class_exists('CURLFile')) {
            $post[$k] = new CURLFile(realpath($v));
          } else {
            $post[$k] = '@'.realpath($v);
          }
        }
      }
      @curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    }

    $result = @curl_exec($ch);
    @curl_close($ch);
    return $result;
}
