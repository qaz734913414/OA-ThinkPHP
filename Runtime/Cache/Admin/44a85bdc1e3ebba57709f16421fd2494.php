<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="/Public/Admin/css/base.css" />
<link rel="stylesheet" href="/Public/Admin/css/info-mgt.css" />
<link rel="stylesheet" href="/Public/Admin/css/WdatePicker.css" />
<title>移动办公自动化系统</title>
<style type='text/css'>
	table tr .id{ width:63px; text-align: center;}
	table tr .name{ width:118px; padding-left:17px;}
	table tr .nickname{ width:63px; padding-left:17px;}
	table tr .dept_id{ width:63px; padding-left:13px;}
	table tr .sex{ width:63px; padding-left:13px;}
	table tr .birthday{ width:80px; padding-left:13px;}
	table tr .tel{ width:113px; padding-left:13px;}
	table tr .email{ width:160px; padding-left:13px;}
	table tr .addtime{ width:160px; padding-left:13px;}
	table tr .operate{ padding-left:13px;}
    input, label {cursor: pointer; vertical-align: middle;}
</style>
</head>

<body>
<div class="title"><h2>知识管理</h2></div>
<div class="table-operate ue-clear">
	<a href="/index.php/Admin/Knowledge/add" class="add">添加</a>
    <a href="javascript:;" class="del" id='btnDel'>删除</a>
    <a href="javascript:;" class="edit" id='btnEdit'>编辑</a>
    <a href="javascript:;" class="check">审核</a>
</div>
<div class="table-box">
	<table>
    	<thead>
        	<tr>
            	<th class="id">序号</th>
                <th class="name">标题</th>
				<th class="file">缩略图</th>
                <th class="content">内容</th>
                <th class="content">作者</th>
				<th class="addtime">添加时间</th>
                <th class="operate">
                    <input type="checkbox" id='selectAll'/>
                    <label for="selectAll" id='All'>全选</label>
                    <label id='reverse'>反选</label>
                </th>
            </tr>
        </thead>
        <tbody>
        	<?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                    <td class="id"><?php echo ($vo["id"]); ?></td>
                    <td class="name"><?php echo ($vo["title"]); ?></td>
                    <td class="file"><img src="<?php echo ($vo["thumb"]); ?>"></td>
                    <td class="content"><?php echo ($vo["content"]); ?></td>
                    <td class="content"><?php echo ($vo["author"]); ?></td>
                    <td class="addtime"><?php echo (date('Y-m-d H:i:s', $vo["addtime"])); ?></td>
                    <td class="operate">
                        <input type="checkbox" class='check' />
                        <a href ='javascript:;'>查看</a>
                    </td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
    </table>
</div>
<div class="pagination ue-clear">
	<div class="pagin-list">
		<?php echo ($page); ?>
	</div>
	<div class="pxofy">共 <?php echo ($count); ?> 条记录</div>
</div>
</body>
<script type="text/javascript" src="/Public/Admin/js/jquery.js"></script>
<script type="text/javascript" src="/Public/Admin/js/common.js"></script>
<script type="text/javascript" src="/Public/Admin/js/WdatePicker.js"></script>
<script type="text/javascript" src="/Public/Admin/js/selection.js"></script>
<script type="text/javascript">
$(".select-title").on("click",function(){
	$(".select-list").hide();
	$(this).siblings($(".select-list")).show();
	return false;
})
$(".select-list").on("click","li",function(){
	var txt = $(this).text();
	$(this).parent($(".select-list")).siblings($(".select-title")).find("span").text(txt);
})

$("tbody").find("tr:odd").css("backgroundColor","#eff6fa");

showRemind('input[type=text], textarea','placeholder');

// jQuery实现全选，不选，反选
$(function(){
    var pages = <?php echo ($count); ?>;
    console.log(pages);
    $('#selectAll').on('click', function(){
        $(this).fn1('#selectAll');
        $(this).fn3('.check', pages, '#selectAll', '#All');
    });

    $('#reverse').on('click', function(){
        $(this).fn2('.check', pages, '#all');
        $(this).fn3('.check', pages, '#selectAll', '#All');
    });

    $('.check').on('click', function(){$(this).fn3('.check', pages,'#selectAll', '#All');});

    // 编辑
    $('#btnEdit').on('click', function(){
        var id = $('.check:checked').val();
        if (id == undefined) {
            alert('请先勾选再编辑');
        } else {
            alert(id);
            // window.location.href = '/index.php/Admin/Knowledge/edit/id/' + id;
        }
    });
    // 删除
});
</script>
</html>