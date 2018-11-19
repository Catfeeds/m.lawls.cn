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
							<form class="mui-input-group" id="fixupformid" name="fixupform" action="carbuyaction.php" method="post">
								<div style="display:none;">
									<input name="do" type="hidden" value="clickout">
								</div>
								<div class="mui-input-row">
									<label>手 机：</label>
									<input type="text" name="tel" class="mui-input-clear" placeholder="律师解答咨询的联系方式" maxLength="11" onkeyup="value=value.replace(/[^1234567890-]+/g,'')"
									 id="OrderMobile" required="required" data-input-clear="5"><span class="mui-icon mui-icon-clear mui-hidden"></span>
								</div>
								<div class="mui-input-row">
									<label>邮 箱：</label>
									<input type="text" name="email" class="mui-input-clear" placeholder="接收律师起草合同的邮箱" maxLength="30" type="text"
									 value="" id="OrderEmail" data-input-clear="5"><span class="mui-icon mui-icon-clear mui-hidden"></span>
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

								<h4>支付方式</h4>
								<div class="ddgb-zf-xuanzhe">
									<input type="hidden" name="paytype" value="7" id="OrderPaymentType" />
									<?php  foreach($GLOBALS['shops_paymentarr'] as $key=>$value){ ?>
									<div class="zf-xz-inner">
										<label class="guanlian" for="pay05" id="pay0<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
									</div>
									<?php  }    ?>
 </div>
								<h3>应付金额：<span class="dahong"><span class="youjianju">¥</span> <span class="confirm-price"><?php echo $GLOBALS['_vars']['carts']['price_count']; ?></span></span></h3>
								<!-- <tr>
										<td width="180" class="td1">验证码</td>
										<td><a name="mate_vdimgck" />
											<input name="vdcode" id="vdcode" type="text" class="ipt-txt" size="10" style="text-transform:uppercase;" />
											<a href="#mate_vdimgck"><img id="vdimgck_img" src="../include/vdimgck.php" hspace="6" align="absmiddle" onClick="vdimgck();" title="看不清换一张" /></a> <a href="#mate_vdimgck" onClick="vdimgck();">看不清换一张</a></td>
									</tr> -->
								<button type="submit" id="btnPaySubmit" class="mui-btn mui-btn-primary mui-btn-block">提交订单</button>
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
	<script src="/js/jquery-1.8.1.min.js"></script>
	<script type="text/javascript" src="/js/order-payment-selection-stylexin.js"></script>
	<script>
		$(function() {
			$(".zf-xz-inner").click(function(event) {
				$(this).addClass('zf-xz-inner-cheng').siblings('.zf-xz-inner').removeClass('zf-xz-inner-cheng');
			});
		});
		//手机验证
		function check_mobile(obj) {
			var m = $.trim(obj.val());
			if (m != '') {
				var reg = /^1[345789]\d{9}$/;
				var result = false;
				if (reg.test(m))
					result = true;
				if (result) {
					return true;
				} else {
					alert("请输入正确的手机号！");
					obj.focus();
					return false;
				}
			} else {
				alert("请输入手机号！");
				obj.focus();
				return false;
			}
		}

		function validateEmail(email) {
			if (email == "")
				return true;
			var pattern =
				/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
			if (!pattern.test(email)) {
				return false;
			} else {
				return true;
			}
		}
		$("#btnPaySubmit").click(function() {
			//var smsCode=$('#OrderSmsCode').val();
			var mobileObj = $('#OrderMobile');
			if (!check_mobile(mobileObj)) {
				return false;
			}
		});
	</script>
	<?php include $this->CompilerInclude("commonJs.htm");
 ?>
</html>