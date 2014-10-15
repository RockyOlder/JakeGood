<?php

/**
 * 地址薄
 *
 */
class AddressBookController extends SellerController {


    public function init()
    {
        parent::init();
        $this->title = '地址薄';
    }

    
    public function actionIndex()
    {
        $this->template = 'index';
        
        $id = $this->request->getQuery('id');
        
        $model = AddressBook::model()->findByAttributes(array('id' => $id, 'user_id' => Yii::app()->user->getId()));
        if ( ! $model) $model = new AddressBook();
        
        $addresses = AddressBook::model()->findAll('user_id = :user_id', array(':user_id' => Yii::app()->user->getId()));
        $this->data['addresses'] = $addresses;
        $this->data['model'] = $model;
    }
    public function actionSave()
    {
        $data = $this->request->getPost('AddressBook');
        $model = AddressBook::model()->findByAttributes(array('id' => $data['id'], 'user_id' => Yii::app()->user->getId()));
        if ( ! $model) $model = new AddressBook();
        
        $attributes = $data;
        $area = array($attributes['state'], $attributes['city'], $attributes['district']);
        $area = Area::model()->findAllByAttributes(array('area_id' => $area));
        $attributes['user_id'] = Yii::app()->user->getId();
        $attributes['country'] = 1;
        $attributes['area'] = $area[0]->name . $area[1]->name . $area[2]->name;
        
        $count = AddressBook::model()->count('id<>:id AND user_id=:user_id AND `default`=1', array(':user_id' => Yii::app()->user->getId(), ':id' => $attributes['id']));
        if ($count == 0)
        {
            $attributes['default'] = 1;
        }
        elseif ($attributes['default'] == 1)
        {
            AddressBook::model()->updateAll(array('default' => 0), 'user_id=:user_id', array(':user_id' => Yii::app()->user->getId()));
        }

        $model->attributes = $attributes;

        if ($model->save())
        {
            $this->redirect($this->createUrl('index', array('suc' => 'true')));
        }
        else
        {
            parent::renderError('保存出错');
        }
    }

    public function actionDelete()
    {
        $id = $this->request->getQuery('id');
        $model = AddressBook::model()->findByAttributes(array('id' => $id, 'user_id' => Yii::app()->user->getId()));
        if ($model)
        {
            if ($model->default == 1)
            {
                $first = AddressBook::model()->find('user_id=:user_id AND `default`=0', array(':user_id' => Yii::app()->user->getId()));
                if ($first)
                {
                    $first->default = 1;
                    $first->update();
                }
            }
            $model->delete();
        }
        $this->redirect($this->createUrl('index'));
    }

}
