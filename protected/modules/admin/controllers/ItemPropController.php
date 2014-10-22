<?php

class ItemPropController extends AdminController {

    public $cid = 0;
    
    function init()
    {
        $this->model = 'ItemProp';
        parent::init();
        $this->cid = $this->request->getParam('cid');
        $this->data['model']->cid = $this->cid;
    }

    function list_columns($col)
    {
        $data = parent::list_columns($col);
        //print_r($data);die;
        $data['pid']['header'] = 'ID';
        $data['is_parent']['header'] = '上级';
        $data['name']['header'] = '属性名';
        $data['status']['header'] = '状态';
        $data['sort_order']['header'] = '排序';
        unset($data['is_key_prop']);
        unset($data['is_sale_prop']);
        unset($data['is_color_prop']);
        unset($data['is_enum_prop']);
        unset($data['is_input_prop']);
        unset($data['item_propcol']);
        unset($data['must']);
        unset($data['multi']);
        
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
    
    public function actionList()
    {
        $model = $this->data['model'];
        $model->_attributes = Yii::app()->request->getParam($this->model);
        $model->cid = $this->cid;
        
        $cols = $this->list_columns($model->columnNames());
        $columns = $this->makeGridViewColumns($cols); //装载columns
        //CDbCriteria represents a query criteria, such as conditions, ordering by, limit/offset.
        $criteria = new CDbCriteria;

        foreach ($columns as $v)
        {
            $value = $model->getAttribute($v['name']);
            if (!$value)
                continue;

            $type = $this->table[$v['name']]->type;
            switch ($type)
            {
                //数据库为int型的查询条件拼写
                case 'integer':
                    //将日期格式转为int型
                    if ($v['type'] == 'date')
                    {
                        $time = strtotime(trim($value) . ' 00:00:00');
                        $time2 = strtotime(trim($value) . ' 23:59:59');
                        $criteria->addCondition($v['name'] . '>=' . $time);
                        $criteria->addCondition($v['name'] . '<=' . $time2);
                    }
                    //将日期时间格式转为int型
                    elseif ($v['type'] == 'datetime')
                    {
                        $criteria->addCondition($v['name'] . '=' . strtotime($value));
                    }
                    else
                    {
                        $criteria->addCondition($v['name'] . '=' . intval($value));
                    }

                    break;
                //数据库为double,float 型的查询条件拼写	
                case 'double':
                    if (is_numeric($value))
                        $criteria->addCondition($v['name'] . '=' . $value);
                    break;
                //数据库为char，varchar，text 等符串型的查询条件拼写	
                default:
                    $criteria->addCondition("{$v['name']} like '%" . mysql_escape_string($value) . "%'");
                    break;
            }
        }


        $this->data['columns'] = $columns;
        $this->data['model'] = $model;
        $this->data['filter'] = $model;
        $this->data['criteria'] = $criteria;

        $this->template = '/list';
    }
    function buildForm($col, $return_id = FALSE)
    {
        $data = parent::buildForm($col, $return_id);
        
        $model = $this->data['model'];
        $flags = array(1 => 'Yes', 0 => 'No');
        
        $data['is_parent']['field']     = CHtml::activeDropDownList($model, 'is_parent', $flags);
        $data['is_key_prop']['field']   = CHtml::activeDropDownList($model, 'is_key_prop', $flags);
        $data['is_enum_prop']['field']  = CHtml::activeDropDownList($model, 'is_enum_prop', $flags);
        $data['is_input_prop']['field'] = CHtml::activeDropDownList($model, 'is_input_prop', $flags);
        $data['must']['field']          = CHtml::activeDropDownList($model, 'must', $flags);
        $data['multi']['field']         = CHtml::activeDropDownList($model, 'multi', $flags);
        $data['status']['field']        = CHtml::activeDropDownList($model, 'status', $flags);
        unset($data['alias']);
        unset($data['is_sale_prop']);
        unset($data['is_color_prop']);
        unset($data['item_propcol']);
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
                        'label' => '属性值管理',
                        'url'   => 'Yii::app()->controller->createUrl("itemPropValue/list", array("pid"=>$data->getPrimaryKey(), "cid" => $data->cid))',
                      )
                  ), 
        );
        return $buttons;
    }
}
