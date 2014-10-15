<?php

class MemberController extends BaseController {

    public $must_login = TRUE;
    public function init()
    {
        parent::init();
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
