<?php

//---------------------------------------------------------
//财付通即时到帐支付请求示例，商户按照此文档进行开发即可
//---------------------------------------------------------

require (dirname(__FILE__) . "/tenpay/ResponseHandler.class.php");
require (dirname(__FILE__) . "/tenpay/RequestHandler.class.php");
require (dirname(__FILE__) . "/tenpay/client/ClientResponseHandler.class.php");
require (dirname(__FILE__) . "/tenpay/client/TenpayHttpClient.class.php");
require (dirname(__FILE__) . "/tenpay/function.php");

class Tenpay {

    public function init()
    {
        
    }

    /**
     * Constructor. Here the instance of PHPMailer is created.
     */
    public function __construct()
    {
        
    }

    public function Pay($param)
    {
        require_once (dirname(__FILE__) . "/tenpay/config.php");
        /* 创建支付请求对象 */
        $reqHandler = new RequestHandler();
        $reqHandler->init();
        $reqHandler->setKey($key);
        $reqHandler->setGateUrl("https://gw.tenpay.com/gateway/pay.htm");

        //----------------------------------------
        //设置支付参数 
        //----------------------------------------
        $reqHandler->setParameter("partner", $partner);
        $reqHandler->setParameter("return_url", $return_url);
        $reqHandler->setParameter("notify_url", $notify_url);
        /* 获取提交的订单号 */
        $out_trade_no = $param["order_no"];
        /* 获取提交的商品名称 */
        $product_name = $param["product_name"];
        /* 获取提交的商品价格 */
        $order_price = $param["order_price"];
        /* 获取提交的备注信息 */
        $remarkexplain = $param["remarkexplain"];
        /* 支付方式 */
        $trade_mode = $param["trade_mode"];

        $strDate = date("Ymd");
        $strTime = date("His");

        /* 商品价格（包含运费），以分为单位 */
        $total_fee = $order_price * 100;

        /* 商品名称 */
        $desc = "商品：" . $product_name . ",备注：" . $remarkexplain;


        //----------------------------------------
        //设置支付参数 
        //----------------------------------------
        $reqHandler->setParameter("out_trade_no", $out_trade_no);
        $reqHandler->setParameter("total_fee", $total_fee);  //总金额
        $reqHandler->setParameter("body", $desc);
        $reqHandler->setParameter("bank_type", "DEFAULT");     //银行类型，默认为财付通
        //用户ip
        $reqHandler->setParameter("spbill_create_ip", $_SERVER['REMOTE_ADDR']); //客户端IP
        $reqHandler->setParameter("fee_type", "1");               //币种
        $reqHandler->setParameter("subject", $subject);          //商品名称，（中介交易时必填）
        //系统可选参数
        $reqHandler->setParameter("sign_type", "MD5");       //签名方式，默认为MD5，可选RSA
        $reqHandler->setParameter("service_version", "1.0");    //接口版本号
        $reqHandler->setParameter("input_charset", "utf-8");      //字符集
        $reqHandler->setParameter("sign_key_index", "1");       //密钥序号
        //业务可选参数
        $reqHandler->setParameter("attach", "");                //附件数据，原样返回就可以了
        $reqHandler->setParameter("product_fee", "");           //商品费用
        $reqHandler->setParameter("transport_fee", "0");         //物流费用
        $reqHandler->setParameter("time_start", date("YmdHis"));  //订单生成时间
        $reqHandler->setParameter("time_expire", "");             //订单失效时间
        $reqHandler->setParameter("buyer_id", "");                //买方财付通帐号
        $reqHandler->setParameter("goods_tag", "");               //商品标记
        $reqHandler->setParameter("trade_mode", $trade_mode);              //交易模式（1.即时到帐模式，2.中介担保模式，3.后台选择（卖家进入支付中心列表选择））
        $reqHandler->setParameter("transport_desc", "");              //物流说明
        $reqHandler->setParameter("trans_type", "1");              //交易类型
        $reqHandler->setParameter("agentid", "");                  //平台ID
        $reqHandler->setParameter("agent_type", "");               //代理模式（0.无代理，1.表示卡易售模式，2.表示网店模式）
        $reqHandler->setParameter("seller_id", "");                //卖家的商户号
        //获取debug信息,建议把请求和debug信息写入日志，方便定位问题
        /**/
        //$debugInfo = $reqHandler->getDebugInfo();
        //echo "<br/>" . $debugInfo . "<br/>"; die;
        //请求的URL
        $reqUrl = $reqHandler->getRequestURL();
        return $reqUrl;
    }

