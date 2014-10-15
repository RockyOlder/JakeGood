<?php

class Refund extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Refund the static model class
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
		return 'refund';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('refund_sn', 'length', 'max'=>45),
			array('money, order_id', 'length', 'max'=>20),
			array('user_id, created', 'length', 'max'=>10),
			array('status', 'length', 'max'=>8),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('refund_id, refund_sn, money, order_id, user_id, status, created', 'safe', 'on'=>'search'),
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
            'Order' => array(self::BELONGS_TO, 'Order', 'order_id'),
            'OrderItem' => array(self::BELONGS_TO, 'OrderItem', 'order_item_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'refund_id' => 'Refund',
			'refund_sn' => 'Refund Sn',
			'money' => 'Money',
			'order_id' => 'Order',
			'user_id' => 'User',
			'status' => 'Status',
			'create_time' => 'Create Time',
		);
	}

	public function typeOptions()
	{
		$options = array(
				1 => '卖家未发货, 全额退款',
				2 => '卖家已发货,买家未收到货,全额退款',
				3 => '已收货, 部分退款',
				4 => '已收货, 全额退款',
			);
		return (! $this->type) ? $options : $options[$this->type];
	}

	public function statusOptions()
	{
		$options = array(
				1 => '退款申请,等待卖家确认',
				2 => '卖家不同意退款, 等待买家修改',
				3 => '退款达成等待买家退货',
				4 => '买家已退货, 等待卖家收货',
				5 => '退款关闭',
				6 => '退款成功',
			);
		return (! $this->status) ? $options : $options[$this->status];
	}
}