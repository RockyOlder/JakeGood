<?php

/**
 * 登录
 *
 */
class LoginController extends Controller {

    public $template;
    public $data;
    public $layout = 'login';
    public $title = '益号有约';

    public function init()
    {
        parent::init();
    }

    /**
     * 登录
     */
    public function actionIndex()
    {
        $this->template = '/login';
        if (isset($_POST['username']))
        {
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');
            $shop = Shop::model()->findByAttributes(array('username' => $username));
            
            if ($shop && $shop->password == md5('eeee'.trim($password).'hhhh'))
            {
                $store = $shop->Store;
                $user = new CUserIdentity($username, $password);
                
                Yii::app()->user->login($user);
                Yii::app()->user->setId($shop->id);
                Yii::app()->user->setName($username);
                Yii::app()->user->setState('shop', $shop);
                Yii::app()->user->setState('store', $store);
                $this->request->redirect($this->createUrl('/verify'));
            }
            else
            {
                $this->data['errors'] = '用户名或密码有误';
            }
        }
    }

    public function actionLogout()
    {
        Yii::app()->user->logout();
        Yii::app()->request->redirect('/verify/login?logout=true');
    }

    function afterAction()
    {
        $this->render($this->template, $this->data);
    }
    
}
