<?php
namespace app\dlc\controller;

use think\Db;
class FeedbackController extends BaseController
{
    //反馈列表
	public function feedbackList()
    {
       $bread = array(
			'0' => array(
                'name' => '帐号管理',
                'url' => url('dlc/user/index'),
            ),
            '1' => array(
                'name' => '反馈列表',
                'url' => url('dlc/Feedback/feedbackList')
            ),

        );
		$this->assign('breadhtml', $this->getBread($bread)); 
		//绑定搜索条件与分页
        $model = model('feedback');
        $status= input('status');
        $page = input('page')?:1;
        $size = self::$CMS['set']['pagesize']?:20;
        $p=$page;

        $map = array();
        $nickname = input('nickname') ? trim(input('nickname')) : '';
        $mobile = input('mobile') ? trim(input('mobile')) : '';
        if ($nickname) {
            $map['b.nickname'] = array('like', "%$nickname%");
            $this->assign('nickname', $nickname);
        }
        if ($mobile) {
            $map['b.mobile'] = array('like', "%$mobile%");
            $this->assign('mobile', $mobile);
        }
        if ($status) {
            if($status == 2){
                $map['a.status'] = 0;
            }else{
                $map['a.status'] = $status;
            }
            $this->assign('status', $status);
        }
        $count = $model->alias('a') ->join('dlc_user b ',' a.user_id=b.user_id','left')->where($map)->count();//数量
        $list = $model->alias('a')
            ->join('dlc_user b ',' a.user_id=b.user_id','left')
            ->where($map)
            ->order('id desc')
            ->field('a.*,b.nickname,b.mobile')
            ->page($page, $size)
            ->select();
        foreach($list as$k=>$v){
            if($v['img'] != ''){
                // $v['img'] = substr($v['img'], 0,-1);
               $img= trim($v['img'],',');
                $img_ids = explode(',',$img);
                $list[$k]['img']=$img_ids;
            }
            
        }
        $this->getPage($count, $size, 'App-loader', '意见反馈列表', 'App-search');
        $this->assign('list', $list);
        $this->assign('p', $p);
		echo $this->fetch('feedback_feedbackList');
    }
	
    //反馈处理
    public function edit()
    {
       $id = input('id');
       $pages = input('pages');
       $bread = array(
            '0' => array(
                'name' => '帐号管理',
                'url' => url('dlc/user/index'),
            ),
            '1' => array(
                'name' => '反馈列表',
                'url' => url('dlc/Feedback/feedbackList')
            ),
            '1' => array(
                'name' => '反馈处理',
                'url' => url('dlc/Feedback/edit')
            ),

        );
        if($_POST){
            $data['dispose_content'] = trim(input('dispose_content'));
            $data['status'] = 1;
            $data['dispose_time'] = time();
            $re = Db::name('feedback')->where('id',$id)->update($data);
            if($re !== false){
                $info['status'] = 1;
                $info['msg']    = '处理成功';
            }else{
                $info['status'] = 0;
                $info['msg']    = '处理失败';
            }
            return($info);
        }
        $this->assign('breadhtml', $this->getBread($bread));
        $this->assign('id', $id);
        $this->assign('pages',$pages);
        echo $this->fetch('edit');
    }
	
   /*
    * 弹框处理
    */
   public function htedit(){
       $id=  input('id');

       $this->assign('id',$id);
       echo $this->fetch();
       exit;
   }
   public function edit1(){
       $id = input('id');
       $dispose_content = input('dispose_content');
       if(!$id || !$dispose_content)   exit(json_encode(['status'=>0,'msg'=>'ID或处理内容不能为空或零'],true));
       $data['dispose_content'] = trim(input('dispose_content'));
       $data['status'] = 1;
       $data['dispose_time'] = time();
       $re = Db::name('feedback')->where('id',$id)->update($data);
       if($re !== false){
           $info['status'] = 1;
           $info['msg']    = '处理成功';
       }else{
           $info['status'] = 0;
           $info['msg']    = '处理失败';
       }
       return($info);
   }
    //反馈查看详情 
    public function info()
    {
       $id = input('id');
       $pages = input('pages');
       $bread = array(
            '0' => array(
                'name' => '帐号管理',
                'url' => url('dlc/user/index'),
            ),
            '1' => array(
                'name' => '反馈列表',
                'url' => url('dlc/Feedback/feedbackList')
            ),
            '1' => array(
                'name' => '反馈处理',
                'url' => url('dlc/Feedback/edit')
            ),

        );
        $re = Db::name('feedback')->alias('a')
              ->join('dlc_user b ',' a.user_id=b.user_id','left')->where('id',$id)
              ->field('a.*,b.nickname,b.mobile')->find();
        if($re['img']){
            $re['img'] = rtrim($re['img'],',');
            $re['img'] = explode(',',$re['img']);
        }
        $re['status'] = $re['status']== 1 ? '已处理' : '未处理';
        $this->assign('breadhtml', $this->getBread($bread));

        $this->assign('result',$re);
        $this->assign('id', $id);
        $this->assign('pages',$pages);
        echo $this->fetch('info');
    }

	public function about(){
		$id = input('id');
        $m = model('about');
        //设置面包导航，主加载器请配置
        $bread = array(
			'0' => array(
                'name' => '系统设置',
                'url' => url('dlc/system/index?type=1'),
            ),
            '1' => array(
                'name' => '关于我们',
                'url' => url('dlc/system/about')
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
            $this->ajaxReturn($info);
        }else{
            $cache = $m->where('id=1')->find();
            $this->assign('cache', $cache);
        }
        echo $this->fetch();
	}

    //反馈列表删除
    public function del()
    {
        $id = input('id');
        if (empty($id)) {
            $info['status'] = 0;
            $info['msg'] = 'ID不能为空!';
            return($info);
        }
        $res1 = Db::name('feedback')->where(['id'=>['in',$id]])->delete();
        if ($res1 !==false){
            $info['status'] = 1;
            $info['msg'] = '删除成功';
        }else{
            $info['status'] = 0;
            $info['msg'] = '删除失败';
        }
        return($info);
    }

}