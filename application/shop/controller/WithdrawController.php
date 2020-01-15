<?php
/**
 * User: liju
 * Date: 2018/6/7
 * Time: 14:37
 */
 
namespace app\shop\controller;

use think\Db;
use think\Session;

class WithdrawController extends BaseController
{
    public $id;
    public $type;
    public function _initialize()
    {
        $this->type = Session::get('MMS.type');//子后台登录帐号类型（1：商家 2：员工）
        if($this->type == 1){
            $aid=Session::get('MMS.uid');
            $this->id=Db::name('shop')->where(['aid'=>$aid])->value('shop_id');//商家ID 
        }else{
            $this->id = Session::get('MMS.uid');//员工ID
        }
        $this->assign('type',$this->type);
    }

    //提现列表
    public function index()
    {
        $pagesize = 15;
        $page = input('page', 1);
        $condition=[];
        $status=input('status');
        if($status){
            $condition['a.status']=$status;
            $this->assign('status', $status);
        }
        $statusArr=[1=>'审核中',2=>'完成'];
        $this->assign('statusArr', $statusArr);
        $type=input('type');
        if($type==1&&$this->type==1){
            //设置面包导航，主加载器请配置
            $bread = array(
                '0' => array(
                    'name' => '提现管理',
                    'url' => url('shop/withdraw/index'),
                ),
                '1' => array(
                    'name' => '商家提现列表',
                    'url' => url('shop/withdraw/index')
                ),
            );
            $this->assign('breadhtml', $this->getBread($bread));

            $condition['a.action_id']=$this->id;
            $condition['user_type']=1;//商家
            $list=Db::name('withdraw')->alias('a')
                ->join('__ADMIN__ b', 'a.aid=b.id', 'left')
                ->field('a.*,b.nickname')
                ->where($condition)
                ->order('a.ctime desc')
                ->page($page,$pagesize)
                ->select();
            $count=Db::name('withdraw')->alias('a')
                ->where($condition)
                ->count();
            $this->getPage($count, $pagesize, 'App-loader', '商家列表', 'App-search');
            $this->assign('list', $list);
        }else{
            //设置面包导航，主加载器请配置
            $bread = array(
                '0' => array(
                    'name' => '提现管理',
                    'url' => url('shop/withdraw/index'),
                ),
                '1' => array(
                    'name' => '员工提现列表',
                    'url' => url('shop/withdraw/userIndex')
                ),
            );
            $this->assign('breadhtml', $this->getBread($bread));

            $condition['a.action_id']=$this->id;
            $condition['user_type']=2;//员工
            $list=Db::name('withdraw')->alias('a')
                ->join('__ADMIN__ b', 'a.aid=b.id', 'left')
                ->field('a.*,b.nickname')
                ->where($condition)
                ->order('a.ctime desc')
                ->page($page,$pagesize)
                ->select();
            $count=Db::name('withdraw')->alias('a')
                ->join('__ADMIN__ b', 'a.aid=b.id', 'left')
                ->where($condition)
                ->count();
            $this->getPage($count, $pagesize, 'App-loader', '员工提现列表', 'App-search');
            $this->assign('list', $list);
        }
        $this->assign('type',$type);

        echo $this->fetch();

    }

