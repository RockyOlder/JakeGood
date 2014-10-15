<?php

class ApiController extends BaseController {

    /**
     * Data array
     * @var array
     */
    public $format = "json";

    public function init()
    {
        parent::init();

        $format = $this->request->getQuery('format');

        if ($format)
        {
            $this->format = $format;
        }
    }

    public function afterAction()
    {
        if ($this->format == "json")
        {
            header('content-type: application/json');
            die(json_encode($this->data));
        }
        else
        {
            die($this->data);
        }
    }

    function errorCode($code = 1, $message = "")
    {
        return array('ret' => $code, "msg" => $message);
    }

}
