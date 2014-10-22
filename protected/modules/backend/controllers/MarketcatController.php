<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * 商城分类
 *
 * @author Fighter
 */
class MarketcatController extends CurdController {

    public $model = 'MarketCats';
    public $parentId = 0;

    function init()
    {
        parent::init();
        $this->parentId = $this->request->getParam('parent_id', 0);
        $this->data['model']->parent_id = $this->parentId;
        $this->data['model']->market_id = $this->store->market_id;
        $this->data['model']->parent_id = $this->parentId;
        $_GET[$this->model]['parent_id'] = $this->parentId;
        
        $_GET['parent_id'] = $this->parentId;
    }

    function list_columns($col)
    {
        $data = parent::list_columns($col);
        
        $data['parent_id']['func']  = "listName";
        $data['recommend']['func']  = "toggle";
        $data['status']['func']     = "toggle";
        $data['cid']['func']        = "catName";
        unset($data['parent_cid']);
        unset($data['market_id']);
        unset($data['url']);
        unset($data['css']);
        unset($data['icon']);

        return $data;
    }

    function actionList()
    {
        parent::actionList();
        $this->data['criteria']->addCondition('parent_id='.$this->parentId);
        $model = $this->data['model']->findByPk($this->parentId);
        
        $returnUrl = $this->createUrl('list', array('parent_id' => (int)$model->parent_id));
        $this->data['returnUrl'] = $returnUrl;
    }
    function actionEdit()
    {
        parent::actionEdit();
        
    }

    function actionSave($ret = FALSE)
    {
        $data = Yii::app()->request->getPost($this->model); // 获取post中该表的数据 数组
        if ($data['cid'] > 0)
        {
            $cat = ItemCats::model()->findByPk($data['cid']);
            $_POST[$this->model]['parent_cid'] = $cat->parent_cid;
            if ($data['name'] == '')
            {
                $_POST[$this->model]['name'] = $cat->name;
            }
        }
        
        $model = parent::actionSave(TRUE);
        
        $this->redirect($this->createUrl('list', array('parent_id' => $model->parent_id)));
    }
    /**
     * 	通用 列表数据查询方法
     */
    public function search()
    {
        /*
         * CActiveDataProvider为类modelClass的ActiveRecord对象 提供数据。
         * 它使用AR的CActiveRecord::findAll方法， 从数据库中检索信息。
         * criteria属性能够用来 查询多种指定条件。
         */
        return new CActiveDataProvider($this->data['model'], array(
            'criteria' => $this->data['criteria'],
            'pagination' => array('pageSize' => 20),
        ));
    }

    /**
     *
     * 表单中的字段信息  子类可以overwrite 此方法自定义
     *
     * @param Array $data
     * @param Bool $return_id
     */
    protected function blank_form_columns($col, $model = FALSE)
    {
        $data = parent::blank_form_columns($col, $model);
        
        if ($this->data['model']->parent_id == 0)
        {
            $list = array('请选择...');
            $list = array_merge($list, ItemCats::model()->findAll('parent_cid=0'));
            $cats = CHtml::listData($list, 'cid', 'name');
        }
        else
        {
            $cats = ItemCats::model()->queryListData(0);
        }
        
        
        $data['cid']['field'] = CHtml::activeDropDownList($this->data['model'], 'cid', $cats, array('class' => 'form-control'));
        
        unset($data['parent_cid']);
        unset($data['icon']);
        return $data;
    }
    
    protected function full_form_columns($col, $model = NULL)
    {
        $data = parent::full_form_columns($col, $model);
        
        if ($model->parent_id == 0)
        {
            $list = array('请选择...');
            $list = array_merge($list, ItemCats::model()->findAll('parent_cid=0'));
            $cats = CHtml::listData($list, 'cid', 'name');
        }
        else
        {
            $cats = ItemCats::model()->queryListData(0);
        }
        
        $data['cid']['field'] = CHtml::activeDropDownList($model, 'cid', $cats, array('class' => 'form-control'));
        
        unset($data['parent_cid']);
        unset($data['icon']);
        
        $_GET['parent_id'] = $model->parent_id;
        return $data;
    }
    /**
     *
     * 列表静态操作方法
     * @param primary_key $id
     */
    public function handle()
    {
        $buttons = array(
            'class' => 'CButtonColumn',
            'header' => '操作',
            'headerHtmlOptions' => array('width' => '200'),
            'template' => '{sublist} &nbsp;&nbsp;&nbsp; {update} {delete}', //{view} {update} {delete} {other}
            //    'viewButtonOptions'=>array('title'=>'查看'),
            'updateButtonOptions' => array('title' => '修改'),
            'deleteButtonOptions' => array('title' => '刪除'),
            'deleteConfirmation' => '确定删除？',
            'updateButtonUrl' => 'Yii::app()->controller->createUrl("edit", array($data->primaryKey() => $data->getPrimaryKey()))',
            'deleteButtonUrl' => 'Yii::app()->controller->createUrl("delete", array($data->primaryKey() => $data->getPrimaryKey()))',
            'buttons' => array(
                'sublist' => array(
                    'label' => '子列表',
                    'url' => 'Yii::app()->controller->createUrl("list", array("parent_id"=>$data->getPrimaryKey()))',
                )
            ),
        );
        return $buttons;
    }

    public function actionGetChild($parent_id)
    {
        $areas = Area::model()->findAllByAttributes(array('parent_id' => $parent_id));
        $areasData = CHtml::listData($areas, 'area_id', 'name');
        echo json_encode(CMap::mergeArray(array('0' => ''), $areasData));
    }
    
    public function listName($col, $data)
    {
        return MarketCats::model()->findByPk($data->$col)->name;
    }
}
