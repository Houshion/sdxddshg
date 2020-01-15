<?php
/**
 * User: liju
 * Date: 2018/6/7
 * Time: 14:37
 */

namespace app\dlc\controller;

use think\Db;
use think\Session;

class WithdrawController extends BaseController
{
    //提现列表
    public function index()
    {
        $pagesize = 20;
        $page = input('page', 1);
        $condition = [];
        $status = input('status');
        if ($status) {
            $condition['a.status'] = $status;
            $this->assign('status', $status);
        }
        $statusArr = [1 => '审核中', 2 => '完成'];
        $this->assign('statusArr', $statusArr); 
        $type = input('type');
        if ($type == 1) {
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

            $condition['user_type'] = 1;
            $list = Db::name('withdraw')->alias('a')
                ->join('__ADMIN__ b', 'a.aid=b.id', 'left')
                ->field('a.*,b.nickname')
                ->where($condition)
                ->order('a.ctime desc')
                ->page($page, $pagesize)
                ->select();
            $count = Db::name('withdraw')->alias('a')
                ->where($condition)
                ->count();
            $this->getPage($count, $pagesize, 'App-loader', '商家提现列表', 'App-search');
            $this->assign('list', $list);
        } else {
            //设置面包导航，主加载器请配置
            $bread = array(
                '0' => array(
                    'name' => '提现管理',
                    'url' => url('shop/withdraw/Index'),
                ),
                '1' => array(
                    'name' => '员工提现列表',
                    'url' => url('shop/withdraw/userIndex')
                ),
            );
            $this->assign('breadhtml', $this->getBread($bread));

            $condition['user_type'] = 2;
            $list = Db::name('withdraw')->alias('a')
                ->join('__ADMIN__ b', 'a.aid=b.id', 'left')
                ->field('a.*,b.nickname')
                ->where($condition)
                ->order('a.ctime desc')
                ->page($page, $pagesize)
                ->select();
            $count = Db::name('withdraw')->alias('a')
                ->join('__ADMIN__ b', 'a.aid=b.id', 'left')
                ->where($condition)
                ->count();
            $this->getPage($count, $pagesize, 'App-loader', '员工提现列表', 'App-search');
            $this->assign('list', $list);
        }
        echo $this->fetch();
    }

    //审核
    public function edit()
    {
        $withdraw_id = input('withdraw_id');
        if (!$withdraw_id) {
            $info['status'] = 0;
            $info['msg'] = 'id不能为空';
            return ($info);
        }
        $type = input('type');
        if (!$type) {
            if (!$withdraw_id) {
                $info['status'] = 0;
                $info['msg'] = '提现类型不能为空'; 
                return ($info);
            }
        }
        $uid = Session::get('CMS.uid');
        Db::startTrans();
        $result = Db::name('withdraw')->where('withdraw_id', $withdraw_id)->update(['check_time' => time(), 'aid' => $uid, 'status' => 2]);//审核通过
        $w_result = Db::name('withdraw')->where('withdraw_id', $withdraw_id)->field('money,user_type,action_id')->find();
        if ($type == 1) {  //商家
            //$Minus_balance = Db::name('shop')->where('shop_id', $w_result['action_id'])->setDec('money', $w_result['money']);//减去余额
            $withdrawed = Db::name('shop')->where('shop_id', $w_result['action_id'])->setInc('withdraw_money', $w_result['money']);//已提现
            $now_withdrawe = Db::name('shop')->where('shop_id', $w_result['action_id'])->setDec('pend_money', $w_result['money']);//正在提现
        } else {//员工
            //$Minus_balance = Db::name('user')->where('user_id', $w_result['action_id'])->setDec('money', $w_result['money']);//减去余额
            $withdrawed = Db::name('user')->where('user_id', $w_result['action_id'])->setInc('withdraw_money', $w_result['money']);//已提现
            $now_withdrawe = Db::name('user')->where('user_id', $w_result['action_id'])->setDec('pend_money', $w_result['money']);//正在提现
        }
        if ($result && $withdrawed && $now_withdrawe) {
            Db::commit();
            $info['status'] = 1;
            $info['msg'] = '审核成功';
        } else {
            Db::rollback();
            $info['status'] = 0;
            $info['msg'] = '审核失败';
        }
        return ($info);
    }

    //收入列表
    public function income()
    {
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
        $list = Db::name('shop')
            ->field('shop_id as id,money,withdraw_money,pend_money,user_name')
            ->page($page, $pagesize)
            ->order('ctime desc')
            ->select();
        $count = Db::name('shop')
            ->count();
        $this->getPage($count, $pagesize, 'App-loader', '收入列表', 'App-search');
        $this->assign('list', $list);
        echo $this->fetch();
    }
}