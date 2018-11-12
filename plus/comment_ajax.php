<?php

/**

 * 织梦猫评论助手

 *

 * @version        1.0

 * @link           https://www.dedemao.com

 * @time            2018年5月27日20:29:36

 *

 */

require_once(dirname(__FILE__).'/../include/common.inc.php');

require_once(DEDEINC.'/channelunit.func.php');

AjaxHead();

if($cfg_feedback_forbid=='Y'){

    $data['code'] = 0;

    $data['data'] = gbk2utf8('系统已经禁止评论功能！');

    echo json_encode($data);exit();

}



$aid = intval($aid);

helper('comment');

include_once(DEDEINC.'/memberlogin.class.php');

$cfg_ml = new MemberLogin();



if(empty($dopost)) $dopost = '';

if($dopost=='getlist')

{

    if(!$aid) return;

    $aid = intval($aid);

    $start = intval($start);

    $limit = intval($limit);

    $orderWay = $orderWay ? $orderWay : 'DESC';

    $comments = getChildData($aid,$start,$limit,$orderWay);

    $html = "";

    //评论总条数

    $data['count'] = getTotalCount($aid);

    $pagehtml = '';

    if(($start+$limit)<$data['count']){

        //分页html

        $pagehtml = "<div node-type=\"cmt-more\" class=\"cmt-more-wrap-gw\" onclick='get_ajax_comment({$aid},".($start+$limit).",{$limit})'>查看更多<span class=\"more-arrow-ico\"></span></div>";

    }

    foreach ($comments as $comment){

        $floorHtml = $show_floor==1 ? '<strong class="p_floor">'.$comment['floor'].'楼</strong>' : '';

        $ipinfo = $comment_ipaddr==1 ? $comment['ipinfo'].'网友' : '';

        $html .="<li class='entry'><div class='adiv'><div><img class='headerimage' src='{$comment['d_headpic']}'></div></div><div><div class='info rmp'>{$floorHtml}<div class='nmp'><span class='nick'>{$comment['username']}</span><span class='posandtime'>{$ipinfo}&nbsp;{$comment['date']}</span></div></div><div class='comm'><p>{$comment['content']}</p></div><div class='zhiChi'><span class='comm_reply'>";

        if ($showZan==3 || $showZan==1){

            $html.="<a class='s' href='javascript:commentVote(\"goodfb\",{$comment['id']})'>支持(<span id='goodfb{$comment['id']}'>{$comment['good']}</span>)</a>";

        }

        if ($showZan==3 || $showZan==2){

            $html.="<a class='a' href='javascript:commentVote(\"badfb\",{$comment['id']})'>反对(<span id='badfb{$comment['id']}'>{$comment['bad']}</span>)</a>";

        }

        $html.="<a href='javascript:;' aid='{$comment['aid']}' pid='{$comment['id']}' username='{$comment['username']}' onclick='reply(this)'>回复</a></span></div>";

        if($comment['child']){

            $html .="<ul class='reply'>";

        }

        $i=0;

        foreach ($comment['child'] as $child){

            $ipinfo = $comment_ipaddr==1 ? $child['ipinfo'].'网友' : '';

            $html .="<li class='gh'><div class='adiv'><div><img class='headerimage'  src='{$child['d_headpic']}'></a></div></div><div><div class='re_info rmp rmpvipblue'><strong class='p_floor'>".++$i."#</strong><div class='nmp'><span class='nick'>{$child['username']}</span><span class='posandtime'>{$ipinfo}&nbsp;{$child['date']}</span></div></div><div class='re_comm'><p>{$child['content']}</p><div class='zhiChi'><span class='comm_reply'>";

            if ($showZan==3 || $showZan==1){

                $html.="<a class='s' href='javascript:commentVote(\"goodfb\",{$child['id']})'>支持(<span id='goodfb{$child['id']}'>{$child['good']}</span>)</a>";

            }

            if ($showZan==3 || $showZan==2){

                $html.="<a class='a' href='javascript:commentVote(\"badfb\",{$child['id']})'>反对(<span id='badfb{$child['id']}'>{$child['bad']}</span>)</a>";

            }

            $html.="<a href='javascript:;' aid='{$child['aid']}' pid='{$child['id']}' username='{$child['username']}' onclick='reply(this)'>回复</a></span></div></div></div></li>";

        }

        if($comment['child']){

            $html .="</ul>";

        }

        $html.="</div></li>";

    }

    $data['html'] = gbk2utf8($html);

    $data['page'] = gbk2utf8($pagehtml);

    echo json_encode($data);die;

}

