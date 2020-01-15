<?php
namespace app\dlc\controller;

use think\Db;
class DiscountController extends BaseController
{

    public function _initialize()
    {
        //你可以在此覆盖父类方法
        parent::_initialize();
    }

    //优惠卷列表
    public function discountList()
    {
        //设置面包导航，主加载器请配置
        $bread = array(
            '0' => array(
                'name' => '优惠卷管理',
                'url' => url('dlc/Discount/discountList')
            ),
            '1' => array(
                'name' => '优惠卷列表',
                'url' => url('dlc/Discount/discountList')
            )
        );
        $this->assign('breadhtml', $this->getBread($bread));
        //绑定搜索条件与分页
        $page = $_GET['page'] ? $_GET['page'] : 1;
        $size =  20;
        $count  = Db::name('coupon_core')->order('ctime desc')->count();
        $result = Db::name('coupon_core')->order('ctime desc')->page($page, $size)->select();
         // var_dump($result);

        $this->getPage($count, $size, 'App-loader', '优惠卷列表', 'App-search');
        $this->assign('empty','<tr><td colspan="6" style="line-height:32px;text-align:center;">暂无数据！</td></tr>');
        $this->assign('result', $result);
        echo $this->fetch('discountList');
    }

    //优惠卷分发用户列表
    public function userList()
    {
        //设置面包导航，主加载器请配置
        $bread = array(
            '0' => array(
                'name' => '优惠卷管理',
                'url' => url('dlc/Discount/discountList')
            ),
            '1' => array(
                'name' => '用户列表',
                'url' => url('dlc/Discount/userList')
            )
        );
        $this->assign('breadhtml', $this->getBread($bread));
        $discount_id = input('discount_id');
        $page = input('page')? : 1;
        $size = 20;
        $name = input('name') ? input('name') : '';
       $type= input('type')?:0;
        if ($name !== '') {
            $map['nickname'] = ["like",'%'.$name.'%'];
            $this->assign('name', $name);
        }
        if($type==1){
            $str=' order_count asc ,';
        }else if($type==2){
            $str=' order_count desc ,';
        }else{
            $str='';
        }
        $count = Db::name('user')->where($map)->count();//数量
        $result = Db::name('user')->where($map)->order($str.' user_id desc')->page($page,$size)->select();

//        print_r($result1);
        foreach ($result as $k => $v) {
            if (strpos($v['head_img'] ,"http")!==false){
                $result[$k]['head_img'] = $v['head_img'];
            }else{
                $result[$k]['head_img'] = 'http://'.$_SERVER['HTTP_HOST'].'/public' . $v['head_img'];
            }

            }

//         var_dump($result);
         $data['discount_id']=$discount_id;

        $this->getPage($count, $size, 'App-loader', '用户列表', 'App-search',$data);
        $this->assign('result', $result);
        $this->assign('discount_id', $discount_id);
        echo $this->fetch('userList');
    }

    //发送优惠卷
    public function sendDiscount()
    {
        $user_id = $_GET['user_id'];
        $discount_id = $_GET['discount_id'];;
        if(empty($user_id)){
            $info['status'] = 0;
            $info['msg'] = '用户ID不能为空';
            return($info);
        }
        $arr = explode(',',$user_id);
        $str = '';
        $discount = Db::name('coupon_core')->where(['id'=>$discount_id])->find();
        foreach ($arr as $key => $value) {
            $data['coupon_id'] = $discount['id'];
            $data['user_id']     = $value;
            $data['coupon_money']= $discount['discounts'];
            $data['ctime']       = time();
            $data['indate']      = time()+ ($discount['valid_time']*24*3600);
            $data['status']      = 0;
            if($value){
                $result = Db::name('coupon_log')->insert($data);
            }
            if($result == false){
                $str .= 's';
            }
        }
        if($str !== ''){
            $info['status'] = 0;
            $info['msg'] = '分发失败' ;
        }else{
            $info['status'] = 1;
            $info['msg'] = '分发成功' ;
        }
        return($info);
    }

    //添加/编辑优惠卷
    public function discount()
    {
        $id = input('id');
        //dump($m);
        //设置面包导航，主加载器请配置
        $bread = array(
            '0' => array( 
                'name' => '优惠卷管理',
                'url' => url('dlc/Discount/discountList')
            ),
            '1' => array(
                'name' => $id ? '编辑优惠卷' : '新增优惠卷',
                'url' => url('dlc/Discount/discount?id='.$id) 
            )
        );
        $this->assign('breadhtml', $this->getBread($bread));
        //处理POST提交
        if ($_POST) {
            $data = input('post.');
            if($id){
                $re = Db::name('coupon_core')->where('id',$id)->update($data);
            }else{
                $data['ctime'] = time();
                $re = Db::name('coupon_core')->insert($data);
            }
            if ($re !== false) {
                $info['status'] = 1;
                $info['msg'] = $id ? '编辑成功': '添加成功！';
            } else {
                $info['status'] = 0;
                $info['msg'] = $id ? '编辑失败': '添加失败！';
            }
            return($info);
        }
        $result = Db::name('coupon_core')->where('id',$id)->find();
        $this->assign('result', $result);
        $this->assign('id',$id);
        echo $this->fetch('discount');
    }

