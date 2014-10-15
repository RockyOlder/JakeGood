<?php

/**
 * This is the model class for table "{{wishlist}}".
 *
 * The followings are the available columns in table '{{wishlist}}':
 * @property string $wishlist_id
 * @property string $user_id
 * @property string $item_id
 * @property string $desc
 * @property string $create_time
 */
class DpItems extends IActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Wishlist the static model class
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
		return '{{dp_items}}';
	}

}