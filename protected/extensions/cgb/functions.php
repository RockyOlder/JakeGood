<?php

//签名函数 
function createSign($paramArr, $appSecret, $timestamp = 0)
{
    $sign = $appSecret;
    if (isset($paramArr['appKey']))
    {
        ksort($paramArr);
        foreach ($paramArr as $key => $val)
        {
            if (is_array($val))
            {
                foreach ($val as $k => $items)
                {
                    ksort($items);
                    foreach ($items as $k2 => $item)
                    {
                        if ($k2 != '' && $item != '')
                        {
                            $sign .= $k . $k2 . $item;
                        }
                    }
                }
            }
            elseif ($key != '' && $val != '')
            {
                $sign .= $key . $val;
            }
        }
        $sign = md5($sign . $appSecret . $timestamp);
        return $sign;
    }
    elseif (isset($paramArr[0]['seller']))
    {
        foreach ($paramArr as $order)
        {
            ksort($paramArr);
            foreach ($order as $key => $val)
            {
                if (is_array($val))
                {
                    foreach ($val as $k => $items)
                    {
                        ksort($items);
                        foreach ($items as $k2 => $item)
                        {
                            if ($k2 != '' && $item != '')
                            {
                                $sign .= $k . $k2 . $item;
                            }
                        }
                    }
                }
                elseif ($key != '' && $val != '')
                {
                    $sign .= $key . $val;
                }
            }
        }
        $sign = md5($sign . $appSecret . $timestamp);
        return $sign;
    }
}

//组参函数 
function buildQuery($orders, $appkey, $sign)
{
    if (isset($orders[0]))
    {
        $orders = array('list' => $orders);        
    }
    $orders['appKey'] = $appkey;
    $orders['sign']   = $sign;
    return http_build_query($orders);
}

//组参函数 
function createPostParam($orders)
{
    $string = '';

    foreach ($orders as $i => $order)
    {
        foreach ($order as $key => $val)
        {
            if (is_array($val))
            {
                foreach ($val as $k => $items)
                {
                    foreach ($items as $k2 => $item)
                    {
                        if ($k2 != '' && $item != '')
                        {
                            $string .= '<input type="hidden" name="list['.$i.']['.$key . '][' . $k . '][' . $k2 . ']' .'" value="'.$item.'">'."\n";
                        }
                    }
                }
            }
            elseif ($key != '' && $val != '')
            {
                $string .= '<input type="hidden" name="list['.$i.']['.$key.']" value="'.$val.'">'."\n";
            }
        }
    }
    return $string;
}

//解析xml函数
function getXmlData($strXml)
{
    $pos = strpos($strXml, 'xml');
    if ($pos)
    {
        $xmlCode = simplexml_load_string($strXml, 'SimpleXMLElement', LIBXML_NOCDATA);
        $arrayCode = get_object_vars_final($xmlCode);
        return $arrayCode;
    }
    else
    {
        return '';
    }
}

?>