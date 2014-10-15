<?php

/**
 * This is the model class for table "{{address_book}}".
 *
 * The followings are the available columns in table '{{address_book}}':
 * @property string $id
 * @property string $user_id
 * @property string $name
 * @property string $country
 * @property string $state
 * @property string $city
 * @property string $district
 * @property string $zipcode
 * @property string $address
 * @property string $phone
 * @property string $mobile
 * @property string $memo
 * @property integer $default
 * @property string $create_time
 * @property string $update_time
 */
class AddressBook extends IActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return AddressResult the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{address_book}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, name, state, city, district, zipcode, address, mobile, area', 'required'),
            array('default', 'numerical', 'integerOnly' => true),
            array('country, state, city, district,', 'length', 'max' => 11),
            array('name, zipcode, phone, mobile, company', 'length', 'max' => 20),
            array('address', 'length', 'max' => 200),
            array('memo', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('contact_id, user_id, name, country, state, city, district, zipcode, area, address, phone, mobile, company, memo, default, create_time, update_time', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'd' => array(self::BELONGS_TO, 'Area', 'district'),
            'c' => array(self::BELONGS_TO, 'Area', 'city'),
            's' => array(self::BELONGS_TO, 'Area', 'state'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'contact_id' => 'ID',
            'user_id' => '会员',
            'name' => '收货人姓名',
            'country' => '国家',
            'state' => '省',
            's.name'=>'省',
            'city' => '市',
            'c.name'=>'市',
            'district' => '区',
            'd.name'=>'区',
            'zipcode' => '邮政编号',
            'address' => '详细地址',
            'phone' => '电话',
            'mobile' => '手机',
            'memo' => '备注',
            'default' => '默认',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('contact_id', $this->contact_id, true);
        $criteria->compare('user_id', $this->user_id, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('country', $this->country, true);
        $criteria->compare('state', $this->state, true);
        $criteria->compare('city', $this->city, true);
        $criteria->compare('district', $this->district, true);
        $criteria->compare('zipcode', $this->zipcode, true);
        $criteria->compare('address', $this->address, true);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('mobile', $this->mobile, true);
        $criteria->compare('memo', $this->memo, true);
        $criteria->compare('default', $this->default);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('update_time', $this->update_time, true);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }
    
    public function getDefault() {
        echo $this->default == 1 ? CHtml::image(Yii::app()->request->baseUrl.'/images/yes.gif') : CHtml::image(Yii::app()->request->baseUrl.'/images/no.gif');
    }

    public function beforeSave() {
        if (parent::beforeSave()) {
            if ($this->isNewRecord) {
                $this->create_time = $this->update_time = time();
            }
            else
                $this->update_time = time();
            return true;
        }
        else
            return false;
    }

    public function getAreas()
    {
        $areasData = array();
        $areas = Area::model()->findAllByAttributes(array('grade' =>  1));
        $areasData[] = CMap::mergeArray(array('0' => ''), CHtml::listData($areas, 'area_id', 'name'));
        if (!$this->isNewRecord) {
            foreach (array('state', 'city') as $area) {
                $areas = Area::model()->findAllByAttributes(array('parent_id' => $this->{$area}));
                $areasData[] = CMap::mergeArray(array('0' => ''), CHtml::listData($areas, 'area_id', 'name'));
            }
        } else {
            $areasData = CMap::mergeArray($areasData, array(array('0' => ''),array('0' => '')));
        }

        return $areasData;
    }
}