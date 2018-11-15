<?php
/*********************************************************************************
 * QQ登陆接口核心文件
 *-------------------------------------------------------------------------------
 * 版权所有: CopyRight By yiqiu.org
 * 联系我们: yiqiustudio@gmail.com
 *-------------------------------------------------------------------------------
 * Author:亦秋_小新
 * Dtime:2012-5-12 14:02:41
***********************************************************************************/
class AppClass 
{
    
    public function setting()
    {
    	global $cfg_basehost,$cfg_version,$cfg_soft_lang;
        CheckPurview('plus_广告管理');
        $json_info = file_get_contents(dirname(__file__)."/../../qqLogin/comm/inc.php");
        $keyarr = json_decode($json_info);
        include DedeInclude('templets/qqlogin_setting.htm');
    }
    
    public function save()
    {
        $appid = trim($this->Gpc('appid'));
        $appkey = trim($this->Gpc('appkey'));
        $callurl = trim($this->Gpc('callurl'));
        $keyinfo = array(
            appid => $appid,
            appkey => $appkey,
            callback => $callurl
        );
        $keyinfo = json_encode($keyinfo);
        if(empty($appid))
        {
            ShowMsg("APPID不能为空",'-1');
            exit();
        }
        
        if(empty($appkey))
        {
            ShowMsg("APPKEY不能为空",-1);
            exit();
        }
        
        if(empty($callurl))
        {
            ShowMsg("回调地址不能为空",-1);
            exit();
        }
        
        $filepath = dirname(__file__).'/../../qqLogin/comm/inc.php';
        file_put_contents($filepath,$keyinfo);
        ShowMsg("配置文件保存成功","?ac=setting");
        
    }
    
    public function ajax()
	{
        $v = $this->Gpc('v');
        $filepath = dirname(__file__).'/../../qqLogin/data/demo.txt';
        file_put_contents($filepath,$v);
    }

	public function get()
	{
    	$filepath = dirname(__file__).'/../../qqLogin/data/demo.txt';
        $content = file_get_contents($filepath);
        echo $content;
    }    
    
	function Gpc($key,$defaultvalue='',$method='REQUEST')
	{
    	global $_POST,$_GET,$_REQUEST;
    	$method = strtoupper($method);
    	switch($method) {
        	case 'GET': $var = &$_GET; break;
        	case 'POST': $var = &$_POST; break;
        	case 'COOKIE': $var = &$_COOKIE; break;
        	case 'REQUEST': $var = &$_REQUEST; break;
    	}
    	return isset($var[$key])?$var[$key]:$defaultvalue;
	}
}