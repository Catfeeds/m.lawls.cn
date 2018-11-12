<?php
function litimgurls($imgid=0)
{
    global $lit_imglist,$dsql;
    //获取附加表
    $row = $dsql->GetOne("SELECT c.addtable FROM #@__archives AS a LEFT JOIN #@__channeltype AS c ON a.channel=c.id where a.id='$imgid'");
    $addtable = trim($row['addtable']);
    //获取图片附加表imgurls字段内容进行处理
    $row = $dsql->GetOne("Select imgurls From `$addtable` where aid='$imgid'");
    //调用inc_channel_unit.php中ChannelUnit类
    $ChannelUnit = new ChannelUnit(2,$imgid);
    //调用ChannelUnit类中GetlitImgLinks方法处理缩略图
    $lit_imglist = $ChannelUnit->GetlitImgLinks($row['imgurls']);
    //返回结果
    return $lit_imglist;
}

/*首页隐藏用户手机号*/

function cutPhone($obj){
    if (is_numeric($obj)) {
        return substr_replace($obj,'****',3,4);
    }else{
        return $obj;
    }
	
}


function GetOneArchiveBody($aid,$length){
	global $dsql;
	$aid = trim(ereg_replace('[^0-9]','',$aid));
	$body = '';
	$query = " Select art.body From `#@__addonarticle` art, `#@__archives` arc where art.aid='$aid' and art.aid=arc.id ";
	$arcRow = $dsql->GetOne($query);
	if(!is_array($arcRow)) {
		return $body;
	}
	if(isset($arcRow['body'])) {
		if ($length>0)
		 	$body = cn_substr(html2text($arcRow['body']),$length);
		else
		 	$body =$arcRow['body'];
		}
	return $body;
}