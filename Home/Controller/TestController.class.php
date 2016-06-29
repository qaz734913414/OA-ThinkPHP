<?php

namespace Home\Controller;

use Think\Controller;

class TestController extends Controller
{
	public function index()
	{
		echo time();
	}
	
	public function test()
    {
        $time = date('H:i:s');
        $this->assign('time', $time);
        $this->display();
    }

    // 模板中的常量替换
    public function test2()
    {
        $this->display();
    }

    // TP中的两种跳转
    public function test3()
    {
//        $this->success('成功', U('test'), 3);
        $this->error('失败', U('test2', array('id'=>3, 'name'=>'God')), 3);
    }

    // fetch 方法与display方法的区别
    public function test4()
    {
        $var = $this->fetch('test2');
        dump($var);
    }

    // TP中数组的分配
    public function test5()
    {
        $arr = array(1,2,3,4,5);
        $this->assign('arr', $arr);
        $ass = array(
            'id'=> 2,
            'name'=> 'God',
            'age'=> 'unknown',
        );
        $this->assign('ass', $ass);
        $this->display();
    }
    
    // 视图中函数的使用方法
    public function test6()
    {
        $time = time();
        $this->assign('time', $time);
        $str = 'HhhioHholHIhUYEOu43656HOothyoGHOWHeoHJGH';
        $this->assign('str', $str);
        $this->display();
    }

    // 视图中遍历数组的方法
    public function test7()
    {
        $arr = array(
            array('id'=>1, 'name'=>'Joey', 'nickname'=>'me'),
            array('id'=>2, 'name'=>'zzp', 'nickname'=>'Still me'),
            array('id'=>3, 'name'=>'Jen', 'nickname'=>'my wife'),
        );
        $this->assign('arr', $arr);
        $this->display();
    }

    // 模板中if的用法
    public function test8()
    {
        $day = date('N');
//        dump($day);
        $this->assign('day', $day);
        $this->display();
    }
}