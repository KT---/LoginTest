<?php
/* ===================================
*	tytel		:
*	version		:
*	By			:KT
*	Data		:2017年6月8日
=======================================*/
if(!defined('LT_req')){exit('非法调用');}
require dirname(__FILE__).'/common.func.php';


function  _check_email($_emailadd)
{
    if(empty(_emailadd))
    {
        return null;
    }
    else if(!preg_match('/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/', _emailadd))
    {
        _alert_back("邮件格式不正确");
    }
    
    return _emailadd;
}


function _check_password($_pwd,$_minlen,$_maxlen)
{
    if(mb_strlen($_pwd)<$_minlen || mb_strlen($_pwd)>$_maxlen)
    {
//         _alert_back("密码长度应在"."'".$_minlen."'"."到"."'".$_maxlen."'"."位之间！");
           _alert_back('密码长度应在'.$_minlen.'到'.$_maxlen.'之间');
    }
}

function _check_verifcode($_num,$_postcode,$_checkcode)
{
    
}

?>