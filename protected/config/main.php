<?php

/**
 * 系统配置
 * 
 */
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => '互益同城',
    'language' => 'zh_cn',
    'theme' => 'default',
    'timeZone' => 'Asia/Shanghai',
    'preload' => array('log'),
    'import' => array(
        'application.models.*',
        'application.components.*',
        'application.extensions.*',
    ),
    'modules' => array(
        'api' => array(
            'class' => 'application.modules.api.ApiModule',
        ),
        'seller' => array(
            'class' => 'application.modules.seller.SellerModule',
        ),
        'member' => array(
            'class' => 'application.modules.member.MemberModule',
        ),
        'admin' => array(
            'class' => 'application.modules.admin.AdminModule',
        ),
	'backend' => array(
            'class' => 'application.modules.backend.BackendModule',
        ),
	'verify' => array(
            'class' => 'application.modules.verify.VerifyModule',
        ),
	'm' => array(
            'class' => 'application.modules.mobile.MobileModule',
        ),
    ),
    'components' => array(
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
        'user' => array(
            // enable cookie-based authentication
            'allowAutoLogin' => true,
            'loginUrl' => array('user/login'),
        ),
        'errorHandler' => array(
        //'errorAction'=>'/error/index',
        ),
        'CGB' => array(
            'class' => 'application.extensions.cgb.CGB',
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
        ),
        'cache' => array(
            'class' => 'CFileCache',
        ),
        'SMS' => array(
            'class' => 'application.extensions.SMS',
        ),
        'taobao' => array(
            'class' => 'TaobaoFunc',
            'config' => array(
                'appKey' => '21566865',
                'appSecret' => '80d250f43a80eacb80edbb03844e8f9e',
                'apiUrl' => 'http://gw.api.taobao.com/router/rest',
                'sessionUrl' => 'http://container.api.tbsandbox.com/container?appkey=',
            ),
        ),
        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
            //'urlSuffix'=>'.html',
            'rules' => array(
                '<_c:\w+>/<id:\d+>' => '<_c>/view',
                '<_c:\w+>/<_a:\w+>/<id:\d+>' => '<_c>/<_a>',
                '<_c:\w+>/<_a:\w+>' => '<_c>/<_a>',
            ),
        ),
    ),
);
