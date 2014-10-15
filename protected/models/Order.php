<?php

/**
 * This is the model class for table "order".
 *
 * The followings are the available columns in table 'order':
 * @property string $order_id
 * @property string $user_id
 * @property integer $status
 * @property integer $pay_status
 * @property integer $ship_status
 * @property integer $refund_status
 * @property string $total_fee
 * @property string $ship_fee
 * @property string $pay_fee
 * @property string $ship_method
 * @property string $receiver_name
 * @property string $receiver_country
 * @property string $receiver_state
 * @property string $receiver_city
 * @property string $receiver_district
 * @property string $receiver_address
 * @property string $receiver_zip
 * @property string $receiver_mobile
 * @property string $receiver_phone
 * @property string $memo
 * @property string $pay_time
 * @property string $ship_time
 * @property string $create_time
 * @property string $update_time
 */
class Order extends IActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Order the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'orders';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('market_id, store_id, status, refund_status', 'numerical', 'integerOnly' => true),
            array('order_id', 'length', 'max' => 20),
            array('user_id, ship_fee, pay_fee, pay_time, ship_time, created, updated', 'length', 'max' => 10),
            array('receiver_name, receiver_country, receiver_state, receiver_city, receiver_district, receiver_zip, receiver_mobile, receiver_phone', 'length', 'max' => 45),
            array('receiver_address', 'length', 'max' => 255),
            array('order_id, user_id, market_id, store_id, status, refund_status, '
                . 'item_total, ship_fee, amount, pay_fee, receiver_name, receiver_country, '
                . 'receiver_state, receiver_city, receiver_district, receiver_address, receiver_zip, receiver_mobile, '
                . 'receiver_phone, memo, pay_time, ship_time, created, updated', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('order_id, user_id, market_id, store_id, status, refund_status, '
                . 'ship_fee, pay_fee, receiver_name, receiver_country, '
                . 'receiver_state, receiver_city, receiver_district, receiver_address, receiver_zip, receiver_mobile, '
                . 'receiver_phone, memo, pay_time, ship_time, created, updated', 'safe', 'on' => 'search'),
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
            'OrderItem' => array(self::HAS_MANY, 'OrderItem', 'order_id'),
            'Refund'    => array(self::HAS_MANY, 'Refund', 'order_id'),
            'User'      => array(self::BELONGS_TO, 'User', 'user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'order_id' => '订单号',
            'user_id' => '会员',
            'status' => '订单状态',
            'ship_status' => '配送状态',
            'refund_status' => '退款状态',
            'total' => '商品总金额',
            'ship_fee' => '运费',
            'pay_fee' => '实付款',
            'receiver_name' => '收货人',
            'receiver_country' => '国家',
            'receiver_state' => '省',
            'receiver_city' => '市',
            'receiver_district' => '区',
            'receiver_address' => '详细地址',
            'receiver_zip' => '邮政编码',
            'receiver_mobile' => '手机',
            'receiver_phone' => '电话',
            'memo' => '备注',
            'pay_time' => '付款时间',
            'ship_time' => '发货时间',
            'created' => '下单时间',
            'updated' => '更新时间',
        );
    }

    /**
     * 	订单状态集
     */
    public static function statusOptions($status = NULL)
    {
        $list = array(
            0 => '异常订单',
            1 => '等待买家付款',
            2 => '买家已付款',
            3 => '卖家已发货',
            4 => '交易完成',
            5 => '交易关闭',
            6 => '退款中',
            7 => '定金已付'
        );
        return $status === NULL ? $list : $list[$status];
    }

    /**
     * 	订单状态集
     */
    public static function refundStatus($status = NULL)
    {
        $list = array(
            1 => '退款申请',
            2 => '卖家不同意退款, 等待买家修改',
            3 => '退款协议达成，等待（买家退货/卖家退款）',
            4 => '买家已退货, 等待卖家收货',
            5 => '退款关闭',
            6 => '退款成功',
        );
        return $status === NULL ? $list : $list[$status];
    }
    
    function beforeSave()
    {
        if ($this->getIsNewRecord())
        {
            /**
             * SN 生成
             */
            $this->sn = date('ymd').substr(time(),-5).substr(microtime(),2,5).sprintf('%02d',rand(0,99));
        }
        
        return parent::beforeSave();
    }
}
