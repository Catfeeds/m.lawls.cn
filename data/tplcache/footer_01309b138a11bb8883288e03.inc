<?php
if(!isset($GLOBALS['_vars'])) $GLOBALS['_vars'] = array(); 
$fields = array();
?><div class="cpgb-fixed"> <a id="BizQQBottomCommon" href="http://wpa.qq.com/msgrd?v=3&amp;uin=2448211596&amp;site=qq&amp;menu=yes" class="cpgb-fixed-zixun">
    <p><img src="/templets/lawyer/images/qq.png" alt="QQ"><br>
        在线咨询</p>
    </a> <a class="cpgb-fixed-zixun cpgb-fixed-dianhua">
    <p><span class="ico-font tubiao">&#xea89;</span><br>
        联系电话</p>
    <span class="zx-haoma"> 18202835355 <img src="/templets/lawyer/images/jiantou.png" alt="箭头"> </span> </a> <a class="cpgb-fixed-zixun cpgb-fixed-dingbu">
    <p><img src="/templets/lawyer/images/dingbu.png" alt="QQ"><br>
        返回顶部</p>
    </a> </div>
<footer class="new-foot">
    <div class="nf-main">
        <div class="inner-box p-r">
            <div class="foot-logo">
                <h1><img src="/templets/lawyer/images/foot-logo.png" width="250px" alt="法易通法务服务"></h1>
            </div>
            <div class="nf-items">
                <section class="nf-item fl">
                    <h2 class="title">平台保障</h2>
                    <a>赔付保障</a> <a>执业认证</a> <a>网站认证</a> </section>
                <section class="nf-item fl">
                    <h2 class="title">关于我们</h2>
                    <a class="link-hover" target="_blank" href="/about/">关于法易通</a> <a class="link-hover" target="_blank" href="/team/">法易通团队</a> <a class="link-hover" target="_blank" href="/news/">法易通新闻</a> </section>
                <section class="nf-item fl">
                    <h2 class="title">加入我们</h2>
                    <a class="link-hover" target="_blank" href="/joinus/">加入法易通</a> <a class="link-hover" target="_blank" href="/linkus/">联系我们</a> </section>
                <section class="nf-item fl">
                    <h2 class="title">关注我们</h2>
                    <div class="nf-item-code"> <img src="/templets/lawyer/images/code.jpg" alt=""> </div>
                </section>
            </div>
            <div class="nf-message">
                <h2 class="nf-message-telephone">全国服务热线</h2>
                <h2 class="nf-message-telephonenumber">18202835355</h2>
            </div>
        </div>
    </div>
    <div class="nf-link">
        <div class="inner-box">
            <h5> <span>友情链接：</span> <?php
$atts = array();
$atts['tagname'] = 'flink';
$atts['row'] = '24';
$atts['titlelen'] = '24';
$atts['typeid'] = '0';
$blockValue = MakePublicTag($atts,$this->refObj,$fields); 
if(is_array($blockValue) && count($blockValue) > 0){
foreach( $blockValue as $key=>$fields )
{
?> [field:link /] <?php
}
}
?> </h5>
            <h4> <?php echo $GLOBALS['cfg_beian']; ?> <span><?php echo $GLOBALS['cfg_powerby']; ?></span> </h4>
        </div>
    </div>
</footer>