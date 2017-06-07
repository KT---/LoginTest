<?php
/* ===================================
*	tytel		:
*	version		:
*	By			:KT
*	Data		:2017年6月7日
=======================================*/
if(!defined('Login_func')){exit('非法调用');}

function  _check_email($string)
{
    if(empty($string))
    {
        return null;
    }
    else if(!preg_match('/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/', $string))
    {
        return false;
    }
    return $string;
}
	
	
?>