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
		<title><?php echo $fields['seotitle']; ?>_<?php echo $GLOBALS['cfg_indexname']; ?></title>
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
			<?php include $this->CompilerInclude("aside.htm");
 ?>
			<!-- 主页面容器 -->
			<div class="mui-inner-wrap">
				<?php include $this->CompilerInclude("header.htm");
 ?>
				<div id="offCanvasContentScroll" class="mui-content mui-scroll-wrapper">
					<div class="mui-scroll">
						<div class="mui-slider">
							<div class="mui-slider-group mui-slider-loop">
								<!--支持循环，需要重复图片节点-->
								<div class="mui-slider-item mui-slider-item-duplicate"><a href="#"><img src="/images/banner1.jpg" /></a></div>
								<div class="mui-slider-item"><a href="#"><img src="/images/banner1.jpg" /></a></div>
								<div class="mui-slider-item"><a href="#"><img src="/images/banner1.jpg" /></a></div>
								<!--支持循环，需要重复图片节点-->
								<div class="mui-slider-item mui-slider-item-duplicate"><a href="#"><img src="/images/banner1.jpg" /></a></div>
							</div>
						</div>

						<div class="clear"></div>
						<!-- 推荐新闻-->
						<div class="car" style="margin-top: 6rem;">
							<h4>收件信息</h4>
							<form class="mui-input-group">
								<div class="mui-input-row">
									<label>手 机：</label>
									<input type="text" class="mui-input-clear" placeholder="律师解答咨询的联系方式" data-input-clear="5"><span class="mui-icon mui-icon-clear mui-hidden"></span>
								</div>
								<div class="mui-input-row">
									<label>邮 箱：</label>
									<input type="text" class="mui-input-clear" placeholder="接收律师起草合同的邮箱" data-input-clear="5"><span class="mui-icon mui-icon-clear mui-hidden"></span>
								</div>
								<div class="mui-button-row">
									<button type="submit" class="mui-btn mui-btn-primary" onclick="return false;">确认</button>&nbsp;&nbsp;
									<button type="reset" class="mui-btn mui-btn-danger" onclick="return false;">取消</button>
								</div>
								<h4>订单详情 (编号：<?php echo $GLOBALS['_vars']['carts']['orders_id']; ?>)</h4>
                                <?php  foreach($GLOBALS['Items'] as $key=>$value){ ?>
								<ul class="mui-table-view">
									<li class="mui-table-view-cell mui-media">
										<a href="javascript:;" class="">
											<img class="mui-media-object mui-pull-left" src="/images/dingtu.png">
											<div class="mui-media-body">
												<?php echo $value['title']; ?>
												<p class="mui-ellipsis">不限次数咨询+不限合同份数</p>
												<p class="mui-ellipsis">确认下单付款——30分钟内客服电话确认——发送服务函、企业风险调查表——法务对接，开始服务</p>
											</div>
										</a>
									</li>
									<li class="mui-table-view-cell mui-media">
										<a href="javascript:;">
											<div class="mui-media-body">
												总计：￥<span style="color: red; font-weight: bold;"><?php echo $value['price']; ?></span>元
											</div>
										</a>
									</li>
								</ul>
                                <?php  }    ?>

							</form>
						</div>
						<!-- 服务热线-->
						<div class="bottom">
							<div class="bottom-con">
								<h4>近一周，已有<span>1325人</span>获得解决方案</h4>
								<p>“互联网+法务团队”通过集体智慧，提供卓越的法律服务</p>
								<p>服务热线：<span>18202835355</span></p>
							</div>
						</div>
						<!-- 底部 -->
						<?php include $this->CompilerInclude("footer.htm");
 ?>
					</div>
				</div>
				<div class="mui-off-canvas-backdrop"></div>
			</div>
		</div>
	</body>
	<?php include $this->CompilerInclude("commonJs.htm");
 ?>
</html>