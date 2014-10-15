<?php

class ShopController extends CurdController {

    public $model = 'Shop';
    public function init()
    {
        parent::init();
        $this->title = '分店管理';
    }
    
    function list_columns($col)
    {
        $data = parent::list_columns($col);
        
        $data['cid']['func']       = 'catName';
        $data['district']['func']  = 'areaName';
        $data['region']['func']    = 'areaName';
        $data['created']['func']   = 'dateFormat';
        $data['status']['func']    = 'toggle';
        
        $cats = ItemCats::model()->findAll('parent_cid=0');
        $data['cid']['filter'] = CHtml::listData($cats, 'cid', 'name');        
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
        return new CActiveDataProvider($this->data['model'], array(
            'criteria' => $this->data['criteria'],
            'pagination' => array('pageSize' => 20),
        ));
    }
    
    public function actionAdd()
    {
        $this->title = '添加分店';
        
        $this->data['model']->cid = $this->store->cid;
        $this->data['model']->state     = $this->store->state;
        $this->data['model']->city      = $this->store->city;
        
        parent::actionAdd();    
    }

    public function actionSave($ret = FALSE)
    {
        $data = $this->request->getPost($this->model);
        
        $_POST[$this->model]['market_id'] = $this->store->market_id;
        $_POST[$this->model]['store_id'] = $this->store->store_id;
        
        if (trim($data['password']) != '')
        {
            $_POST[$this->model]['password'] = md5('eeee'.trim($data['password']).'hhhh');
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
        
        $cats = ItemCats::model()->findAll('parent_cid=0');
        $cats = CHtml::listData($cats, 'cid', 'name');
        
        $areas   = $this->getAreas($this->data['model']->state, $this->data['model']->city, $this->data['model']->district, $this->data['model']->region);
        $areaUrl = Yii::app()->createUrl('seller/area/getChild');
        
        $data['cid']['field']      = CHtml::activeDropDownList($this->data['model'], 'cid', $cats, array('class' => 'form-control'));
        
        $data['status']['field']   = CHtml::activeDropDownList($this->data['model'], 'status', array('Close', 'Open'), array('class' => 'form-control'));
        
        $state  = CHtml::activeHiddenField($this->data['model'], 'state');
        $city   = CHtml::activeHiddenField($this->data['model'], 'city');
        $dist   = CHtml::activeDropDownList($this->data['model'], 'district', $areas[2], array('class' => 'form-control area area-district', 'data-child-area' => 'area-region', 'data-url' => $areaUrl));
        $region = CHtml::activeDropDownList($this->data['model'], 'region', $areas[3], array('class' => 'form-control area-region'));
        
        $data['region']['field']  = $state.$city;
        $data['region']['field'] .= '<div class="col-lg-4">'.$dist.'</div>';
        $data['region']['field'] .= '<div class="col-lg-6">'.$region.'</div>';
        
        unset($data['state']);
        unset($data['city']);
        unset($data['district']);
        
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
        
        $cats = ItemCats::model()->findAll('parent_cid=0');
        $cats = CHtml::listData($cats, 'cid', 'name');
        $areas   = $this->getAreas($model->state, $model->city, $model->district, $model->region);
        $areaUrl = Yii::app()->createUrl('seller/area/getChild');
        $model->password = '';
        
        $data['cid']['field']      = CHtml::activeDropDownList($model, 'cid', $cats, array('class' => 'form-control'));
        $data['status']['field']   = CHtml::activeDropDownList($model, 'status', array('Close', 'Open'), array('class' => 'form-control'));
        $data['password']['field']   = CHtml::activeTextField($model, 'password', array('class' => 'form-control'));
        
        $state  = CHtml::activeHiddenField($model, 'state');
        $city   = CHtml::activeHiddenField($model, 'city');
        $dist   = CHtml::activeDropDownList($model, 'district', $areas[2], array('class' => 'form-control area area-district', 'data-child-area' => 'area-region', 'data-url' => $areaUrl));
        $region = CHtml::activeDropDownList($model, 'region', $areas[3], array('class' => 'form-control area-region'));
        
        $data['region']['field']  = $state.$city;
        $data['region']['field'] .= '<div class="col-lg-4">'.$dist.'</div>';
        $data['region']['field'] .= '<div class="col-lg-6">'.$region.'</div>';
        
        unset($data['state']);
        unset($data['city']);
        unset($data['district']);
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
