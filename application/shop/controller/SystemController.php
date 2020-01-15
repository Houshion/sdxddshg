<?php
namespace app\shop\controller;

use think\Db;
class SystemController extends BaseController
{
    //默认页面
	public function index()
    {
       $bread = array(
            '0' => array(
                'name' => '系统设置',
                'url' => url('shop/index/index?type=3'),
            ), 
        );
		$type = input('type');
		if(empty($type))$type = 1;
        $this->assign('breadhtml', $this->getBread($bread));
		if($type == 1){
			$cache = db('shop')->where('shop_id',$this->shop_id)->find();
			$this->assign('cache',$cache);
        	echo $this->fetch();
		}elseif($type == 2){
			$cache = model('sms')->where('id','1')->find();
			$this->assign('cache',$cache);
			echo $this->fetch('sms_index');
		}elseif($type == 3){
//			$cache = model('shop_wxset')->where('shop_id',$this->shop_id)->find();
//			$this->assign('cache',$cache);
//            echo $this->fetch('wxpay_index');
//            $cache = db('banner')->where(['shop_id'=>$this->shop_id,'type'=>2])->find();
//            $this->assign('cache',$cache);
//            echo $this->fetch('banner_logo');
            $cache = db('shop')->where('shop_id',$this->shop_id)->find();
            $this->assign('cache',$cache);
            echo $this->fetch();
		}elseif($type == 4){
			$cache = model('alipay')->where('id','1')->find();
			$this->assign('cache',$cache);
			echo $this->fetch('alipay_index');
		}
//        elseif($type == 5){
//            $cache = db('banner')->where(['shop_id'=>$this->shop_id,'type'=>2])->find();
//            $this->assign('cache',$cache);
//            echo $this->fetch('banner_logo');
//        }
    }
	//商家logo
    public function shoplogoset(){
        $data = input('post.');
        if ($data) {
        unset($data['type']);
           $find= db('banner')->where(['shop_id'=>$this->shop_id,'type'=>2])->find();
           if($find){
               $re=    db('banner')->where(['shop_id'=>$this->shop_id,'type'=>2])->update(['img'=>$data['img']]);
           }else{
               unset($data['banner_id']);
               $data['ctime']=time();
               $data['type']=2;
               $data['shop_id']=$this->shop_id;
               $re=    db('banner')->insert($data);
           }
            if (FALSE !== $re) {
                $info['status'] = 1;
                $info['msg'] = '设置成功！';
            } else {
                $info['status'] = 0;
                $info['msg'] = '设置失败！';
            }
            return($info);
        }else{
            $info['status'] = 0;
            $info['msg'] = '设置失败！';
            return($info);
        }
    }
	//更改配置
	public function set(){
		$data = input('post.');
		if ($data) {
            $m = model('shop_wxset');
			unset($data['type']);

			if($m->where('shop_id',$this->shop_id)->find()){
			    if(empty($data['wxname'])&&empty($data['wxappid'])&&empty($data['wxappsecret'])&&empty($data['wxmchid'])&&empty($data['wxmchkey'])&&empty($data['wxplanid'])){
                    $m->where(['id'=>$data['id'],'shop_id'=>$this->shop_id])->delete();
                }else{
                    $re = $m->where(['id'=>$data['id'],'shop_id'=>$this->shop_id])->update($data);
                }

            }else{
                $data['shop_id'] = $this->shop_id;
                $re = $m->insert($data);
            }

            if (FALSE !== $re) {
                $info['status'] = 1;
                $info['msg'] = '设置成功！';
            } else {
                $info['status'] = 0;
                $info['msg'] = '设置失败！';
            }
            return($info);
        }else{
            $info['status'] = 0;
            $info['msg'] = '设置失败！';
			return($info);
        }
	}

    //更改配置
    public function systemset(){
        $data = input('post.');
        unset($data['type']);
        if ($data) {
            $re =  db('shop')->where('shop_id',$data['shop_id'])->update($data);
            if (FALSE !== $re) {
                $info['status'] = 1;
                $info['msg'] = '设置成功！';
            } else {
                $info['status'] = 0;
                $info['msg'] = '设置失败！';
            }
            return($info);
        }else{
            $info['status'] = 0;
            $info['msg'] = '设置失败！';
            return($info);
        }
    }
	public function about(){
		$id = input('id');
        $m = model('about');
        //设置面包导航，主加载器请配置
        $bread = array(
			'0' => array(
                'name' => '系统设置',
                'url' => url('shop/system/index?type=1'),
            ),
            '1' => array(
                'name' => '关于我们',
                'url' => url('shop/system/about')
            ),

        );
        $this->assign('breadhtml', $this->getBread($bread));
        //处理POST提交
        $data = input('post.');
        if ($data) {
            $re = $m->update($data);
            if (FALSE !== $re) {
                $info['status'] = 1;
                $info['msg'] = '设置成功！';
            } else {
                $info['status'] = 0;
                $info['msg'] = '设置失败！';
            }
            return($info);
        }else{
            $cache = $m->where('id=1')->find();
            $this->assign('cache', $cache);
        }
        echo $this->fetch();
	}


