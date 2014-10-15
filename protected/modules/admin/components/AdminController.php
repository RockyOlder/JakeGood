<?php

class AdminController extends Controller {

    public $template;
    public $data;
    public $model;
    public $table;
    public $pk;
    public $pageTitle;
    public $request;

    public function init()
    {
        parent::init();
        $this->auth();
        if ($this->model != NULL)
        {
            $model = new $this->model;
            $this->pk = $model->primaryKey();
            $this->table = $model->columns();
            $this->data['model'] = $model;
            $this->data['count'] = $model->count();
        }
    }

    private function auth()
    {
        $loggedIn = $this->session->get('LoggedIn');

        if ($loggedIn == 1)
        {
            return TRUE;
        }
        
        $user = $_SERVER["PHP_AUTH_USER"];
        $pw = $_SERVER["PHP_AUTH_PW"];

        if ($user == "admin" && $pw == 'admin')
        {
            $this->session->add('LoggedIn', 1);
        }
        else
        {
            header('WWW-Authenticate: Basic realm="realm"');
            header('HTTP/1.0 401 Unauthorized');
            exit;
        }
    }

    public function actionLogout()
    {
        $this->session->remove('LoggedIn');
        $this->session->clear();
        $this->session->destroy();
        $this->redirect('/admin');
    }

    /**
     * 实时获取系统配置
     * @return [type] [description]
     */
    private function _config()
    {
        $model = Config::model()->findAll();
        foreach ($model as $key => $row)
        {
            $config[$row['key']] = $row['value'];
        }
        return $config;
    }

    /**
     *
     * 列表中的列信息  子类可以overwrite 此方法自定义显示列
     *
     * @param Array $data
     */
    protected function list_columns($col)
    {
        foreach ($col as $k => $v)
        {
            //如果有注释 默认中文名为注释名
            $data[$v]['header'] = (empty($this->table[$v]->comment)) ? $v : $this->table[$v]->comment;
            $data[$v]['func'] = "strval";
            $data[$v]['desc'] = "";
            $data[$v]['type'] = "raw";
            $data[$v]['headerHtmlOptions'] = NULL;
        }
        return $data;
    }

    /**
     * 	根据list_columns 生成CGridView 所要的columns 数组
     *
     * @param Array $data
     */
    protected function makeGridViewColumns($cols)
    {
        $data = array();
        $CLASS = get_class($this);

        foreach ($cols as $k => $v)
        {
            if (!isset($v['class']))
            {

                $v['value'] = $CLASS . '::' . $v['func'] . '(' . $k . ', $data)';
                $v['headerHtmlOptions']['title'] = $v['desc'];
                $v['name'] = $k;
                unset($v['func']);
                unset($v['desc']);

                $data[] = $v;
            }
            else
            {
                unset($v['func']);
                unset($v['desc']);
                $data[] = $v;
            }
        }
        array_unshift($data, $this->checkbox_column()); // 装载首列checkbox
        $data[] = $CLASS::handle(); // 装载操作列
        return $data;
    }

    public function actionIndex()
    {
        $this->actionList();
    }

    /**
     * 	通用 列表方法
     */
    public function actionList()
    {
        $model = $this->data['model'];
        $model->_attributes = Yii::app()->request->getParam($this->model);

        $cols = $this->list_columns($model->columnNames());
        $columns = $this->makeGridViewColumns($cols); //装载columns
        //CDbCriteria represents a query criteria, such as conditions, ordering by, limit/offset.
        $criteria = new CDbCriteria;

        foreach ($columns as $v)
        {
            $value = $model->getAttribute($v['name']);
            if (!$value)
                continue;

            $type = $this->table[$v['name']]->type;
            switch ($type)
            {
                //数据库为int型的查询条件拼写
                case 'integer':
                    //将日期格式转为int型
                    if ($v['type'] == 'date')
                    {
                        $time = strtotime(trim($value) . ' 00:00:00');
                        $time2 = strtotime(trim($value) . ' 23:59:59');
                        $criteria->addCondition($v['name'] . '>=' . $time);
                        $criteria->addCondition($v['name'] . '<=' . $time2);
                    }
                    //将日期时间格式转为int型
                    elseif ($v['type'] == 'datetime')
                    {
                        $criteria->addCondition($v['name'] . '=' . strtotime($value));
                    }
                    else
                    {
                        $criteria->addCondition($v['name'] . '=' . intval($value));
                    }

                    break;
                //数据库为double,float 型的查询条件拼写	
                case 'double':
                    if (is_numeric($value))
                        $criteria->addCondition($v['name'] . '=' . $value);
                    break;
                //数据库为char，varchar，text 等符串型的查询条件拼写	
                default:
                    $criteria->addCondition("{$v['name']} like '%" . mysql_escape_string($value) . "%'");
                    break;
            }
        }


        $this->data['columns'] = $columns;
        $this->data['model'] = $model;
        $this->data['filter'] = $model;
        $this->data['criteria'] = $criteria;

        $this->template = '/list';
    }

