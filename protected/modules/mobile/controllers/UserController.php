<?php

/**
 * 用户
 *
 */
class UserController extends BaseController
{

    public $template;
    public $data;

    public function init()
    {
        parent::init();
    }

    /**
     * 登录
     */
    public function actionLogin()
    {
    //    echo 1;exit;
        $this->template = 'login';
        $this->data['title'] = '登录';

        $token   = $this->request->getQuery('token');
        $forward = $this->request->getQuery('forward', '/');
        
        if ($token)
        {
            $identity = new UserIdentity($token, '');

            if ($identity->authenticate())
            {
                Yii::app()->user->setReturnUrl('/');
                Yii::app()->request->redirect($forward);
            }
            else
            {
                $this->data['errors'][] = $identity->errorMessage;
            }
        }
    }

    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->template = '/user/login';
      //  Yii::app()->request->redirect('/?logout=true');
    }

    function afterAction()
    {
        $this->render($this->template, $this->data);
    }

}
