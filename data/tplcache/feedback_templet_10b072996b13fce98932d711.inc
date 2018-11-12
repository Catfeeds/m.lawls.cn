<?php
if(!isset($GLOBALS['_vars'])) $GLOBALS['_vars'] = array(); 
$fields = array();
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $GLOBALS['cfg_soft_lang']; ?>" />
<title>用户评论 - <?php echo $GLOBALS['cfg_webname']; ?></title>
<link href="<?php echo $GLOBALS['cfg_templets_skin']; ?>/css/style-xin.css?v=201805021933" rel="stylesheet" media="screen" type="text/css" />
<script language="javascript" type="text/javascript" src="<?php echo $GLOBALS['cfg_cmsurl']; ?>/include/dedeajax2.js"></script>
<script type="text/javascript" src="/templets/lawyer/js/jquery-1.8.1.min.js"></script>
<script language="javascript">
function postBadGood(ftype,fid){
	var taget_obj = document.getElementById(ftype+fid);
	var saveid = GetCookie('badgoodid');
	if(saveid != null
	{
		 var saveids = saveid.split(',');
		 var hasid = false;
		 saveid = '';
		 j = 1;
		 for(i=saveids.length-1;i>=0;i--)
		 {
		 	  if(saveids[i]==fid && hasid) continue;
		 	  else {
		 	  	if(saveids[i]==fid && !hasid) hasid = true;
		 	  	saveid += (saveid=='' ? saveids[i] : ','+saveids[i]);
		 	  	j++;
		 	  	if(j==10 && hasid) break;
		 	  	if(j==9 && !hasid) break;
		 	  }
		 }
     if(hasid) { alert('您刚才已表决过了喔！'); return false; }
     else saveid += ','+fid;
		 SetCookie('badgoodid',saveid,1);
	}
	else
	{
		SetCookie('badgoodid',fid,1);
	}
	//document.write("feedback.php?action="+ftype+"&fid="+fid);
	//return;
  myajax = new DedeAjax(taget_obj,false,false,'','','');
  myajax.SendGet2("feedback.php?aid=<?php echo $GLOBALS['aid']; ?>&action="+ftype+"&fid="+fid);
  DedeXHTTP = null;
}
function ajaxFeedback(aid, fid, type)
{
	var taget_obj = $DE('ajaxfeedback_'+fid);
	if(taget_obj.innerHTML == '')
	{
		var myajax = new DedeAjax(taget_obj, true, true, '', 'x');
		myajax.SendGet2("<?php echo $GLOBALS['cfg_phpurl']; ?>/feedback.php?aid="+aid+"&fid="+fid+"&action=quote&type=ajax");
		eval('var result = typeof CKEDITOR.instances.msg_'+fid);
		if(result != 'undefined')
		{
			// 删除实例
			eval('var edit = CKEDITOR.instances.msg_'+fid);
			CKEDITOR.remove(edit);
		}
		CKEDITOR.replace(document.getElementById('msg_'+fid) , CKEDITOR.instances.msg.config);
		scroll(0, taget_obj.offsetTop - 120);
		var formname = 'f = document.ajaxfeedback_'+fid;
		eval(formname);
		if(f.validate)
		{
			if($DE('vdimg_'+fid)) $DE('vdimg_'+fid).src = "<?php echo $GLOBALS['cfg_cmsurl']; ?>/include/vdimgck.php?"+f.validate.value;
			f.validate.value = '';
		}
		DedeXHTTP = null;
	}
}
function ajaxQuotePost(fid)
{
	var formname = 'f = document.ajaxfeedback_'+fid;
	eval(formname);
	//var f = document.formname;
	//var f = f[0];
	var nvalidate = '';
	var nnotuser = '';
	var nusername = '';
	var npwd = '';
	var taget_obj = $DE('commetcontentNew');
	var waithtml = "<div style='line-height:30px'><img src='<?php echo $GLOBALS['cfg_cmsurl']; ?>/images/loadinglit.gif' />正在发送中...</div>";
	eval('var msg = CKEDITOR.instances.msg_'+fid+'.getData()');
	if(f.validate)
	{
		if(f.validate.value=='') {
			alert("请填写验证码！");
			return;
		}
		else {
			nvalidate = f.validate.value;
		}
	}
	var myajax = new DedeAjax(taget_obj, false, true, '', '', waithtml);
	if(f.notuser.checked) nnotuser = '1';
	if(f.username) nusername = f.username.value;
	if(f.pwd) npwd = f.pwd.value;
	myajax.sendlang = '<?php echo $GLOBALS['cfg_soft_lang']; ?>';
	myajax.AddKeyN('dopost', 'send');
	myajax.AddKeyN('aid', '<?php echo $GLOBALS['aid']; ?>');
	myajax.AddKeyN('fid', f.fid.value);
	myajax.AddKeyN('type', 'ajax');
	myajax.AddKeyN('comtype', f.comtype.value);
	myajax.AddKeyN('isconfirm','yes');
	myajax.AddKeyN('typeid', f.typeid.value);
	myajax.AddKeyN('quotemsg', f.quotemsg.value);
	myajax.AddKeyN('validate', nvalidate);
	myajax.AddKeyN('notuser', nnotuser);
	myajax.AddKeyN('username', nusername);
	myajax.AddKeyN('pwd', npwd);
	myajax.AddKeyN('msg', msg);
	myajax.SendPost2('<?php echo $GLOBALS['cfg_phpurl']; ?>/feedback_ajax.php');
	//alert(f.quotemsg.value);
	if($DE('ajaxfeedback_'+fid).innerHTML != null)

	{
		$DE('ajaxfeedback_'+fid).innerHTML = '';
	}
	scroll(0, taget_obj.offsetTop);
	taget_obj.removeAttribute('id');
}
</script>
<body class="commentpage">
<?php include $this->CompilerInclude("../lawyer/header.htm");
 ?> 
<!-- /nav --> 
<!-- /header -->
<div class="pc-chanpingaiban">
   <div class="cpgb-fuwu">
    <div class="cpgb-fw-pingjia"> <a class="gogo4" name="gogo4"></a>
        <div class="pj-title">
            <h2>用户评价</h2>
        </div>
        <div class="pj-pinglv">
            <div class="pl-l">
                <div class="pl-l-l">
                    <h2>99.6%</h2>
                    <p>好评率</p>
                    <span class="tupian"> <img src="/templets/lawyer/images/xing4.png" alt=""> </span> </div>
                <div class="pl-l-r">
                    <p><span class="zi">好评(99.6%)</span><span class="hui"><span class="hong" style="width:99.6%;"></span></span></p>
                    <p><span class="zi">中评(0.2%)</span><span class="hui"><span class="hong" style="width:0.2%;"></span></span></p>
                    <p><span class="zi">差评(0.2%)</span><span class="hui"><span class="hong" style="width:0.2%;"></span></span></p>
                </div>
            </div>
            <div class="pl-r">
                <h2>客户印象</h2>
                <div class="pl-r-inner"> <span class="inner-par">服务态度好</span> <span class="inner-par">服务模式不错</span> <span class="inner-par">良好职业道德修养</span> <span class="inner-par">专业程度高</span> <span class="inner-par">办事效率高</span> <span class="inner-par">服务很满意</span> <span class="inner-par">对接很及时</span> <span class="inner-par">声音甜美</span> </div>
            </div>
        </div>
        <div class="pj-quanping">
            <h2><a id="current_all" href='feedback.php?aid=<?php echo $GLOBALS['aid']; ?>' <?php if($ftype=='') echo "class='lanse'"; ?>>全部评价</a><a id="current_1" href='feedback.php?aid=<?php echo $GLOBALS['aid']; ?>&ftype=good' <?php if($ftype=='good') echo "class='lanse'"; ?>>好评<!-- (<?php echo $fields['good']; ?>) --></a><a id="current_2" href='feedback.php?aid=<?php echo $GLOBALS['aid']; ?>&ftype=feedback' <?php if($ftype=='feedback') echo "class='lanse'"; ?>>中评<!-- (<?php echo $fields['feedback']; ?>) --></a><a id="current_3" href='feedback.php?aid=<?php echo $GLOBALS['aid']; ?>&ftype=bad' <?php if($ftype=='bad') echo "class='lanse'"; ?>>差评<!-- (<?php echo $fields['bad']; ?>) --></a></h2>
            <p> <span class="pingjia">用户评价</span> <span class="manyi">满意度</span> <span class="yonghu">用户</span> </p>
        </div>
        <div class="pj-nav" id="orderReviewPage">
           <?php
$atts = array();
$atts['tagname'] = 'datalist';
$blockValue = $this->refObj->GetArcList($atts,$this->refObj,$fields); 
if(is_array($blockValue)){
foreach( $blockValue as $key=>$fields )
{

			  if($fields['userid']!='') $spaceurl = $cfg_basehost.'/member/index.php?uid='.$fields['userid'];
			  else $spaceurl = "#";
			  if($fields['username']=='匿名') $spaceurl = "#";
			  $fields['bgimg'] = 'cmt-neu.gif';
			  $fields['ftypetitle'] = '该用户表示中立';
			  if($fields['ftype']=='bad') {
				$fields['bgimg'] = 'cmt-bad.gif';
				$fields['ftypetitle'] = '该用户表示差评';
			  }
			  else if($fields['ftype']=='good') {
				$fields['bgimg'] = 'cmt-good.gif';
				$fields['ftypetitle'] = '该用户表示好评';
			  }
			  if(empty($fields['mface']))
			  {
				if($fields['sex']=="女") $fields['mface']="/member/templets/images/dfgirl.png";
				else $fields['mface']="/member/templets/images/dfboy.png";
			  }
			?>
            <div class="pj-nav-inner">
                <div class="pj-nav-pingjia">
                    <h2>用户评价：
                        <time><?php echo MyDate('m-d H:i',$fields['dtime']); ?></time>
                    </h2>
                    <p>
					<?php
					echo RemoveXSS(Quote_replace(parseSmileys($fields['msg'],$cfg_cmspath.'/images/smiley')));
					?>
                   </p>
                   <p><span style="font-weight: bold;color: red;">管理员回复：
                   <?php
					echo RemoveXSS(Quote_replace(parseSmileys($fields['reply'],$cfg_cmspath.'/images/smiley')));
					?>
                   </span>
					
                   </p>
                   <span id='goodfb<?php echo $fields['id']; ?>'><a href="#" onclick="postBadGood('goodfb',<?php echo $fields['id']; ?>)">支持</a>[<?php echo $fields['good']; ?>]</span> <span id='badfb<?php echo $fields['id']; ?>'><a href="#" onclick="postBadGood('badfb',<?php echo $fields['id']; ?>)">反对</a>[<?php echo $fields['bad']; ?>]</span>
                   <!--<span class='quote'><a href="javascript:ajaxFeedback(<?php echo $fields['id']; ?>,<?php echo $fields['id']; ?>,'quote');">引用</a></span>-->
                    <!--<div class="pj-yinxiang"> <span class="yx-inner">服务态度好</span> <span class="yx-inner">服务模式不错</span> <span class="yx-inner">专业程度高</span> <span class="yx-inner">办事效率高</span> <span class="yx-inner">服务很满意</span> <span class="yx-inner">服务认真仔细</span> <span class="yx-inner">对接很及时</span> </div>-->
                </div>
                <div class="pj-nav-manyi"> <span class="xingxing"> <img src="/templets/lawyer/images/xing5.png" alt=""> </span> </div>
                <div class="pj-nav-yonghu">
                    <p> <?php echo cutPhone($fields['username']); ?> </p>
                </div>
            </div>
            <div id="ajaxfeedback_<?php echo $fields['id']; ?>"></div>
            <?php
}
}?>
            <div class="web-page">
              <ul><?php
$atts = array();
$atts['tagname'] = 'pagelist';
$atts['listitem'] = 'info,index,end,pre,next,pageno';
$atts['listsize'] = '5';
 echo $this->refObj->GetPageList($atts,$this->refObj,$fields); 
?>
</ul>
            </div>
        </div>
    </div>
    </div>
</div>
<?php include $this->CompilerInclude("../lawyer/footer.htm");
 ?> 
<!-- /footer -->
</body>
</html>