    /**
     * 	通用 新增方法
     */
    public function actionAdd()
    {
        $model = $this->data['model'];
        $data = $this->blank_form_columns($model->columnNames(), FALSE);

        $this->data['columns'] = $data;

        if (!$this->template)
            $this->template = '/form';
    }

    /**
     * 	通用 编辑方法
     */
    public function actionEdit()
    {
        $pk = Yii::app()->request->getParam($this->pk);
        $model = $this->data['model'];
        $model = $model->findByPk($pk);

        $data = $this->full_form_columns($model->columnNames(), $model);

        $this->data['columns'] = $data;

        if (!$this->template)
            $this->template = '/form';
    }

    /**
     * 	通用 保存方法
     */
    public function actionSave($ret = FALSE)
    {
        $data = Yii::app()->request->getPost($this->model); // 获取post中该表的数据 数组
        $pk = isset($data[$this->pk]) ? $data[$this->pk] : NULL;
        
        if ($pk)
        {
            $model = $this->data['model']->findByPk($pk);
        }
        else
        {
            $model = $this->data['model'];
        }

        $model->_attributes = $data;

        //保存文件，单个文件
        foreach ($model->rules() as $v)
        {
            if ($v[1] == 'file' && $_FILES[$this->model]['error'][$v[0]] == 0)
            {
                $model->$v[0] = CUploadedFile::getInstance($model, $v[0]);
                $filename = md5_file($_FILES[$this->model]['tmp_name'][$v[0]]) . '.' . $model->$v[0]->getExtensionName();
                $model->$v[0]->saveAs('assets/uploads/files/' . $filename);
                $model->$v[0] = '/assets/uploads/files/' . $filename;
            }
        }
        if ($model->save())
        {
            $catalog = $model->isNewRecord ? 'create' : 'update';
            //parent::adminLogger(array('user_id' => 1, 'catalog'=>'create', 'intro'=>'新增'.$this->data['title'].'，ID:'.$model->id));
        }
        else
        {
            print_r($model->errors);die;
        }
        if ($ret === TRUE)
            return $model;
        else
            $this->redirect($this->createUrl('list'));
    }

    /**
     * 	通用 删除方法
     */
    public function actionDelete()
    {
        $pk = Yii::app()->request->getParam($this->pk);
        $model = $this->data['model'];
        if ($pk)
            $model->deleteByPk($pk);

        $this->actionList();
    }

    /**
     * 	通用 状态方法
     */
    public function actionToggle()
    {
        $pk = Yii::app()->request->getQuery('id');
        $col = Yii::app()->request->getQuery('c');

        $model = $this->data['model'];
        $model = $model->findByPk($pk);
        $model->$col = ($model->$col) * -1 + 1;

        if ($model->save())
            die('OK');
        else
        {
            print_r($model);
            die('FALSE');
        }
    }

    /**
     * 	通用 列表数据查询方法
     */
    public function search()
    {
        /*
         * CActiveDataProvider为类modelClass的ActiveRecord对象 提供数据。
         * 它使用AR的CActiveRecord::findAll方法， 从数据库中检索信息。
         * criteria属性能够用来 查询多种指定条件。
         */
        return new CActiveDataProvider($this->data['model'], array(
            'criteria' => $this->data['criteria'],
            'pagination' => array('pageSize' => 10),
        ));
    }

    public function afterAction()
    {
        if ($this->template)
            $this->render($this->template, $this->data);
    }

    /* ================================== End Actions ======================================================== */

    /**
     *
     */
    static function strval($val, $data = NULL)
    {
        return !$data ? $val : $data->$val;
    }

