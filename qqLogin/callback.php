<?php
require_once(dirname(__file__)."/qqConnectAPI.php");
$qc = new QC();
$qc->qq_callback();
$qc->get_openid();
header("location:/member/login_qq.php");