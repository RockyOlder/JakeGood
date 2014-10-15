<?php

class ICheckBoxColumn extends CCheckBoxColumn {

    public function init()
    {
        if (isset($this->checkBoxHtmlOptions['name']))
            $name = $this->checkBoxHtmlOptions['name'];
        else
        {
            $name = $this->id;
            if (substr($name, -2) !== '[]')
                $name.='[]';
            $this->checkBoxHtmlOptions['name'] = $name;
        }
        $name = strtr($name, array('[' => "\\[", ']' => "\\]"));

        if ($this->selectableRows === null)
        {
            if (isset($this->checkBoxHtmlOptions['class']))
                $this->checkBoxHtmlOptions['class'].=' select-on-check';
            else
                $this->checkBoxHtmlOptions['class'] = 'select-on-check';
            return;
        }

        $cball = $cbcode = '';
        if ($this->selectableRows == 0)
        {
            //.. read only
            $cbcode = "return false;";
        }
        elseif ($this->selectableRows == 1)
        {
            //.. only one can be checked, uncheck all other
            $cbcode = "jQuery(\"input:not(#\"+this.id+\")[name='$name']\").prop('checked',false);";
        }
        elseif (strpos($this->headerTemplate, '{item}') !== false)
        {
            //.. process check/uncheck all
            $cball = <<<CBALL
jQuery(document).on('click','#{$this->id}_all',function() {
	var checked=this.checked;
	jQuery("input[name='$name']:enabled").each(function() {
		this.checked=checked;
		if (checked)
			$(this).parent().addClass('checked');
		else
			$(this).parent().removeClass('checked');
	});
});

CBALL;
            $cbcode = "jQuery('#{$this->id}_all').prop('checked', jQuery(\"input[name='$name']\").length==jQuery(\"input[name='$name']:checked\").length);";
        }

        if ($cbcode !== '')
        {
            $js = $cball;
            $js.=<<<EOD
jQuery(document).on('click', "input[name='$name']", function() {
	$cbcode
});
EOD;
            Yii::app()->getClientScript()->registerScript(__CLASS__ . '#' . $this->id, $js);
        }
    }

}
