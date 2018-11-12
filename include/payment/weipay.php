<?php
if(!defined('DEDEINC')) exit('Request Error!');
/**
 * 微信接口类
 * author 缘境 QQ:316430983
 */
class Weipay
{
    var $dsql;
    var $mid;
    var $return_url = "/plus/carbuyaction.php?dopost=return";
    /**
     * 构造函数
     *
     * @access  public
     * @param
     *
     * @return void
     */
    function Weipay()
    {
        global $dsql;
        $this->dsql = $dsql;
    }

    function __construct()
    {
        $this->Weipay();
    }
	
    /**
    * 获取支付二维码
    */
	function GetCode($order, $payment)
	{
		require_once(DEDEINC."/WxPay.Api.php");
		$order['price'] = str_replace(".00","",$order['price']);
		$input = new WxPayUnifiedOrder();
		$input->payment = $payment;
		$body_name = "支付订单号";
		//$body_name = utf82gb($body_name);
		$input->SetBody($body_name.$order['out_trade_no']);
		$input->SetAttach($body_name.$order['out_trade_no']);
		$input->SetOut_trade_no($order['out_trade_no']);
		$input->SetTotal_fee($order['price']*100);
		$input->SetTime_start(date("YmdHis"));
		$input->SetTime_expire(date("YmdHis", time() + 600));
		$input->SetGoods_tag("test");
		$input->SetNotify_url("/plus/carbuyaction.php?dopost=return&code=".$payment['code']);
		$input->SetTrade_type("NATIVE");
		$input->SetProduct_id($order['out_trade_no']);
		
		$result = $this->GetPayUrl($input,$payment);
		$url = $result["code_url"];
		$url = urlencode($url);
		$btn_name = "立即使用微信支付";
		
		//$btn_name = utf82gb($btn_name);
        //$button = '<div style="text-align:center"><input type="button" onclick="window.open(\'/member/weipay.php?url='.$url.'&out_trade_no='.$order['out_trade_no'].'\')" value="'.$btn_name.'"/></div>';
        $button = '/member/weipay.php?url='.$url.'&out_trade_no='.$order['out_trade_no'];
		/* 清空购物车 */
        require_once DEDEINC.'/shopcar.class.php';
        $cart     = new MemberShops();
        $cart->clearItem();
        $cart->MakeOrders();
		
		return $button;
	}
    
	/**
	 * 
	 * 生成直接支付url，支付url有效期为2小时,模式二
	 * @param UnifiedOrderInput $input
	 */
	public function GetPayUrl($input,$payment)
	{
		require_once(DEDEINC."/WxPay.Api.php");
		if($input->GetTrade_type() == "NATIVE")
		{
			$result = WxPayApi::unifiedOrder($input,$payment);
			return $result;
		}
	}
	
