<?php
require_once(dirname(__file__)."/config.php");
global $dsql;
$dsql;
//取得订单号
$order_sn = trim($_GET['out_trade_no']);
$rows = $dsql->GetOne("SELECT * FROM #@__shops_orders WHERE oid = '{$order_sn}'");
$priceCount = $rows['priceCount'];
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>微信支付 - 法易通法律法务</title>
<link rel="stylesheet" type="text/css" href="/templets/lawyer/css/layout-new.css">
<link rel="stylesheet" type="text/css" href="/templets/lawyer/css/style-new.css">
<link rel="stylesheet" type="text/css" href="/templets/lawyer/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="/templets/lawyer/css/box.css">
<script src="/templets/lawyer/js/push.js"></script>
<script charset="utf-8" src="/templets/lawyer/js/lxb.js"></script>
<script charset="utf-8" src="/templets/lawyer/js/v.js"></script>
<script src="/include/js/jquery/jquery.js" type="text/javascript"></script>
<script type="text/javascript" src="/templets/lawyer/js/jquery-1.8.1.min.js"></script>
<script type="text/javascript" src="/templets/lawyer/js/modal.min.js"></script>
<script type="text/javascript" src="/templets/lawyer/js/box.js"></script>
<script type="text/javascript" src="/templets/lawyer/js/iealert.js"></script>
<script type="text/javascript">
	$(function(){
		$('.web-header .user-box ul > li:nth-of-type(2) div.fl b').click(function(){
			$('.web-header .user-box ul > li:nth-of-type(2) div.fl ol').show();
			$('.model-box').show();
		});
		$('.model-box').click(function(){
			$('.web-header .user-box ul > li:nth-of-type(2) div.fl ol').hide();
			$('.web-header .inner-box .fr > div.dropdown ul.menu').hide();
			$(this).hide();
		});
		$('.web-header .inner-box .fr > div.dropdown span').click(function(){
			$('.web-header .inner-box .fr > div.dropdown ul.menu').show();
			$('.model-box').show();
		})
		$("#search-btn").leanModal();
		$("body").iealert();
		$('footer .link .row .inner-box .top-box ul li').click(function(){
			$(this).addClass('click').siblings().removeClass('click');
			var numb = $(this).index()
			$('footer .link .row .inner-box .bottom-box div').eq(numb).show().siblings().hide()
		});
	});
	</script>
