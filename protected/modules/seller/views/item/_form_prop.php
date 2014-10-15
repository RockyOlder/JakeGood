<?php
$itemPropValues = json_decode($item->props, true);
//$itemSkus = $item->skus;
//print_r($itemPropValues);die;
foreach ($base_props as $prop)
{
    $itemPropValue = '';
    if (isset($itemPropValues[$prop->pid]['values']))
    {
        foreach ($itemPropValues[$prop->pid]['values'] as $vid => $vtext)
        {
            $itemPropValue[] = $vid;
        }
    }

    if ($prop->is_enum_prop == 1)
    {
        echo '<div class="form-group">';
        echo '<label class="col-lg-3 control-label">' . $prop->name . '：</label>';
        echo '<div class="col-lg-9">';
        $name = 'ItemProp[' . $prop->pid . ']';
        $propValueData = CHtml::listData($prop->itemPropValues, 'vid', 'name');

        if ($prop->multi == 1)
        {
            echo CHtml::checkBoxList($name, $itemPropValue, $propValueData, array('label' => $prop->name, 'separator' => '', 'template' => '<span class="col-md-3">{input} {label}</span>'));
        }
        else
        {
            $input = array(0 => '');
            $propValueData = $input + $propValueData;
            echo CHtml::dropDownList($name, $itemPropValue, $propValueData, array('label' => $prop->name, 'class' => 'form-control input-small '. ($prop->must == 1 ? 'required' : '')));
            if ($prop->is_input_prop == 1)
            {
                //echo CHtml::textField($name);
            }
        }
        echo '</div>';
        echo '</div>';
    }
    elseif ($prop->is_input_prop == 1)
    {
        echo '<div class="form-group">';
        echo '<label class="col-lg-3 control-label">' . $prop->name . '：</label>';
        echo '<div class="col-lg-9">';
        $name = 'ItemProp[' . $prop->pid . ']';
            echo CHtml::textField($name, $itemPropValue, array('label' => $prop->name));
        echo '</div>';
        echo '</div>';
    }
}
?>