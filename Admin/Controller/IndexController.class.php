<?php
/**
 * Created by PhpStorm.
 * User: zzpwestlife
 * Date: 2016/6/17
 * Time: 19:55
 */

namespace Admin\Controller;

use Think\Controller;

class IndexController extends Controller
{
    public function index()
    {
        // 获取用户ip
        $ip = get_client_ip();
        // 查询ip地址对应的物理地址
        // 首先要实例化ip地址类
        $class = new \Org\Net\IpLocation('qqwry.dat');
        // 调用getlocation方法进行查询
        $mac = $class -> getlocation($ip);
        $data = $mac['country'] . ' ' . $mac['area'];
        $data = iconv('gbk', 'utf-8', $data);
        $this -> assign('mac', $data);
        $this->display();
    }
}