    //商家申请提现
    public function add(){
        //设置面包导航，主加载器请配置
        $bread = array(
            '0' => array(
                'name' => '提现列表',
                'url' => url('shop/withdraw/index'), 
            ),
            '1' => array(
                'name' => '申请提现',
                'url' => url('shop/withdraw/index')
            ),
        );
        $this->assign('breadhtml', $this->getBread($bread));
        $type = input('type');
        if($this->type == 1){
            $money = Db::name('shop')->where(['shop_id'=>$this->id])->value('money');
        }else{
            $money = Db::name('user')->where(['user_id'=>$this->id])->value('money');
        }
        if(request()->isPost()){
            $data=input('post.');
                $data['action_id']=$this->id;
                $data['ctime']=time();
                $data['user_type']=1;//商家
                $money=Db::name('shop')->where('shop_id',$this->id)->value('money');
                if(!is_numeric($data['money'])){
                    $info['status'] = 0;
                    $info['msg'] = '提现金额必须是数字';
                    return($info);
                }
                if($money<$data['money']){
                    $info['status'] = 0;
                    $info['msg'] = '余额不足';
                    return($info);
                }
                Db::startTrans();
                $w_result=Db::name('withdraw')->insert($data);
                $balance_result=Db::name('shop')->where(['shop_id'=>$this->id])->setDec('money',$data['money']);//减去余额
                $now_result=Db::name('shop')->where(['shop_id'=>$this->id])->setInc('pend_money',$data['money']);//现在提现金额
                if($w_result&&$now_result&&$balance_result){
                    Db::commit();
                    $info['status'] = 1;
                    $info['msg'] = '提交申请成功';
                }else{
                    Db::rollback();
                    $info['status'] = 0;
                    $info['msg'] = '提交申请失败';
                }
            return($info);
        }
        $this->assign('money',$money);
        $this->assign('type',$type);
        echo $this->fetch();
    }

    //员工提现
    public function userAdd(){
        //设置面包导航，主加载器请配置
        $bread = array(
            '0' => array(
                'name' => '提现列表',
                'url' => url('shop/withdraw/index'),
            ),
            '1' => array(
                'name' => '申请提现',
                'url' => url('shop/withdraw/index')
            ),
        );
        $this->assign('breadhtml', $this->getBread($bread));
        if(request()->isPost()){
            $data=input('post.');
            $data['action_id']=$this->id;
            $data['ctime']=time();
            $data['user_type']=2;//员工
            $money=Db::name('user')->where('user_id',$this->id)->value('money');
            if(!is_numeric($data['money'])){
                $info['status'] = 0;
                $info['msg'] = '提现金额必须是数字';
                return($info);
            }
            if($money<$data['money']){
                $info['status'] = 0;
                $info['msg'] = '余额不足';
                return($info);
            }
            Db::startTrans();
            $w_result=Db::name('withdraw')->insert($data);
            $balance_result=Db::name('user')->where(['user_id'=>$this->id])->setDec('money',$data['money']);//减去余额
            $user_result=Db::name('user')->where('user_id',$this->id)->setInc('pend_money',$data['money']);//现在提现金额
            if($w_result&&$user_result&&$balance_result){
                Db::commit();
                $info['status'] = 1;
                $info['msg'] = '提交申请成功';
            }else{
                Db::rollback();
                $info['status'] = 0;
                $info['msg'] = '提交申请失败';
            }
            return($info);
        }
        $money = Db::name('user')->where(['user_id'=>$this->id])->value('money');
        $this->assign('money',$money);
        echo $this->fetch();
    }

    //收入列表
    public function income(){
        $pagesize = 15;
        $page = input('page', 1);
        //设置面包导航，主加载器请配置
        $bread = array(
            '0' => array(
                'name' => '提现管理',
                'url' => url('shop/withdraw/income'),
            ),
            '1' => array(
                'name' => '收入列表',
                'url' => url('shop/withdraw/income')
            ),
        );
        $this->assign('breadhtml', $this->getBread($bread));

        if($this->type==1){//商家
            $list=Db::name('shop')
                ->where('shop_id',$this->id)
                ->field('shop_id as id,money,withdraw_money,pend_money')
                ->page($page,$pagesize)
                ->order('ctime desc')
                ->select();
            $count=Db::name('shop')
                ->where('shop_id',$this->id)
                ->count();
        }else{//员工
            $list=Db::name('user')
                ->where('user_id',$this->id)
                ->field('user_id as id,money,withdraw_money,pend_money')
                ->page($page,$pagesize)
                ->order('ctime desc')
                ->select();
            $count=Db::name('user')
                ->where('user_id',$this->id)
                ->count();
        }
        $this->getPage($count, $pagesize, 'App-loader', '收入列表', 'App-search');
        $this->assign('list',$list);
        echo $this->fetch();
    }
}