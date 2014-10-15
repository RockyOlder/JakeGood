<?php

/**
 * This is the model class for table "item_img".
 *
 * The followings are the available columns in table 'item_img':
 * @property string $item_img_id
 * @property string $item_id
 * @property string $url
 * @property integer $position
 * @property string $create_time
 *
 * The followings are the available model relations:
 * @property Item $item
 */
class ItemImg extends IActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'item_img';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that 
        // will receive user inputs. 
        return array(
            array('item_id, url, position', 'required'),
            array('position', 'numerical', 'integerOnly' => true),
            array('item_id', 'length', 'max' => 10),
            array('url', 'length', 'max' => 255),
            array('item_img_id, item_id, url, position', 'safe', 'on' => 'search'),
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
            'item' => array(self::BELONGS_TO, 'Item', 'item_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'item_img_id' => 'Item Img',
            'item_id' => 'Item',
            'url' => 'url',
            'position' => 'Position',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Tyurlal usecase:
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

        $criteria->compare('item_img_id', $this->item_img_id, true);
        $criteria->compare('item_id', $this->item_id, true);
        $criteria->compare('url', $this->url, true);
        $criteria->compare('position', $this->position);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ItemImg the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}
