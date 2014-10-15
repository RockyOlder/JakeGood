<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AuthComponent
 *
 * @author Administrator
 */
class AuthComponent extends Phalcon\Mvc\User\Component {

    public $user;
    private $key = '&SFD(*sdf*SD79fzdf0asfd*';

    public function __construct()
    {
        $this->user = $this->session->get('auth_user');
        ;
    }

    public function login($user = array())
    {
        $this->user = (object) $user;
        $this->session->set('auth_user', $this->user);
    }

    public function logout()
    {
        $this->session->remove('auth_user');
        ;
    }

    public function isLogin()
    {
        if ($this->getId() > 0)
            return TRUE;
        else
            return FALSE;
    }

    public function getId()
    {
        if (isset($this->user->id) && $this->user->id > 0)
            return $this->user->id;
        else
            return 0;
    }

    public function getName()
    {
        if (isset($this->user->username) && $this->user->username > 0)
            return $this->user->username;
        else
            return '';
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getToken()
    {
        $crypt = new Phalcon\Crypt();
        $crypt->setCipher('rijndael-256');
        $crypt->setMode('cbc');

        $text = $this->getId() . ';' . $this->getName() . ';' . (time() + 30 * 24 * 3600);

        return $crypt->encryptBase64($text, $this->key);
    }

    public function getAvatar()
    {
        return $this->url->get('avatar', array('u' => $this->getName()));
    }

    public function loginByToken($token)
    {
        $crypt = new Phalcon\Crypt();
        $crypt->setCipher('rijndael-256');
        $crypt->setMode('cbc');

        $token = $crypt->decryptBase64($token, $this->key);

        if (is_numeric(substr($token, 0, 2)))
        {
            list($uid, $username, $expire) = explode(';', $token);

            if ($expire < time())
                return FALSE; //过期token

            $this->login(array('id' => $uid, 'username' => $username)); //登录

            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

}
