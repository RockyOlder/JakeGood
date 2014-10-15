<?php

class IActiveRecord extends CActiveRecord
{
    //列名列表
    public function columnNames()
    {
        return $this->tableSchema->columnNames;
    }

    //该表的列元数据。每个数组元素都是一个CDbColumnSchema对象，以列名为索引。
    public function columns()
    {
        return $this->tableSchema->columns;
    }

    //表名
    public function name()
    {
        return $this->tableSchema->name;
    }

    //该表的外键。该数组以列名作为索引。每个值是一个外键表名和外键列名组成的数组。
    public function foreignKeys()
    {
        return $this->tableSchema->foreignKeys;
    }

    //该表的主键名
    public function primaryKey()
    {
        $primaryKey = $this->tableSchema->primaryKey;
        if (is_array($primaryKey))
            return array_shift($primaryKey);
        else
            return $primaryKey;
    }

    /**
     * rewrite set attributes, set relation data to relations, auto save at after save
     * @param array $values
     * @param bool $safeOnly

     */
    public function setAttributes($values, $safeOnly = true)
    {
        if (!is_array($values))
            return;
        foreach ($values as $name => $value) {
            if (is_array($value) && isset($this->getMetaData()->relations[$name])) {
                $this->$name = $value;
            }
        }
        return parent::setAttributes($values, $safeOnly);
    }

    public function getAttributeLabel($attribute)
    {
        $labels = $this->attributeLabels();

        if(isset($labels[$attribute]))
        {
            return $labels[$attribute];
        }
        elseif ($this->tableSchema->columns[$attribute]->comment != '')
        {
            return $this->tableSchema->columns[$attribute]->comment;
        }
        elseif(strpos($attribute,'.')!==false)
        {
            $segs  = explode('.',$attribute);
            $name  = array_pop($segs);
            $model = $this;
            foreach($segs as $seg)
            {
                $relations = $model->getMetaData()->relations;
                if(isset($relations[$seg]))
                    $model = CActiveRecord::model($relations[$seg]->className);
                else
                    break;
            }
            return $model->getAttributeLabel($name);
        }
        else return $this->generateAttributeLabel($attribute);
    }
    public function queryOptions($keyName, $valueName, $condition='', $params=array(), $order = '')
    {
        $rs = $this->dbConnection
                    ->createCommand()
                    ->select("{$keyName}, {$valueName}")
                    ->from($this->tableName())
                    ->where($condition, $params)
                    ->order($order)
                    ->queryAll();

        $data = array();
        foreach ($rs as $v)
        {
            $data[$v[$keyName]] = $v[$valueName];
        }
        return $data;
    }
    /**
     * rewrite save to add transaction
     * @param bool $runValidation
     * @param null $attributes
     * @return bool

     */
    public function save($runValidation = true, $attributes = null)
    {
        //事务处理，如果已经开启事务，则不再实例化
        $currentTransaction = $this->getDbConnection()->getCurrentTransaction();
        if ($currentTransaction)
        {
            $return = parent::save($runValidation, $attributes);
            return $return;
        }
        else
        {
            //实例化事务处理
            $transaction = $this->getDbConnection()->beginTransaction();
            try 
            {
                $return = parent::save($runValidation, $attributes);
                $transaction->commit();
                return $return;
            } 
            catch (Exception $e)
            {
                $this->addError($e->getMessage(), $e->errorInfo);
                $transaction->rollback();
                return false;
            }

        }
    }
    /**
     * save relation data after save model
     */
    protected function afterSave()
    {
        foreach ($this->getMetaData()->relations as $name => $relation) 
        {
            if ($this->hasRelated($name) && is_array($values = $this->$name)) 
            {
                $className = $this->getMetaData()->relations[$name]->className;   //关联的model名
                $foreignKey = $this->getMetaData()->relations[$name]->foreignKey; //关联表的外键名
                $primaryKey = $this::model($className)->getTableSchema()->primaryKey; //关联表的主键名
                
                foreach ($values as $value) 
                {
                    $model = new $className();

                    //如果pk存在，则load出来update
                    if (isset($value[$model->primaryKey()]))
                    {
                        $fullModel = $model->findByPk($value[$model->primaryKey()]);
                        if ($fullModel)
                        {
                            $model = $fullModel;
                            unset($fullModel);
                        }
                        //unset($value[$model->primaryKey()]);
                    }

                    $model->attributes = $value;

                    $model->$foreignKey = $this->primaryKey; //设置外键值为当前表的pk

                    if ( ! $model->save())
                    {
                       throw new CDbException(get_class($model), 0, $model);
                    }
                }
            }
        }
        parent::afterSave();
    }
}
