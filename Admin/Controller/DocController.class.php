<?php
namespace Admin\Controller;

use Think\Controller;

class DocController extends Controller
{
    // 添加公文的方法
    public function add()
    {
        $this -> display();
    }

    // 添加公文后表单的接收和数据入库
    public function addOk()
    {
        $post = I('post.');
        $post['addtime'] = time();
        // 文件上传的处理
        if ($_FILES['file']['size'] > 0) {
            // 实例化上传类
            $cfg = array('rootPath' => WORKING_PATH . UPLOAD_ROOT_PATH);
            $upload = new \Think\Upload($cfg);
            // 上传文件并保存信息
            $info = $upload -> uploadOne($_FILES['file']);
            // 保存所需信息到post
            $post['hasfile']  = 1;
            // 写到数据库的路径要从项目根目录开始写
            // 上传下载的文件路径要从根目录开始写
            $post['filepath'] = UPLOAD_ROOT_PATH . $info['savepath'] . $info['savename'];
            $post['filename'] = $info['savename'];
        }
        // dump($post);die;
        $model = M('Doc');
        if ($model -> add($post)) {
            $this -> success('添加成功', U('showList'), 3);
        } else {
            $this -> error('添加失败', U('add'), 3);
        }
    }

    // 显示公文列表模板的方法
    public function showList()
    {
        // 实例化模型
        $model = M('Doc');
        // 获取数据
        $data = $model -> select();
        // 总条数，懒得分页了
        $count = $model -> count();
        // 分配数据
        $this -> assign('data', $data);
        $this -> assign('count', $count);
        // 渲染模板
        $this -> display();
    }

    // 下载附件的方法
    public function download()
    {
        // 接收附件对应的id
        $id = I('get.id');
        // 实例化模型
        $model = M('Doc');
        // 查找该id对应的数据
        $data = $model -> find($id);
        // 拼接下载地址
        $file = WORKING_PATH . $data['filepath'];
        // 将文件输出，以下四行不用记
        header("Content-type: application/octet-stream");
        header('Content-Disposition: attachment; filename="' . basename($file) . '"');
        header("Content-Length: ". filesize($file));
        readfile($file);
    }

    // 公文的删除功能
    public function delete()
    {
        // 获取要删除的id号，可能有多个
        $str = I('get.str');
        // 获取要删除的数量
        $count = I('get.count');
        // dump($str); dump($count); die;
        // 实例化模型
        $model = M('Doc');
        // 附件路径的数组
        $files = array();
        $data = $model -> select($str);
        foreach ($data as $value) {
            if ($value['hasfile'] == 1) {
            $files[] = WORKING_PATH . $value['filepath'];
            }
        }
        // dump($files);die;
        if ($model -> delete($str)) {
        // 如果有附件，还要把附件一起删掉
            foreach ($files as $value) {
                unlink($value);
            }
            $this -> success("成功删除 {$count} 条数据", U('showList'), 3);
        } else {
            $this -> error('删除失败', U('showList'), 3);
        }
    }

    // 完成公文编辑的方法
    public function edit()
    {
        // 获取要编辑的数据的id
        $id = I('get.id');
        // 获取该条数据的完整信息
        $data = M('Doc') -> find($id);
        // dump($data);die;
        // 数据分配
        $this -> assign('data', $data);
        // 渲染模板
        $this -> display();
    }

    // 处理编辑完提交过来的数据
    public function editOk()
    {
        $post = I('post.');
        // 文件上传的操作
        if ($_FILES['file']['size'] > 0) {
            // 实例化文件上传类
            $cfg = array('rootPath' => WORKING_PATH . UPLOAD_ROOT_PATH);
            $upload = new \Think\Upload($cfg);
            // 上传文件
            $info = $upload -> uploadOne($_FILES['file']);
            // dump($info);die;
            if ($info) {
                // 更新数据表中的几个字段
                $post['hasfile'] = 1;
                $post['filepath'] = UPLOAD_ROOT_PATH . $info['savepath'] . $info['savename'];
                $post['filename'] = $info['savename'];
                // 还要删除原来上传的附件
                $data = M('Doc') -> find($post['id']);
                unlink(WORKING_PATH . $data['filepath']);
            } else {
                $this -> error('附件上传失败，请重试', U('edit', array('id' => $post['id'])), 3);
            }
        }
        // 如果没有文件上传，操作就很简单了。直接将数据入库
        if (M('Doc') -> save($post)) {
            $this -> success('数据修改成功', U('showList'), 3);
        } else {
            $this -> error('数据修改失败', U('edit', array('id' => $post['id'])), 3);
        }
    }

    // iframe里面获取id对应的content的方法
    public function getContent()
    {
        $id = I('get.id');
        $data = M('Doc') -> find($id);
        // 输出方式与TP中的不同了
        echo htmlspecialchars_decode($data['content']);
    }

}
