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
       label, input {cursor: pointer;}
   </style>
</head>

<body>
    <div class="title"><h2>信息管理</h2></div>
    <div class="table-operate ue-clear">
       <a href="/index.php/Admin/User/add" class="add">添加</a>
       <a href="javascript:;" class="del" id='btnDelete'>删除</a>
       <a href="javascript:;" class="edit" id='btnEdit'>编辑</a>
       <a href="/index.php/Admin/User/charts" class="count">统计</a>
       <a href="javascript:;" class="check">审核</a>
   </div>
   <div class="table-box">
       <table>
           <thead>
               <tr>
                   <th class="id">序号</th>
                   <th class="name">姓名</th>
                   <th class="nickname">昵称</th>
                   <th class="dept_id">所属部门</th>
                   <th class="sex">性别</th>
                   <th class="birthday">生日</th>
                   <th class="tel">电话</th>
                   <th class="email">邮箱</th>
                   <th class="addtime">添加时间</th>
                   <th class="operate">
                       <input type="checkbox" id='selectAll' style="vertical-align: middle" />
                       <label for='selectAll' id='all' style="vertical-align: middle">全选</label>
                       <label id='reverse' style="vertical-align: middle">反选</label>
                   </th>
               </tr>
           </thead>
           <tbody>
               <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                    <td class="id"><?php echo ($vo["id"]); ?></td>
                    <td class="name"><?php echo ($vo["username"]); ?></td>
                    <td class="nickname"><?php echo ($vo["nickname"]); ?></td>
                    <td class="dept_id"><?php echo ($vo["name"]); ?></td>
                    <td class="sex"><?php echo ($vo["sex"]); ?></td>
                    <td class="birthday"><?php echo ($vo["birthday"]); ?></td>
                    <td class="tel"><?php echo ($vo["tel"]); ?></td>
                    <td class="email"><?php echo ($vo["email"]); ?></td>
                    <td class="addtime"><?php echo (date('Y-m-d H:i:s', $vo["addtime"])); ?></td>
                    <td class="operate"><a href="javascript:;"><input type="checkbox" class='check' value='<?php echo ($vo["id"]); ?>' /></a></td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
    </table>
</div>
<div class="pagination ue-clear">
	<div class="pagin-list">
		<?php echo ($page); ?>
	</div>
	<div class="pxofy">显示第 <?php echo ($start); ?> 条到 <?php echo ($end); ?> 条记录，总共 <?php echo ($count); ?> 条记录</div>
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

// $('.pagination').pagination(100,{
// 	callback: function(page){
// 		alert(page);
// 	},
// 	display_msg: true,
// 	setPageNo: true
// });

$("tbody").find("tr:odd").css("backgroundColor","#eff6fa");

showRemind('input[type=text], textarea','placeholder');


// jquery 代码
$(function(){
  var pages = <?php echo ($end); ?> - <?php echo ($start); ?> + 1;
  // 全选/全不选
  $('#selectAll').on('click', function(){$(this).fn1('#all')});
  // 反选
  $('#reverse').on('click', function(){
    $(this).fn2('.check', pages, '#all');
    check();
  });
  // 判断上面的checkbox是否要勾选
  $('.check').on('click', function(){
      // $(this).fn3('.check', pages, '#all');
      check();
    });

    // 重复使用的部分封装为一个函数，在需要使用的时候进行调用
    function check()
    {
      if ($('.check:checked').length == <?php echo ($pagesize); ?>) {
        $('#selectAll').attr('checked', 'checked');
      } else {
        $('#selectAll').removeAttr('checked');
      }
    }

    // 删除
    $('#btnDelete').on('click', function(){
      var ids = $('.check:checked');
      var count = ids.length;
      var str = '';
      for (var i = 0; i < count; i++) {
        str += ids[i].value + ',';
      }
      str = str.substring(0, str.length - 1);
      // console.log(str);
      window.location.href = '/index.php/Admin/User/delete/str/' + str + '/count/' + count;
    });
    // 编辑
    $('#btnEdit').on('click', function(){
        var id = $('.check:checked').val();
        // console.log(id);
        window.location.href = '/index.php/Admin/User/edit/id/' + id;
    });

});
</script>
</html>