<?php
if(!isset($GLOBALS['_vars'])) $GLOBALS['_vars'] = array(); 
$fields = array();
?><!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>我的提问 -<?php echo $cfg_webname; ?></title>
<link rel="stylesheet" type="text/css" href="/templets/lawyer/css/layout-new.css" />
<link rel="stylesheet" type="text/css" href="/templets/lawyer/css/style-new.css" />
<link rel="stylesheet" type="text/css" href="/templets/lawyer/css/bootstrap.min.css" />
<link href="<?php echo $cfg_ask_basehost;?>/member/templets/style/base.css" rel="stylesheet" type="text/css" />
<!-- <script language="javascript" type="text/javascript" src="<?php echo $cfg_ask_basehost;?>/images/js/j.js"></script> -->
<script type="text/javascript" src="/templets/lawyer/js/jquery-1.8.1.min.js"></script>
<style>
.showmsg{
    width: 100%;
    margin-top: 20px;
    padding-bottom: 10px;
    border-bottom: 1px solid #ccc;
    box-sizing: border-box;
    clear: both;
    cursor: default;
    font-size: 16px;
}
.showmsg span{
    font-size: 18px;
    font-weight: bold;
    color: #1078DA;
    float: left;
}
.showmsg .showcontent{
    width: 100%;
    padding: 10px 0px;
}
.showmsg .showcontent span{
    color: #1078DA;
    font-weight: 400;
}
.active{
    background: #ccc;
}
table tr{
    cursor:pointer;
}
</style>
</head>
<body>
<header class="user-center">
    <div class="uc-info o-h">
        <div class="inner-box">
            <div class="uc-info-left fl">
                <h2>
                <p>我的法易通法律法务</p>
            </div>
        </div>
    </div>
    <div class="uc-header">
        <div class="inner-box">
            <div class="uc-header-logo fl o-h"><a href="/"><img height="45"  alt="法易通法律法务" src="/templets/lawyer/images/yifatonglogo_whithout_word.png"></a></div>
            <div class="uc-header-bread fl">
                <div class="breadcrumb-box visible-lg clean-m clean-p" style="height: 45px;line-height: 45px;padding: 0;margin: 0;">
                    <p> <span class="icon-font text-blue">&#xe610;</span> <a target="_blank" href="/" class=" text-blue">首页</a> - <span>我的咨询</span> </p>
                </div>
            </div>
            <div class="fr uc-header-info">
                <p><span class="ico-font">&#xee0a;</span>你好，欢迎 <?php echo $cfg_ml->M_Phone; ?> <a href="/member/index_do.php?fmdo=login&dopost=exit">退出</a></p>
            </div>
        </div>
    </div>
</header>
<div id="lean_overlay">
    <form class="form-inline p-r" action="/plus/search.php" method="post">
        <div class="search-bar">
            <div class="input-part">
                <input id="exampleInputEmail2"  type="text" placeholder="劳动合同" name="q">
            </div>
            <button class="text-white btn btn-link " type="submit"><img width="29" height="25" alt="搜索" src="/templets/lawyer/images/search.png"></button>
        </div>
        <div class="inner-box"></div>
    </form>
</div>
<!-------------- javascript -------------->
<div class="user-center h100p o-h">
<?php pasterTempletDiy("lawyer/aside.htm"); ?>
<div class="user-center-contract-service">
<div class="border-box">
    <div class="container">
        <div class="row"> </div>
    </div>
    <div id="mainCp">
        <table  width="100%" border="0" cellpadding="0" cellspacing="0" class="list">
         <thead>
           <tr>
             <th style="padding-left:10px;">标题</th>
             <th width="10%" style="text-align:center;">状态</th>
             <th width="18%" style="text-align:center;">提问时间</th>
             <th width="18%" style="text-align:center;">回复时间</th>
           </tr>
         </thead>
         <tbody>
                <?php
