<?php


class VisitStatistics extends IActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'visit_statistics';
    }
    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ItemImg the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

} 