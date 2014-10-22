<?php

class UserIdentity extends CUserIdentity
{

    private $_id;
    private $key;
    private $token;
    public function UserIdentity($token, $pass)
    {
        $this->token = $token;
        $this->key = pack('H*', "baf6badc168f168b168a168d1c1b89846138fadb631cfdcfbadf684cba68dfcb");
    }
    public function authenticate()
    {
        $ctext = base64_decode($this->token);
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $iv_dec = substr($ctext, 0, $iv_size);
        $ctext = substr($ctext, $iv_size);
        $token = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $this->key, $ctext, MCRYPT_MODE_CBC, $iv_dec);

        if (is_numeric(substr($token, 0, 2)))
        {
            list($uid, $username, $expire) = explode(';', $token);

            if ($expire < time())
            {
                $this->errorCode = self::ERROR_PASSWORD_INVALID;
            } //过期token

            $user = User::model()->findByPk($uid);
            if ($user)
            {
                $user->user_id    = $uid;
                $user->username   = $username;
                $user->logins    += 1;
                $user->last_login = time();
                $user->update();
            }
            else
            {
                $user = new User();
                $info = file_get_contents('http://i.anarry.com/api/user/info?token='.urlencode($this->token));
                $info = json_decode($info);
                
                $user->user_id  = $uid;
                $user->username = $username;
                $user->nickname = '';
                $user->email    = '';
                $user->logins   = 1;
                $user->status   = 1;
                $user->created  = time();
                $user->last_login = time();
                
                if (isset($info->nickname))
                {
                    $user->email    = $info->email;
                    $user->nickname = $info->nickname;
                }
                $user->save();
            }

            Yii::app()->user->login($this);
            Yii::app()->user->setId($uid);
            Yii::app()->user->setName($username);
            Yii::app()->user->setState('user', $user);
            Yii::app()->user->setState('token', $this->token);

            $this->errorCode = self::ERROR_NONE;
        }
        else
        {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        }

        return !$this->errorCode;
    }

}