    /**
    * 响应操作
    */
    function respond()
    {
        /* 引入配置文件 */
		$code = preg_replace( "#[^0-9a-z-]#i", "", $_GET['code'] );
		require_once DEDEDATA.'/payment/'.$code.'.php';
		
        /* 取得订单号 */
        $order_sn = trim($_GET['out_trade_no']);
		$_GET['total_fee'] = $_GET['total_fee']/100;
        /*判断订单类型*/
        if(preg_match ("/S-P[0-9]+RN[0-9]/",$order_sn)) {
            //检查支付金额是否相符
            $row = $this->dsql->GetOne("SELECT * FROM #@__shops_orders WHERE oid = '{$order_sn}'");
            if ($row['priceCount'] != $_GET['total_fee'])
            {
                return $msg = "支付失败，支付金额与商品总价不相符!";
            }
            $this->mid = $row['userid'];
            $ordertype="goods";
        }else if (preg_match ("/M[0-9]+T[0-9]+RN[0-9]/", $order_sn)){
            $row = $this->dsql->GetOne("SELECT * FROM #@__member_operation WHERE buyid = '{$order_sn}'");
            //获取订单信息，检查订单的有效性
            if(!is_array($row)||$row['sta']==2) return $msg = "您的订单已经处理，请不要重复提交!";
            elseif($row['money'] != $_GET['total_fee']) return $msg = "支付失败，支付金额与商品总价不相符!";
            $ordertype = "member";
            $product =    $row['product'];
            $pname= $row['pname'];
            $pid=$row['pid'];
            $this->mid = $row['mid'];
        } else {    
            return $msg = "支付失败，您的订单号有问题！";
        }

        /* 检查数字签名是否正确 */
        ksort($_GET);
        reset($_GET);

		$input = new WxPayOrderQuery();
		$input->SetOut_trade_no($order_sn);
		$result = WxPayApi::orderQuery($input);
		
        if ($result['trade_state'] !== 'SUCCESS')
        {
            return $msg = "支付失败!";
        }
        if ($result['trade_state'] == 'SUCCESS')
        {
			//查询购买的用户
            $row = $this->dsql->GetOne("SELECT phone FROM #@__member WHERE mid = '{$this->mid}'");
            //查询接收短信手机号
            $res = $this->dsql->GetOne("SELECT value FROM #@__sysconfig WHERE aid = 765");
            //查询购买类型和价格
            $type = $this->dsql->GetOne("SELECT title,price FROM #@__shops_products WHERE oid = '{$order_sn}'");
            //订单成功短信提醒
            require_once dirname(__FILE__).'/../../plus/sendSMS/ChuanglanSmsHelper/ChuanglanSmsApi.php';
            $clapi  = new ChuanglanSmsApi();

            // 获取购买商品信息
            $uid = $row['phone'];
            //$tel = "13122707159";
            $trade_total = $type['title'];
            //设置您要发送的内容：其中“【】”中括号为运营商签名符号，多签名内容前置添加提交
            $msg = '用户 {$var}刚购买了"{$var}"服务总价 {$var}元。';
            $params = "{$res['value']},{$uid},{$trade_total},{$type['price']}";
            $result = $clapi->sendVariableSMS($msg, $params);
            if(!is_null(json_decode($result))){
                $output=json_decode($result,true);
                if(isset($output['code'])  && $output['code']=='0'){
                    header("location:/member/shops_orders.php");
                }else{
                    echo $output['errorMsg'];
                }
            }else{
                echo $result;
            }
        }

		if($ordertype=="goods"){ 
			if($this->success_db($order_sn))  return $msg = "支付成功!<br> <a href='/'>返回主页</a> <a href='/member'>会员中心</a>";
			else  return $msg = "支付失败！<br> <a href='/'>返回主页</a> <a href='/member'>会员中心</a>";
		} else if ( $ordertype=="member" ) {
			$oldinf = $this->success_mem($order_sn,$pname,$product,$pid);
			return $msg = "<font color='red'>".$oldinf."</font><br> <a href='/'>返回主页</a> <a href='/member'>会员中心</a>";
		}

    }

    /*处理物品交易*/
    function success_db($order_sn)
    {
        //获取订单信息，检查订单的有效性
        $row = $this->dsql->GetOne("SELECT state FROM #@__shops_orders WHERE oid='$order_sn' ");
        if($row['state'] > 0)
        {
            return TRUE;
        }    
        /* 改变订单状态_支付成功 */
        $sql = "UPDATE `#@__shops_orders` SET `state`='1' WHERE `oid`='$order_sn' AND `userid`='".$this->mid."'";
        if($this->dsql->ExecuteNoneQuery($sql))
        {
            $this->log_result("verify_success,订单号:".$order_sn); //将验证结果存入文件
            return TRUE;
        } else {
            $this->log_result ("verify_failed,订单号:".$order_sn);//将验证结果存入文件
            return FALSE;
        }
    }

