<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BaseController
 *
 * @author Fighter
 */
class BaseController extends Controller {
    
    public $market;
    public $template = 'NULL';
    public $data = array();
    public $title = '';
    public $must_login = FALSE;
    //put your code here
    function init()
    {
        parent::init();
        $domain = Yii::app()->request->getServerName();
        
        $market = Market::model()->find("domain like '{$domain}'");
        
        if ($market)
        {
            $this->market = $market;
            $this->title  = $market->name;
            Yii::app()->theme = ( ! $market->theme ? 'default' : $market->theme);

            $this->theme     = Yii::app()->theme;
            $this->themePath = str_replace(array('\\', '\\\\'), '/', Yii::app()->theme->basePath);
            $this->skinUrl   = Yii::app()->baseUrl . '/assets/skin/' . $this->skin;
        }
        else
        {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        if ($this->must_login === TRUE  && Yii::app()->user->getIsGuest())
        {
            $this->request->redirect('/login');
        }
    }
    
    public function renderError($title, $message = '', $returnUrl = NULL)
    {
        $this->template = '/error/index';
        $this->data['title'] = $title;
        $this->data['message'] = $message;
        $this->data['returnUrl'] = ! $returnUrl ? 'javascript:history.back()' : $returnUrl;
        return TRUE;
    }
    public function afterAction()
    {
        if ($this->template)
        {
            $this->render($this->template, $this->data);
        }
    }
}
