<?php

class Props extends IActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{props}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name', 'required'),
            array('sort_order', 'numerical', 'integerOnly' => true),
            array('parent_pid', 'length', 'max' => 10),
            array('name', 'length', 'max' => 100),
            array('status', 'length', 'max' => 7),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('pid, parent_vid, name, sort_order', 'safe', 'on' => 'search'),
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
           // 'itemCats' => array(self::BELONGS_TO, 'ItemCats', 'cid'),
            'propValues' => array(self::HAS_MANY, 'PropValues', 'pid', 'order' => 'propValues.sort_order asc'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'pid' => 'Item Prop',
            'parent_pid' => 'Parent Prop',
            'name' => 'Prop Name',
            'alias' => 'Prop Alias',
            'must' => 'Must',
            'multi' => 'Multi',
            'status' => 'Status',
            'sort_order' => 'Sort Order',
            'item_propcol' => 'Item Propcol',
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

        $criteria->compare('pid', $this->pid, true);
        $criteria->compare('parent_pid', $this->parent_pid, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('alias', $this->alias, true);
        $criteria->compare('is_key_prop', $this->is_key_prop);
        $criteria->compare('is_sale_prop', $this->is_sale_prop);
        $criteria->compare('is_color_prop', $this->is_color_prop);
        $criteria->compare('must', $this->must);
        $criteria->compare('multi', $this->multi);
        $criteria->compare('status', $this->status, true);
        $criteria->compare('sort_order', $this->sort_order);
        $criteria->compare('item_propcol', $this->item_propcol, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ItemProp the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function defaultScope()
    {
        return array(
            'condition' => 't.`status` = 1',
            'order' => 't.`sort_order` asc'
        );
    }

    /**
     * get attribute value for display
     * @param string $name
     * @param array $parameters
     * @return array|mixed
     */
    public function __call($name, $parameters)
    {
        $prefix = substr($name, 0, 2);
        if ($prefix === 'is') {
            $key = strtolower(substr($name, 2));
            if (in_array($key, array('key', 'sale', 'color'))) {
                return $this->{'is_' . $key . '_prop'};
            }
            if (in_array($key, array('must', 'multi'))) {
                return $this->{$key};
            }
        }
        $prefix = substr($name, 0, 3);
        if ($prefix === 'all') {
            $key = strtolower(substr($name, 3));
            switch ($key) {
                case 'status':
                    return array(1 => 'normal', 0 => 'delete');
                default:
                    if (in_array($key, array('key', 'sale', 'color', 'must', 'multi'))) {
                        return array(0 => 'No', 1 => 'Yes');
                    }
            }
        }
        if ($prefix === 'get') {
            $key = strtolower(substr($name, 3));
            switch ($key) {
                case 'status':
                    $data = array(1 => 'normal', 0 => 'delete');
                    break;
                default:
                    if (in_array($key, array('key', 'sale', 'color', 'must', 'multi'))) {
                        $data = array(0 => 'No', 1 => 'Yes');
                    }
                    if (in_array($key, array('key', 'sale', 'color'))) {
                        $key = 'is_' . $key . '_prop';
                    }
                    break;
            }
            if (isset($data[$this->$key]))
                return $data[$this->$key];
        }
        return parent::__call($name, $parameters);
    }

    /**
     * get itemCats list data
     * @param int $root
     * @return mixed
     */
    public function getItemCats($root = 3)
    {
        return ItemCats::model()->getSelectOptions($root);
    }

    public function getPropValues()
    {
        $cri = new CDbCriteria(array(
            'condition' => 'pid =' . $this->pid,
            'order' => 'sort_order asc, vid asc'
        ));
        $PropValues = PropValue::model()->findAll($cri);

        foreach ($PropValues as $sv) {
            echo $sv->name . ',';
        }
    }

    public function getPropOptionValues($label = '', $selected = '')
    {
        $cri = new CDbCriteria(array(
            'condition' => 'pid =' . $this->pid,
            'order' => 'sort_order asc, vid asc'
        ));
        $PropValues = PropValue::model()->findAll($cri);
        $list = CHtml::listData($PropValues, 'vid', 'name');
        $data = array();
        foreach ($list as $k => $v) {
            $data[$this->pid . ':' . $k] = $v;
        }
        echo CHtml::DropDownList('Item[props][' . $this->pid . ']', $selected, $data, array('empty' => '请选择', 'label' => $label));
    }

    public function getPropTextFieldValues($label = '', $value = '')
    {
        echo CHtml::textField('Item[props][' . $this->pid . ']', $value, array('label' => $label));
    }

    public function getPropArrayValues()
    {
        $cri = new CDbCriteria(array(
            'condition' => 'pid =' . $this->pid,
            'order' => 'sort_order asc, vid asc'
        ));
        $PropValues = PropValue::model()->findAll($cri);
        foreach ($PropValues as $sv) {
            $array[] = $sv->name;
        }
        return $array;
    }

    public function getPropCheckBoxListValues($label = '', $selected = '', $class = '', $type = 'props', $child_type = '')
    {
        $cri = new CDbCriteria(array(
            'condition' => 'pid =' . $this->pid,
            'order' => 'sort_order asc, vid asc'
        ));
        $PropValues = PropValue::model()->findAll($cri);

        $list = CHtml::listData($PropValues, 'vid', 'name');
        foreach ($list as $k => $v) {
            $data[$this->pid . ':' . $k] = $v;
        }
        echo '<ul class="sku-list">';
        if ($child_type) {
            echo CHtml::checkBoxList('Item[' . $type . '][' . $child_type . '][' . $this->pid . ']', $selected, $data,
                array('template' => '<label class="checkbox inline">{input}{label}</label>', 'label' => $label, 'separator' => '', 'class' => $class, 'labelOptions' => array('class' => 'labelForRadio')));
        } else {
            echo CHtml::checkBoxList('Item[' . $type . '][' . $this->pid . ']', $selected, $data,
                array('template' => '<label class="checkbox inline">{input}{label}</label>', 'label' => $label, 'separator' => '', 'class' => $class, 'labelOptions' => array('class' => 'labelForRadio')));
        }
        echo '</ul>';
    }
}
