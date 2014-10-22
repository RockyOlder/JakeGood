<?php

/**
 * This is the model class for table "item".
 *
 * The followings are the available columns in table 'item':
 * @property string $item_id
 * @property string $cid
 * @property string $outer_id
 * @property string $title
 * @property string $num
 * @property string $price
 * @property string $props
 * @property string $sku_map
 * @property string $desc
 * @property string $express_fee
 * @property integer $is_show
 * @property integer $is_showcase
 * @property string $create_time
 * @property string $update_time
 * @property string $state
 * @property string $city
 *
 * The followings are the available model relations:
 * @property ItemCats $itemCats
 * @property Area $stateArea
 * @property Area $cityArea
 * @property ItemImg[] $itemImgs
 * @property OrderItem[] $orderItems
 * @property PropImg[] $propImgs
 * @property Sku[] $skus
 */
class Item extends IActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'items';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('cid, market_id, store_id, name, title, num, price ', 'required'),
            array('is_show, is_showcase', 'numerical', 'integerOnly' => true),
            array('cid, num, price, orig_price, create_time, update_time ', 'length', 'max' => 10),
            array('name', 'length', 'max' => 50),
            array('title', 'length', 'max' => 200),
            array('parent_cid, outer_id, props, pic_url, list_time, delist_time,desc, 
				is_virtual, locality_life, expiry_date, is_show, is_showcase, 
				create_time, update_time, sort_order, regions, commission, notice, tips', 'safe')
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'itemCats' => array(self::BELONGS_TO, 'ItemCats', 'cid'),
            'ItemImgs' => array(self::HAS_MANY, 'ItemImg', 'item_id'),
            'OrderItem' => array(self::HAS_MANY, 'OrderItem', 'item_id'),
            'propImgs' => array(self::HAS_MANY, 'PropImg', 'item_id'),
            'ItemShop' => array(self::HAS_MANY, 'ItemShop', 'item_id'),
            'ItemSpec' => array(self::HAS_MANY, 'ItemSpec', 'item_id'),
            'Counter' => array(self::HAS_ONE, 'ItemCounter', 'item_id'),
            'Wishlist' => array(self::HAS_MANY, 'Wishlist', 'item_id'),
            'ItemRate' => array(self::HAS_MANY, 'ItemRate', 'item_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'item_id' => 'Item',
            'cid' => '类目',
            'market_id' => '商城',
            'outer_id' => '商家编码',
            'name ' => '名称',
            'title' => '标题',
            'num' => '数量',
            'price' => '团购价',
            'orig_price' => '门店价',
            'props' => '宝贝属性',
            'prop_imgs' => '属性图片',
            'desc' => '宝贝描述',
            'is_show' => '是否上架',
            'is_showcase' => '橱窗推荐',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
            'locality_life' => '本地生活',
            'expirydate' => '有效期',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('store_id', Yii::app()->user->getId(), true);
        $criteria->compare('item_id', $this->item_id, true);
        $criteria->compare('cid', $this->cid, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('num', $this->num, true);
        $criteria->compare('price', $this->price, true);
        $criteria->compare('props', $this->props, true);
        $criteria->compare('sku_map', $this->sku_map, true);
        $criteria->compare('desc', $this->desc, true);
        $criteria->compare('is_show', $this->is_show);
        $criteria->compare('is_showcase', $this->is_showcase);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('update_time', $this->update_time, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array('pageSize' => 10),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Item the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @param string $name
     * @param array $parameters
     * @return array|mixed
     */
    public function __call($name, $parameters)
    {
        $prefix = substr($name, 0, 2);
        if ($prefix === 'is') {
            $key = strtolower(substr($name, 2));
            if (in_array($key, array('show', 'showcase'))) {
                return $this->{'is_' . $key};
            }
        }
        $prefix = substr($name, 0, 3);
        if ($prefix === 'all') {
            $key = strtolower(substr($name, 3));
            if (in_array($key, array('show', 'showcase'))) {
                return array(0 => 'No', 1 => 'Yes');
            }
        }
        return parent::__call($name, $parameters);
    }

    public function beforeSave()
    {
        if ($this->isNewRecord)
        {
            $this->create_time = $this->update_time = time();
        }
        else
        {
            $this->update_time = time();
            ItemImg::model()->deleteAllByAttributes(array('item_id' => $this->item_id));
            ItemShop::model()->deleteAllByAttributes(array('item_id' => $this->item_id));
        }
        return parent::beforeSave();
    }

    /**
     * 得到商品URL地址
     * @return string the URL that shows the detail of the item
     */
    public function getUrl()
    {
        if (F::utf8_str($this->title) == '1') {
            $title = str_replace('/', '-', $this->title);
        } else {
            $pinyin = new Pinyin($this->title);
            $title = $pinyin->full2();
            $title = str_replace('/', '-', $title);
        }
        return Yii::app()->createUrl('item/view', array(
            'id' => $this->item_id,
            'title' => $title,
        ));
    }

    /**
     * @return string
     */
    public function getBtnList()
    {
        return CHtml::textField('qty', $this->min_number, array('style' => 'width:20px', 'size' => '2', 'maxlength' => '5', 'id' => 'qty_' . $this->item_id)) . '&nbsp;'
        . CHtml::link(CHtml::image(Yii::app()->request->baseUrl . '/images/btn_buy.gif'), '#', array('id' => 'btn-buy-' . $this->item_id, 'onclick' => 'fastBuy(this, ' . $this->item_id . ', $("#qty_' . $this->item_id . '").val())'
        ))
        . '&nbsp;' . CHtml::link(CHtml::image(Yii::app()->request->baseUrl . '/images/btn_addwish.gif'), '#', array('id' => 'btn-addwish-' . $this->item_id, 'onclick' => 'addWish(this, ' . $this->item_id . ')'
        ));
    }

    /**
     * get item image gallery
     * @return array
     */
    public function getItemGallery()
    {
        $images = ItemImg::model()->findAllByAttributes(array('item_id' => $this->item_id));
        foreach ($images as $k => $v)
        {
            $imageList[] = $v['url'];
        }
        return $imageList;
    }

    /**
     * 分类属性
     *
     * @param int $id 分类ID
     * @param boolean $returnAttr false则返回分类列表，true则返回该对象的分类值
     * @param string $index 结合$returnAttr使用。如果$returnAttr为true，
     *              若指定$index，则返回指定$index对应的值，否则返回当前对象对应的分类值
     * @param int $level 层级
     * @return mixed
     */
    public function attrItemCats($id, $returnAttr = false, $index = null, $level = 1)
    {
        $data = array();
        $itemCats = ItemCats::model()->findByPk($id);
        $descendants = $itemCats->descendants()->findAll();
        $data = ItemCats::model()->getSelectOptions($descendants);
        if ($returnAttr && $index && isset($data[$index]))
            $data = $data[$index];
        return $data;
    }

    public function afterSave()
    {
        parent::afterSave();
    }

}