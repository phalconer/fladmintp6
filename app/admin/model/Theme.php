<?php

namespace app\admin\model;

use app\common\model\BaseModel;


class Theme extends BaseModel
{

    

    

    // 表名
    protected $name = 'booth_theme';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    protected $deleteTime = false;

    // 追加属性
    protected $append = [
        'theme_time_text'
    ];
    

    



    public function getThemeTimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['theme_time']) ? $data['theme_time'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }

    protected function setThemeTimeAttr($value)
    {
        return $value === '' ? null : ($value && !is_numeric($value) ? strtotime($value) : $value);
    }


}
