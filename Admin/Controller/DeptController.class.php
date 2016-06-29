<?php
/**
 * Created by PhpStorm.
 * User: zzpwestlife
 * Date: 2016/6/17
 * Time: 17:47
 */

namespace Admin\Controller;

use Think\Controller;

class DeptController extends Controller
{
     public function showList()
    {
        $model = M('Dept');
        $data = $model->select();
        foreach ($data as $key => $value) {
            // 二次查询，通过pid查出对应的name，后期会通过联表查询改进
            $info = $model -> find($value['pid']);
            // 添加一个字段
            $data[$key]['parentName'] = $info['name'];
        }
        // 加载无限级分类文件
        load('@/tree');
        $data = getTree($data);
        // dump($data);die;
        $this->assign('data', $data);
        $this->display();
    }

    public function add()
    {
        $model = D('Dept');
        $data = $model->select();
        $this->assign('data', $data);
        $this->display();
    }

    public function addOk()
    {
        $post = I('post.');
//        dump($post);
        $model = M('Dept');
        if($model->add($post)) {
            $this->success('添加成功', U('showList', 3));
        } else {
            $this->error('人品败了', U('add'), 3);
        }
    }

    public function delete()
    {
        $ids = I('get.ids');
        $count = I('get.count');
        // dump($ids);die;
        $model = D('Dept');
        if ($model->delete($ids)) {
            $this->success("成功删除 {$count} 条数据", U('showList'), 3);
        } else {
            $this->success('删除失败', U('showList'), 3);
        }
    }

    public function edit()
    {
        $id = I('get.id');
        $model = D('Dept');
        $rt = $model->find($id);
        // dump($rt);die;
        $data = $model->select();
        $this->assign(array(
                'rt' => $rt,
                'data' => $data,
            ));
        $this->display('edit');
    }

    public function editOk()
    {
        $post = I('post.');
        // dump($post);
        $model = D('Dept');
        if ($model->save($post)) {
            $this->success('修改成功', U('showList'), 3);
        } else {
            $this->error('人品有问题啊', U('edit', array('id'=>$post('id'))), 3);
        }
    }


//****************************************************************************
    // 下面都是测试的方法，没啥用
    // 常规的实例化模型方法
    public function test()
    {
        $model = new \Admin\Model\DeptModel;
        dump($model);
    }

    // D方法实例化自定义的模型类
    public function test2()
    {
        $model = D('Dept');
        dump($model);
    }

    // 快速方法 M方法实例化父类模型
    public function test3()
    {
        $model = M('Dept');
        dump($model);
    }

    // 数据表记录的添加操作
    public function test4()
    {
        $model = D('Dept');
        $rt = $model->add(array(
            'name'=>'hahaha',
            'pid'=>'3',
            'sort'=>'22',
            'remark'=>'又来了一个',
        ));
        dump($rt); // 返回值为新增记录的主键值
        // 如果数组的键跟数据表中的字段不匹配，则会被过滤掉，
        // 如果都不匹配，则添加一个空白行（只有主键）
    }

    // 数据表记录的更新操作
    public function test5()
    {
        $model = D('Dept');
        $rt = $model->save(array(
            'id'=>10,
            'name'=>'Wang',
        ));
        dump($rt); // 修改成功返回影响的行数，失败返回false,
        // 没有修改返回0。数组中必须有主键，否则不允许修改，返回false
    }

    // 数据表的查询操作之 select
    public function test6()
    {
        $model = D('Dept');
//        $rt = $model->select();
//        $rt = $model->select('10');
        $rt = $model->select('1, 2, 5, 10, 11');
        dump($rt);
    }

    // 数据表查询操作之 find
    public function test7()
    {
        $model = M('Dept');
//        $rt = $model->find(); // select * from table limit 1
        $rt = $model->find('10');
        dump($rt);
    }

    // 数据表删除操作 delete
    public function test8()
    {
        $model = D('Dept');
//        $rt = $model->delete('22');
        $rt = $model->delete('22, 24, 33');
        dump($rt); // 返回值为影响的行数
    }

}