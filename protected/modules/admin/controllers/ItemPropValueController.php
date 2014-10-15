<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ItemPropValue
 *
 * @author Fighter
 */
class ItemPropValueController extends AdminController {

    public $pid = 0;
    public $cid = 0;
    function init()
    {
        $this->model = 'ItemPropValue';
        parent::init();
        $this->pid = $this->request->getParam('pid');
        $this->cid = $this->request->getParam('cid');
        $this->data['model']->pid = $this->pid;
        $this->data['model']->cid = $this->cid;
    }
    
    public function actionList()
    {
        parent::actionList();
        $this->data['filter']->pid = $this->pid;
    }
    
    public function actionSave($ret = FALSE)
    {
        $model = parent::actionSave(TRUE);
        $this->request->redirect($this->createUrl('/admin/ItemPropValue', array('pid' => $model->pid, 'cid' => $model->cid)));
    }
}
