<?php
/**
 * 织梦猫评论助手
 * User: dedemao
 * 发布时间: 2018年5月27日20:42:27
 * 最后修改: 2018年6月21日20:22:30
 */
$ver='1.0';
session_cache_limiter('private,must-revalidate');
require_once(dirname(__FILE__)."/config.php");
$apiDomain = 'https://api.dedemao.com';
$protocol = getHttpProtocol();
helper('comment');
if(empty($dopost)) $dopost = "";

$configfile = DEDEDATA.'/config.cache.inc.php';
//更新配置函数
function ReWriteConfig()
{
    global $dsql,$configfile;
    if(!is_writeable($configfile))
    {
        echo "配置文件'{$configfile}'不支持写入，无法修改系统配置参数！";
        exit();
    }
    $fp = fopen($configfile,'w');
    flock($fp,3);
    fwrite($fp,"<"."?php\r\n");
    $dsql->SetQuery("SELECT `varname`,`type`,`value`,`groupid` FROM `#@__sysconfig` ORDER BY aid ASC ");
    $dsql->Execute();
    while($row = $dsql->GetArray())
    {
        if($row['type']=='number')
        {
            if($row['value']=='') $row['value'] = 0;
            fwrite($fp,"\${$row['varname']} = ".$row['value'].";\r\n");
        }
        else
        {
            fwrite($fp,"\${$row['varname']} = '".str_replace("'",'',$row['value'])."';\r\n");
        }
    }
    fwrite($fp,"?".">");
    fclose($fp);
}

function getRandString()
{
    $str = strtoupper(md5(uniqid(md5(microtime(true)),true)));
    return substr($str,0,8).'-'.substr($str,8,4).'-'.substr($str,12,4).'-'.substr($str,16,4).'-'.substr($str,20);
}
function getHttpProtocol() {
    $protocol = 'http';
    if ( !empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off') {
        $protocol='https';
    } elseif ( isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https' ) {
        $protocol='https';
    } elseif ( !empty($_SERVER['HTTP_FRONT_END_HTTPS']) && strtolower($_SERVER['HTTP_FRONT_END_HTTPS']) !== 'off') {
        $protocol='https';
    }
    return $protocol;
}
function setCache()
{
    global $cfg_version,$ver;
    $first_use = false;
    $use_time = date('Y-m-d');
    $txt = DEDEDATA.'/module/dedemao_comment.txt';
    if(!file_exists($txt))
    {
        $id = getRandString();
        $first_use = true;
        $fp = fopen($txt,'w');
        $tData['id'] = $id;
        $tData['time'] = $use_time;
        $tData['ver'] = $ver;
        fwrite($fp,serialize($tData));
        fclose($fp);
    }else{
        $fp = fopen($txt,'r');
        $content = fread($fp, filesize($txt));
        fclose($fp);
        $content = unserialize($content);
        $id = $content['id'];
        $use_time = $content['time'];
        $tData['id'] = $id;
        $tData['time'] = date('Y-m-d');
        $tData['ver'] = $ver;
        $fp = fopen($txt,'w');
        fwrite($fp,serialize($tData));
        fclose($fp);
    }
    if($first_use || $use_time!=date('Y-m-d')){
        echo '<script>
                var _hmt = _hmt || [];
                (function() {
                    var hm = document.createElement("script");
                    hm.src = "//www.dedemao.com/api/stat.php?id='.$id.'&v='.$cfg_version.'&subject=comment";
                    var s = document.getElementsByTagName("script")[0];
                    s.parentNode.insertBefore(hm, s);
                })();
            </script>';
    }
}
function gbk2utf8($str)
{
    global $cfg_soft_lang;
    if($cfg_soft_lang != 'utf-8'){
        return gb2utf8($str);
    }
    return $str;
}
function utf82gbk($str)
{
    global $cfg_soft_lang;
    if($cfg_soft_lang != 'utf-8'){
        return utf82gb($str);
    }
    return $str;
}
function curlPost($url, $POSTFIELDS=null,$resultType='array') {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);

    if($POSTFIELDS){
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $POSTFIELDS);
    }

    $response = curl_exec ($ch);
    curl_close ($ch);

    if(empty($response)){
        return '-100000';
    }
    return $resultType=='array' ? json_decode($response,true) : $response;
}
//保存配置的改动
if($dopost=="save")
{
    $info = $_POST['info'];
    $data = $_POST['basic'];
    foreach($data as $k=>$v)
    {
        $row = $dsql->GetOne("SELECT varname FROM `#@__sysconfig` WHERE varname LIKE '$k' ");
        if(is_array($row))
        {
            //存在就更新
            $dsql->ExecuteNoneQuery("UPDATE `#@__sysconfig` SET `value`='$v' WHERE varname='$k' ");
        }else{
            $row = $dsql->GetOne("SELECT aid FROM `#@__sysconfig` ORDER BY aid DESC ");
            $aid = $row['aid'] + 1;
            $inquery = "INSERT INTO `#@__sysconfig`(`aid`,`varname`,`info`,`value`,`type`,`groupid`)
VALUES ('$aid','$k','{$info[$k]}','$v','string','8')";
            $rs = $dsql->ExecuteNoneQuery($inquery);
            if(!$rs)
            {
                ShowMsg("有非法字符！");
                exit();
            }
            if(!is_writeable($configfile))
            {
                ShowMsg("成功保存，但由于 $configfile 无法写入，因此不能更新配置文件！");
                exit();
            }
        }

    }
    ReWriteConfig();
    //在模板中增加标记
    ShowMsg("成功更改配置！", "comment.php");
    exit();
}
function checkFeedbackTable()
{
    global $dsql;
    $dsql->GetTableFields('#@__feedback');
    $fields = array();
    while($r=$dsql->GetFieldObject()){
        $fields[] = $r->name;
    }
    if(in_array('pid',$fields)===false){
        $dsql->ExecNoneQuery("ALTER TABLE `#@__feedback` ADD COLUMN `pid` int UNSIGNED NULL DEFAULT 0 COMMENT '回复的id' AFTER `aid`");
        $dsql->ExecNoneQuery("ALTER TABLE `#@__member` MODIFY COLUMN `face`  varchar(200) NOT NULL DEFAULT '' AFTER `spacesta`");
    }
    if(in_array('avatar',$fields)===false){
        $dsql->ExecNoneQuery("ALTER TABLE `#@__feedback` MODIFY COLUMN `face`  varchar(200) NOT NULL DEFAULT '0' AFTER `ftype`");
    }
    if(in_array('ipinfo',$fields)===false){
        $dsql->ExecNoneQuery("ALTER TABLE `#@__feedback` ADD COLUMN `ipinfo`  varchar(50) NULL AFTER `ip`;");
    }

}

