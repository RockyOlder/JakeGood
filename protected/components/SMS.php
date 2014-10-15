<?php

/**
 * 短信发送类
 * 
 */
class SMS {

    static public function instance()
    {
        return new self();
    }

    function sendCheckcode($to, $name = 'sms_check_code')
    {
        $code = mt_rand(100001, 999999);
        ISession::instance()->remove($name);
        ISession::instance()->set($name, $code);
        return $this->send($to, '你好您的验证码是' . $code);
    }

    function send($to, $message)
    {
        $args = array(
            'Uid' => 'anarry',
            'Key' => 'b9fc274fa6b4fd999152',
            'smsMob' => $to,
            'smsText' => $message . '【阿那里科技】',
        );
        $url = 'http://utf8.sms.webchinese.cn/?' . http_build_query($args);
        $ret = file_get_contents($url);
        switch ($ret)
        {
            case '1' :
                return TRUE;
                break;
            case '-4' :
                $msg = '手机号格式不正确';
                return FALSE;
                break;
        }
        return FALSE;
    }

    function check($name = 'sms_check_code')
    {
        if (isset($_REQUEST[$name]))
        {
            $scode = ISession::instance()->get($name);
            if ($scode == $_REQUEST[$name])
            {
                ISession::instance()->remove($name);
                return TRUE;
            }
        }
        return FALSE;
    }

}
