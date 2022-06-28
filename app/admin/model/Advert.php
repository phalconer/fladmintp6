<?php

namespace app\admin\model;

use app\common\model\BaseModel;


class Advert extends BaseModel
{

    

    

    // 表名
    protected $name = 'booth_advert';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    protected $deleteTime = false;

    // 追加属性
    protected $append = [
        'module_text',
        'type_text',
        'status_text'
    ];
    
    /**
    * @param Model $row
    */
    protected static function onAfterInsert($row){
        $pk = $row->getPk();
        $row->where($pk, $row[$pk])->update(['weigh' => $row[$pk]]);
    }

    
    public function getModuleList()
    {
        return ['open' => __('Module open'), 'page' => __('Module page'), 'category' => __('Module category'), 'first' => __('Module first'), 'other' => __('Module other')];
    }

    public function getTypeList()
    {
        return ['banner' => __('Type banner'), 'image' => __('Type image'), 'video' => __('Type video')];
    }

    public function getStatusList()
    {
        return ['normal' => __('Normal'), 'hidden' => __('Hidden')];
    }


    public function getModuleTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['module']) ? $data['module'] : '');
        $list = $this->getModuleList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getTypeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['type']) ? $data['type'] : '');
        $list = $this->getTypeList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getStatusTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['status']) ? $data['status'] : '');
        $list = $this->getStatusList();
        return isset($list[$value]) ? $list[$value] : '';
    }




}
