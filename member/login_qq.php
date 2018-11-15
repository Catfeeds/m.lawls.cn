<?php
/*********************************************************************************
 * QQ登陆文件
 *-------------------------------------------------------------------------------
 * 版权所有: CopyRight By yiqiu.org
 * 联系我们: yiqiustudio@gmail.com
 *-------------------------------------------------------------------------------
 * Author:亦秋_小新
 * Dtime:2013-4-7 14:02:41
***********************************************************************************/

require_once("../qqLogin/qqConnectAPI.php");
$qc = new QC();
$openid = $qc->keysArr['openid'];
$userinfo = $qc->get_user_info();
require_once(dirname(__FILE__)."/config.php");
if($cfg_soft_lang == 'gb2312')
{
	$userinfo['nickname'] = utf82gb($userinfo['nickname']);
	$userinfo['gender'] = utf82gb($userinfo['gender']);
}
$appid = substr($openid,2,8);
$userid = $appid;
$uname = "Q".substr(md5($userid),0,8);
if($cfg_ml->IsLogin())
{
    ShowMsg('你已经登陆系统，无需重新注册！', 'index.php');
    exit();
}
$memInfo = $dsql->GetOne("SELECT * FROM #@__member WHERE `userid` = '{$userid}'");
$jointime = time();
$logintime = time();
$joinip = GetIP();
$loginip = GetIP();
if(empty($memInfo))
{
	$inQuery = "INSERT INTO `#@__member` (`mtype` ,`userid` ,`uname`  ,`rank` ,
        `matt` ,`face`,`jointime` ,`joinip` ,`logintime` ,`loginip` )
       VALUES ('个人','$userid','$userinfo[nickname]','10','0','$userinfo[figureurl_1]','$jointime','$joinip','$logintime','$loginip'); "; 
     if($dsql->ExecuteNoneQuery($inQuery))
     {
            $mid = $dsql->GetLastID();
            $cfg_ml->PutLoginInfo($mid);
            $cfg_ml->DelCache($mid);
            ShowMsg("成功登录，5秒钟后转向系统主页...","index.php",0,2000);
            exit;
      }
}else{
	$cfg_ml->PutLoginInfo($memInfo['mid']);
    $cfg_ml->DelCache($cfg_ml->M_ID);
    ShowMsg("成功登录，5秒钟后转向系统主页...","index.php",0,2000);
    exit;
}


