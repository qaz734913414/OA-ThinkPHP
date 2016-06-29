<?php
namespace Admin\Model;

use Think\Model;

class StudentModel extends Model
{
    // 指定当前模型需要关联的真实数据表名，没有前缀什么的特殊表
    protected $trueTableName = 'student';
    public function test()
    {

    }
}