else if($dopost=='send')

{

    require_once(DEDEINC.'/charset.func.php');

    /*if(empty($aid)) {

        $data['code'] = 0;

        $data['data'] = gbk2utf8('没指定评论文档的ID，不能进行操作！');

        echo json_encode($data);exit();

    }

    $arcRow = GetOneArchive($aid);

    if(empty($arcRow['aid']))

    {

        $data['code'] = 0;

        $data['data'] = gbk2utf8('无法查看未知文档的评论！');

        echo json_encode($data);exit();

    }*/

    if(isset($arcRow['notpost']) && $arcRow['notpost']==1)

    {

        $data['code'] = 0;

        $data['data'] = gbk2utf8('这篇文档禁止评论！');

        echo json_encode($data);exit();

    }

	

	$content = utf82gbk($content);

	if(!empty($username)) $username = utf82gbk($username);





    $content=trim(strip_tags($content,'<img>'));

    $content=htmlspecialchars($content,ENT_QUOTES);

    //非法内容

    if(strstr($content,"//")!==false){

        $data['code'] = 0;

        $data['data'] = gbk2utf8('非法内容！');

        echo json_encode($data);exit();

    }

    //限制评论字数

    if(strlen($content)<10){

        $data['code'] = 0;

        $data['data'] = gbk2utf8('您的评论内容太短！');

        echo json_encode($data);exit();

    }

    if(strlen($content)>500) {

        //超过500个字的评论大多是垃圾评论

        $data['code'] = 0;

        $data['data'] = gbk2utf8('您的评论内容太长，请删除部分之后再提交！');

        echo json_encode($data);exit();

    }

    //垃圾评论过滤，其他过滤规则可以自行增加正则表达式来实现

    $pattern1 = "/\d{7,}/i";   //连续7个以上数字，过滤发Q号和Q群的评论

    $pattern2 = "/(\d.*){7,}/i";   //非连续的7个以上数字，过滤用字符间隔开的Q号和Q群的评论

    $pattern3 = "/\u52A0.*\u7FA4/i";   //包含“加群”两字的通常是发Q群的垃圾评论

    $pattern4 = "^([hH][tT]{2}[pP]:\/\/|[hH][tT]{2}[pP][sS]:\/\/)(([A-Za-z0-9-~]+)\.)+([A-Za-z0-9-~\/])+$/";   //过滤网址

    if(preg_match($pattern1,$content) || preg_match($pattern2,$content) || preg_match($pattern3,$content) || preg_match($pattern4,$content)){

        $data['code'] = 0;

        $data['data'] = gbk2utf8('请不要发表灌水、广告、违法、Q群Q号等信息，感谢您的配合！');

        echo json_encode($data);exit();

    }

    //评论间隔时间

    if($_SESSION['comment_time'] && (time()-$_SESSION['comment_time'])<30){

        $data['code'] = 0;

        $data['data'] = gbk2utf8('评论太快了！请休息一会吧~');

        echo json_encode($data);exit();

    }



    //评论次数

    if($_SESSION['comment_count'] && ($_SESSION['comment_count']>5)){

        $data['code'] = 0;

        $data['data'] = gbk2utf8('今日可用评论数量已用完，明天再来评论吧~');

        echo json_encode($data);exit();

    }



    //检查用户

    $username = empty($username) ? '游客' : $username;

    if($cfg_ml->M_ID > 0)

    {

        $username = $cfg_ml->M_Phone;

    }else{

        $username = $email;

    }



    if(empty($username) && empty($email)){

        $data['code'] = 0;

        $data['data'] = gbk2utf8('请登录或填写email地址！');

        echo json_encode($data);exit();

    }



    //检查email地址是否合法

    if($email){

        $pattern1email = '/^\w+(-+.\w+)*@\w+(-.\w+)*\.\w+(-.\w+)*$/';

        if(!preg_match($pattern1email,$email)){

            $data['code'] = 0;

            $data['data'] = gbk2utf8('email地址不合法！');

            echo json_encode($data);exit();

        }

    }



    //词汇过滤检查

    if( $cfg_notallowstr != '' )

    {

        if(preg_match("#".$cfg_notallowstr."#i", $content))

        {

            $data['code'] = 0;

            $data['data'] = gbk2utf8('评论内容含有禁用词汇！');

            echo json_encode($data);exit();

        }

    }

    if( $cfg_replacestr != '' )

    {

        $content = preg_replace("#".$cfg_replacestr."#i", '***', $content);

    }

    if( empty($content) )

    {

        $data['code'] = 0;

        $data['data'] = gbk2utf8('评论内容可能不合法或为空！');

        echo json_encode($data);exit();

    }

	if($cfg_feedback_guest == 'N' && $cfg_ml->M_ID < 1)

	{

        $data['code'] = 0;

        $data['data'] = gbk2utf8('管理员禁用了游客评论！<a href="'.$cfg_cmspath.'/member/login.php">点击登录</a>');

        echo json_encode($data);exit();

	}



    //检查评论间隔时间

    $ip = GetIP();

    $dtime = time();

    if(!empty($cfg_feedback_time))

    {

        //检查最后发表评论时间，如果未登陆判断当前IP最后评论时间

        $where = ($cfg_ml->M_ID > 0 ? "WHERE `mid` = '$cfg_ml->M_ID' " : "WHERE `ip` = '$ip' ");

        $row = $dsql->GetOne("SELECT dtime FROM `#@__feedback` $where ORDER BY `id` DESC ");

        if(is_array($row) && $dtime - $row['dtime'] < $cfg_feedback_time)

        {

            ResetVdValue();

            $data['code'] = 0;

            $data['data'] = gbk2utf8('请稍等休息一下！');

            echo json_encode($data);exit();

        }

    }

    $face = $cfg_ml->M_Face ? $cfg_ml->M_Face : $GLOBALS['cfg_phpurl'].'/dedemao-comment/img/default_head_img.gif';

    extract($arcRow, EXTR_SKIP);

    $username = cn_substrR(HtmlReplace($username,2), 20);

    if(empty($feedbacktype) || ($feedbacktype!='good' && $feedbacktype!='bad'))

    {

        $feedbacktype = 'feedback';

    }

    //保存评论内容

    $ischeck = ($cfg_feedbackcheck=='Y' ? 0 : 1);

    $arctitle = addslashes(RemoveXSS($title));

    $typeid = intval($typeid);

    $pid = intval($pid);

    $feedbacktype = preg_replace("#[^0-9a-z]#i", "", $feedbacktype);

    $ipinfo = getIpInfo($ip);

    $inquery = "INSERT INTO `#@__feedback`(`aid`,`typeid`,`username`,`arctitle`,`ip`,`ipinfo`,`ischeck`,`dtime`, `mid`,`bad`,`good`,`ftype`,`face`,`msg`,`pid`)

                   VALUES ('$aid','$typeid','$username','$arctitle','$ip','$ipinfo','$ischeck','$dtime', '{$cfg_ml->M_ID}','0','0','$feedbacktype','$face','$content','{$pid}'); ";

    $rs = $dsql->ExecuteNoneQuery($inquery);

    if( !$rs )

    {

        $data['code'] = 0;

        $data['data'] = gbk2utf8('发表评论出错了！');

        echo json_encode($data);exit();

    }

    if($GLOBALS['comment_inform']==1){

        sendMailToManager($GLOBALS['comment_email'],$aid,$content);

    }

    $_SESSION['comment_time'] = time(); //保存评论时间

    $comment_count = $_SESSION['comment_count'] ? $_SESSION['comment_count']  : 0;      //评论次数

    $_SESSION['comment_count'] = ($comment_count+1);



    $newid = $dsql->GetLastID();

  //给文章评分

    if($feedbacktype=='bad')

    {

        $dsql->ExecuteNoneQuery("UPDATE `#@__archives` SET scores=scores-{cfg_feedback_sub},badpost=badpost+1,lastpost='$dtime' WHERE id='$aid' ");

    }

    else if($feedbacktype=='good')

    {

        $dsql->ExecuteNoneQuery("UPDATE `#@__archives` SET scores=scores+{$cfg_feedback_add},goodpost=goodpost+1,lastpost='$dtime' WHERE id='$aid' ");

    }

    else

    {

        $dsql->ExecuteNoneQuery("UPDATE `#@__archives` SET scores=scores+1,lastpost='$dtime' WHERE id='$aid' ");

    }

    //给用户增加积分

    if($cfg_ml->M_ID > 0)

    {

        #api{{

        if(defined('UC_API') && @include_once DEDEROOT.'/api/uc.func.php')

        {

            //同步积分

            uc_credit_note($cfg_ml->M_LoginID, $cfg_sendfb_scores);

            

            //推送事件

            $arcRow = GetOneArchive($aid);

            $feed['icon'] = 'thread';

            $feed['title_template'] = '<b>{username} 在网站发表了评论</b>';

            $feed['title_data'] = array('username' => $cfg_ml->M_UserName);

            $feed['body_template'] = '<b>{subject}</b><br>{message}';

            $url = !strstr($arcRow['arcurl'],'http://') ? ($cfg_basehost.$arcRow['arcurl']) : $arcRow['arcurl'];        

            $feed['body_data'] = array('subject' => "<a href=\"".$url."\">$arcRow[arctitle]</a>", 'message' => cn_substr(strip_tags(preg_replace("/\[.+?\]/is", '', $content)), 150));

            $feed['images'][] = array('url' => $cfg_basehost.'/images/scores.gif', 'link'=> $cfg_basehost);

            uc_feed_note($cfg_ml->M_LoginID,$feed); unset($arcRow);

        }

        #/aip}}

        $dsql->ExecuteNoneQuery("UPDATE `#@__member` set scores=scores+{$cfg_sendfb_scores} WHERE mid='{$cfg_ml->M_ID}' ");

        $row = $dsql->GetOne("SELECT COUNT(*) AS nums FROM `#@__feedback` WHERE `mid`='".$cfg_ml->M_ID."'");

        $dsql->ExecuteNoneQuery("UPDATE `#@__member_tj` SET `feedback`='$row[nums]' WHERE `mid`='".$cfg_ml->M_ID."'");

    }

    $_SESSION['sedtime'] = time();

    if($ischeck==0)

    {

        $data['code'] = 0;

        $data['data'] = gbk2utf8('成功发表评论，但需审核后才会显示!');

        echo json_encode($data);exit();

    }

    else {

        $headpic = $GLOBALS['cfg_phpurl'].'/dedemao-comment/img/default_head_img.gif';

        $row = $dsql->GetOne("SELECT face,sex FROM `#@__member` WHERE mid={$cfg_ml->M_ID} ");

        if (!empty($row['face'])) {

            $headpic = $row['face'];

        }



        $data['code'] = $newid;

        $data['data'] = gbk2utf8('评论成功');

        $data['headpic'] = $headpic;

        $data['nickName'] = gbk2utf8($username);

        $data['ipinfo'] = gbk2utf8($ipinfo);

        $c=$dsql->GetOne("SELECT count(*) c FROM `#@__feedback` WHERE id <= {$newid} AND pid = 0");

        $data['floor'] = $c['c'];

        $data['date'] = date('Y-m-d H:i:s');

        $data['content'] = gbk2utf8(stripslashes(htmlspecialchars_decode($content, ENT_QUOTES)));

        echo json_encode($data);

        exit();

    }

}else if($action=='goodfb')

