<?php

/**
 * 系统配置
 * 
 */
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'O2O',
    'language' => 'zh_cn',
    'timeZone' => 'Asia/Shanghai',
    'preload' => array('log'),
    'import' => array(
        'application.models.*',
        'application.components.*',
        'application.extensions.*',
    ),
    'components' => array(
        'request' => array(
            'enableCsrfValidation' => true,
            'enableCookieValidation' => true,
        ),
        'db' => array(
            'connectionString' => 'mysql:host=localhost;dbname=anl_o2o',
            'emulatePrepare' => true,
            'enableParamLogging' => true,
            'enableProfiling' => true,
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            'tablePrefix' => '',
        ),
        'curl' => array(
            'class' => 'ext.Curl',
            'options' => array(),
        ),
        'mailer' => array(
            'class' => 'application.extensions.mailer.EMailer',
            'pathViews' => 'application.views.email',
            'pathLayouts' => 'application.views.email.layouts',
            'SMTPAuth' => TRUE,
            'Host' => 'smtp.exmail.qq.com',
            'Port' => 25,
            'Username' => 'service@anarry.com',
            'Password' => 'ana123456',
            'From' => 'service@anarry.com',
        )
    ),
);