</head>
<body>
<iframe src="javascript:false" title="" frameborder="0" tabindex="-1" style="position: absolute; width: 0px; height: 0px; border: 0px;" src="/templets/lawyer/images/saved_resource.html">
</iframe>
<iframe style="display: none;" src="/templets/lawyer/images/saved_resource(1).html"></iframe>
<style type="text/css">
.WPA3-SELECT-PANEL { z-index:2147483647; width:463px; height:292px; margin:0; padding:0; border:1px solid #d4d4d4; background-color:#fff; border-radius:5px; box-shadow:0 0 15px #d4d4d4;}.WPA3-SELECT-PANEL * { position:static; z-index:auto; top:auto; left:auto; right:auto; bottom:auto; width:auto; height:auto; max-height:auto; max-width:auto; min-height:0; min-width:0; margin:0; padding:0; border:0; clear:none; clip:auto; background:transparent; color:#333; cursor:auto; direction:ltr; filter:; float:none; font:normal normal normal 12px "Helvetica Neue", Arial, sans-serif; line-height:16px; letter-spacing:normal; list-style:none; marks:none; overflow:visible; page:auto; quotes:none; -o-set-link-source:none; size:auto; text-align:left; text-decoration:none; text-indent:0; text-overflow:clip; text-shadow:none; text-transform:none; vertical-align:baseline; visibility:visible; white-space:normal; word-spacing:normal; word-wrap:normal; -webkit-box-shadow:none; -moz-box-shadow:none; -ms-box-shadow:none; -o-box-shadow:none; box-shadow:none; -webkit-border-radius:0; -moz-border-radius:0; -ms-border-radius:0; -o-border-radius:0; border-radius:0; -webkit-opacity:1; -moz-opacity:1; -ms-opacity:1; -o-opacity:1; opacity:1; -webkit-outline:0; -moz-outline:0; -ms-outline:0; -o-outline:0; outline:0; -webkit-text-size-adjust:none; font-family:Microsoft YaHei,Simsun;}.WPA3-SELECT-PANEL a { cursor:auto;}.WPA3-SELECT-PANEL .WPA3-SELECT-PANEL-TOP { height:25px;}.WPA3-SELECT-PANEL .WPA3-SELECT-PANEL-CLOSE { float:right; display:block; width:47px; height:25px; background:url(http://combo.b.qq.com/crm/wpa/release/3.3/wpa/views/SelectPanel-sprites.png) no-repeat;}.WPA3-SELECT-PANEL .WPA3-SELECT-PANEL-CLOSE:hover { background-position:0 -25px;}.WPA3-SELECT-PANEL .WPA3-SELECT-PANEL-MAIN { padding:23px 20px 45px;}.WPA3-SELECT-PANEL .WPA3-SELECT-PANEL-GUIDE { margin-bottom:42px; font-family:"Microsoft Yahei"; font-size:16px;}.WPA3-SELECT-PANEL .WPA3-SELECT-PANEL-SELECTS { width:246px; height:111px; margin:0 auto;}.WPA3-SELECT-PANEL .WPA3-SELECT-PANEL-CHAT { float:right; display:block; width:88px; height:111px; background:url(http://combo.b.qq.com/crm/wpa/release/3.3/wpa/views/SelectPanel-sprites.png) no-repeat 0 -80px;}.WPA3-SELECT-PANEL .WPA3-SELECT-PANEL-CHAT:hover { background-position:-88px -80px;}.WPA3-SELECT-PANEL .WPA3-SELECT-PANEL-AIO-CHAT { float:left;}.WPA3-SELECT-PANEL .WPA3-SELECT-PANEL-QQ { display:block; width:76px; height:76px; margin:6px; background:url(http://combo.b.qq.com/crm/wpa/release/3.3/wpa/views/SelectPanel-sprites.png) no-repeat -50px 0;}.WPA3-SELECT-PANEL .WPA3-SELECT-PANEL-QQ-ANONY { background-position:-130px 0;}.WPA3-SELECT-PANEL .WPA3-SELECT-PANEL-LABEL { display:block; padding-top:10px; color:#00a2e6; text-align:center;}.WPA3-SELECT-PANEL .WPA3-SELECT-PANEL-BOTTOM { padding:0 20px; text-align:right;}.WPA3-SELECT-PANEL .WPA3-SELECT-PANEL-INSTALL { color:#8e8e8e;}
</style>
<style type="text/css">
.WPA3-CONFIRM { z-index:2147483647; width:285px; height:141px; margin:0;}.WPA3-CONFIRM { *background-image:url(http://combo.b.qq.com/crm/wpa/release/3.3/wpa/views/panel.png);}.WPA3-CONFIRM * { position:static; z-index:auto; top:auto; left:auto; right:auto; bottom:auto; width:auto; height:auto; max-height:auto; max-width:auto; min-height:0; min-width:0; margin:0; padding:0; border:0; clear:none; clip:auto; background:transparent; color:#333; cursor:auto; direction:ltr; filter:; float:none; font:normal normal normal 12px "Helvetica Neue", Arial, sans-serif; line-height:16px; letter-spacing:normal; list-style:none; marks:none; overflow:visible; page:auto; quotes:none; -o-set-link-source:none; size:auto; text-align:left; text-decoration:none; text-indent:0; text-overflow:clip; text-shadow:none; text-transform:none; vertical-align:baseline; visibility:visible; white-space:normal; word-spacing:normal; word-wrap:normal; -webkit-box-shadow:none; -moz-box-shadow:none; -ms-box-shadow:none; -o-box-shadow:none; box-shadow:none; -webkit-border-radius:0; -moz-border-radius:0; -ms-border-radius:0; -o-border-radius:0; border-radius:0; -webkit-opacity:1; -moz-opacity:1; -ms-opacity:1; -o-opacity:1; opacity:1; -webkit-outline:0; -moz-outline:0; -ms-outline:0; -o-outline:0; outline:0; -webkit-text-size-adjust:none;}.WPA3-CONFIRM * { font-family:Microsoft YaHei,Simsun;}.WPA3-CONFIRM .WPA3-CONFIRM-TITLE { height:40px; margin:0; padding:0; line-height:40px; color:#2b6089; font-weight:normal; font-size:14px; text-indent:80px;}.WPA3-CONFIRM .WPA3-CONFIRM-CONTENT { height:55px; margin:0; line-height:55px; color:#353535; font-size:14px; text-indent:29px;}.WPA3-CONFIRM .WPA3-CONFIRM-PANEL { height:30px; margin:0; padding-right:16px; text-align:right;}.WPA3-CONFIRM .WPA3-CONFIRM-BUTTON { position:relative; display:inline-block!important; display:inline; zoom:1; width:99px; height:30px; margin-left:10px; line-height:30px; color:#000; text-decoration:none; font-size:12px; text-align:center;}.WPA3-CONFIRM .WPA3-CONFIRM-BUTTON-FOCUS { width:78px;}.WPA3-CONFIRM .WPA3-CONFIRM-BUTTON .WPA3-CONFIRM-BUTTON-TEXT { line-height:30px; text-align:center; cursor:pointer;}.WPA3-CONFIRM-CLOSE { position:absolute; top:7px; right:7px; width:10px; height:10px; cursor:pointer;}
</style>
<!-------------- javascript -------------->

<div class="diannao-weixinsaoma">
    <div class="wxsm-logo">
        <div class="wxsm-lg-l">
            <div class="f-l"> <span class="tubiao"><img src="/templets/lawyer/images/weixin.png" alt=""></span><span class="da">微信|</span>我的收银台 </div>
            <div class="f-r">
                <h2>你好，欢迎使用微信付款！</h2>
            </div>
        </div>
    </div>
    <div class="wxsm-mod">
        <div class="wxsm-title">
            <div class="wxsm-title-l">
                <h2>正在使用即时到帐交易<span class="lanse"> [?]</span>
                    <div class="hide-tishi"><span class="sanjiao"><img src="/templets/lawyer/images/sanjiaoxing.png" alt=""></span><span class="cu">付款后资金直接进入对方账户</span><br>
                        若发生退款需联系收款方协商，如付款给陌生人，请谨慎操作。</div>
                </h2>
                <p>收款方：成都木子木科技有限公司</p>
            </div>
            <div class="wxsm-title-r">
                <p><span class="chengse"><?php echo $priceCount; ?></span> 元</p>
            </div>
        </div>
        <div class="weidian-weixinsaoma">
            <div class="dingdan-dingwei"> <span>订单详情</span> </div>
            <h2>现金支付</h2>
            <h3>￥<?php echo $priceCount; ?></h3>
            <p> <span class="erweima"><img src="/include/qrcode.php?data=<?php echo $url;?>"><!--<span class="logo"><img src="/templets/lawyer/images/buylogo.png" alt="" width="40px" height="40px"></span>--></span> <span class="shibie">通过微信扫描二维码，进行快速支付</span> </p>
            <h4> <a class="chengdi" href="/member/shops_orders.php">支付完成</a><a href="/">返回首页</a> </h4>
        </div>
        <div class="wxsm-foot">
            <h2><span class="tubiao"><img src="/templets/lawyer/images/weixinxia.png" alt=""></span>法易通法律法务<a class="jianju" target="_blank" href="/about">关于我们</a><span class="lanse">|</span><a target="_blank" href="/contact">联系我们</a></h2>
        </div>
    </div>
</div>
<div class="cpgb-fixed"> <a id="BizQQBottomCommon" href="http://wpa.qq.com/msgrd?v=3&amp;uin=2448211596&amp;site=qq&amp;menu=yes" class="cpgb-fixed-zixun">
    <p><img src="/templets/lawyer/images/qq.png" alt="QQ"><br>
        在线咨询</p>
    </a> <a class="cpgb-fixed-zixun cpgb-fixed-dianhua">
    <p><span class="ico-font tubiao"></span><br>
        联系电话</p>
    <span class="zx-haoma"> 18202835355 <img src="/templets/lawyer/images/jiantou.png" alt="箭头"> </span> </a> <a class="cpgb-fixed-zixun cpgb-fixed-dingbu" style="display: none;">
    <p><img src="/templets/lawyer/images/dingbu.png" alt="QQ"><br>
        返回顶部</p>
    </a> </div>
<!--  debug --> 
<script>
$ = jQuery;
$(function(){
	setInterval(weipay,5000);
})

function weipay()
{
	var timeStamp = new Date().getTime();
	$.get("/member/weipay_ajax.php",{'out_trade_no':'<?php echo $out_trade_no; ?>',timeStamp:timeStamp},function(data){
		if(data['trade_state'] == 'SUCCESS')
		{
			//alert("订单支付成功，即将跳转....");
			window.location.href='/plus/carbuyaction.php?dopost=return&code=weipay&out_trade_no=<?php echo $out_trade_no; ?>&total_fee='+data['cash_fee'];
		}
	},'json')
}
</script>
<script type="text/javascript">
$(function(){
	$('.cpgb-fixed-dingbu').click(function(){
		$(window).scrollTop(0);
	});

	$(window).scroll(function () {

		if ($(window).scrollTop() > 1018 ) {			
			$(".cpgb-fixed-dingbu").css("display","block");
		}else if($(window).scrollTop() < 1016){			
			$(".cpgb-fixed-dingbu").css("display","none");
		}
	});
})
BizQQWPA.addCustom({aty: '1', a: '0', nameAccount: 4008515666, selector: 'BizQQBottomCommon'});
</script>
</body>
</html>