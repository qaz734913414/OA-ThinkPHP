<?php
// 设置字符集
header("Content-Type:text/html;charset=utf8");
// 禁止自动生成目录安全文件index.php
define("BUILD_DIR-SECURE", false);
// 开启debug调试
define("APP_DEBUG", true);
// 定义当前文件所在的工作目录
define('WORKING_PATH', str_replace('\\', '/', __DIR__)); // C:/wamp/www/TP

// 定义上传的根目录
define('UPLOAD_ROOT_PATH', '/Public/Upload/'); // /Public/Upload/
// 引入TP的入口文件
include './ThinkPHP/ThinkPHP.php';


