<?php
if(!isset($GLOBALS['_vars'])) $GLOBALS['_vars'] = array(); 
$fields = array();
?><aside id="offCanvasSide" class="mui-off-canvas-right">
	<div id="offCanvasSideScroll" class="mui-scroll-wrapper">
		<div class="mui-scroll">
			<!-- 菜单具体展示内容 -->
			<div class="title">侧滑导航</div>
			<ul class="mui-table-view mui-table-view-chevron mui-table-view-inverted">
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