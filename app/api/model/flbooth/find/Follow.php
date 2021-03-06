<?php

namespace app\api\model\flbooth\find;

use think\Model; 

class Follow extends Model
{
 

    // 表名
    protected $name = 'booth_find_user_follow';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $created = 'created';
    protected $modified = 'modified';
    protected $deleted = 'deleted';
}
