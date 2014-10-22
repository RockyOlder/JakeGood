<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AreaController
 *
 * @author Fighter
 */
class AreaController extends CurdController {

    public $model = 'Area';
    public $parentId = 0;

    function init()
    {
        parent::init();
        $this->parentId = $this->request->getParam('parent_id', 100000);
        $this->data['model']->area_id   = $this->parentId;
        $this->data['model']->parent_id = $this->parentId;
        $_GET['Area']['parent_id'] = $this->parentId;
    }

    function list_columns($col)
    {
        $data = parent::list_columns($col);
        $data['parent_id']['filter'] = false;
        unset($data['path']);
        unset($data['grade']);
        unset($data['language']);

        return $data;
    }

    function actionList()
    {
        parent::actionList();
        $model = $this->data['model']->findByPk($this->parentId);
        $returnUrl = $this->createUrl('list', array('parent_id' => $model->parent_id));
        $this->data['returnUrl'] = $returnUrl;
    }
    
    function actionSave($ret = FALSE)
    {
        $data = Yii::app()->request->getPost($this->model); // 获取post中该表的数据 数组
        $pk = isset($data[$this->pk]) ? $data[$this->pk] : NULL;
        
        $parent = $this->data['model']->findByPk($data['parent_id']);
        $data['path']  = $parent->path .','. $data['parent_id'];
        $data['grade'] = $parent->grade+1;
        $data['language'] = '1';
        $model = $this->data['model']->findByPk($pk);
        if (!$model)
        {            
            $model = $this->data['model'];
        }

        $model->_attributes = $data;

        if ($model->save())
        {
            $catalog = $model->isNewRecord ? 'create' : 'update';
            //parent::adminLogger(array('user_id' => 1, 'catalog'=>'create', 'intro'=>'新增'.$this->data['title'].'，ID:'.$model->id));
        }
        else
        {
            print_r($model->errors);die;
        }
        $this->redirect($this->createUrl('list', $_GET));
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
    protected function blank_form_columns($col, $return_id = FALSE)
    {
        //继承list中的标题
        $list_columns = $this->list_columns($col);

        $data = array();
        foreach ($col as $k => $v)
        {
            //当是新增记录时 默认值为空
            $data[$v]['field'] = CHtml::activeTextField($this->data['model'], $v, array('id' => '_' . $v, 'class' => 'form-control'));
            $data[$v]['name'] = isset($list_columns[$v]['name']) ? $list_columns[$v]['name'] : ( (empty($this->table[$v]->comment)) ? $v : $this->table[$v]->comment );
            $data[$v]['desc'] = isset($list_columns[$v]['desc']) ? $list_columns[$v]['desc'] : "";


            //eg {	required: true,	minlength: 5,equalTo: "#password"}
            $data[$v]['validate']['rules'] = '{required: true}';
            $data[$v]['validate']['message'] = '{required:" ' . $data[$v]['name'] . '必填"}';
        }
        //默认添加情况下 表单中不显示pk
        
        unset($data['path']);
        unset($data['grade']);
        unset($data['language']);
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
}
