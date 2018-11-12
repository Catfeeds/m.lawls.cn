<?php
if(!isset($GLOBALS['_vars'])) $GLOBALS['_vars'] = array(); 
$fields = array();
?><!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>我购买的商品 - 会员中心 -<?php echo $cfg_webname; ?></title>
<link rel="stylesheet" type="text/css" href="/templets/lawyer/css/layout-new.css" />
<link rel="stylesheet" type="text/css" href="/templets/lawyer/css/style-new.css" />
<link rel="stylesheet" type="text/css" href="/templets/lawyer/css/bootstrap.min.css" />
<link href="templets/style/base.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/templets/lawyer/js/jquery-1.8.1.min.js"></script>
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
                    <p> <span class="icon-font text-blue">&#xe610;</span> <a target="_blank" href="/" class=" text-blue">首页</a> - <span>订单信息</span> </p>
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
        <?php if(!empty($oid)){ ?>
        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="list">
            <thead>
                <tr>
                    <th colspan="2" style="padding-left: 10px;"><strong>订单信息</strong></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td width="15%" align="right" valign="top">订单号：</td>
                    <td><strong><?php echo $oid?></strong></td>
                </tr>
                <tr>
                    <td align="right" valign="top">支付方式：</td>
                    <td><?php echo GetSta($row['state'],$oid)?></td>
                </tr>
                <tr>
                    <td align="right" valign="top">数量：</td>
                    <td><?php echo $row['cartcount']?></td>
                </tr>
                <tr>
                    <td align="right" valign="top">总计：</td>
                    <td><?php echo $row['priceCount']?>元</td>
                </tr>
                <tr>
                    <td align="right" valign="top">订单时间：</td>
                    <td><?php echo GetDateTimeMk($row['stime'])?></td>
                </tr>
                <tr>
                    <td align="right" valign="top">联系电话：</td>
                    <td><?php echo $row['tel']?></td>
                </tr>
                <tr>
                    <td align="right" valign="top">邮箱：</td>
                    <td><?php echo $row['email']?></td>
                </tr>
            </tbody>
        </table>
        <?php }?>
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
</body>
</html>