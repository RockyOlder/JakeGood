<?php

/**
 * 登录
 *
 */
class LoginController extends Controller {

    public $template;
    public $data;
    public $layout = 'login';

    public function init()
    {
        parent::init();
    }

    /**
     * 登录
     */
    public function actionIndex()
    {
        $this->data['title'] = '登录';

        $token = $this->request->getQuery('token');

        if ($token)
        {
            $identity = new UserIdentity($token, '');

            if ($identity->authenticate())
            {
                $url = Yii::app()->user->getReturnUrl();
                $url = ($url == '' ? '/' : $url);
                Yii::app()->user->setReturnUrl('/');
                $url = '/seller';

                Yii::app()->request->redirect($url);
            }
            else
            {
                $this->data['errors'][] = $identity->errorMessage;
            }
        }
        else
        {

            $this->template = '/login';
        }
    }

    public function actionLogout()
    {
        Yii::app()->user->logout();
        Yii::app()->request->redirect('/seller/login?logout=true');
    }

    function afterAction()
    {
        $this->render($this->template, $this->data);
    }

}
