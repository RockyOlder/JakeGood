<?php
/**
 * 快递查询
 * 
 */
class Kuaidi {

    private $key  = 'dc3407dddd821207';
    public  $type = '';
    public  $nu   = '';

    function Kuaidi($type, $nu)
    {
        $this->type = $type;
        $this->nu   = $nu;
    }

    public static function init($type, $nu)
    {
        return new self($type, $nu);
    }

    function query()
    {
        return file_get_contents("http://www.kuaidi100.com/applyurl?key={$this->key}&com={$this->type}&nu={$this->nu}");
    }
}
