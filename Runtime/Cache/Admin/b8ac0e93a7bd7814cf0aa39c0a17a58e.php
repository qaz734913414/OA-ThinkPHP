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
       input, label {cursor: pointer;}
   </style>
</head>

<body>
    <div class="title"><h2>公文管理</h2></div>
    <div class="table-operate ue-clear">
       <a href="/index.php/Admin/Doc/add" class="add">添加</a>
       <a href="javascript:;" class="del" id='btnDel'>删除</a>
       <a href="javascript:;" class="edit" id='btnEdit'>编辑</a>
       <a href="javascript:;" class="count">统计</a>
       <a href="javascript:;" class="check">审核</a>
   </div>
   <div class="table-box">
       <table>
           <thead>
               <tr>
                   <th class="id">序号</th>
                   <th class="name">标题</th>
                   <th class="file">附件</th>
                   <th class="content">内容</th>
                   <th class="addtime">添加时间</th>
                   <th class="operate">
                    <input type="checkbox" id='selectAll' style='vertical-align: middle' />
                    <label for="selectAll" id='all' style='vertical-align: middle'>全选</label>
                    <label id='reverse' style='vertical-align: middle'>反选</label>
                </th>
            </tr>
        </thead>
        <tbody>
        	<?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                   <td class="id"><?php echo ($vo["id"]); ?></td>
                   <td class="name"><?php echo (msubstr($vo["title"],0,8)); ?></td>
                   <td class="file">
                    <?php echo ($vo["filename"]); ?>
                    <?php if($vo["hasfile"] == 1 ): ?><a href="javascript:;" data='<?php echo ($vo["id"]); ?>' class='download'>【下载】</a><?php endif; ?>
                </td>
                <td class="content"><?php echo (msubstr(strip_tags(html_entity_decode($vo["content"])),0,20)); ?></td>
                <td class="addtime"><?php echo (date('Y-m-d H:i:s',$vo["addtime"])); ?></td>
                <td class="operate">
                    <input type="checkbox" class='check' value='<?php echo ($vo["id"]); ?>' style='vertical-align: middle' />
                    <a href ='javascript:;' style='vertical-align: middle' class='show' data='<?php echo ($vo["id"]); ?>' data-title='<?php echo ($vo["title"]); ?>'>查看</a>
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
<script type="text/javascript" src="/Public/Admin/js/layer/layer.js"></script>
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

$(function(){
    // 获取本页显示的条数
    var pages = <?php echo ($count); ?>;
    // 点击全选/全不选的实现
    $('#selectAll').on('click', function(){
        $(this).fn1('#selectAll');
        $(this).fn3('.check', pages, '#selectAll', '#all');
    });
    // 点击反选的实现
    $('#reverse').on('click',function(){
        $(this).fn2('.check', pages, '#selectAll');
        $(this).fn3('.check', pages, '#selectAll', '#all');
    });
    // 判断上面那个checkbox的状态
    $('.check').on('click', function(){$(this).fn3('.check', pages, '#selectAll', '#all');});

    // jquery点击下载功能的实现
    $('.download').on('click', function(){
        var id =$(this).attr('data');
        window.location.href = '/index.php/Admin/Doc/download/id/' + id;
    });

    // 点击删除按钮触发的事件
    $('#btnDel').on('click', function(){
      var ids = $('.check:checked');
      var count = ids.length;
      if (count == 0) {
        alert('请先勾选要删除的数据，再点击删除');
      } else {
        var str = '';
        $('.check:checked').each(function(index, el){
          str += $(el).attr('value') + ',';
          // console.log($(el).attr('value'));
        });
        str = str.substring(0, str.length - 1);
      }
      // console.log(str);
      window.location.href = '/index.php/Admin/Doc/delete/str/' + str + '/count/' + count;
    });

    // 点击编辑按钮触发的事件
    $('#btnEdit').on('click', function(){
      var id = $('.check:checked').val();
      if (id == undefined) {
        alert('请勾选想要编辑的数据');
      } else {
        // alert(id);
        window.location.href = '/index.php/Admin/Doc/edit/id/' + id;
      }
    });

    // 点击查看按钮触发的事件
    $('.show').on('click', function(){
      // 获取公文id
      var id = $(this).attr('data');
      // 获取公文标题
      var doc_title = $(this).attr('data-title');
      // 调用layer插件
      layer.open({
        type: 2,
        title: doc_title,
        shadeClose: true,
        shade: 0.5,
        area: ['380px', '90%'],
        content: '/index.php/Admin/Doc/getContent/id/' + id,
      });
    });
});
</script>
</html>