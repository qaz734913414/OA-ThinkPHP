<?php
/**
 * Created by PhpStorm.
 * User: zzpwestlife
 * Date: 2016/6/17
 * Time: 14:46
 */

namespace Admin\Controller;

use Think\Controller;

use Think\Verify;

class PublicController extends Controller
{
    public function login()
    {
        $this->display();
    }

    public function captcha()
    {
         // 生成验证码
        $cfg = array(
                'fontSize'   =>   12,
                'useCurve'  => false,
                'useNoise'  =>  false,
                'length'    => 4,
                'fontttf'     =>  '4.ttf',
            );
        $verify = new Verify($cfg);
        $verify->entry();
    }

    public function index()
    {
          $post = I('post.');
          // dump($post);die;
          // 先检查验证码是否正确
          $verify = new Verify();
          if ($verify->check($post['captcha'])) {
            // 然后检查用户名和密码
            $model = D('User');
            if ($model->where(array('username'=>$post['username'], 'password'=>$post['password']))->find()) {
                session('username', $post['username']);
                session('uid', $post['id']);
                session('role_id', $post['role_id']);
                $this->success('登录成功', U('Index/index'), 3);
            } else {
                $this->error('登录失败', U('login'), 3);
            }
          } else {
            $this->error('验证码错误', U('login'), 3);
          }
    }

    public function logout()
    {
        session(null);
        $this->success('成功退出，再见', U('login'), 3);
    }
}