{

    $fid = intval($fid);

    $dsql->ExecuteNoneQuery("UPDATE `#@__feedback` SET good = good+1 WHERE id='$fid' ");

    $row = $dsql->GetOne("SELECT good FROM `#@__feedback` WHERE id='$fid' ");

    $data['code'] = 0;

    $data['data'] = $row['good'];

    echo json_encode($data);

    exit();

}

else if($action=='badfb')

{

    AjaxHead();

    $fid = intval($fid);

    $dsql->ExecuteNoneQuery("UPDATE `#@__feedback` SET bad = bad+1 WHERE id='$fid' ");

    $row = $dsql->GetOne("SELECT bad FROM `#@__feedback` WHERE id='$fid' ");

    $data['code'] = 0;

    $data['data'] = $row['bad'];

    echo json_encode($data);

    exit();

}

else if($action=='getHeadPic')

{

    if($cfg_ml->M_Face){

        $data['code'] = 0;

        $data['data'] = $cfg_ml->M_Face;

    }else{

        $data['code'] = 1;

    }

    echo json_encode($data);exit();

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

/**

 * 传递文章id获取树状结构的评论

 * @param  int $aid 文章id

 * @return array    树状结构数组

 */

function getChildData($aid,$start,$limit,$orderWay='DESC'){

    global $dsql;

    $querystring = "SELECT * FROM `#@__feedback` WHERE aid = {$aid} AND pid = 0 AND ischeck = 1 ORDER BY id ".$orderWay;

    $dsql->Execute('fb', $querystring." LIMIT $start, $limit ");

    $k=0;

    $data = array();

    while($fields = $dsql->GetArray('fb')) {

        $data[$k] = $fields;

        $data[$k]['d_headpic']=$fields['face']!=1 ? $fields['face'] : $GLOBALS['cfg_phpurl'].'/dedemao-comment/img/default_head_img.gif';

        $data[$k]['content']=stripslashes(htmlspecialchars_decode($fields['msg']));

        $data[$k]['username']=stripslashes(htmlspecialchars_decode($fields['username']));

        $data[$k]['username']=hideStar($data[$k]['username']);

        $data[$k]['date']=date('Y-m-d H:i:s',$fields['dtime']);

        if($orderWay=='ASC'){

            $data[$k]['floor']=intval($start+1);

        }else{

            $c=$dsql->GetOne("SELECT count(*) c FROM `#@__feedback` WHERE id <= {$data[$k]['id']} AND pid = 0 AND aid= {$aid}");

            $data[$k]['floor'] = $c['c'];

        }

        $data[$k]['ipinfo'] = $fields['ipinfo'] ? $fields['ipinfo'] : getIpInfo($fields['ip']);



        // 获取二级评论

        $child = array();

        getTree($fields,$child);

        if(!empty($child)){

            // 按评论时间asc排序

            uasort($child,'comment_sort');

            foreach ($child as $m => $n) {

                // 获取被评论人昵称

                $f = $dsql->GetOne("SELECT username FROM `#@__feedback` WHERE id= {$n['pid']}");

                $child[$m]['reply_name']=$f['username'];

            }

        }

        $data[$k]['child']=$child;

        $k++;

        $start++;

    }

    return $data;

}



// 递归获取树状结构

function getTree($data,&$child){

    global $dsql;

    $querystring = "SELECT * FROM `#@__feedback` WHERE pid = {$data['id']} AND ischeck = 1 ";

    $dsql->Execute('fbc', $querystring);

    $k=0;

    while($fields = $dsql->GetArray('fbc')) {

        $v=$fields;

        $v['d_headpic']=$fields['face']!=1 ? $fields['face'] : $GLOBALS['cfg_phpurl'].'/dedemao-comment/img/default_head_img.gif';

        $v['username']=stripslashes(htmlspecialchars_decode($fields['username']));

        $v['username']=hideStar($v['username']);

        $v['content']=htmlspecialchars_decode($fields['msg']);

        $v['date']=date('Y-m-d H:i:s',$fields['dtime']);

        $v['ipinfo'] = $fields['ipinfo'] ? $fields['ipinfo'] : getIpInfo($fields['ip']);

        $child[]=$v;

        getTree($v,$child);

    }

}



// 用于评论系统的自定义排序功能

function comment_sort($a,$b){

    $prev = isset($a['date']) ? $a['date'] : 0;

    $next = isset($b['date']) ? $b['date'] : 0;

    if($prev == $next) return 0;

    return ($prev<$next) ? -1 : 1;

}



function getTotalCount($aid)

{

    global $dsql;

    $row = $dsql->GetOne("SELECT count(*) c FROM `#@__feedback` WHERE aid= {$aid} AND pid = 0");

    return $row['c'];

}



function getIpInfo($ip)

{

    global $dsql;

    $data = file_get_contents('http://ip.taobao.com/service/getIpInfo.php?ip='.$ip);

    if($data){

        $data = json_decode($data,true);

        if($data['code']==0){

            if($data['data']['region']=='XX') $data['data']['region']='';

            $ipinfo = $data['data']['region'].$data['data']['city'];

			$ipinfo = utf82gbk($ipinfo);

            $dsql->ExecuteNoneQuery("Update `#@__feedback` set ipinfo='{$ipinfo}' where ip='{$ip}'");

            return $ipinfo;

        }

    }

}



function hideStar($str) { //用户名、邮箱、手机账号中间字符串以*隐藏

    if (strpos($str, '@')) {

        $email_array = explode("@", $str);

        $prevfix = (strlen($email_array[0]) < 4) ? "" : substr($str, 0, 3); //邮箱前缀

        $count = 0;

        $str = preg_replace('/([\d\w+_-]{0,100})@/', '***@', $str, -1, $count);

        return $prevfix . $str;

    } else return $str;

}



