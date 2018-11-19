<?php
if(!isset($GLOBALS['_vars'])) $GLOBALS['_vars'] = array(); 
$fields = array();
?><!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<title>浏览订单 - 法易通法律法务</title>
		<meta name="keywords" content="<?php echo $fields['keywords']; ?>" />
		<meta name="description" content="<?php echo html2text($fields['description']); ?>" />
		<script src="/js/mui.min.js"></script>
		<link href="/css/mui.min.css" rel="stylesheet" />
		<link href="/css/style.css" rel="stylesheet" />
		<script type="text/javascript" charset="utf-8">
			mui.init();
		</script>
		<script type="text/javascript">
			//获得选中文件的文件名
			function GetCheckfolderItem() {
				var allSel = '';
				if (document.form1.deleteid.value) return document.form1.deleteid.value;
				for (i = 0; i < document.form1.deleteid.length; i++) {
					if (document.form1.deleteid[i].checked) {
						if (allSel == '')
							allSel = document.form1.deleteid[i].value;
						else
							allSel = allSel + "," + document.form1.deleteid[i].value;
					}
				}
				return allSel;
			}

			function DoSubmit() {
				var selid = GetCheckfolderItem();
				if (selid == '') {
					alert("你没选中任何信息！");
					return false;
				}
				if (window.confirm("你确定要删除这些消息么？"))

				{
					location = "shops_products.php?dopost=del&ids=" + selid;
				}
			}
		</script>
	</head>
	<body>
		<!-- 侧滑导航根容器 -->
		<div id="offCanvasWrapper" class="mui-off-canvas-wrap mui-draggable mui-scalable">
			<!-- 菜单容器 -->
			<script language="javascript" type="text/javascript" src="<?php echo $GLOBALS['cfg_cmsurl']; ?>/include/dedeajax2.js"></script>
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
                                    <h3>我的订单</h3>
									<div class="mui-slider-item mui-control-content">
										<form name='form1' action="shops_orders.php" method="post">
											<input type='hidden' name='dopost' value='del' />
											<ul class="mui-table-view">
												<?php
$atts = array();
$atts['tagname'] = 'datalist';
$blockValue = $this->refObj->GetArcList($atts,$this->refObj,$fields); 
if(is_array($blockValue)){
foreach( $blockValue as $key=>$fields )
{
?>
												<li class="mui-table-view-cell mui-media">

														<!-- <input type="checkbox" name="deleteid" value="<?php echo $fields['oid']; ?>" /> -->
														<img class="mui-media-object mui-pull-left" src="/images/defaultpic.gif">
														<div class="mui-media-body mui-pull-left">
															<a href="shops_products.php?do=show&oid=<?php echo $fields['oid']; ?>"><?php echo GetTitle($fields["oid"]);?>
															<p>不限次数咨询+不限合同次数</p></a>
														</div>
                                                        <div class="mui-media-body" style="margin-top: 10px;margin-bottom: 10px;float: left;">
                                                        	<span>
                                                        		<?php echo GetSta($fields["state"],$fields["oid"])?></span>
                                                        	<p class="mui-ellipsis">￥<?php echo $fields['price']; ?> <i>x1</i></p>
                                                        	<span>
                                                        		<?php echo GoPay($fields["state"],$fields["oid"])?></span>
                                                        </div>
													<div class="tips">确认下单付款--30分钟内客服回电确认订单--发送服务函、企业风险调查表--法务对接，正式服务。</div>
												</li>
                                                <!-- <div class="wait-pay"><a class="cancel" href="javascript:void(0)" class="cancel-order" onclick="DoSubmit()">删除订单</a></div> -->
												<?php
}
}?>
											</ul>
											
											<ul class="mui-pagination mui-pagination-sm">
												<?php
$atts = array();
$atts['tagname'] = 'pagelist';
$atts['listitem'] = 'info,index,end,pre,next,pageno';
$atts['listsize'] = '5';
 echo $this->refObj->GetPageList($atts,$this->refObj,$fields); 
?>

											</ul>
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