    //删除优惠卷
    public function discountDel()
    {
        $id = input('id');//必须使用get方法
        if (empty($id)) {
            $info['status'] = 0;
            $info['msg'] = 'ID不能为空!';
            return($info);
        }
        $re = Db::name('coupon_core')->where(['id'=>['in',$id]])->delete();
        if ($re!== false) {
            $info['status'] = 1;
            $info['msg'] = '删除成功!';
        } else {
            $info['status'] = 0;
            $info['msg'] = '删除失败!';
        }
        return($info);
    }

    //优惠卷发送记录列表
    public function discountsLog()
    {
        //设置面包导航，主加载器请配置
        $bread = array(
            '0' => array(
                'name' => '优惠卷管理',
                'url' => url('dlc/Discount/discountList')
            ),
            '1' => array(
                'name' => '优惠卷发送记录',
                'url' => url('dlc/Discount/discountsLog')
            )
        );
        $this->assign('breadhtml', $this->getBread($bread));
        //绑定搜索条件与分页
        $page = input('page')?: 1;
        $size =  20;
        $status = input('status');
        $type = input('type');
        $username = trim(input('name')) ;
        if($username){
            $map['b.nickname'] = ['like','%'.$username.'%'];
            $this->assign('name',$username);
        }
        if($status){
            if($status == 2){
                $map['a.status'] = 0;
            }else{
                $map['a.status'] = $status;
            }
            
            $this->assign('name',$username);
        }
        if($type==1){
            //升序查询

        }
        $result = Db::name('coupon_log')->alias('a')
                  ->join('dlc_user b','b.user_id=a.user_id','left')
                  ->order('a.ctime desc')->where($map)
                  ->field('a.*,b.nickname')->page($page, $size)->select();
        foreach ($result as $k=>$v){
            $result[$k]['count']= Db::name('coupon_log')->where(array('user_id'=>$v['user_id'],'status'=>1))->count()?:0;
            if($v['status']==0){
                if($v['indate'] < time() ){
                    $result[$k]['status_name']='已过期';
                }else{
                    $result[$k]['status_name']='未使用';
                }
            }else{
                $result[$k]['status_name']='已使用';
            }
        }

//        print_r(Db::name('coupon_log')->getLastSql());
        $count  = Db::name('coupon_log')->alias('a')
                  ->join('dlc_user b','b.user_id=a.user_id','left')
                  ->order('a.ctime desc')->where($map)
                  ->field('a.*,b.username')->count();
        $this->getPage($count, $size, 'App-loader', '优惠卷列表', 'App-search');
        $this->assign('empty','<tr><td colspan="6" style="line-height:32px;text-align:center;">暂无数据！</td></tr>');
        $this->assign('result', $result);
        echo $this->fetch('discountsLog');
    }


    //删除优惠卷记录表
    public function discountsLogDel()
    {
        $id = input('id');//必须使用get方法
        if (empty($id)) {
            $info['status'] = 0;
            $info['msg'] = 'ID不能为空!';
            return($info);
        }
        $re = Db::name('coupon_log')->where(['id'=>['in',$id]])->delete();
        if ($re!== false) {
            $info['status'] = 1;
            $info['msg'] = '删除成功!';
        } else {
            $info['status'] = 0;
            $info['msg'] = '删除失败!';
        }
        return($info);
    }
    /*
        * 会员套餐列表
        */
    public function meallist(){
        //设置面包导航，主加载器请配置
        $bread = array(
            '0' => array(
                'name' => '充值套餐列表',
                'url' => url('shop/Discount/meallist')
            ),

        );
        $this->assign('breadhtml', $this->getBread($bread));
        //绑定搜索条件与分页
        $page = $_GET['p'] ? $_GET['p'] : 1;
        $size =  self::$CMS['set']['pagesize']?:20;
//        $where['shop_id']=$this->shop_id;
        $list=db('regulation')->page($page,$size)->order('ctime desc')->select();
        $count=db('regulation')->count();
        $this->getPage($count, $size, 'App-loader', '充值套餐列表', 'App-search');
        $this->assign('empty','<tr><td colspan="6" style="line-height:32px;text-align:center;">暂无数据！</td></tr>');
        $this->assign('list',$list);
        $this->assign('p',$page);
        echo $this->fetch();
    }


    //删除优惠卷
    public function mealdel()
    {
        $id = input('regulation_id');//必须使用get方法
        if (empty($id)) {
            $info['status'] = 0;
            $info['msg'] = 'ID不能为空!';
            return($info);
        }
        $re = Db::name('regulation')->where(['regulation_id'=>['in',$id]])->delete();
        if ($re!== false) {
            $info['status'] = 1;
            $info['msg'] = '删除成功!';
        } else {
            $info['status'] = 0;
            $info['msg'] = '删除失败!';
        }
        return($info);
    }

}