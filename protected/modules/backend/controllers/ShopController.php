<?php

class ShopController extends CurdController {

    public $model = 'Shop';
    public function init()
    {
        parent::init();
        $this->title = '商家管理';
        $parent_id = $this->request->getQuery('parent_id', 0);
        if ($parent_id > 0)
        {
            $_POST[$this->model]['parent_id'] = $parent_id;
            $this->data['returnUrl'] = $this->createUrl('shop/list');
        }
    }
    
    function list_columns($col)
    {
        $data = parent::list_columns($col);
        
        $data['cid']['func']       = 'catName';
        $data['parent_id']['func'] = 'parentName';
        $data['district']['func']  = 'areaName';
        $data['region']['func']    = 'areaName';
        $data['created']['func']   = 'dateFormat';
        $data['status']['func']    = 'toggle';
        
        $cats = ItemCats::model()->findAll('parent_cid=0');
        $data['cid']['filter'] = CHtml::listData($cats, 'cid', 'name');
        $data['parent_id']['filter'] = false;
        $data['district']['filter'] = false;
        $data['region']['filter'] = false;
        
        unset($data['market_id']);
        unset($data['store_id']);
        unset($data['metro']);
        unset($data['state']);
        unset($data['city']);
        unset($data['address']);
        unset($data['hours']);
        unset($data['lng']);
        unset($data['lat']);
        unset($data['closed']);
        unset($data['user_id']);
        unset($data['password']);

        return $data;
    }
    
    public function search()
    {
        $this->data['criteria']->order = 'parent_id asc';
        return new CActiveDataProvider($this->data['model'], array(
            'criteria' => $this->data['criteria'],
            'pagination' => array('pageSize' => 20),
        ));
    }
    
    public function actionAdd()
    {
        $this->title = '添加商家';
        $parent_id = $this->request->getQuery('parent_id', 0);
        if ($parent_id > 0)
        {
            $model = $this->data['model']->findByPk($parent_id);
            $this->data['model']->cid = $model->cid;
            $this->data['model']->parent_id = $parent_id;
            $this->data['model']->state     = $model->state;
            $this->data['model']->city      = $model->city;
            $this->data['model']->hours     = $model->hours;
        }
        
        parent::actionAdd();    
    }

    public function actionSave($ret = FALSE)
    {
        $data = $this->request->getPost($this->model);
        
        $_POST[$this->model]['market_id'] = $this->store->market_id;
        $_POST[$this->model]['store_id'] = $this->store->store_id;
        
        if (trim($data['password']) != '')
        {
            $_POST[$this->model]['password'] = md5(trim($data['password']));
        }
        else
        {
            unset($_POST[$this->model]['password']);
        }
        parent::actionSave($ret);
    }
    
    function blank_form_columns($col, $return_id = FALSE)
    {
        $data = parent::blank_form_columns($col, $return_id);
        
        $shops = $this->data['model']->findAll('parent_id=0');
        $shops = CHtml::listData($shops, 'id', 'name');
        $shops = array(0 => '')+$shops;
        
        $cats = ItemCats::model()->findAll('parent_cid=0');
        $cats = CHtml::listData($cats, 'cid', 'name');
        
        $areas   = $this->getAreas($this->data['model']->state, $this->data['model']->city, $this->data['model']->district, $this->data['model']->region);
        $areaUrl = Yii::app()->createUrl('seller/area/getChild');
        
        $data['parent_id']['field']= CHtml::activeDropDownList($this->data['model'], 'parent_id', $shops, array('class' => 'form-control'));
        $data['cid']['field']      = CHtml::activeDropDownList($this->data['model'], 'cid', $cats, array('class' => 'form-control'));
        $data['state']['field']    = CHtml::activeDropDownList($this->data['model'], 'state', $areas[0], array('class' => 'form-control area', 'data-child-area' => 'area-city', 'data-url' => $areaUrl));
        $data['city']['field']     = CHtml::activeDropDownList($this->data['model'], 'city', $areas[1], array('class' => 'form-control area area-city', 'data-child-area' => 'area-district', 'data-url' => $areaUrl));
        $data['district']['field'] = CHtml::activeDropDownList($this->data['model'], 'district', $areas[2], array('class' => 'form-control area area-district', 'data-child-area' => 'area-region', 'data-url' => $areaUrl));
        $data['region']['field']   = CHtml::activeDropDownList($this->data['model'], 'region', $areas[3], array('class' => 'form-control area-region'));
        $data['status']['field']   = CHtml::activeDropDownList($this->data['model'], 'status', array('Close', 'Open'), array('class' => 'form-control'));
        
        unset($data['market_id']);
        unset($data['store_id']);
        unset($data['created']);
        unset($data['closed']);
        unset($data['user_id']);
        
        $data['hours']['validate']['rules'] = '{required: false}';
        return $data;
    }
    protected function full_form_columns($col, $model)
    {
        
        $data = parent::full_form_columns($col, $model);
        
        $shops = $this->data['model']->findAll('parent_id=0');
        $shops = CHtml::listData($shops, 'id', 'name');
        $shops = array(0 => '')+$shops;
        
        $cats = ItemCats::model()->findAll('parent_cid=0');
        $cats = CHtml::listData($cats, 'cid', 'name');
        $areas   = $this->getAreas($model->state, $model->city, $model->district, $model->region);
        $areaUrl = Yii::app()->createUrl('seller/area/getChild');
        $model->password = '';
        
        $data['parent_id']['field']= CHtml::activeDropDownList($model, 'parent_id', $shops, array('class' => 'form-control'));
        $data['cid']['field']      = CHtml::activeDropDownList($model, 'cid', $cats, array('class' => 'form-control'));
        $data['state']['field']    = CHtml::activeDropDownList($model, 'state', $areas[0], array('class' => 'form-control area', 'data-child-area' => 'area-city', 'data-url' => $areaUrl));
        $data['city']['field']     = CHtml::activeDropDownList($model, 'city', $areas[1], array('class' => 'form-control area area-city', 'data-child-area' => 'area-district', 'data-url' => $areaUrl));
        $data['district']['field'] = CHtml::activeDropDownList($model, 'district', $areas[2], array('class' => 'form-control area area-district', 'data-child-area' => 'area-region', 'data-url' => $areaUrl));
        $data['region']['field']   = CHtml::activeDropDownList($model, 'region', $areas[3], array('class' => 'form-control area-region'));
        $data['status']['field']   = CHtml::activeDropDownList($model, 'status', array('Close', 'Open'), array('class' => 'form-control'));
        $data['password']['field']   = CHtml::activeTextField($model, 'password', array('class' => 'form-control'));
                
        unset($data['market_id']);
        unset($data['store_id']);
        unset($data['created']);
        unset($data['closed']);
        unset($data['user_id']);
        
        $data['hours']['validate']['rules'] = '{required: false}';
        $data['password']['validate']['rules'] = '{required: false}';
        return $data;
    }
    
