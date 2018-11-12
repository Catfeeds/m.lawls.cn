<?php
$z[0]=Array("field","",3318,3336);
$z[0][4]=array();
$z[0][4]['name']="body";
$z[1]=Array("likesql","\n                <li>\n                    <div class=\"h15\"></div>\n                    <div class=\"tit_info fl\">\n                        <div class=\"title h40\"><a href=\"[field:id runphp='yes'] \$id=@me;@me='';\$url=GetOneArchive(\$id);@me=\$url['arcurl'];[/field:id]\" target=\"_blank\" title=\"[field:title/]\">[field:title/]</a></div>\n                        <div class=\"info\">[field:description/]</div>\n                    </div>\n                    <div class=\"clear\"></div>\n                </li>\n                ",3582,4299);
$z[1][4]=array();
$z[1][4]['sql']="Select * from dede_archives as a LEFT JOIN dede_lawyerinfos AS l ON l.tolawyer like \"~license~%\" where a.id = l.aid and a.typeid=79 and arcrank=0 ORDER BY aid desc limit 0,20";
$z[2]=Array("likesql","\n                <li>\n                    <div class=\"h15\"></div>\n                    <div class=\"tit_info fl\">\n                        <div class=\"title h40\"><a href=\"[field:id runphp='yes'] \$id=@me;@me='';\$url=GetOneArchive(\$id);@me=\$url['arcurl'];[/field:id]\" target=\"_blank\" title=\"[field:title/]\">[field:title/]</a></div>\n                        <div class=\"info\">[field:description/]</div>\n                    </div>\n                    <div class=\"clear\"></div>\n                </li>\n                ",4542,5259);
$z[2][4]=array();
$z[2][4]['sql']="Select * from dede_archives as a LEFT JOIN dede_lawyerinfos AS l ON l.tolawyer like \"~license~%\" where a.id = l.aid and a.typeid=80 and arcrank=0 ORDER BY aid desc limit 0,20";
$z[3]=Array("sql","\n                [field:content/]\n                ",5455,5577);
$z[3][4]=array();
$z[3][4]['sql']="Select content from dede_arctype where id=16";

?>