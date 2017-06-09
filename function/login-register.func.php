<?php
/* ===================================
*	tytel		:
*	version		:
*	By			:KT
*	Data		:2017年6月8日
=======================================*/
if(!defined('LT_req')){exit('非法调用');}
require dirname(__FILE__).'/common.func.php';

/**
 * 
 * @name _check_email
 * @param string $_emailadd :传入email字符串
 * @param string $_action :正则判断异常'alert'表示直接弹框提示并返回  'return'则表示返回false
 * @return NULL|false|$_emailadd
 */
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

/**
 * 
 * @name _check_password
 * @param string $_pwd
 * @param int $_minlen
 * @param int $_maxlen
 * @return $_pwd
 */
function _check_password($_pwd,$_minlen = 6,$_maxlen = 30,$_pwdcf = null)
{
    if(mb_strlen($_pwd)<$_minlen || mb_strlen($_pwd)>$_maxlen)
    {
        _alert_back('密码长度应在'.$_minlen.'到'.$_maxlen.'之间');
    }
    if(!preg_match('/^[\w]{6,30}$/',$_pwd))
    {
        _alert_back('密码包含非法字符！');
    }
    if(($_pwdcf != null) && ($_pwd != $_pwdcf))
    {
        _alert_back('密码确认出错，请重新输入!');
    }
    return $_pwd;
}

/**
 * 
 * @name  _check_verifcode
 * @param int $_length
 * @param string $_postcode
 * @param string $_checkcode
 */
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

/**
 * 
 * @name  _check_identityCode
 * @param unknown $_postcode
 * @param unknown $_checkcode
 * 
 */
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

function _check_username($_username,$_minlen = 4,$_maxlen = 20,$_illegalchar = array())
{
    if(mb_strlen($_username)<$_minlen)
    {
        _alert_back('用户名长度不应该小于'.$_minlen.'个字符!');
    }else if (mb_strlen($_username)>$_maxlen)
    {
        _alert_back('用户名长度不应该大于'.$_maxlen.'个字符!');
    }
    
    if(preg_match('/[\@\.\- ]+/', $_username))
    {
        _alert_back('用户名包含非法字符!');
    }
    
    $i = 0;
    while(isset($_illegalchar[$i]))
    {
        if(preg_match($_illegalchar[$i], $_username))
        {
            _alert_back('用户名不合法或已存在!');
        } 
        $i++;
    }
    return $_username;
}
?>




