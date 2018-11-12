<?php
if(!isset($GLOBALS['_vars'])) $GLOBALS['_vars'] = array(); 
$fields = array();
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $cfg_soft_lang;?>">
<title>问题管理</title>
<link href="static/style/admin.css" rel="stylesheet" type="text/css" />
<script language='javascript'>

	function DelOld()

	{

		if(window.confirm("你确实要删除选定的记录么？"))

		{

			document.lurdform.ac.value = 'delete';

			document.lurdform.submit();

		}

	}

	function CheckOld()

	{

		if(window.confirm("你确实要审核选定的记录么?"))

		{

			document.lurdform.ac.value = 'check';

			document.lurdform.submit();

		}

	}

	function GigestOld()

	{

		if(window.confirm("你确实要推荐选定的记录么?"))

		{

			document.lurdform.ac.value = 'digest';

			document.lurdform.submit();

		}

	}

	function AllSel(ntype)

	{

		var f = document.lurdform;

		for(var i=0; i < f.elements.length; i++)

		{

			if(f.elements[i].type=='checkbox') {

				if(ntype==1) f.elements[i].checked = true;

				else if(ntype==0) f.elements[i].checked = false;

				else f.elements[i].checked = !f.elements[i].checked;

			}

		}

	}

</script>
</head>

<body>
<div class="bodytitle">
    <div class="bodytitleleft"></div>
    <div class="bodytitletxt" style="padding-left:10px;"><b>问答模块</b> -- 提问管理 </div>
</div>
<tr>
    <td align='center' valign='top'>
           <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr bgcolor="#FFFFFF">
                <td height="4"></td>
            </tr>
        </table>
        <table width="98%" border="0" cellpadding="1" cellspacing="1" align="center" class="tbtitle" style="background:#cfcfcf;">
           <form action="/include/setprice.php" method="post">
            <tr style="background:#cfcfcf;">
                <td width="30%" height="26" colspan="8" align="left" bgcolor="#EDF9D5" background="static/images/tbg.gif" style="padding-left:10px;"><b>价格设置 &nbsp;</b></td>
                <td height="26" colspan="8" align="left" bgcolor="#EDF9D5" background="static/images/tbg.gif">&nbsp;</td>
            </tr>
            <?php
				global $dsql;
				$sql = "Select * From dede_askprice";
				$row=$dsql->getone($sql);
            ?>
            <tr style="padding-left: 40px;">
                <td width="30%" height="26" colspan="8" bgcolor="#fff" align="right"><b>
                专业解答： &nbsp;</b></td>
                <td height="26" colspan="8" bgcolor="#fff" align="left"><input type="number" name="major" style="width: 80px; font-size: 18px; text-align: center; height: 25px;" required min="0" max="10000" value="<?php echo $row['major']?>"></td>
            </tr>
            <tr style="padding-left: 40px;">
                <td width="30%" height="26" colspan="8" bgcolor="#fff" align="right"><b>资深解答： &nbsp;</b></td>
                <td height="26" colspan="8" bgcolor="#fff" align="left"><input type="number" name="senior" style="width: 80px; font-size: 18px; text-align: center; height: 25px;" required min="0" max="10000" value="<?php echo $row['senior']?>"></td>
            </tr>
            <tr style="padding-left: 40px;">
                <td width="30%" height="26" colspan="8" bgcolor="#fff" align="right"><b>出方案解答： &nbsp;</b></td>
                <td height="26" colspan="8" bgcolor="#fff" align="left"><input type="number" name="project" style="width: 80px; font-size: 18px; text-align: center; height: 25px;" required min="0" max="10000" value="<?php echo $row['project']?>"></td>
            </tr>
            <tr>
                <td width="30%" height="26" colspan="8" bgcolor="#fff" align="right">&nbsp;</td>
                <td height="26" colspan="8" bgcolor="#fff" align="left"><input style="width: 90px; height: 35px; line-height: 35px; font-size: 16px; font-weight: bold; color: #fff;background: red;" type="submit" value="提交修改"></td>
            </tr>
			</form>
		</table>
        <table width="98%" border="0" cellpadding="1" cellspacing="1" align="center" class="tbtitle" style="background:#cfcfcf;">
            <tr>
                <td height="26" colspan="8" align="left" bgcolor="#EDF9D5" background="static/images/tbg.gif" style="padding-left:10px;"><b>问题列表 &nbsp; <a href="admin.php?ct=issue&status=-1">未审核</a> | <a href="admin.php?ct=issue&status=1">已解决</a> | <a href="admin.php?ct=issue&status=0">待解决</a> | <a href="admin.php?ct=issue&status=2">已关闭</a> | <a href="admin.php?ct=issue&status=3">已过期</a></b></td>
            </tr>
            <form name="lurdform" action="<?php
