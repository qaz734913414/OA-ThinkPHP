<?php
namespace Admin\Controller;

use Think\Controller;

class UserController extends Controller
{
    public function add()
    {
        $model = M('Dept');
        $data  = $model -> select();
        load('@/tree');
        $data  = getTree($data);
        // dump($data);die;
        $this -> assign('data', $data);
        $this -> display();
    }

    public function addOk()
    {
        $post            = I('post.');
        $post['addtime'] = time();
        // 数据入库
        $model           = M('User');
        if ($model -> add($post)) {
            $this  -> success('添加成功', U('showList'), 3);
        } else {
            $this  -> success('添加失败', U('add'), 3);
        }
    }

    public function showList()
    {
        $model    = M('User');
        // 获取所有记录数
        $count    = $model -> count();
        // 每页显示条数
        $pagesize = 3;
        // 当前的页码
        $p        = (I('get.p') == null) ? 1 : I('get.p');
        // 总页数
        $pages    = ceil($count / $pagesize);
        // 当前页最后一条是第几条
        if ($p == $pages) {
            $end = $count;
        } else {
            $end = $p * $pagesize;
        }
        // 当前页第一条是第几条
        $start = ($p - 1) * $pagesize + 1;
        // 实例化分页类
        $page = new \Think\Page($count, $pagesize);
        // 更改显示的数字为中文
        $page -> setConfig('prev', '上一页');
        $page -> setConfig('next', '下一页');
        $page -> setConfig('first', '首页');
        $page -> setConfig('last', '末页');
        $page -> lastSuffix = false; // 将末页从数字显示切换为汉字显示
        // 获取需要显示在模板上的内容
        $show = $page -> show();
        // 获取当前页的数据
        $info  = $model -> alias('t1')
                        -> field('t1.*, t2.name')
                        -> join('tp_dept as t2 on t1.dept_id = t2.id')
                        -> select();
        // select t1.*, t2.name from tp_user as t1 left join tp_dept as t2 on t1.dept_id = t2.id;
        // 修复部分数据不显示的问题，貌似还是不行
        $data = array();
        for ($i = $start; $i <= $end; $i++) {
            $data[] = $info[$i-1];
        }
        $this -> assign('data', $data);
        // 将分页所需数据传至模板文件
        $this -> assign(array(
            'page'      => $show,
            'start'     => $start,
            'end'       => $end,
            'pagesize'  => $pagesize,
            'count'     => $count,
        ));
        $this -> display();
    }

    public function edit()
    {
        $id    = I('get.id');
        $model = M('User');
        $data  = $model -> find($id);
        // dump($data);
        $this -> assign('data', $data);
        // 还需要部门的无限级分类数据
        load('@/tree');
        $dept = getTree(M('Dept') -> select());
        // dump($dept);die;
        $this -> assign('data', $data); // 查到的一个用户的数据
        $this -> assign('dept', $dept); // 部门的所有数据
        $this -> display();
    }

    public function editOk()
    {
        $post = I('post.');
        // 密码这一块，未填写则表示不修改
        if ($post['password'] == '') {
            unset($post['password']);
        }
        $model = M('User');
        if ($model -> save($post) !== false) {
            $this  -> success('修改成功', U('showList'), 3);
        } else {
            $this  -> error('修改失败', U('edit', array('id'=>$post['id'])), 3);
        }
    }

    public function delete()
    {
        $str = I('get.str');
        $count = I('get.count');
        $model = M('User');
        if ($model -> delete($str)) {
            $this -> success("成功删除 {$count} 条数据", U('showList'), 3);
        } else {
            $this -> error('删除失败', U('showList'), 3);
        }
    }

    // 实现每个部门人数统计的highcharts显示
    public function charts()
    {
        // select count(t1.id) as count, t2.name from tp_user as t1 left join tp_dept as t2 on t1.dept_id = t2.id group by t2.name having count > 0;
        // 实例化模型
        $model = M('User');
        // 连贯查询
        $data = $model  -> alias('t1')
                        -> field('count(t1.id) as count, t2.name as dept_name')
                        -> join('left join tp_dept as t2 on t1.dept_id = t2.id')
                        -> group('dept_name')
                        -> having('count > 0')
                        -> select();
        // dump($data);die;
        // 要将数据拼凑成highcharts所需的格式，有点类似json
        $str = '[';
        foreach ($data as $value) {
            $str .= "['" . $value['dept_name'] . "'," . $value['count'] . "],";
        }
        $str .= ']';
        // echo $str; die;
        $this -> assign('str', $str);
        $this -> display();
    }
}
