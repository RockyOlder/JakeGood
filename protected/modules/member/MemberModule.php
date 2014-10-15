<?php

/**
 * 前台用户模块
 *
 */
class MemberModule extends CWebModule {

    public function init()
    {
        // import the module-level models and components
        //导 入类，必要时可恢复此属性
        $this->setImport(array(
            'member.models.*',
            'member.components.*',
        ));
    }

    public function beforeControllerAction($controller, $action)
    {
        if (parent::beforeControllerAction($controller, $action))
        {
            return true;
        }
        else
            return false;
    }

}
