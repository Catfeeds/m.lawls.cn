<?php
session_start();
header("Content-type:text/html; charset=UTF-8");
/* *
 * 功能：创蓝发送变量短信
 * 版本：1.3
 * 日期：2018-08-20
 */
require_once 'ChuanglanSmsHelper/ChuanglanSmsApi.php';
$clapi  = new ChuanglanSmsApi();
// 获取注册信息
//$name = $_POST['userid'];
$phone = $_POST['phone'];
$sessionName = 'smsLoginCode_'.$phone;
$code = rand(100000,999999);
/* 设置短信验证session 60秒超时*/
$lifetime = 60;
setcookie(session_name(),session_id(),time()+$lifetime,'/');
if (!isset($_SESSION[$sessionName])) {
    $_SESSION[$sessionName] = $code;
}
$smsCode = isset($_SESSION[$sessionName]) ? $_SESSION[$sessionName] : '';
//设置您要发送的内容：其中“【】”中括号为运营商签名符号，多签名内容前置添加提交
$msg = '尊敬的用户，您本次的登录验证码为{$var}有效期{$var}秒。';
$params = "{$phone},{$smsCode},{$lifetime}";
$result = $clapi->sendVariableSMS($msg, $params);
if(!is_null(json_decode($result))){
	$output=json_decode($result,true);
	if(isset($output['code'])  && $output['code']=='0'){
		echo "success";
	}else{
		echo $output['errorMsg'];
	}
}else{
	echo $result;
}