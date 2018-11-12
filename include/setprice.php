<?php
	require_once ("common.inc.php");
	//接收设置的价格
	$major = htmlspecialchars($_POST['major']);
	$senior = htmlspecialchars($_POST['senior']);
	$project = htmlspecialchars($_POST['project']);
	//global $dsql;
	$sql = "UPDATE dede_askprice SET major ='$major',senior='$senior',project='$project' WHERE id = 1";
	$dsql->ExecuteNoneQuery($sql);
	echo('<script>window.history.back(-1); </script>');
?>