    //充值规则表
    public function recharge()
    {
         $bread = array(
            '0' => array(
                'name' => '系统设置',
                'url' => url('shop/stystem/index'), 
            ), 
            '1' => array(
                'name' => '充值规则',
                'url' => url('shop/stystem/recharge'), 
            ), 
        );
        $this->assign('breadhtml', $this->getBread($bread));
        $page = input('p')? : 1;
        $size = 20;
        $result = Db::name('regulation')->order('ctime desc')->page($page,$size)->select();
        $count  = Db::name('regulation')->order('ctime desc')->count();
        $this->getPage($count, $size, 'App-loader', '设备列表', 'App-search');
        $this->assign('empty','<tr><td colspan="5" style="line-height:32px;text-align:center;">暂无数据！</td></tr>');
        $this->assign('result',$result);
        echo $this->fetch('');
    }


    //新增/修改充值规则
    public function rechargeSet()
    {   
        $id = input('id');
        $bread = array(
            '0' => array(
                'name' => '系统设置',
                'url' => url('shop/stystem/index'), 
            ), 
            '1' => array(
                'name' => $id? '编辑充值规则' : '新增充值规则',
                'url' => url('shop/stystem/rechargeSet?type='.$id), 
            ), 
        );
        $this->assign('breadhtml', $this->getBread($bread));
        if($_POST){
            $money = input('money');
            if($id){
                $res = Db::name('regulation')->where('regulation_id',$id)->update(['money'=>$money]);
            }else{
                $data['ctime'] = time();
                $data['money'] = input('money');
                $res = Db::name('regulation')->insert($data);
            }
            if($res !== false){
                $info['status'] = 1;
                $info['msg'] = '设置成功！';
            }else{
                $info['status'] = 0;
                $info['msg'] = '设置失败！';
            }
            return($info);
        }
        $result = Db::name('regulation')->where('regulation_id',$id)->find();
        $this->assign('result',$result);
        $this->assign('id',$id);
        echo $this->fetch('rechargeSet');
    }

    //充值规则删除
    public function rechargeDel()
    {
        $id = input('id');
        if(empty($id)){
            $info['status'] = 0;
            $info['msg'] = 'Id不能为空';
            return($info);
        }
        $res = Db::name('regulation')->where(['regulation_id'=>['in',$id]])->delete();
        if($res !== false){
            $info['status'] = 1;
            $info['msg'] = '删除成功！';
        }else{
            $info['status'] = 0;
            $info['msg'] = '删除失败！';
        }
        return($info);
    }
    /*
	 * 广告列表
	 */
    public function banner(){
        $bread = array(
            '0' => array(
                'name' => '广告列表',
                'url' => url('dlc/System/banner'),
            )
        );
        $this->assign('breadhtml', $this->getBread($bread));
        $page = input('p')? : 1;
        $size =  self::$MMS['set']['pagesize']?:20;

        $list= db('banner')->where('type=1 and shop_id='.$this->shop_id)->field('banner_id,title,image,ctime')
            ->order('ctime desc')
            ->page($page,$size)->select();
        $this->assign("list",$list);
        echo $this->fetch();
    }
    /*
     * 广告设置
     */
    public function bannerset(){
        $id = input('id');
        $bread = array(
            '0' => array(
                'name' => '广告设置',
                'url' => url('dlc/stystem/bannerset'),
            )
        );
        $this->assign('breadhtml', $this->getBread($bread));
        if(request()->isPost()){
            $data = input('post.');
            $banner_id = input('banner_id');
            if($banner_id){
                db('banner')->where('banner_id',$banner_id)->update($data);
                $info['status'] = 1;
                $info['msg'] = '修改成功！';
            }else{
                $data['ctime']=time();
                $data['type']=1;
                $data['shop_id']=$this->shop_id;
                db('banner')->insert($data);
                $info['status'] = 1;
                $info['msg'] = '新增成功！';
            }
            return($info);
        }
        if($id){
            $find=  db('banner')->where('banner_id',$id)->find();
            $this->assign("find",$find);
        }
        echo $this->fetch();
    }

    /*
     * 发起广告命令
     */
    public function bannerlist(){
        $listmacno= db('device')->where('shop_id',$this->shop_id)->field('device_id,macno')->select();
        $arr['type']=7;
        $arr['notify_url']='http://sdxddshg.app.xiaozhuschool.com/wxsite/Public/get_open_arr';
        $arr['order_number']='';
        $json_str=json_encode($arr,true);
        foreach ($listmacno as $k=>$v){
            $data['macno'] = 'com.dlc.thinkingvalley_'.$v['macno'];
            $data['version'] = 3;
            $data['sign'] = md5('dlcshouhuogui');
            $data['data']=$json_str;
            $res  = httpPost('http://10.27.204.40/shouhuogui/n_operate',$data);
            $res = json_decode($res,true);
            write_log('bannerlist',"广告发起命令----".$res.'发送时间--'.date('Y-m-d H:i:s',time()));
        }

        $info['status'] = 1;
        $info['msg'] = '更新广告成功！';
        return($info);
    }
    /*
     * 删除
     */
    public function bannerdel(){
        $ids = input('banner_id');
        if (!$ids) {
            $info['status'] = 0;
            $info['msg'] = 'ID不能为空!';
            return ($info);
        }
        $res = Db('banner')->delete(['banner_id' => [in,explode(',',$ids)]]);
        if ($res) {
            $info['status'] = 1;
            $info['msg'] = '删除成功';
        } else {
            $info['status'] = 0;
            $info['msg'] = '删除失败';
        }
        return ($info);
    }

}