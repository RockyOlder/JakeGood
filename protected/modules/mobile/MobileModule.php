<?php

class MobileModule extends CWebModule
{
    public function init()
    {
        // this method is called when the module is being created
        // you may place code here to customize the module or the application

        // import the module-level models and components
       // echo 1;exit;
        $this->setImport(array(
            'm.controller.*',
            'm.components.*',
        ));
    }

    public function afterControllerAction($controller, $action)
    {
        Yii::app()->end();
    }
}
