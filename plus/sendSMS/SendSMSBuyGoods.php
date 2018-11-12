<?php
header("Content-type:text/html; charset=UTF-8");
/* *
 * 功能：创蓝发送变量短信
 * 版本：1.3
 * 日期：2018-08-20
 */
require_once 'ChuanglanSmsHelper/ChuanglanSmsApi.php';
$clapi  = new ChuanglanSmsApi();
// 获取购买商品信息
$uid = $_POST['uid'];
$tel = "13122707159";
$trade_total = $_POST['trade_total'];
//设置您要发送的内容：其中“【】”中括号为运营商签名符号，多签名内容前置添加提交
$msg = '【成都木子木科技公司】，易法通用户 {$var}刚购买了网站服务总价为 {$var}元。';
$params = "{$tel},{$uid},{$trade_total}";
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