function curlGet($url = '', $options = array())
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    if (!empty($options)) {
        curl_setopt_array($ch, $options);
    }
    //https请求 不验证证书和host
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    $data = curl_exec($ch);
    if($data === false)
    {
        echo 'Curl error: ' . curl_error($ch);exit();
    }
    curl_close($ch);
    return $data;
}

function initConfig()
{
	global $comment_pagesize,$dsql,$configfile;
	if(!$comment_pagesize){
		$info['comment_pagesize'] = '每页显示多少条评论';
		$data['comment_pagesize'] = 5;
		$info['comment_tips'] = '评论框默认提示语';
		$data['comment_tips'] = '说点什么吧';
		$info['show_floor'] = '是否显示楼层';
		$data['show_floor'] = 1;
		foreach($data as $k=>$v)
		{
			$row = $dsql->GetOne("SELECT varname FROM `#@__sysconfig` WHERE varname LIKE '$k' ");
			if(is_array($row))
			{
				//存在就更新
				$dsql->ExecuteNoneQuery("UPDATE `#@__sysconfig` SET `value`='$v' WHERE varname='$k' ");
			}else{
				$row = $dsql->GetOne("SELECT aid FROM `#@__sysconfig` ORDER BY aid DESC ");
				$aid = $row['aid'] + 1;
				$inquery = "INSERT INTO `#@__sysconfig`(`aid`,`varname`,`info`,`value`,`type`,`groupid`)
		VALUES ('$aid','$k','{$info[$k]}','$v','string','8')";
				$rs = $dsql->ExecuteNoneQuery($inquery);
				if(!$rs)
				{
					ShowMsg("有非法字符！");
					exit();
				}
				if(!is_writeable($configfile))
				{
					ShowMsg("成功保存，但由于 $configfile 无法写入，因此不能更新配置文件！");
					exit();
				}
			}

		}
		ReWriteConfig();	
	}

}
$protocol = getHttpProtocol();
checkFeedbackTable();

$dsql->SetQuery("Select * From `#@__sysconfig` where groupid = 8 order by aid asc");
$dsql->Execute();
$i = 1;
$data = array();
while($row = $dsql->GetArray()) {
    $data[$row['varname']] = $row['value'];
    $i++;
}
$data['comment_pagesize'] = $data['comment_pagesize'] ? $data['comment_pagesize'] : 5;
$data['showZan'] = $data['showZan'] ? $data['showZan'] : 3;
$data['showQQ'] = $data['showQQ'] ? $data['showQQ'] : 1;
$data['comment_basecolor'] = $data['comment_basecolor'] ? $data['comment_basecolor'] : '#39a7e4';
$data['comment_tips'] = $data['comment_tips'] ? $data['comment_tips'] : '说点什么吧';
$data['comment_ipaddr'] = $data['comment_ipaddr'] ? $data['comment_ipaddr'] : 1;
initConfig();
include DedeInclude('templets/comment.htm');
setCache();

