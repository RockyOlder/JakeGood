<?php

/**
 * This is the model class for table "order_item".
 *
 * The followings are the available columns in table 'order_item':
 * @property integer $id
 * @property integer $category_id
 * @property string $order_id
 * @property string $item_id
 * @property string $title
 * @property string $sn
 * @property string $price
 * @property integer $num
 * @property string $total
 * @property string $pic
 * @property string $props_name
 */
class OrderItem extends IActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OrderItem the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'order_item';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('order_id, item_id', 'required'),
			array('quantity', 'numerical', 'integerOnly'=>true),
			array('title, pic', 'length', 'max'=>255),
			array('props_name, price, ship_fee, total, created', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, order_id, item_id, title, price, num, total, pic, props_name', 'safe', 'on'=>'search'),
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
			'Order'  => array(self::BELONGS_TO, 'Order', 'order_id'),
			'Item'   => array(self::BELONGS_TO, 'Item', 'item_id'),
			'Refund' => array(self::HAS_ONE, 'Refund', 'order_item_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'order_id' => 'Order',
			'item_id' => 'Item',
			'title' => 'Title',
			'sn' => 'Sn',
			'price' => 'Price',
			'num' => 'Num',
			'total' => 'Amount',
			'pic' => 'Pic Url',
			'props_name' => 'Props Name',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('category_id',$this->category_id);
		$criteria->compare('order_id',$this->order_id,true);
		$criteria->compare('item_id',$this->item_id,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('sn',$this->sn,true);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('num',$this->num);
		$criteria->compare('total',$this->total,true);
		$criteria->compare('pic',$this->pic,true);
		$criteria->compare('props_name',$this->props_name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}