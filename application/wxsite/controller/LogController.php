<?php
/**
 * Created by PhpStorm.
 * User: 马远利
 * Date: 2018/5/21 0021
 * Time: 22:30
 */

namespace app\wxsite\controller;

use think\Db;
use think\Controller;

class LogController extends Controller
{

   public function _initialize()
   {
       parent::_initialize(); 
   }

   public function writeLog(){
	   $msg = input('msg');
	   write_log('apk',$msg);
	   $info['code'] = 1;
	   $info['msg'] = '写入成功';
	   echo json_encode($info);
   }
    public function readLog($name){
        read_log($name);
    }
    function read_log($name){

        $file ='http://'. $_SERVER['HTTP_HOST'].'/runtime/log/'.$name.'.txt';
        header("Content-Type: text/html; charset=utf-8");
        if(empty($file))$file = $_GET['file'];
        $myfile = fopen($file, "r") or die("Unable to open file!");
        $string = fread($myfile,filesize($file));
        fclose($myfile);
        echo '<pre>'.$string.'</pre>';
    }
    public function uploadLog(){
        $name = input("name");
        $files = request()->file('file');
        $upload = $files->validate(array('size'=>20000000,'ext'=>'txt'))->move('./runtime/log',$name);
        $info['code'] = 1;
        $info['msg'] = '上传成功';
        $info['data'] = $upload;
        echo json_encode($info);
    }
}













