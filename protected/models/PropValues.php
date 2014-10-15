<?php

class PropValues extends IActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'prop_values';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('pid, name, alias, status', 'required'),
            array('status, sort_order', 'numerical', 'integerOnly'=>true),
            array('pid', 'length', 'max'=>10),
            array('name, alias', 'length', 'max'=>45),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('vid, pid, name, alias, status, sort_order', 'safe', 'on'=>'search'),
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
            'props' => array(self::BELONGS_TO, 'Props', 'pid'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'vid' => 'Prop Value',
            'pid' => 'Item Prop',
            'name' => 'Value Name',
            'alias' => 'Value Alias',
            'status' => 'Status',
            'sort_order' => 'Sort Order',
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

        $criteria=new CDbCriteria;

        $criteria->compare('vid',$this->vid,true);
        $criteria->compare('pid',$this->pid,true);
        $criteria->compare('name',$this->name,true);
        $criteria->compare('alias',$this->alias,true);
        $criteria->compare('status',$this->status);
        $criteria->compare('sort_order',$this->sort_order);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return PropValue the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}