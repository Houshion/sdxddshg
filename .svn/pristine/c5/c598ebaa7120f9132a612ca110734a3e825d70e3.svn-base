<?php
// 本类由系统自动生成，仅供测试用途
namespace app\shop\controller;
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


    }

//    public function delimgs()
//    {
//        if (IS_AJAX) {
//            $img = input(ids);
//            $arr = explode('/',$img);
//            $m = Db::name('upload');
//            $count=count($arr);//获取数组长度
//            if($count==4){
////                print_r($arr[3]);
//                $list = $m->where(['savename'=>$arr[3]])->delete();
//            }else{
////                print_r($arr[3].'/'.$arr[4]);
//                $url=$arr[3].'/'.$arr[4];
//                $list = $m->where(['savename'=>$url])->delete();
//
//            }
////            die;
//            // $list = $m->delete($arr[2]);
//
//            if ($list == true) {
//                $data['status'] = 1;
//                $data['msg'] = '成功删除' . $list . '张图片！';
//            } else {
//                $data['status'] = 0;
//                $data['msg'] = '删除失败，请重试或联系管理员！';
//            }
//            return($data);
//            // return($data, 'JSON');
//        } else {
//            $this->error('微专家提醒您：禁止外部访问！');
//        }
//    }

    public function delimgs()
    {
        if ($this->request->isAjax()) {
            $imgid = input('ids');

            $imgModel = \app\dlc\model\Upload::get($imgid);
            if ($imgModel && $imgModel->delete()) {
                $data['status'] = 1;
                $data['msg'] = '成功删除图片！';

                $localPath =  ROOT_PATH . DS . 'public' . $imgModel->savepath . $imgModel->savename;
                is_file($localPath) && unlink($localPath);

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


//    public function delimgs()
//    {
//        if ($this->request->isAjax()) {
//            $imgid = input('ids');
//            $arr = explode('/',$imgid);
//            $m = Db::name('upload');
//            $count=count($arr);//获取数组长度
//            if($count==4){
////                print_r($arr[3]);
//                $list = $m->where(['savename'=>$arr[3]])->delete();
//                $url=$arr[3];
//            }else{
////                print_r($arr[3].'/'.$arr[4]);
//                $url=$arr[3].'/'.$arr[4];
//                $list = $m->where(['savename'=>$url])->delete();
//
//            }
//
//            $localPath =  ROOT_PATH . DS . 'public' . $url;
//            is_file($localPath) && unlink($localPath);
//            $data['status'] = 1;
//                $data['msg'] = '成功删除图片！';
//            return($data);
//            // return($data, 'JSON');
//        } else {
//            $this->error('微专家提醒您：禁止外部访问！');
//        }
//    }


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
//
    }
    public function bin()
    {
        $file = request()->file('file');
        if(!$file) {
            echo json_encode(array('code'=>0, 'msg'=>'请上传文件', 'data'=> '1111'));
        }

        $info = $file->validate(['ext'=>'jpg,png,gif,jpeg,mp4,avi,rmvb'])->move(ROOT_PATH . 'public' . DS . 'uploads/imgs');

        if ($info) {
            echo json_encode(array('code'=>1, 'msg'=>'ok', 'data'=>  '/public/uploads/imgs/'.date("Ymd") .'/'.$info->getFilename()));
//            $this->request->domain() .
        } else {
            echo json_encode(array('code'=>0, 'msg'=>$file->getError() , 'data'=> '2222'));
        }

    }
}