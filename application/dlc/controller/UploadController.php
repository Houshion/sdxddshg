<?php
// 本类由系统自动生成，仅供测试用途
namespace app\dlc\controller;
use think\Db;
class UploadController extends BaseController
{

    public function index()
    {
        $this->display();
    }

    public function indeximg()
    {
        //查找带回字段
        $fbid = input('fbid');
        $isall = input('isall'); 
        $issrc = input('issrc')?1:0;
        $this -> assign('issrc',$issrc);
        $this->assign('fbid', $fbid);
        $this->assign('isall', $isall);
        $page = '1,8';
        $m = Db::name('upload');
        $cache = $m->page($page)->order('id desc')->select();
        // var_dump($cache);
        $this->assign('cache', $cache);
        return($this->fetch('indeximg'));
    }

    public function doupimg()
    {
        $files = request()->file('appfile');
        $info = $files->validate(array('size'=>20000000,'ext'=>'jpg,png,gif,jpeg'))->move(ROOT_PATH .'public'. DS . 'uploads/imgs');
        if ($info) {
            $item['name'] = $info->getInfo('name');
            $item['type'] = $info->getInfo('type');
            $item['savename'] = $info->getSaveName();
            $item['savepath'] = '/uploads/imgs/';
            $item['savename']= str_replace("\\", '/', $item['savename']);
            $count = Db::name('upload')->insert($item)? :１;
            // return '/uploads/imgs/'.$info->getSaveName();
            if ($count) {
                $backstr = "'" . $count . "张图片上传成功！'" . ',' . "true";
                echo "<script>parent.doupimgcallback(" . $backstr . ")</script>";
            } else {
                echo "<script>parent.doupimgcallback('图片保存时失败！',false)</script>";
            };

        } else {
            echo "<script>parent.doupimgcallback('" . $files->getError() . "',false)</script>";
        };
        // $config = array(
        //     'mimes' => array(), //允许上传的文件MiMe类型
        //     'maxSize' => 0, //上传的文件大小限制 (0-不做限制)
        //     'exts' => array('jpg', 'gif', 'png', 'jpeg'), //允许上传的文件后缀
        //     'autoSub' => true, //自动子目录保存文件
        //     'subName' => array('date', 'Y-m-d'), //子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
        //     'rootPath' => './Upload/', //保存根路径
        //     'savePath' => 'img/', //保存路径
        //     'saveName' => array('uniqid', ''), //上传文件命名规则，[0]-函数名，[1]-参数，多个参数使用数组
        //     'saveExt' => '', //文件保存后缀，空则使用原后缀
        //     'replace' => false, //存在同名是否覆盖
        //     'hash' => true, //是否生成hash编码
        //     'callback' => false, //检测文件是否存在回调，如果存在返回文件信息数组
        //     'driver' => '', // 文件上传驱动
        //     'driverConfig' => array(), // 上传驱动配置
        // );
        //var_dump($_FILES);
        // $up = new \Util\Upload($config);
        // if ($list = $up->upload($_FILES)) {
        //     //dump($list);
        //     $pic = M('Upload_img');
        //     $count = 0;
        //     $arr = array();
        //     foreach ($list as $k => $v) {
        //         //$arr['uid']=$uid;
        //         $arr['name'] = $list[$k]['name'];
        //         $arr['ext'] = $list[$k]['ext'];
        //         $arr['type'] = 'img';
        //         $arr['savename'] = $list[$k]['savename'];
        //         $arr['savepath'] = $list[$k]['savepath'];
        //         // $arr['user_id'] = $_SESSION['CMS']['uid'];
        //         $re = $pic->add($arr);
        //         if ($re) {
        //             $count += 1;
        //         }
        //     }

        //     if ($count) {
        //         $backstr = "'" . $count . "张图片上传成功！'" . ',' . "true";
        //         echo "<script>parent.doupimgcallback(" . $backstr . ")</script>";
        //     } else {
        //         echo "<script>parent.doupimgcallback('图片保存时失败！',false)</script>";
        //     };

        // } else {
        //     echo "<script>parent.doupimgcallback('" . $up->getError() . "',false)</script>";
        // };

    }

    public function delimgs()
    {
        if (IS_AJAX) {
            $img = input(ids);
            $arr = explode('/',$img);
            $m = Db::name('upload');
            // var_dump($img);die;
            // $list = $m->delete($arr[2]);
            $list = $m->where(['savename'=>$arr[2]])->delete();
            if ($list == true) {
                $data['status'] = 1;
                $data['msg'] = '成功删除' . $list . '张图片！';
            } else {
                $data['status'] = 0;
                $data['msg'] = '删除失败，请重试或联系管理员！';
            }
            return($data);
            // return($data, 'JSON');
        } else {
            $this->error('微专家提醒您：禁止外部访问！');
        }
    }


    public function getmoreimg()
    {
        $page = input('p') . ',8';
        $m = Db::name('upload');
        $cache = $m->page($page)->order('id desc')->select();
        // var_dump($cache);
        if ($cache) {
            $this->assign('cache', $cache);
            return($this->fetch());//封装模板fetch并返回
        } else {
            return("");
        }

    }
    public function bin()
    {
        $file = request()->file('file');
        if(!$file) {
            echo json_encode(array('code'=>0, 'msg'=>'请上传文件', 'data'=> '1111'));
        }

        $info = $file->validate(['ext'=>'mp4,avi,rmvb,apk'])->move(ROOT_PATH . 'public' . DS . 'uploads/imgs');

        if ($info) {
            echo json_encode(array('code'=>1, 'msg'=>'ok', 'data'=>  '/public/uploads/imgs/'.date("Ymd") .'/'.$info->getFilename()));
//            $this->request->domain() .
        } else {
            echo json_encode(array('code'=>0, 'msg'=>$file->getError() , 'data'=> '2222'));
        }

    }
}