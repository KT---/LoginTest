<?php
/* ===================================
*	tytel		:login-register.func.php
*	version		:v1.0
*	By			:KT
*	Data		:2017年6月8日
=======================================*/
if(!defined('LT_req')){exit('非法调用');}
require dirname(__FILE__).'/common.func.php';
require dirname(__FILE__).'./../include/mysql.inc.php';

/**
 * 
 * @function:查询一个email地址的格式合法性，格式错误可选择弹框报错或反馈false值，正确返回email地址;
 * @name _check_email
 * @param string $_emailadd :传入email字符串
 * @param string $_action :正则判断异常'alert'表示直接弹框提示并返回 ,'return'则表示返回false
 * @return NULL|false|$_emailadd
 * 
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
 * @function:查询一个密码字符串的格式合法性，可以传入参数确定长度的最大值和最小值，可传入密码确认字符串进行对比
 * @name _check_password
 * @param string $_pwd：密码字符串
 * @param int $_minlen：最短长度
 * @param int $_maxlen：最长长度
 * @param $_pwdcf:确认密码
 * @return $_pwd
 * 
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
 * @function:查询对照验证码
 * @name  _check_verifcode
 * @param int $_length： 验证码长度
 * @param string $_postcode:表单提交的验证码
 * @param string $_checkcode：查询的验证码
 * 
 */
function _check_verifcode($_length,$_postcode,$_checkcode)
{
    if(!(mb_strlen($_postcode) == $_length))
    {
        _alert_back("验证码长度是".$_length."位数字");
        exit();
    }
    if(!($_postcode == $_checkcode))
    {
        _alert_back("验证码不正确！");
        exit();
    }
}

/**
 * 
 * @function:查询唯一标识码
 * @name  _check_identityCode
 * @param string $_postcode:表单提交的唯一标识码
 * @param string $_checkcode：查询的唯一标识码
 * @return $_postcode 正确返回唯一标识码
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

/**
 * 
 * @function:检查用户名合法性，可传入用户名长度大小，及非法用户名进行判断
 * @name _check_username
 * @param string $_username：传入检查用户名
 * @param int $_minlen：定义最短长度
 * @param int $_maxlen：定义最长长度
 * @param array $_illegalchar：非法用户名
 * @return $_username：检查通过后返回用户名
 * 
 */
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

/**
 * 
 * @function:检查电话号码格式合法性
 * @name _check_phonenum
 * @param string $_phonenum:传入检查电话号码字符串
 * @param int $_numlen：定义电话号码长度
 * @return $_phonenum:传出验证后电话号码
 * 
 */
function _check_phonenum($_phonenum,$_numlen = 0)
{
    if($_numlen != 0 && strlen($_phonenum) != $_numlen)
    {
        _alert_back('电话号码长度应为'.$_numlen.'位');
    }
    if(!preg_match('/^[0-9]+$/', $_phonenum))
    {
        _alert_back('电话号码应为纯数字');
    }
    return $_phonenum;
}

/**
 * 
 * @function:验证数据库某表单的对应某字段是否存在
 * @name _check_mysql_repetition
 * @param $_SELECTfield：返回字段
 * @param $_TABLEname：表单名称
 * @param $_WHEREfield：检查的字段
 * @param $_LIKEfield：是否存在参数
 * @param $_alterinfo：如果参数存在，报错内容
 * @param $_action：'alter'表示弹框报错  'return'表示返回获取到的返回字段
 * @return $_mysql_query:返回字段
 * 
 */
function _check_mysql_repetition($_SELECTfield,$_TABLEname,$_WHEREfield,$_LIKEfield,$_alterinfo = '错误',$_action = 'alter')
{
    $_mysql_query = mysql_fetch_assoc(mysql_query("SELECT {$_SELECTfield} FROM {$_TABLEname} WHERE {$_WHEREfield} LIKE '$_LIKEfield'"));
    if(null != $_mysql_query)
    {
        if($_action == 'alter')
        {
            _alert_back($_alterinfo);
        }
        else if($_action == 'return')
        {
            return $_mysql_query;
        }   
    }
}

/**
 * function:验证登录函数
 * @name _login_verify
 * @param $_loginuser：用户登录信息，数组包含用户名或邮箱、登录密码
 * @return $_mysql_fetch:返回获取该用户的所有信息
 * 
 */
function _login_verify($_loginuser = array())
{
    if(false != _check_email($_loginuser['username'],'return'))
    {
        $_mysql_fetch = mysql_fetch_assoc(mysql_query("SELECT * FROM `user_info` WHERE `user_email` LIKE '{$_loginuser['username']}'"));
    }
    else
    {
        $_mysql_fetch = mysql_fetch_assoc(mysql_query("SELECT * FROM `user_info` WHERE `user_name` LIKE '{$_loginuser['username']}'"));
    }
    if($_mysql_fetch['user_pwd'] == NULL)
    {
        _alert_back('用户不存在！');
        exit();
    }
    if(!(sha1(md5($_loginuser['password'])) == $_mysql_fetch['user_pwd']))
    {
        _alert_back('密码错误!');
        exit();
    }
    return $_mysql_fetch;
}
?>




