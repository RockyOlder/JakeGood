<?php

/**
 * This is the model class for table "shipping".
 *
 * The followings are the available columns in table 'shipping':
 * @property integer $ship_id
 * @property string $order_id
 * @property string $ship_sn
 * @property string $type
 * @property integer $status
 * @property string $receiver_address
 * @property string $create_time
 * @property string $update_time
 */
class OrderShip extends IActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Shipping the static model class
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
		return 'order_ship';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('status', 'numerical', 'integerOnly'=>true),
			array('order_id', 'length', 'max'=>20),
			array('type', 'length', 'max'=> 20),
			array('create_time, update_time', 'length', 'max'=>10),
			array('receiver_address', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ship_id, order_id, ship_sn, type, status, receiver_address, create_time, update_time', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ship_id' => 'Ship',
			'order_id' => 'Order',
			'ship_sn' => 'Ship Sn',
			'type' => 'Type',
			'status' => 'Status',
			'receiver_address' => 'Receiver Address',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
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

		$criteria->compare('ship_id',$this->ship_id);
		$criteria->compare('order_id',$this->order_id,true);
		$criteria->compare('ship_sn',$this->ship_sn,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('receiver_address',$this->receiver_address,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}