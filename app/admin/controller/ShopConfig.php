<?php

namespace app\admin\controller;

use app\common\controller\Backend;

/**
 * 店铺配置管理
 *
 * @icon fa fa-circle-o
 */
class ShopConfig extends Backend
{
    
    /**
     * ShopConfig模型对象
     * @var \app\admin\model\ShopConfig
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\ShopConfig;
        $this->view->assign("freightList", $this->model->getFreightList());
        $this->view->assign("categoryStyleList", $this->model->getCategoryStyleList());
        $this->view->assign("iscloudList", $this->model->getIscloudList());
        $this->view->assign("isautoList", $this->model->getIsautoList());
    }
    
    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个基础方法、destroy/restore/recyclebin三个回收站方法
     * 因此在当前控制器中可不用编写增删改查的代码,除非需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */
    

}
