<?php

class VerifyController extends Controller {

    public $data;
    public $store;
    public $shop;
    public $template = NULL;
    public $title = '益号有约';

    public function init()
    {
        parent::init();

        if (Yii::app()->user->getIsGuest())
        {
            Yii::app()->user->setReturnUrl($this->request->getUrl());
            $this->redirect('/verify/login');
        }
        $this->shop = Yii::app()->user->getState('shop');
        if ( ! $this->shop)
        {
            $this->layout = FALSE;
            $this->template = '/error/default';
            $this->data['code'] = '8002';
            $this->data['message'] = '没有权限';
            $this->afterAction();
            exit;
        }
        $this->store = Yii::app()->user->getState('store');
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
