<?php
$z[0]=Array("field","",220,242);
$z[0][4]=array();
$z[0][4]['name']="seotitle";
$z[1]=Array("global","",243,271);
$z[1][4]=array();
$z[1][4]['name']="cfg_indexname";
$z[2]=Array("field","",312,341);
$z[2][4]=array();
$z[2][4]['name']="keywords";
$z[3]=Array("field","",380,438);
$z[3][4]=array();
$z[3][4]['name']="description";
$z[3][4]['function']="html2text(@me)";
$z[4]=Array("include","",2531,2568);
$z[4][4]=array();
$z[4][4]['filename']="header.htm";
$z[5]=Array("field","",3686,3715);
$z[5][4]=array();
$z[5][4]['name']="position";
$z[6]=Array("infolink","\n                    <div class=\"choose-block\">\n                        <div class=\"city-bar\">\n                            <div class=\"title-part\">\n                                <h3>所在城市：</h3>\n                            </div>\n                            <div class=\"content-part\"> \n								[field:linkallplace /]\n								<select id=\"province\" onchange=\"provinceSelect(this,[field:channelid/],[field:typeid/],'[field:selyears/]','[field:skill/]')\">\n									<option value=\"\">选择省份</option>\n									[field:topplace /]\n								</select>\n								<select id=\"city\" onchange=\"citySelect(this,[field:channelid/],[field:typeid/],'[field:selyears/]','[field:skill/]')\">\n										<option value=\"\">选择县市</option>\n                                        [field:nativeplace /]\n								</select>\n                            </div>\n                        </div>\n                        <div class=\"special-bar\">\n                            <div class=\"title-part\">\n                                <h3>专长领域：</h3>\n                            </div>\n                            <div class=\"content-part\">\n								[field:typename /]\n							</div>\n                        </div>\n                        <div class=\"year-bar\">\n                            <div class=\"title-part\">\n                                <h3>执业年限：</h3>\n                            </div>\n                            <div class=\"content-part\" style=\"border-bottom: none;\">[field:linkalltype/] [field:infotype /]</div>\n                        </div>\n                    </div>\n                    <script>\n						\$(\"input[name='years']\").click(function(){\n							var yearsval = \$(this).val();\n							window.location.href=\"/plus/list.php?channelid=[field:channelid/]&tid=[field:typeid/]&skill=[field:skill/]&nativeplace=[field:selnat/]&infotype=\"+yearsval;\n						})\n					</script>\n                ",3961,5889);
$z[6][4]=array();
$z[7]=Array("list","\n                    		<div class=\"zj_bg\" style=\"background: url('[field:picname/]') no-repeat;background-size:cover;\">\n                    			<div class=\"zj_block\">\n                    				<div class=\"zj_main\">\n                    					<h1><a href=\"[field:arcurl/]\">[field:title/]</a></h1>\n                    					<span>[field:tags/]</span>\n                    					<p>擅长领域：[field:skill/]</p>\n                    				</div>\n                    			</div>\n               					<div class=\"zj_isShow\">\n									<div class=\"zj_main\" url=\"[field:arcurl/]\">\n										<h1>[field:title/]</h1>\n										<span>[field:addr/]</span>\n										<h3>[field:tel/]</h3>\n										<p><font style=\"font-size: 18px;\">“</font>[field:body function='cn_substr(html2text(@me),400)'/]...[详情]<font style=\"font-size:18px;\">”</font></p>\n										<div class=\"zj_addr\">\n											<p class=\"fl\"><span>半小时</span>内响应>></p>\n											<p class=\"fr addr\">[field:nativeplace/]</p>\n										</div>\n									</div>\n								</div>\n                    		</div>\n                    		",6782,7898);
$z[7][4]=array();
$z[7][4]['pagesize']="20";
$z[8]=Array("pagelist","",8066,8137);
$z[8][4]=array();
$z[8][4]['listitem']="info,index,end,pre,next,pageno";
$z[8][4]['listsize']="5";
$z[9]=Array("include","",8842,8879);
$z[9][4]=array();
$z[9][4]['filename']="footer.htm";

?>