$atts = array();
$atts['tagname'] = 'server';
$atts['name'] = 'PHP_SELF';
$blockValue = MakePublicTag($atts,$this->refObj,$fields); 
if(is_array($blockValue) && count($blockValue) > 0){
foreach( $blockValue as $key=>$fields )
{

}
}
?>" method="post">
                <input type='hidden' name='ct' value='<?php echo $GLOBALS['ct']; ?>' />
                <input type='hidden' name='ac' value='listenall' />
                <input type='hidden' name='bc' value='' />
                <input type='hidden' name='pageno' value='<?php echo $GLOBALS['pageno']; ?>' />
                <tr height="25" align="center" bgcolor="#FBFCE2">
                    <td  width="6%" align="center">选择</td>
                    <td width="4%" align="center">ID</td>
                    <td width="26%" align="center">问题</td>
                    <td width="10%" align="center">提问时间</td>
                    <!-- <td width="10%" align="center">所属大分类</td> -->
                    <td width="10%" align="center">提问者</td>
                    <td width="10%" align="center">所属分类</td>
                    <td width="6%" align="center">修改问题</td>
                    <td width="8%" align="center">是否解答</td>
                    <td width="6%" align="center">问题状态</td>
                </tr>
                <?php
$atts = array();
$atts['tagname'] = 'datalist';
$blockValue = $this->refObj->GetArcList($atts,$this->refObj,$fields); 
if(is_array($blockValue)){
foreach( $blockValue as $key=>$fields )
{

                    global $dsql;
                    $id = $fields['id'];
                    $rows = $dsql->GetOne("SELECT s.state FROM #@__ask AS a LEFT JOIN #@__shops_orders AS s ON a.oid=s.oid WHERE a.id='$id'");
                    if($fields['replies'] > 0){
                        $fields['status'] = '已解答';
                    }else if($fields['replies'] <=0){
                        if($rows['state']==0){
                            $fields['status'] = '未付款';
                        }else{
                            $fields['status'] = '待解答';
                        }
                    }else if($fields['status']<0){
                        $fields['status'] = '未审核';
                    }
                    /*if($fields['status'] == 0){
                        $fields['status'] = '待解决';
                    }else if($fields['status'] == 1 || $fields['status'] == 2 || $fields['status'] == 3){
                        $fields['status'] = '已解决';
                    }else if($fields['status'] == 2 ){
                        $fields['status'] = '已关闭';
                    }else if($fields['status'] == 3){
                        $fields['status'] = '已过期';
                    }else if($fields['status']<0){
                        $fields['status'] = '未审核';
                    }*/
                    $tid2url = "";
                    if(empty($status)){
                        $tidurl = "admin.php?tid=".$fields['tid'];
                        if($fields['tid2']) $tid2url = "admin.php?tid2=".$fields['tid2'];
                    }else{
                        $tidurl = "admin.php?status=".$status."&tid=".$fields['tid'];
                        if($fields['tid2']) $tid2url = "admin.php?status=".$status."&tid2=".$fields['tid2'];
                    }
                ?>
                <tr align='center' bgcolor="#FFFFFF"  onMouseMove="javascript:this.bgColor='#FCFDEE';" onMouseOut="javascript:this.bgColor='#FFFFFF';" height="22" >
                    <td><input type="checkbox" name="id[]" value="<?php echo $fields['id']; ?>" /></td>
                    <td><?php echo $fields['id']; ?></td>
                    <td align='left'><?php echo $fields['digest']==1? '<font color="red">[荐]</font>' : ''; ?><a href="?ct=adminAnswer&ac=edit&askaid=<?php echo $fields['id']; ?>"><?php echo $fields['title']; ?></a></td>
                    <td><?php echo GetDateTimeMk($fields['dateline']); ?></td>
                    <td><?php
                        $id = $fields['id'];
                        $sql = "SELECT m.* FROM `#@__member` as m left join `#@__ask` as a on m.mid=a.uid  WHERE a.id='{$id}'";
                        $row = $dsql->getOne($sql);
                        echo $row['phone'];
                        ?></td>
                    <!-- <td><a href="<?php echo $tidurl;?>"><?php echo $fields['tidname']; ?></a></td> -->
                    <td><a href="<?php echo $tid2url;?>"><?php echo $fields['tid2name']; ?></a></td>
                    <td><a class="coolbg" href="?ct=adminAnswer&ac=edit&askaid=<?php echo $fields['id']; ?>">修改问题</a></td>
                    <?php 
                    if($fields['replies'] == 0){
                        echo '<td><a href="?ct=adminAnswer&askaid='.$fields['id'].'">点击回答</a></td>'; 
                    }else{
                        echo '<td><a href="?ct=answer&askid='.$fields['id'].'">已解答</a></td>';
                    }
                    ?>
                    <td><?php echo $fields['status']; ?></td>
                </tr>
                <?php
}
}?>
            </form>
            <tr bgcolor="#ffffff">
                <td height="30" colspan="8" align="left">&nbsp; <a href="javascript:AllSel(1)" class="coolbg">全选</a> <a href="javascript:AllSel(0)" class="coolbg">取消</a> <a href="javascript:GigestOld()" class="coolbg">推荐</a> <a href="javascript:CheckOld()" class="coolbg">审核</a> <a href="javascript:DelOld()" class="coolbg">删除</a>  <!--<a href="?ct=adminAnswer&ac=ask_complete" class="coolbg">添加问题</a>--></td>
            </tr>
            <tr align="right" bgcolor="#F9FCEF">
                <td height="20" colspan="8" align="center"> <?php
$atts = array();
$atts['tagname'] = 'pagelist';
$atts['listsize'] = '5';
$atts['listitem'] = 'info,index,end,pre,next,pageno,form';
 echo $this->refObj->GetPageList($atts,$this->refObj,$fields); 
?>
 </td>
            </tr>
        </table></td>
</tr>
</body>
</html>