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
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<title>我购买的产品 - 法易通法律法务</title>
		<meta name="keywords" content="{dede:field name='keywords'/}" />
		<meta name="description" content="{dede:field name='description' function='html2text(@me)'/}" />
		<script src="/js/mui.min.js"></script>
		<link href="/css/mui.min.css" rel="stylesheet" />
		<link href="/css/style.css" rel="stylesheet" />
		<script type="text/javascript" charset="utf-8">
			mui.init();
		</script>
        <script type="text/javascript" src="/js/jquery.min.js"></script>
	</head>
	<body>
		<!-- 侧滑导航根容器 -->
		<div id="offCanvasWrapper" class="mui-off-canvas-wrap mui-draggable mui-scalable">
			<!-- 菜单容器 -->
			<script language="javascript" type="text/javascript" src="/include/dedeajax2.js"></script>
			<script language="javascript" type="text/javascript">
				function CheckLogin() {
					var taget_obj = document.getElementById('_userlogin');
					myajax = new DedeAjax(taget_obj, false, false, '', '', '');
					myajax.SendGet2("/member/ajax_loginsta.php");
					DedeXHTTP = null;
				}
			</script>
			<aside id="offCanvasSide" class="mui-off-canvas-right">
				<div id="offCanvasSideScroll" class="mui-scroll-wrapper">
					<div class="mui-scroll">
						<!-- 菜单具体展示内容 -->
						<ul class="mui-table-view mui-table-view-chevron mui-table-view-inverted">
							<div id="_userlogin">
								<!-- 未登录 -->
								<li class="mui-table-view-cell">
									<a href="/member/login.php">登录</a>
									<a href="/member/reg_new.php">注册</a>
								</li>
							</div>
							<script language="javascript" type="text/javascript">
								CheckLogin();
							</script>
							<li class="mui-table-view-cell">
								<a href="/" class="mui-navigate-right">首页</a>
							</li>
							<li class="mui-table-view-cell mui-collapse">
								<a href="/flgw/124.html" class="mui-navigate-right">法律顾问</a>
								<ul class="mui-table-view mui-table-view-chevron mui-table-view-inverted">
									<li class="mui-table-view-cell"><a class="mui-navigate-right" href="/flgw/124.html">企业法律顾问</a></li>
									<li class="mui-table-view-cell"><a class="mui-navigate-right" href="/flgw/125.html">个人法律顾问</a></li>
								</ul>
							</li>
							<li class="mui-table-view-cell">
								<a href="/nsht/" class="mui-navigate-right">审查合同</a>
							</li>
							<li class="mui-table-view-cell mui-collapse">
								<a href="/ask/?ct=question&ac=ask_complete" class="mui-navigate-right">法律咨询</a>
								<ul class="mui-table-view mui-table-view-chevron mui-table-view-inverted">
									<li class="mui-table-view-cell"><a class="mui-navigate-right" href="/ask/?ct=question&ac=ask_complete">在线法律咨询</a></li>
									<li class="mui-table-view-cell"><a class="mui-navigate-right" href="/flzx/123.html">电话法律咨询</a></li>
								</ul>
							</li>
							<li class="mui-table-view-cell">
								<a href="/zls/" class="mui-navigate-right">找律师</a>
							</li>
							<li class="mui-table-view-cell">
								<a href="/flbk/" class="mui-navigate-right">法律百科</a>
							</li>

						</ul>
					</div>
				</div>
			</aside>

			<!-- 主页面容器 -->
			<div class="mui-inner-wrap">
				<!--页面标题栏开始-->
				<header class="mui-bar mui-bar-nav order-menu">
					<a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
					<h1 class="mui-title">个人中心</h1>
					<a id="offCanvasBtn" href="#offCanvasSide" class="mui-pull-right mui-btn-link mui-icon mui-icon-more-filled"></a>
					<a class="mui-icon mui-icon-search mui-pull-right"></a>

				</header>
				<div id="offCanvasContentScroll" class="mui-content mui-scroll-wrapper">
					<div class="mui-scroll">
						<!-- 主体 -->
						<div class="order-con login" style="margin-top: 5rem;">
							<div class="mui-slider">
								<div class="order-nav">
									<a href="/member/shops_orders.php">订单管理</a>
									<a href="/ask/?ct=myask">我的咨询</a>
									<a href="/member/edit_baseinfo.php">修改密码</a>
									<a href="/member/edit_fullinfo.php">修改账户</a>
								</div>
								<div id="sliderProgressBar" class="mui-slider-progress-bar mui-col-xs-3"></div>
								<div class="mui-slider-group">
                                    
									<div class="mui-slider-item mui-control-content">
										<div class="weidian-weixinsaoma">
											<h3>现金支付</h3>
											<h3 style="color: red;">￥<?php echo $priceCount; ?></h3>
											<p> <span class="erweima"><img src="/include/qrcode.php?data=<?php echo $url;?>"></span> <h3  style="height: auto;">通过微信扫描二维码，进行快速支付</h3> </p>
											<h4> <a href="/member/shops_orders.php" class="mui-btn mui-btn-block mui-btn-success mui-icon mui-icon-home">支付完成</a><a href="/" class="mui-btn mui-btn-block mui-btn-primary mui-icon mui-icon-home">返回首页</a> </h4>
										</div>
									</div>
								</div>
								<h3 class="show-more">全国服务电话：182-0283-5355</h3>
							</div>
						</div>
						<div class="clear"></div>
					</div>
				</div>
				<div class="mui-off-canvas-backdrop"></div>
			</div>
		</div>

	</body>
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
		var gallery = mui('.mui-slider');
		gallery.slider({
			interval: 5000 //自动轮播周期，若为0则不自动播放，默认为0；
		});
		mui.init({
			swipeBack: false,
		});
		//侧滑容器父节点
		var offCanvasWrapper = mui('#offCanvasWrapper');
		//主界面容器
		var offCanvasInner = offCanvasWrapper[0].querySelector('.mui-inner-wrap');
		//菜单容器
		var offCanvasSide = document.getElementById("offCanvasSide");

		//移动效果是否为整体移动
		var moveTogether = false;
		//侧滑容器的class列表，增加.mui-slide-in即可实现菜单移动、主界面不动的效果；
		var classList = offCanvasWrapper[0].classList;
		//主界面和侧滑菜单界面均支持区域滚动；
		mui('#offCanvasSideScroll').scroll();
		mui('#offCanvasContentScroll').scroll();
		//实现ios平台的侧滑关闭页面；
		if (mui.os.plus && mui.os.ios) {
			offCanvasWrapper[0].addEventListener('shown', function(e) { //菜单显示完成事件
				plus.webview.currentWebview().setStyle({
					'popGesture': 'none'
				});
			});
			offCanvasWrapper[0].addEventListener('hidden', function(e) { //菜单关闭完成事件
				plus.webview.currentWebview().setStyle({
					'popGesture': 'close'
				});
			});
		}
	</script>

</html>
