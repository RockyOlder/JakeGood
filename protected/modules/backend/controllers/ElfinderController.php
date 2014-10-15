<?php
/**

 */

class ElfinderController extends Controller
{
    //public $layout = '/layouts/mall';

    public function actions()
    {
        $dir = '/uploads/'.Yii::app()->user->getId().'/images';
        $path = Yii::getPathOfAlias('webroot') . $dir;
        if ( ! is_dir($path))
        {
            IUtils::mkdir($path, 777);
        }
        return array(
            'connector' => array(
                'class' => 'ext.elFinder.ElFinderConnectorAction',
                'settings' => array(
                    'roots' => array(
                        array(
                            'driver' => 'LocalFileSystem', // driver for accessing file system (REQUIRED)
                            'path' => $path, // path to files (REQUIRED)
                            'URL' =>  Yii::app()->baseUrl . $dir, // URL to files (REQUIRED)
                            'search' => false,
                            'mimeDetect' => 'internal',
                            'rootAlias' => 'Home',
                            'accessControl' => 'access' //access disable and hide dot starting files (OPTIONAL)
                        )
                    )
                )
            ),
        );
    }

    public function actionAdmin()
    {
        $this->render('admin');
    }

    public function actionView()
    {
        $this->renderPartial('view', array(), false, true);
    }
}