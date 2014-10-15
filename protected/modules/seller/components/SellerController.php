<?php

class SellerController extends Controller {

    public $data;
    public $store;
    public $template = NULL;
    public $title = '商家后台';

    public function init()
    {
        parent::init();

        Yii::app()->theme = '/fourteen';
        if (Yii::app()->user->getIsGuest())
        {
            Yii::app()->user->setReturnUrl($this->request->getUrl());
            $this->redirect('/seller/login');
        }
        $this->store = Store::model()->findByPk(Yii::app()->user->getId());
        if (!$this->store)
        {
            $this->layout = FALSE;
            $this->template = '/error/default';
            $this->data['code'] = '3002';
            $this->data['message'] = '还没开通商家权限';
            $this->afterAction();
            exit;
        }
        if ($this->store->cid == 0 && get_class($this) != 'StoreController')
        {
            $this->redirect('/seller/store');
        }
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     * @throws CHttpException
     * @author:  Lujie.Zhou(gao_lujie@live.cn, qq:821293064)
     */
    public function actionDelete($id)
    {
        if (Yii::app()->request->isPostRequest)
        {
            // we only allow deletion via POST request
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
            {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
            }
        }
        else
        {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

    public function afterAction()
    {
        if ($this->template)
        {
            $this->render($this->template, $this->data);
        }
    }

    
    public function renderError($title, $message = '', $returnUrl = NULL)
    {
        $this->template = '/error';
        $this->data['title'] = $title;
        $this->data['message'] = $message;
        $this->data['returnUrl'] = ! $returnUrl ? 'javascript:history.back()' : $returnUrl;
        return TRUE;
    }
    
    public function renderMessage($title, $message = '', $returnUrl = NULL)
    {
        $this->template = '/message';
        $this->data['title'] = $title;
        $this->data['message'] = $message;
        $this->data['returnUrl'] = ! $returnUrl ? 'javascript:history.back()' : $returnUrl;
        return TRUE;
    }

}
