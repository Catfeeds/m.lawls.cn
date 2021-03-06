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
		<title>订单管理 - 法易通法律法务</title>
		<meta name="keywords" content="<?php echo $fields['keywords']; ?>" />
		<meta name="description" content="<?php echo html2text($fields['description']); ?>" />
		<script src="/js/mui.min.js"></script>
		<link href="/css/mui.min.css" rel="stylesheet" />
		<link href="/css/style.css" rel="stylesheet" />
		<script type="text/javascript" charset="utf-8">
			mui.init();
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
			<?php pasterTempletDiy("lawyer/aside.htm");?>
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
						<div class="order-con" style="margin-top: 5rem;">

							<div class="mui-slider login myask">
								
								<div class="order-nav">
									<a href="/member/shops_orders.php">订单管理</a>
									<a href="/ask/?ct=myask">我的咨询</a>
									<a href="/member/edit_baseinfo.php">修改密码</a>
									<a href="/member/edit_fullinfo.php">修改账户</a>
								</div>
								<div id="sliderProgressBar" class="mui-slider-progress-bar mui-col-xs-3"></div>
								<div class="mui-slider-group">
                                    <h3>我的咨询</h3>
									<div class="mui-slider-item mui-control-content">
										<div class="mui-card">
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
											<ul class="mui-table-view person">
												<li class="mui-table-view-cell mui-collapse mui-active">
													<a class="mui-navigate-right menunav" href="#">标 题</a>
													<div class="mui-collapse-content">
														<p>
															<?php echo $fields['title'];?>
														</p>
													</div>
												</li>
												<li class="mui-table-view-cell mui-collapse">
													<a class="mui-navigate-right menunav" href="#">状 态</a>
													<div class="mui-collapse-content">
														<p>
															<?php echo $fields['status'];?>
														</p>
													</div>
												</li>
												<li class="mui-table-view-cell mui-collapse">
													<a class="mui-navigate-right menunav" href="#">详细情况</a>
													<div class="mui-collapse-content">
														<p>
															<?php echo strip_tags($fields['content']) ;?>
														</p>
													</div>
												</li>
												<li class="mui-table-view-cell mui-collapse">
													<a class="mui-navigate-right menunav" href="#">律师回复</a>
													<div class="mui-collapse-content">
														<p>
															<?php echo strip_tags($fields['askcon']) ;?>
														</p>
													</div>
												</li>
												<li class="mui-table-view-cell mui-collapse">
													<a class="mui-navigate-right menunav" href="#">提问时间</a>
													<div class="mui-collapse-content">
														<p>
															<?php echo $fields['dateline'];?>
														</p>
													</div>
												</li>
												<li class="mui-table-view-cell mui-collapse">
													<a class="mui-navigate-right menunav" href="#">回复时间</a>
													<div class="mui-collapse-content">
														<p>
															<?php if(!empty($fields['lastanswer'])) echo MyDate('Y-m-d h:m:s', $fields['lastanswer']);
                                                			else echo '尚未回复';?>
														</p>
													</div>
												</li>
											</ul>
											<?php
}
}?>
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