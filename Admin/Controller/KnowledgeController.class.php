<?php
namespace Admin\Controller;

use Think\Controller;

class KnowledgeController extends Controller
{
    public function showList()
    {
        $data = M('Knowledge') -> select();
        $count = M('Knowledge') -> count();
        $this -> assign('data', $data);
        $this -> assign('count', $count);
        $this -> display();
    }

    public function add()
    {
        $this -> display();
    }

    public function addOk()
    {
        $post = I('post.');
        $post['addtime'] = time();
        // 判断是否有文件上传
        if ($_FILES['thumb']['size'] > 0) {
            // 实例化上传类
            $cfg = array('rootPath' => WORKING_PATH . UPLOAD_ROOT_PATH);
            $upload = new \Think\Upload($cfg);
            // 上传文件
            $info = $upload -> uploadOne($_FILES['thumb']);
            if ($info) {
                $post['picture'] = UPLOAD_ROOT_PATH . $info['savepath'] . $info['savename'];
                // 制作缩略图
                $th = new \Think\Image();
                // 打开图片
                $src = WORKING_PATH . $post['picture'];
                $th -> open($src);
                // 制作缩略图
                $th -> thumb(100 ,100);
                // 保存缩略图
                $des = WORKING_PATH . UPLOAD_ROOT_PATH . $info['savepath'] . 'thumb_' . $info['savename'];
                $th -> save($des);
                // 将缩略图信息保存到数据表
                $post['thumb'] = UPLOAD_ROOT_PATH . $info['savepath'] . 'thumb_' . $info['savename'];
            } else {
                $this -> error('附件上传失败', U('add'), 3); exit;
            }
        } else {
            // 没有文件上传 不做处理
        }
        if (M('Knowledge') -> add($post)) {
            $this -> success('添加成功', U('showList'), 3);
        } else {
            $this -> error('添加失败', U('add'), 3);
        }
    }

    public function edit()
    {
        $id = I('get.id');
        $data = M('Knowledge') -> find($id);
        $this -> assign('data', $data);
        $this -> display();
    }

    public function editOk()
    {
        $post = I('post.');
    }

    public function delete()
    {

    }
}