    public function Notify()
    {
        require_once (dirname(__FILE__) . "/tenpay/config.php");
        /* 创建支付应答对象 */
        $resHandler = new ResponseHandler();
        $resHandler->setKey($key);
        //判断签名
        if ($resHandler->isTenpaySign())
        {

            //通知id
            $notify_id = $resHandler->getParameter("notify_id");

            //通过通知ID查询，确保通知来至财付通
            //创建查询请求
            $queryReq = new RequestHandler();
            $queryReq->init();
            $queryReq->setKey($key);
            $queryReq->setGateUrl("https://gw.tenpay.com/gateway/simpleverifynotifyid.xml");
            $queryReq->setParameter("partner", $partner);
            $queryReq->setParameter("notify_id", $notify_id);

            //通信对象
            $httpClient = new TenpayHttpClient();
            $httpClient->setTimeOut(5);
            //设置请求内容
            $httpClient->setReqContent($queryReq->getRequestURL());

            //后台调用
            if ($httpClient->call())
            {
                //设置结果参数
                $queryRes = new ClientResponseHandler();
                $queryRes->setContent($httpClient->getResContent());
                $queryRes->setKey($key);

                if ($resHandler->getParameter("trade_mode") == "1")
                {
                    //判断签名及结果（即时到帐）
                    //只有签名正确,retcode为0，trade_state为0才是支付成功
                    if ($queryRes->isTenpaySign() && $queryRes->getParameter("retcode") == "0" && $resHandler->getParameter("trade_state") == "0")
                    {
                        //log_result("即时到帐验签ID成功");
                        //取结果参数做业务处理
                        $out_trade_no = $resHandler->getParameter("out_trade_no");
                        //财付通订单号
                        $transaction_id = $resHandler->getParameter("transaction_id");
                        //金额,以分为单位
                        $total_fee = $resHandler->getParameter("total_fee");
                        //如果有使用折扣券，discount有值，total_fee+discount=原请求的total_fee
                        $discount = $resHandler->getParameter("discount");
                        $time_end = $resHandler->getParameter("time_end");

                        //------------------------------
                        //处理业务开始
                        //------------------------------
                        //处理数据库逻辑
                        //注意交易单不要重复处理
                        //注意判断返回金额
                        //------------------------------
                        //处理业务完毕
                        //------------------------------
                        //log_result("即时到帐后台回调成功");
                        file_put_contents('/home/www/htdocs/EPAY/assets/notify0.txt', '即时到帐后台回调成功');
                        return array('order_sn' => $out_trade_no, 'total' => $total_fee / 100, 'transaction_id' => $transaction_id, 'time' => $time_end);
                    }
                    else
                    {
                        //错误时，返回结果可能没有签名，写日志trade_state、retcode、retmsg看失败详情。
                        //echo "验证签名失败 或 业务错误信息:trade_state=" . $resHandler->getParameter("trade_state") . ",retcode=" . $queryRes->                         getParameter("retcode"). ",retmsg=" . $queryRes->getParameter("retmsg") . "<br/>" ;
                        //log_result("即时到帐后台回调失败");
                        echo "fail";
                        return FALSE;
                    }
                }

                //获取查询的debug信息,建议把请求、应答内容、debug信息，通信返回码写入日志，方便定位问题
                /*
                  echo "<br>------------------------------------------------------<br>";
                  echo "http res:" . $httpClient->getResponseCode() . "," . $httpClient->getErrInfo() . "<br>";
                  echo "query req:" . htmlentities($queryReq->getRequestURL(), ENT_NOQUOTES, "GB2312") . "<br><br>";
                  echo "query res:" . htmlentities($queryRes->getContent(), ENT_NOQUOTES, "GB2312") . "<br><br>";
                  echo "query reqdebug:" . $queryReq->getDebugInfo() . "<br><br>" ;
                  echo "query resdebug:" . $queryRes->getDebugInfo() . "<br><br>";
                 */
            }
            else
            {
                //通信失败
                echo "fail";
                //后台调用通信失败,写日志，方便定位问题
                echo "<br>call err:" . $httpClient->getResponseCode() . "," . $httpClient->getErrInfo() . "<br>";

                return FALSE;
            }
        }
        else
        {
            echo "<br/>" . "认证签名失败" . "<br/>";
            echo $resHandler->getDebugInfo() . "<br>";

            return FALSE;
        }
    }

}

?>