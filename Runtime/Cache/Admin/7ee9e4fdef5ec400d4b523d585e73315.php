<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="/Public/Admin/css/base.css" />
<link rel="stylesheet" href="/Public/Admin/css/info-reg.css" />
<title>移动办公自动化系统</title>
<style type='text/css'>
	select {
		background: rgba(0, 0, 0, 0) url("/Public/Admin/images/inputbg.png") repeat-x scroll 0 0;
	    border: 1px solid #c5d6e0;
	    height: 28px;
	    outline: medium none;
	    padding: 0 8px;
	    width: 240px;
	}
	.main p input {
		float:none;
	}
</style>
</head>

<body>
<div class="title"><h2>公文起草</h2></div>
<form action="/index.php/Admin/Doc/editOk" method="post" enctype="multipart/form-data">
<div class="main">
	<p class="short-input ue-clear">
    	<label>标题：</label>
        <input name="title" type="text" placeholder="标题..." value='<?php echo ($data["title"]); ?>'/>
        <input type="hidden" name='id' value='<?php echo ($data["id"]); ?>'>
    </p>
	<p class="short-input ue-clear">
    	<label>附件：</label>
        <input name="file" type="file"/> 注：如果不修改请留空
    </p>
    <p class="short-input ue-clear">
    	<label>作者：</label>
        <input name="author" type="text" placeholder="作者..." value='<?php echo ($data["author"]); ?>'/>
    </p>
    <p class="short-input ue-clear">
    	<label>内容：</label>
        <textarea name="content" style="font-family:Microsoft YaHei !important; font-size:14px;" placeholder="请输入内容..." ><?php echo ($data["content"]); ?></textarea>
    </p>
</div>
<div class="btn ue-clear">
	<a href="javascript:;" class="confirm" id='btnSubmit'>确定</a>
    <a href="javascript:;" class="clear" id='btnReset'>重置</a>
</div>
</form>
</body>
<script type="text/javascript" src="/Public/Admin/js/jquery.js"></script>
<script type="text/javascript" src="/Public/Admin/js/common.js"></script>
<script type="text/javascript" src="/Public/Admin/js/WdatePicker.js"></script>
<script type="text/javascript">
$(function(){
	$('#btnSubmit').on('click',function(){
		$('form').submit();
	});

	$('#btnReset').on('click',function(){
		$('form')[0].reset();
	});
});

$(".select-title").on("click",function(){
	$(".select-list").toggle();
	return false;
});
$(".select-list").on("click","li",function(){
	var txt = $(this).text();
	$(".select-title").find("span").text(txt);
});
showRemind('input[type=text], textarea','placeholder');
</script>
</html>