    /**
     *
     * 列表静态操作方法
     * @param primary_key $id
     */
    public function handle()
    {
        $template  = '<div style="width:150px;text-align:left;">{update}{delete} </div> ';
        $template .= '<div style="width:150px;text-align:left;">{add}{fendian}</div> ';
        $buttons = array(
            'class' => 'CButtonColumn',
            'header' => '操作',
            'headerHtmlOptions' => array('width' => '160'),
            'template' => $template,
            
            'updateButtonImageUrl' => FALSE,
            'deleteButtonImageUrl' => FALSE,            
            'updateButtonLabel'    => '<i class="fa fa-edit"></i> 修 改 &nbsp;',
            'deleteButtonLabel' => '<i class="fa fa-trash-o"></i> 删 除 &nbsp;',
            'updateButtonOptions' => array('class' => 'btn btn-primary btn-xs'),
            'deleteButtonOptions' => array('class' => 'btn btn-dark btn-xs'),
            'deleteConfirmation' => '确定删除？',
            'updateButtonUrl' => 'Yii::app()->controller->createUrl("edit", array($data->primaryKey() => $data->getPrimaryKey()))',
            'deleteButtonUrl' => 'Yii::app()->controller->createUrl("delete", array($data->primaryKey() => $data->getPrimaryKey()))',
            'buttons' => array(
                'add' => array(
                    'label' => '增加分店',
                    'url'   => 'Yii::app()->controller->createUrl("shop/add", array("parent_id"=>$data->getPrimaryKey()))',
                    'options' => array('class' => 'btn btn-success btn-xs'),
                    'visible' => '$data->parent_id == 0 ? TRUE : FALSE'
                  ),
                'fendian' => array(
                    'label' => '分店列表',
                    'url'   => 'Yii::app()->controller->createUrl("shop/list", array("parent_id"=>$data->getPrimaryKey()))',
                    'options' => array('class' => 'btn btn-info btn-xs'),
                    'visible' => '$data->parent_id == 0 ? TRUE : FALSE'
                  ),
            ), 
        );
        return $buttons;
    }
    
    public function getAreas($state = '', $city = '', $district='', $region='')
    {
        $areasData = array();
        $areas = Area::model()->findAllByAttributes(array('grade' =>  1));
        $areasData[] = CMap::mergeArray(array('0' => ''), CHtml::listData($areas, 'area_id', 'name'));

        if ($state)
        {
            foreach (array('state', 'city', 'district') as $area)
            {
                $areas = Area::model()->findAllByAttributes(array('parent_id' => $$area));
                $areasData[] = CMap::mergeArray(array('0' => ''), CHtml::listData($areas, 'area_id', 'name'));
            }
        } 
        else 
        {
            $areasData = CMap::mergeArray($areasData, array(array('0' => ''), array('0' => ''), array('0' => '')));
        }

        return $areasData;
    }
    
    public static function parentName($col, $data)
    {
        return Shop::model()->findByPk($data->$col)->name;
    }
    
}
