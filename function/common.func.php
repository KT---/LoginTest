<?php
/* ===================================
 *	tytel		:
 *	version		:
 *	By			:KT
 *	Data		:2017/6/8
 =======================================*/
if(!defined('LT_req')){exit('非法调用');}

function _alert_back($_alert_info)
{
    echo "<script language=javascript>alert("."'".$_alert_info."'".");history.back();</script>";
//      echo $_info;
     exit();
}
?>
