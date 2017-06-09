<?php
/* ===================================
*	tytel		:
*	version		:
*	By			:KT
*	Data		:2017年6月8日
=======================================*/
if(!defined('LT_req')){exit('非法调用');}
require dirname(__FILE__).'/common.func.php';


function  _check_email($_emailadd,$_action='alert')
{
    if(empty($_emailadd))
    {
        return null;
    }
    else if(!preg_match('/^[\w\-\.]{1,20}@[\w\-\.]{1,20}(\.\w+)+$/',$_emailadd))
    {
       if($_action == 'alert'){_alert_back("邮件格式不正确");}
       else if($_action == 'return'){return false;}
    }
    
    return $_emailadd;
}


function _check_password($_pwd,$_minlen,$_maxlen)
{
    if(mb_strlen($_pwd)<$_minlen || mb_strlen($_pwd)>$_maxlen)
    {
           _alert_back('密码长度应在'.$_minlen.'到'.$_maxlen.'之间');
    }
    if(!preg_match('/^[\w]{6,30}$/',$_pwd))
    {
        _alert_back('密码包含非法字符！');
    }
    return $_pwd;
}

function _check_verifcode($_length,$_postcode,$_checkcode)
{
    if(!(mb_strlen($_postcode) == $_length))
    {
        _alert_back("验证码长度是".$_length."位数字");
    }
    if(!($_postcode == $_checkcode))
    {
        _alert_back("验证码不正确！");
    }
}

function _check_identityCode($_postcode,$_checkcode)
{
    if(!($_postcode == $_checkcode))
    {
        exit('非法访问');
    }
    else
    {
        return $_postcode;
    }
}

?>




