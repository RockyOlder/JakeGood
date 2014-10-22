<?php

class DefaultController extends MobileController {

    public $layout = 'bootstrap';
    public function actionIndex()
    {
       $this->template = '/index';
    }

}
