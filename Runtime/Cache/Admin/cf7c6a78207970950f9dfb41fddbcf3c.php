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
        float: none;
    }
    </style>
</head>

<body>
    <div class="title">
        <h2>信息登记</h2></div>
    <form action="/index.php/Admin/User/addOk" method="post">
        <div class="main">
            <p class="short-input ue-clear">
                <label>用户名：</label>
                <input name="username" type="text" id='username' placeholder="用户名" />
                <font id='usernameSpan'></font>
            </p>
            <p class="short-input ue-clear">
                <label>密码：</label>
                <input name="password" type="text" placeholder="密码" />
            </p>
            <p class="short-input ue-clear">
                <label>姓名：</label>
                <input name="truename" type="text" placeholder="姓名" />
            </p>
            <p class="short-input ue-clear">
                <label>昵称：</label>
                <input name="nickname" type="text" placeholder="昵称" />
            </p>
            <div class="short-input select ue-clear">
                <label>所属部门：</label>
                <select name="dept_id">
                    <option value="-1">请选择</option>
                    <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value='<?php echo ($vo["id"]); ?>'><?php echo (str_repeat('&emsp;', $vo["level"]*2)); echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                </select>
            </div>
            <p class="short-input ue-clear">
                <label>性别：</label>
                <input name="sex" type="radio" value="男" checked='checked' />男
                <input name="sex" type="radio" value="女" />女
            </p>
            <p class="short-input ue-clear">
                <label>生日：</label>
                <input name="birthday" type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" />
            </p>
            <p class="short-input ue-clear">
                <label>联系电话：</label>
                <input type="text" name="tel" placeholder="联系电话" />
            </p>
            <p class="short-input ue-clear">
                <label>邮箱：</label>
                <input type="text" name="email" placeholder="电子邮箱" />
            </p>
            <p class="short-input ue-clear">
                <label>备注：</label>
                <textarea name="remark" style="font-family:Microsoft YaHei !important; font-size:14px;" placeholder="请输入内容" name="remark"></textarea>
            </p>
        </div>
        <div class="btn ue-clear">
            <a href="javascript:;" class="confirm" id='btnSubmit'>确定</a>
            <a href="javascript:;" class="clear" id='btnReset'>清空内容</a>
        </div>
    </form>
</body>
<script type="text/javascript" src="/Public/Admin/js/jquery.js"></script>
<script type="text/javascript" src="/Public/Admin/js/common.js"></script>
<script type="text/javascript" src="/Public/Admin/js/WdatePicker.js"></script>
<script type="text/javascript">
$(function() {
    $('#btnSubmit').on('click', function() {
        $('form').submit();
    });

    $('#btnReset').on('click', function() {
        $('form')[0].reset();
    });
    // 页面加载完成后自动获取用户名焦点
    setTimeout(function() {
        try {
            $('#username').focus();
            // $('$username').select();
        } catch (e) {}
    }, 200);
    // 使用ajax检查用户名是否合法
    $('#username').on('input', function() {
        var username = $('#username').val();
        // alert(username);
        $.ajax({
                url: '/index.php/Admin/User/checkName',
                type: 'get',
                dataType: 'json',
                data: {
                    'username': username
                },
            })
            .done(function(data) {
                if (data) {
                    $('#usernameSpan').css('color', 'red');
                    $('#usernameSpan').html('用户名不可用');
                    $('#username').focus();
                } else {
                    $('#usernameSpan').html('用户名可用');
                    $('#usernameSpan').css('color', 'green');
                }
            })
            .fail(function() {
                console.log("error");
            })
            .always(function() {
                console.log("complete");
            });

    });

});

$(".select-title").on("click", function() {
    $(".select-list").toggle();
    return false;
});
$(".select-list").on("click", "li", function() {
    var txt = $(this).text();
    $(".select-title").find("span").text(txt);
});

showRemind('input[type=text], textarea', 'placeholder');
</script>

</html>