    /*处理点卡，会员升级*/
    function success_mem($order_sn,$pname,$product,$pid)
    {
        //更新交易状态为已付款
        $sql = "UPDATE `#@__member_operation` SET `sta`='1' WHERE `buyid`='$order_sn' AND `mid`='".$this->mid."'";
        $this->dsql->ExecuteNoneQuery($sql);

        /* 改变点卡订单状态_支付成功 */
        if($product=="card")
        {
            $row = $this->dsql->GetOne("SELECT cardid FROM #@__moneycard_record WHERE ctid='$pid' AND isexp='0' ");;
            //如果找不到某种类型的卡，直接为用户增加金币
            if(!is_array($row))
            {
                $nrow = $this->dsql->GetOne("SELECT num FROM #@__moneycard_type WHERE pname = '{$pname}'");
                $dnum = $nrow['num'];
                $sql1 = "UPDATE `#@__member` SET `money`=money+'{$nrow['num']}' WHERE `mid`='".$this->mid."'";
                $oldinf ="已经充值了".$nrow['num']."金币到您的帐号！";
            } else {
                $cardid = $row['cardid'];
                $sql1=" UPDATE #@__moneycard_record SET uid='".$this->mid."',isexp='1',utime='".time()."' WHERE cardid='$cardid' ";
                $oldinf='您的充值密码是：<font color="green">'.$cardid.'</font>';
            }
            //更新交易状态为已关闭
            $sql2=" UPDATE #@__member_operation SET sta=2,oldinfo='$oldinf' WHERE buyid='$order_sn'";
            if($this->dsql->ExecuteNoneQuery($sql1) && $this->dsql->ExecuteNoneQuery($sql2))
            {
                $this->log_result("verify_success,订单号:".$order_sn); //将验证结果存入文件
                return $oldinf;
            } else {
                $this->log_result ("verify_failed,订单号:".$order_sn);//将验证结果存入文件
                return "支付失败！";
            }
        /* 改变会员订单状态_支付成功 */
        } else if ( $product=="member" ){
            $row = $this->dsql->GetOne("SELECT rank,exptime FROM #@__member_type WHERE aid='$pid' ");
            $rank = $row['rank'];
            $exptime = $row['exptime'];
            /*计算原来升级剩余的天数*/
            $rs = $this->dsql->GetOne("SELECT uptime,exptime FROM #@__member WHERE mid='".$this->mid."'");
            if($rs['uptime']!=0 && $rs['exptime']!=0 ) 
            {
                $nowtime = time();
                $mhasDay = $rs['exptime'] - ceil(($nowtime - $rs['uptime'])/3600/24) + 1;
                $mhasDay=($mhasDay>0)? $mhasDay : 0;
            }
            //获取会员默认级别的金币和积分数
            $memrank = $this->dsql->GetOne("SELECT money,scores FROM #@__arcrank WHERE rank='$rank'");
            //更新会员信息
            $sql1 =  " UPDATE #@__member SET rank='$rank',money=money+'{$memrank['money']}',
                       scores=scores+'{$memrank['scores']}',exptime='$exptime'+'$mhasDay',uptime='".time()."' 
                       WHERE mid='".$this->mid."'";
            //更新交易状态为已关闭
            $sql2=" UPDATE #@__member_operation SET sta='2',oldinfo='会员升级成功!' WHERE buyid='$order_sn' ";
            if($this->dsql->ExecuteNoneQuery($sql1) && $this->dsql->ExecuteNoneQuery($sql2))
            {
                $this->log_result("verify_success,订单号:".$order_sn); //将验证结果存入文件
                return "会员升级成功！";
            } else {
                $this->log_result ("verify_failed,订单号:".$order_sn);//将验证结果存入文件
                return "会员升级失败！";
            }
        }    
    }

    function  log_result($word) 
    {
        global $cfg_cmspath;
        $fp = fopen(dirname(__FILE__)."/../../data/payment/log.txt","a");
        flock($fp, LOCK_EX) ;
        fwrite($fp,$word.",执行日期:".strftime("%Y-%m-%d %H:%I:%S",time())."\r\n");
        flock($fp, LOCK_UN);
        fclose($fp);
    }
}//End API