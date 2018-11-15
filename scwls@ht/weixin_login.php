<?php
/**
 * 织梦微信登录插件1.0
 * Created by PhpStorm.
 * User: dedemao
 * Date: 2017年10月08日
 * Time: 16:20:45
 */
session_cache_limiter('private,must-revalidate');
require_once(dirname(__FILE__)."/config.php");
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
function setCache()
{
    global $cfg_version;
    $first_use = false;
    $use_time = date('Y-m-d');
    $txt = DEDEDATA.'/module/weixin_login.txt';
    if(!file_exists($txt))
    {
        $id = getRandString();
        $first_use = true;
        $fp = fopen($txt,'w');
        $tData['id'] = $id;
        $tData['time'] = $use_time;
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
        $fp = fopen($txt,'w');
        fwrite($fp,serialize($tData));
        fclose($fp);
    }
    if($first_use || $use_time!=date('Y-m-d')){
        echo '<script>
                var _hmt = _hmt || [];
                (function() {
                    var hm = document.createElement("script");
                    hm.src = "//www.dedemao.com/api/stat.php?id='.$id.'&v='.$cfg_version.'&subject=weixin_login";
                    var s = document.getElementsByTagName("script")[0];
                    s.parentNode.insertBefore(hm, s);
                })();
            </script>';
    }
}
function updateTemplate()
{
    global $wxkf_appid,$cfg_basehost;
    $memberPath = DEDEMEMBER;
    if(file_exists($memberPath.'/templets/login.htm')){
        $content = file_get_contents($memberPath.'/templets/login.htm');
        if(strstr($content,'open.weixin')===false && strstr($content,'<a href="resetpassword.php">忘记密码？</a>')!==false){
            $content = str_replace('<a href="resetpassword.php">忘记密码？</a>','<button onclick="location.href=\'https://open.weixin.qq.com/connect/qrconnect?appid='.$wxkf_appid.'&redirect_uri='.$cfg_basehost.'/plus/wx_login.php&response_type=code&scope=snsapi_login&state=123#wechat_redirect\'" style="background-color: #3eb94e;color:#fff;padding:10px;padding: 0 5px;" type="button">微信登录</button><a href="resetpassword.php">忘记密码？</a>',$content);
            file_put_contents($memberPath.'/templets/login.htm',$content);
        }
    }
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
    //更新tag
    updateTemplate();
    //在模板中增加标记
    ShowMsg("成功更改配置！", "weixin_login.php");
    exit();
}
$dsql->SetQuery("Select * From `#@__sysconfig` where groupid='8' order by aid asc");
$dsql->Execute();
$i = 1;
$data = array();
while($row = $dsql->GetArray()) {
    $data[$row['varname']] = $row['value'];
    $i++;
}

include DedeInclude('templets/weixin_login.htm');
setCache();

