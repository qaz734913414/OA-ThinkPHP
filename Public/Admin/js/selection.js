// 实现全选、全不选、反选等封装的js函数

// 编写自定义插件
$.fn.extend({
    // 用于全选/全不选的函数，需要checkbox旁边显示文字的label的id
    fn1: function (labelId)
    {
        if ($(this).attr('checked') == 'checked') {
            $('input').attr('checked', true);
        } else {
            $('input').attr('checked', false);
        }
    },
    // 点击反选的实现，需要传入三个参数
    // 下面input的类名，以.开头
    // 分页显示的条数, $end - $start + 1
    // 上面全选input的ID
    fn2: function (className, pages, boxId)
    {
        $(className).each(function(index,el){
        if ($(el).attr('checked') == 'checked') {
          $(el).removeAttr('checked');
        } else {
          $(el).attr('checked', 'checked');
        }
      });
    },
    // 重复使用的部分封装为一个函数，在需要使用的时候进行调用
    // 专职专工，每个函数实现自己的功能
    // 需要的参数，上面checkbox的Id和下面input的类名，还有全选label的ID
    // 下面input的类名，以.开头
    fn3: function (className, pages, boxId, labelId)
    {
      if ($(className + ':checked').length == pages) {
        console.log($(boxId + ':checked').attr('checked'));
        $(boxId).attr('checked', 'checked');
        $(labelId).html('不选');
      } else {
        $(boxId).removeAttr('checked');
        $(labelId).html('全选');
      }
    }
});
