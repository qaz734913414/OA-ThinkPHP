<?php

namespace Admin\Controller;

use Think\Controller;

// 引入验证码类
use Think\Verify;

class TestController extends Controller
{
    public function index()
    {
        echo '这里是后台Admin分组的测试入口';
    }

    // sql调试的用法
    public function test()
    {
        $model = D('Dept');
        $model->select();
//        echo $model->getLastSql();
        echo $model->_sql();
    }

    // 性能调试
    public function test2()
    {
        G('start');
        for ($i=0; $i<1e6; $i++) {
            time();
        }
        G('end');
        echo G('start', 'end', 6) . 's';
    }

    // 使用where辅助方法进行查询
    public function test3()
    {
        $model = D('User');
        // dump($model->where('id = 2')->find());
        dump($model->where(array('username'=>'admin', 'password'=>'123456'))->select());
    }

    // 使用limit辅助方法进行查询
    public function test4()
    {
        $model = D('User');
        // dump($model->limit(2)->select());
        dump($model->limit(2, 3)->select());
    }

    // 使用field辅助方法查询出指定字段
    public function test5()
    {
        $model = D('User');
        dump($model->field('username, nickname, sex')->limit(2)->select());
    }

    // 使用order辅助方法进行查询结果的排序
    public function test6()
    {
        $model = D('User');
        dump($model->order('id DESC')->select());
    }

    // 使用group辅助方法进行查询，需要配合field辅助方法一起使用
    public function test7()
    {
        $model = D('Dept');
        // dump($model->field('name, count(*) as count')->group('count')->select());
    }

    // TP中的统计查询语句
    public function test8()
    {
        $model = D('user');
        // dump($model->count());
        // dump($model->max('id'));
        // dump($model->min('id'));
        // dump($model->avg('id'));
        dump($model->sum('id'));
    }

    // 特殊表的实例化方法
    public function test9()
    {
        $model = D('Student');
        dump($model);
    }

    // 演示session的用法
    public function test10()
    {
        // 给指定名赋值
        session('name', 'Jen');
        session('age', '27');
        // 删除指定session
        session('name', null);
        // 获取指定名的session值
        dump(session('name'));
        // 删除所有session
        session(null);
        // 获取所有的session值
        dump(session());
        // 判断指定session是否存在
        dump(session('?name'));
    }

    // 演示cookie的用法，与session基本一样
    // 清空所有cookie的前提是改系统的functions.php代码
    public function test11()
    {
        cookie('name', 'Baby');
        cookie('age', '22');
        cookie('name', null);
        cookie(null);
        dump(cookie('name'));
        dump(cookie());
    }

    // 使用应用层级的自定义函数
    public function test12()
    {
        hehe();
    }

    // 调用自定义文件内的函数
    public function test13()
    {
        info();
    }

    // 加载当前分组的自定义文件
    public function test14()
    {
        load('@/phptest');
        kitty();
    }

    // 验证码
    public function test15()
    {
        // 定义验证码所需的配置信息
        $cfg = array(
                'fontSize'       =>  14,
                'useCurve'     =>   false,
                'useNoise'     =>  false,
                'length'          =>  4,
                'fontttf'           => '4.ttf',
            );

    }
}