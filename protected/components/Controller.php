<?php

/**
 * 控制器基类，前端，后端均需继承此类
 * 
 */
class Controller extends CController {

    public $layout = 'main';
    public $request;
    public $baseUrl;
    public $session;
    public $cookies;
    public $config;
    public $theme;
    public $themePath;
    public $skin = 'default';  //皮肤
    public $skinUrl = '';
    public $menu = array();
    public $breadcrumbs = array();

    /**
     * 初始化
     * @see CController::init()
     */
    public function init()
    {
        $this->session = new CHttpSession();
        $this->session->open();
        $this->cookies = Yii::app()->request->getCookies();
        $this->request = Yii::app()->request;
        $this->baseUrl = Yii::app()->baseUrl;

    }

    /*
      显示执行时间及内存
      @see CController::afterAction()

      protected function afterAction ($action)
      {
      $time = sprintf('%0.5f', Yii::getLogger()->getExecutionTime());
      $memory = round(memory_get_peak_usage() / (1024 * 1024), 2) . "MB";
      echo '<!-- Time: ' . $time . 'ms, memory: ' . $memory . '-->';
      parent::afterAction($action);
      } */

    /**
     * 申明方法调用的类文件
     */
    public function actions()
    {
        return array('captcha' => array('class' => 'CCaptchaAction', 'minLength' => 1, 'maxLength' => 5, 'backColor' => 0xFFFFFF, 'width' => 100, 'height' => 40));
    }

    /**
     * 用户日志记录
     * @param  $intro
     */
    protected function userLogger(array $arr = array())
    {
    }

    /**
     * 编辑器文件上传
     */
    public function actionUpload()
    {
        if (XUtils::method() == 'POST')
        {
            $accountUserId = self::_sessionGet('accountUserId');
            //$adminiUserId = self::_sessionGet('adminiUserId');
            $file = XUpload::upload($_FILES['imgFile']);
            if (is_array($file))
            {
                $model = new Upload();
                $model->user_id = intval($accountUserId);
                $model->file_name = $file['pathname'];
                $model->thumb_name = $file['paththumbname'];
                $model->real_name = $file['name'];
                $model->file_ext = $file['extension'];
                $model->file_mime = $file['type'];
                $model->file_size = $file['size'];
                $model->save_path = $file['savepath'];
                $model->hash = $file['hash'];
                $model->save_name = $file['savename'];
                $model->create_time = time();
                if ($model->save())
                {
                    exit(CJSON::encode(array('error' => 0, 'url' => Yii::app()->baseUrl . '/' . $file['pathname'])));
                }
                else
                {
                    @unlink($file['pathname']);
                    @unlink($file['paththumbname']);
                    exit(CJSON::encode(array('error' => 1, 'message' => '上传错误')));
                }
            }
            else
            {
                exit(CJSON::encode(array('error' => 1, 'message' => '上传错误')));
            }
        }
    }

}
