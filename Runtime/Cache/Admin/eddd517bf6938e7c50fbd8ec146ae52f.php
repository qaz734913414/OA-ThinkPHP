<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/Public/Admin/css/base.css" />
    <link rel="stylesheet" href="/Public/Admin/css/info-mgt.css" />
    <link rel="stylesheet" href="/Public/Admin/css/WdatePicker.css" />
    <title>移动办公自动化系统</title>
</head>

<body>
    <div class="title">
        <h2>信息管理</h2></div>
    <div class="table-operate ue-clear">
        <a href="javascript:;" class="add">添加</a>
        <a href="javascript:;" class="del" id='deptDel'>删除</a>
        <a href="javascript:;" class="edit" id='deptEdit'>编辑</a>
        <a href="javascript:;" class="count">统计</a>
        <a href="javascript:;" class="check">审核</a>
    </div>
    <div class="table-box">
        <table>
            <thead>
                <tr>
                    <th class="num">序号</th>
                    <th class="name">部门</th>
                    <th class="process">所属部门</th>
                    <th class="node">排序</th>
                    <th class="time">备注</th>
                    <th class="operate">操作</th>
                </tr>
            </thead>
            <tbody>
                <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vol): $mod = ($i % 2 );++$i;?><tr>
                        <td class="num"><?php echo ($vol["id"]); ?></td>
                        <td class="name"><?php echo ($vol["name"]); ?></td>
                        <td class="process">
                            <?php if($vol["pid"] == '0' ): ?>顶级部门
                                <?php else: ?> <?php echo (str_repeat('&emsp;', $vol["level"]*2)); echo ($vol["parentName"]); endif; ?>
                        </td>
                        <td class="node"><?php echo ($vol["sort"]); ?></td>
                        <td class="time"><?php echo ($vol["remark"]); ?></td>
                        <td class="operate">
                            <a href="javascript:;">
                                <input type="checkbox" value='<?php echo ($vol["id"]); ?>'>
                            </a>
                        </td>
                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
        </table>
    </div>
    <div class="pagination ue-clear"></div>
</body>
<script type="text/javascript" src="/Public/Admin/js/jquery.js"></script>
<script type="text/javascript" src="/Public/Admin/js/common.js"></script>
<script type="text/javascript" src="/Public/Admin/js/WdatePicker.js"></script>
<script type="text/javascript" src="/Public/Admin/js/jquery.pagination.js"></script>
<script type="text/javascript">
$(".select-title").on("click", function() {
    $(".select-list").hide();
    $(this).siblings($(".select-list")).show();
    return false;
})
$(".select-list").on("click", "li", function() {
    var txt = $(this).text();
    $(this).parent($(".select-list")).siblings($(".select-title")).find("span").text(txt);
})

$('.pagination').pagination(100, {
    callback: function(page) {
        alert(page);
    },
    display_msg: true,
    setPageNo: true
});

$("tbody").find("tr:odd").css("backgroundColor", "#eff6fa");

showRemind('input[type=text], textarea', 'placeholder');

// 编辑和删除的jQuery代码
$('#deptDel').on('click', function() {
    var id = $(':checkbox:checked');
    var ids = '';
    var count = id.length;
    // console.log(id.length);
    for (var i = 0; i < count; i++) {
        // console.log(id[i].value);
        ids += id[i].value + ',';
    }
    // console.log(ids);
    ids = ids.substr(0, ids.length - 1);
    // console.log(ids);
    // 跳转
    window.location.href = '/index.php/Admin/Dept/delete/ids/' + ids + '/count/' + count;
});

$('#deptEdit').on('click', function() {
    var id = $(':checkbox:checked').val(); // 只会取第一个
    console.log(id);
    if (id) {
        // 跳转
        window.location.href = '/index.php/Admin/Dept/edit/id/' + id;
    } else {
        window.alert('请勾选之后再进行编辑');
    }
});
</script>

</html>