$atts = array();
$atts['tagname'] = 'datalist';
$blockValue = $this->refObj->GetArcList($atts,$this->refObj,$fields); 
if(is_array($blockValue)){
foreach( $blockValue as $key=>$fields )
{

                $fields['dateline'] = GetDateMk($fields['dateline']);
                if($fields['replies']>0){
                $fields['dbstatus'] = 1;
                $fields['status'] = '<font color="green">已解决</font>';
                }else{
                $fields['dbstatus'] = 0;
                $fields['status'] = '<font color="red">未解决</font>';
                }
                //对连接地址进行处理
                if($cfg_ask_isdomain == 'Y')
                {
                if($cfg_ask_rewrite == 'Y')
                    $qurl = $cfg_ask_domain.'/'.$fields['id'].'html';
                    else
                        $qurl = $cfg_ask_domain.'?ct=question&askaid='.$fields['id'];
                }else{
                    if($cfg_ask_rewrite == 'Y')
                    $qurl = $cfg_ask_directory.'/'.$fields['id'].'html';
                    else
                        $qurl = $cfg_ask_directory.'/?ct=question&askaid='.$fields['id'];
                }
                ?>
         <tr class="showask">
           <td style="padding-left:10px;"><a href="javascript:;"><?php echo $fields['title'];?></a></td>
           <td align="center"><?php echo $fields['status'] ;?></td>
           <td align="center"><?php echo $fields['dateline'] ;?></td>
           <td align="center"><?php if(!empty($fields['lastanswer'])) echo MyDate('Y-m-d h:m:s', $fields['lastanswer']);
else echo '尚未回复';?></td>
         </tr>
         <tr class="showbox" style="display:none;" id="box<?php echo $fields[id];?>">
            <td colspan="4">
                <div class="showmsg">
                    <div class="showcontent"><span>详细情况：</span><p><?php echo strip_tags($fields['content']) ;?></p></div>
                </div>
                <div class="showmsg">
                    <div class="showcontent"><span>律师回复：</span><p><?php echo strip_tags($fields['askcon']) ;?></p></div>
                </div>
                <div class="showmsg" style="border:none;">
                    <div class="showcontent">
                        <?php
                         if($fields['feedback'] == ''){
                        ?><span>对答案是否满意：</span><br><?php pasterTempletDiy("plus/myaskcomment.htm");  }else{
                            echo "<span>我的评价：</span>".$fields['feedback'] ;
                        }?></div>
                </div>
                
            </td>
         </tr>
         <?php
}
}?>
         </tbody>
         <!-- <tfoot>
           <tr>
             <td colspan="7"><div class="pages mTB10 fRight"><?php
$atts = array();
$atts['tagname'] = 'pagelist';
 echo $this->refObj->GetPageList($atts,$this->refObj,$fields); 
?>
</div>
               <div class="clear"></div></td>
           </tr>
         </tfoot> -->
       </table>    
    </div>
</div>
<!--- tip end-->
	</div>
</div>
</div>
<div class="cpgb-fixed">
	<a id="BizQQBottomCommon" href="http://wpa.qq.com/msgrd?v=3&amp;uin=2448211596&amp;site=qq&amp;menu=yes" class="cpgb-fixed-zixun">
		<p><img src="/templets/lawyer/images/qq.png" alt="QQ"><br>在线咨询</p>
	</a>
	<a class="cpgb-fixed-zixun cpgb-fixed-dianhua">
		<p><span class="ico-font tubiao">&#xea89;</span><br>400电话</p>
		<span class="zx-haoma">
			18202835355
			<img src="/templets/lawyer/images/jiantou.png" alt="箭头">
		</span>
	</a>
	<a class="cpgb-fixed-zixun cpgb-fixed-dingbu">
		<p><img src="/templets/lawyer/images/dingbu.png" alt="QQ"><br>返回顶部</p>
	</a>
</div>
<!-------------- javascript -------------->
<div class="model-box p-a" ></div>
<?php pasterTempletDiy("lawyer/footer2.htm"); ?>
<script>
$(function(){
    //$(".showbox").hide();
    $(".showask").click(function(){
        $(".showbox").hide();
        $(this).next().toggle();
        //$(this).next().show().siblings(".showbox").hide();
        $(this).addClass("active").siblings().removeClass("active");
        
    });
});
</script>
</body>
</html>