    /**
     *
     * 表单中的字段信息  子类可以overwrite 此方法自定义
     *
     * @param Array $data
     * @param Bool $return_id
     */
    protected function blank_form_columns($col, $return_id = FALSE)
    {
        //继承list中的标题
        $list_columns = $this->list_columns($col);

        $data = array();
        foreach ($col as $k => $v)
        {
            //当是新增记录时 默认值为空
            $data[$v]['field'] = CHtml::activeTextField($this->data['model'], $v, array('id' => '_' . $v, 'class' => 'span6 m-wrap'));
            $data[$v]['name'] = isset($list_columns[$v]['name']) ? $list_columns[$v]['name'] : ( (empty($this->table[$v]->comment)) ? $v : $this->table[$v]->comment );
            $data[$v]['desc'] = isset($list_columns[$v]['desc']) ? $list_columns[$v]['desc'] : "";


            //eg {	required: true,	minlength: 5,equalTo: "#password"}
            $data[$v]['validate']['rules'] = '{required: true}';
            $data[$v]['validate']['message'] = '{required:" ' . $data[$v]['name'] . '必填"}';
        }
        //默认添加情况下 表单中不显示pk

        if ($return_id === FALSE)
            unset($data[$this->pk]);
        return $data;
    }

    /**
     *
     * 表单中的字段信息  子类可以overwrite 此方法自定义
     *
     * @param Array $data
     * @param Bool $return_id
     */
    protected function full_form_columns($col, $model = NULL)
    {
        $data = $this->blank_form_columns($col, $model);

        foreach ($col as $k => $v)
        {
            //当是新增记录时 默认值为空
            $data[$v]['field'] = CHtml::activeTextField($model, $v, array('id' => '_' . $v, 'class' => 'span6 m-wrap'));
        }

        $data[$this->pk]['field'] = CHtml::activeTextField($model, $this->pk, array('id' => '_' . $v, 'class' => 'span6 m-wrap required', 'readonly' => 'readonly'));
        $data[$this->pk]['validate']['rules'] = '{required: false}';
        return $data;
    }

    /**
     *
     * 页面Toggle开关选择
     * @param 字段名 $col
     * @param 更新记录ID $id
     * @param 当前值 $bool
     */
    protected static function toggle($col, $data)
    {
        $image = $data->$col == 0 ? "<img src=\"/assets/admin/images/icons/color/cross.png\" />" : "<img src=\"/assets/admin/images/icons/color/tick.png\" />";

        $toggle = CHtml::link($image, './toggle/?c=' . $col . '&id=' . $data->primaryKey, array('class' => 'toggle', 'onclick' => 'currentToggle($(this))'));
        return $toggle;
    }

    /**
     *
     * 列表静态操作方法
     * @param primary_key $id
     */
    public function handle()
    {
        $buttons = array(
            'class' => 'CButtonColumn',
            'header' => '操作',
            'headerHtmlOptions' => array('width' => '100'),
            'template' => '{update} {delete}', //{view} {update} {delete} {other}
            //    'viewButtonOptions'=>array('title'=>'查看'),
            'updateButtonOptions' => array('title' => '修改'),
            'deleteButtonOptions' => array('title' => '刪除'),
            'deleteConfirmation' => '确定删除？',
            'updateButtonUrl' => 'Yii::app()->controller->createUrl("edit", array($data->primaryKey() => $data->getPrimaryKey()))',
            'deleteButtonUrl' => 'Yii::app()->controller->createUrl("delete", array($data->primaryKey() => $data->getPrimaryKey()))',
                /*    'buttons' => array(
                  'other' => array(
                  'label' => '其它',
                  'url'   => 'Yii::app()->controller->createUrl("&", array("id"=>$data->id))',
                  )
                  ), */
        );
        return $buttons;
    }

    /**
     *
     * 列表多选框方法
     * @param primary_key $id
     */
    public static function checkbox_column()
    {
        $checkboxes = array(
            'class' => 'ICheckBoxColumn',
            'header' => '',
            'headerHtmlOptions' => array('width' => '50'),
            'htmlOptions' => array('align' => 'center'),
            'name' => 'id',
            'id' => 'id',
            'selectableRows' => 2,
        );
        return $checkboxes;
    }

    public function show_message($title, $content)
    {
        $this->template = '/message';
        $this->data['title'] = $title;
        $this->data['content'] = $content;
    }

    public static function limitLink($col, $data)
    {
        return CHtml::link(mb_substr($data->$col, 0, 20), $data->$col);
    }

    public static function show($col, $data)
    {
        if (strlen($data->$col) > 10)
            return CHtml::link('查看', 'javascript:$.fancybox(\'' . $data->$col . '\')');
        else
            return $data->$col;
    }

}
