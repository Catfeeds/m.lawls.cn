<?php
/**
 * @version        $Id: ajax_loginsta.php 1 8:38 2010年7月9日Z tianya $
 * @package        DedeCMS.Member
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
define('AJAXLOGIN', TRUE);
require_once(dirname(__FILE__)."/config.php");
AjaxHead();
if($myurl == ''){
        echo '<li class="mui-table-view-cell"><a href="/member/login.php">登录</a><a href="/member/reg_new.php">注册</a></li>';
        exit('');
}
$uid  = $cfg_ml->M_LoginID;
!$cfg_ml->fields['face'] && $face = ($cfg_ml->fields['sex'] == '女')? 'dfgirl' : 'dfboy';
$facepic = empty($face)? $cfg_ml->fields['face'] : $GLOBALS['cfg_memberurl'].'/templets/images/'.$face.'.png';
?> 
<li class="mui-table-view-cell"><a href="/member/shops_orders.php" class="mui-navigate-right" target="_blank">您好，<strong><?php echo $cfg_ml->M_Phone; ?></strong></a></li>
<li class="mui-table-view-cell"><a href="/member/index_do.php?fmdo=login&dopost=exit" class="mui-navigate-right">退出 </a></li>