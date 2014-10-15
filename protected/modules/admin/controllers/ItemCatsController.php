<?php

class ItemCatsController extends AdminController {

    function init()
    {
        $this->model = 'ItemCats';
        parent::init();
    }

    function list_columns($col)
    {
        $data = parent::list_columns($col);
        //print_r($data);die;
        unset($data['is_down']);
        
        return $data;
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
            'pagination' => array('pageSize' => 25),
        ));
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
            'headerHtmlOptions' => array('width' => '100'),
            'template' => '{props} {update} {delete}', //{view} {update} {delete} {other}
            //    'viewButtonOptions'=>array('title'=>'查看'),
            'updateButtonOptions' => array('title' => '修改'),
            'deleteButtonOptions' => array('title' => '刪除'),
            'deleteConfirmation' => '确定删除？',
            'updateButtonUrl' => 'Yii::app()->controller->createUrl("edit", array($data->primaryKey() => $data->getPrimaryKey()))',
            'deleteButtonUrl' => 'Yii::app()->controller->createUrl("delete", array($data->primaryKey() => $data->getPrimaryKey()))',
                    'buttons' => array(
                        'props' => array(
                        'label' => '属性管理',
                        'url'   => 'Yii::app()->controller->createUrl("itemProp/list", array("cid"=>$data->cid))',
                      )
                  ), 
        );
        return $buttons;
    }
}
