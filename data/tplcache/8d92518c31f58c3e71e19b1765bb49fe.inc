<li class="clearfix">
                            <div class="hb-right"> </div>
                            <a href="[field:arcurl/]" class="law-photo" target="_blank"><img src="[field:picname/]" alt="[field:title/]" /></a>
                            <div class="fl">
                                <p> <a href="[field:arcurl/]" class="f16 s-c333 fb" target="_blank">[field:title/]</a><i title="[field:title/]" class="ico-new i-new63"></i> [field:tag/] </p>
                                <div class="mt5 clearfix">
                                    <div class="w325 fl">
                                        <p>擅长：[field:skill/]</p>
                                        <p class="mt5"> <em class="law-qg">特色律所</em> <a href="[field:arcurl/]" target="_blank">[field:addr/]</a> </p>
                                        <p class="s-c999 mt5"><i class="ico-lr i-place mr5"></i>[field:address/]</p>
                                    </div>
                                    <div class="w373 fl">
                                        <p><span class="mr20">执业证号：[field:license/]</span></p>
                                    </div>
                                </div>
                                <div class="mt15 clearfix lh24">
                                    <div class="law-ensure pr fl mr30">
                                    [field:id runphp='yes']  
									$aid = @me;
									$row=$GLOBALS['dsql']->GetOne("select a.star FROM dede_addoninfos as a where a.aid='$aid' ");
									@me=str_repeat('<i class="ico-ft i-sr14 i-sr14-oe"></i>',$row['star']);
									[/field:id]
									 </div>
                                    <span title="执业认证" class="s-c999 mr20"><i class="ico-new i-new73 mr5"></i>执业认证</span> </div>
                            </div>
                        </li>