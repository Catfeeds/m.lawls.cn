<?php
session_start();
/**
 * @version        $Id: index_do.php 1 8:24 2010年7月9日Z tianya $
 * @package        DedeCMS.Member
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require_once(dirname(__FILE__)."/config.php");
require_once DEDEINC.'/membermodel.cls.php';
if(empty($dopost)) $dopost = '';
if(empty($fmdo)) $fmdo = '';
/*********************
function login()
*******************/
if($fmdo=='login'){
	//短信登录
	if($dopost=="msglogin"){
		//短信验证
		if($phone ==""){
			ShowMsg("请输入手机号！","-1");
			exit();
        }
        function is_mobile( $text ) {
            $search = '/^0?1[3|4|5|6|7|8][0-9]\d{8}$/';
            if ( preg_match( $search, $text ) ) {
                return ( true );
            } else {
                return ( false );
            }
        }
        if(!is_mobile($phone))
        {
            ShowMsg('手机号格式不正确！','-1');
            exit();
        }
        $phone = trim($phone);
		$strphone = 'smsLoginCode_'.$phone;
		$smsCode = $_SESSION[$strphone];
		$userCode = trim($sms_code);
		if ($userCode =='' || $smsCode != $userCode) {
            ShowMsg("短信验证码错误，请重试！","-1");
            exit();
        }
		//验证手机号是否注册
		global $dsql;
		$chkphone = $dsql->GetOne("SELECT m.phone FROM #@__member AS m where m.phone='$phone'");
		if($chkphone['phone']==''){
            // 未注册，录入基本信息登录后完善信息
            if($cfg_mb_allowreg=='N'){
                ShowMsg('系统关闭了新用户注册，如是老用户请使用账号登录！', 'index.php');
                exit();
            }
            if($cfg_ml->IsLogin()){
                ShowMsg('你已经登陆系统，无需重新注册！', 'index.php');
                exit();
            }
            $jointime = time();
            $logintime = time();
            $joinip = GetIP();
            $loginip = GetIP();
            $mtype = "个人";
            $safeanswer = '';
            $dfmoney = 0;
            $email = '';
            $safequestion = '';
            $spaceSta = 0;
            $dfscores = 500;
            $inQuery = "INSERT INTO `#@__member` (`mtype` ,`userid` ,`pwd` ,`phone` ,`sex` ,`rank` ,`money` ,`email` ,`scores` ,`matt`, `spacesta` ,`face`,`safequestion`,`safeanswer` ,`jointime` ,`joinip` ,`logintime` ,`loginip` )VALUES ('$mtype','','','$phone','保密','10','$dfmoney','$email','$dfscores','0','$spaceSta','','$safequestion','$safeanswer','$jointime','$joinip','$logintime','$loginip'); ";
            if($dsql->ExecuteNoneQuery($inQuery)){
                $mid = $dsql->GetLastID();
                //写入默认会员详细资料
                if($mtype=='个人'){
                    $space='person';
                }else if($mtype=='企业'){
                    $space='company';
                }else{
                    $space='person';
                }
                //写入默认统计数据
                $membertjquery = "INSERT INTO `#@__member_tj` (`mid`,`article`,`album`,`archives`,`homecount`,`pagecount`,`feedback`,`friend`,`stow`) VALUES ('$mid','0','0','0','0','0','0','0','0'); ";
                $dsql->ExecuteNoneQuery($membertjquery);
                //写入默认空间配置数据
                $spacequery = "INSERT INTO `#@__member_space`(`mid` ,`pagesize` ,`matt` ,`spacename` ,`spacelogo` ,`spacestyle`, `sign` ,`spacenews`)VALUES('{$mid}','10','0','{$uname}的空间','','$space','',''); ";
                $dsql->ExecuteNoneQuery($spacequery);
                //写入其它默认数据
                $dsql->ExecuteNoneQuery("INSERT INTO `#@__member_flink`(mid,title,url) VALUES('$mid','法易通','http://www.lawls.cn/'); ");
                $membermodel = new membermodel($mtype);
                $modid=$membermodel->modid;
                $modid = empty($modid)? 0 : intval(preg_replace("/[^\d]/",'', $modid));
                $modelform = $dsql->getOne("SELECT * FROM #@__member_model WHERE id='$modid' ");
                if(!is_array($modelform))
                {
                    showmsg('模型表单不存在', '-1');
                    exit();
                }else{
                    $dsql->ExecuteNoneQuery("INSERT INTO `{$membermodel->table}` (`mid`) VALUES ('{$mid}');");
                }
            }
            // 清除会员缓存
            $cfg_ml->DelCache($cfg_ml->M_ID);
            //模拟登录
            $cfg_ml = new MemberLogin(7*3600);
            $rs = $cfg_ml->CheckPhoneLogin($phone);
			ShowMsg("登录成功，请立刻完善用户资料信息！","/member/edit_fullinfo.php");
			exit();
		}else{
            // 以前注册过
            //查询手机号的用户名
            $row = $dsql->GetOne("SELECT m.userid FROM #@__member AS m where m.phone='$phone'");
            $userid = $row['userid'];
            if(CheckUserID($userid,'',false)!='ok')
            {
                ResetVdValue();
                ShowMsg("你输入的用户名 {$userid} 不合法！","index.php");
                exit();
            }
            // 清除会员缓存
            $cfg_ml->DelCache($cfg_ml->M_ID);
            //模拟登录
            $cfg_ml = new MemberLogin(7*3600);
            $rs = $cfg_ml->CheckLogin($userid);
        }
		if(empty($gourl) || preg_match("#action|_do#i", $gourl))
		{
            header('Location:/');
			//ShowMsg("成功登录，5秒钟后转向上一页...","javascript:window.history.go(-2)",0,100);
		}
		else
		{
			$gourl = str_replace('^','&',$gourl);
			ShowMsg("成功登录，现在转向指定页面...",$gourl,0,2000);
		}
		exit();
	}
    //退出登录
    else if($dopost=="exit")
    {
        $cfg_ml->ExitCookie();
        #api{{
        if(defined('UC_API') && @include_once DEDEROOT.'/uc_client/client.php')
        {
            $ucsynlogin = uc_user_synlogout();
        }
        #/aip}}
        ShowMsg("成功退出登录！","/",0,1);
        exit();
    }
}
/*********************
function moodmsg()
*******************/
else if($fmdo=='moodmsg')
{
    //用户登录
    if($dopost=="sendmsg")
    {
        if(!empty($content))
        {
        $ip = GetIP();
        $dtime = time();
          $ischeck = ($cfg_mb_msgischeck == 'Y')? 0 : 1;
          if($cfg_soft_lang == 'gb2312')
          {
              $content = utf82gb(nl2br($content));
          } 
          $content = cn_substrR(HtmlReplace($content,1),360);
          //对表情进行解析
          $content = addslashes(preg_replace("/\[face:(\d{1,2})\]/is","<img src='".$cfg_memberurl."/templets/images/smiley/\\1.gif' style='cursor: pointer; position: relative;'>",$content));
          $content = RemoveXSS($content);
            $inquery = "INSERT INTO `#@__member_msg`(`mid`,`userid`,`ip`,`ischeck`,`dtime`, `msg`)
                   VALUES ('{$cfg_ml->M_ID}','{$cfg_ml->M_LoginID}','$ip','$ischeck','$dtime', '$content'); ";
            $rs = $dsql->ExecuteNoneQuery($inquery);
            if(!$rs)
            {
                $output['type'] = 'error';
                $output['data'] = '更新失败,请重试.';
                exit();
            }
            $output['type'] = 'success';
            if($cfg_soft_lang == 'gb2312')
            {
              $content = utf82gb(nl2br($content));
            } 
            $output['data'] = stripslashes($content);
            exit(json_encode($output));
        }
    }
}
else
{
    ShowMsg("本页面禁止返回!","index.php");
}