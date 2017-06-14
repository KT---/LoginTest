<?php
/* ===================================
 *	tytel		:common.func.php
 *	version		:V1.0
 *	By			:KT
 *	Data		:2017/6/8
 =======================================*/
if(!defined('LT_req')){exit('非法调用');}

/**
 * 
 * @function:弹框提醒并退回前页
 * @name  _alert_back;
 * @param $_alert_info:弹框提醒内容
 * 
 */
function _alert_back($_alert_info)
{
    echo "<script language=javascript>alert("."'".$_alert_info."'".");history.back();</script>";
//      echo $_info;
     exit();
}

/**
 * 
 * @function:弹框提醒并跳转到某页面
 * @name  _alert_jump;
 * @param $_info:弹框提醒内容;
 *        $_url:跳转的页面地址;
 *
 */
function _aler_jump($_info,$_url)
{
    echo "<script language=javascript>alert('$_info');location.href='$_url';</script>";
    //      echo $_info;
    exit();
}

/**
 * 
 * @function:跳转到某页面
 * @name _jumplocation
 * @param $_url:跳转的页面地址;
 * 
 */
function _jumplocation($_url)
{
    echo "<script language=javascript>location.href='$_url';</script>";
    exit();
}
?>
