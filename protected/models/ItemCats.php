<?php

class ItemCats extends IActiveRecord {

    public $subs = array();
    public $recommends = array();
    public $css = '';
    
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'item_cats';
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return item cats the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'items' => array(self::HAS_MANY, 'Item', 'cid'),
            'itemProps' => array(self::HAS_MANY, 'ItemProp', 'cid'),
        );
    }

    public static function queryCats($parentCid = 0, $subs = 9)
    {
        $criteria = new CDbCriteria;
        $criteria->condition = 'parent_cid=:parent_cid AND status=1';
        $criteria->params = array(':parent_cid' => $parentCid);
        $criteria->order = 'sort_order asc';
        
        $models = ItemCats::model()->findAll($criteria);
        
        $cats = array();
        if ($models)
        {
            foreach ($models as $k => $cat)
            {
                $cats[$cat->cid] = $cat;
                if ($subs > 0)
                {
                    $sub = self::queryCats($cat->cid, $subs-1);
                    $cats[$cat->cid]->subs = $sub;
                }
            }
        }
        return $cats;
    }

    public function createCommand()
    {
        return $this->getDbConnection()->createCommand()->from($this->tableName());
    }

    public function queryParents($cid)
    {
        $arr = array();
        $model = ItemCats::model()->findByPk($cid);
        if ($model)
        {
            $attrs = $model->getAttributes();
            $arr[] = $attrs;
            if ($attrs['parent_cid'] > 0)
            {
                $arr = array_merge($arr, $this->queryParents($attrs['parent_cid']));
            }
        }
        return $arr;
    }

    function queryListData($cid=0)
    {
        $condition =  $cid > 0 ? 'cid='.$cid : 'parent_cid='.$cid .' AND status = 1';
        $models = self::model()->findAll(array('condition' => $condition, 'order' => 'sort_order asc'));
        
        $data = array('' => '请选择...');
        foreach ($models as $v)
        {
            $list = self::model()->findAll(array('condition' => 'parent_cid='.$v->cid, 'order' => 'sort_order asc'));
            if ($list)
            {
                $data[$v->name] = CHtml::listData($list, 'cid', 'name');
            }
            else
            {
                $data[$v->cid] = $v->name;
            }
        }
        return $data;
    }
}
