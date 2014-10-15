<?php

/**
 * 用户
 *
 */
class LoginController extends BaseController
{
    public function actionIndex()
    {
        $this->template = '/user/login';
    }
}
