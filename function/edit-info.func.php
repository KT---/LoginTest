<?php
/* ===================================
 *	tytel		:edit-info.func.php
*	version		:v1.0
*	By			:KT
*	Data		:2017年7月6日
=======================================*/
if(!defined('LT_req')){exit('非法调用');}
// require dirname(__FILE__).'./common.func.php';
require dirname(__FILE__).'./login-register.func.php';
require dirname(__FILE__).'./../include/mysql.inc.php';

function _checkupdata_editlogininfo($_check_info,$_user_info)
{
    if(!($_check_info['editusername'] == $_user_info['user_name']))
    {
        _check_username($_check_info['editusername']);
        _check_mysql_repetition('user_name', 'user_info', 'user_name', $_check_info['editusername'],'用户名已被注册!');
        mysql_query("UPDATE `user_info` SET `user_name` = '{$_check_info['editusername']}' WHERE `user_info`.`user_id` = {$_user_info['user_id']}");
    }
    if(!($_check_info['editemail'] == $_user_info['user_email']))
    {
        _check_email($_check_info['editemail']);
        _check_mysql_repetition('user_email', 'user_info', 'user_email', $_check_info['editemail'],'邮箱已被注册!');
        mysql_query("UPDATE `user_info` SET `user_email` = '{$_check_info['editemail']}' WHERE `user_info`.`user_id` = {$_user_info['user_id']}");
    }
    if(!($_check_info['editphonenum'] == $_user_info['user_phone']))
    {
        _check_phonenum($_check_info['editphonenum']);
        _check_mysql_repetition('user_phone', 'user_info', 'user_phone', $_check_info['editphonenum'],'电话号码已被注册!');
        mysql_query("UPDATE `user_info` SET `user_phone` = '{$_check_info['editphonenum']}' WHERE `user_info`.`user_id` = {$_user_info['user_id']}");
    }


}

function _checkupdata_editpwd($_edit_pwd,$_check_pwd,$_user_info)
{
    $_updata_pwd = sha1(md5(_check_password($_edit_pwd,6,30,$_check_pwd)));//检查密码格式及加密
    mysql_query("UPDATE `user_info` SET `user_pwd` = '{$_updata_pwd}' WHERE `user_info`.`user_id` = {$_user_info['user_id']}");
}


function _check_updatainsert_editbaseinfo($_base_info,$_user_info)
{
    $_mysql_query = mysql_fetch_assoc(mysql_query("SELECT * FROM `user_baseinfo` WHERE `user_id` = {$_user_info['user_id']} "));
    if($_base_info['editbirthday-y'] != null || $_base_info['editbirthday-m'] != null || $_base_info['editbirthday-d'] != null)
    {
        $_base_info['editbirthday'] = _check_userbirth($_base_info['editbirthday-y'],$_base_info['editbirthday-m'],$_base_info['editbirthday-d']);
    }
    else
    {
        $_base_info['editbirthday'] = '1900-1-1';
    }
    if(isset($_mysql_query['user_id']))
    {
        if($_mysql_query['user_uid'] != $_user_info['user_uid'])
        {
            _alert_back('数据出错');
        }
        mysql_query("UPDATE `user_baseinfo` SET `user_sex` = '{$_base_info['editusersex']}', 
                            `user_realname` = '{$_base_info['editrealname']}', 
                            `user_birth` = '{$_base_info['editbirthday']}', 
                            `user_occupation` = '{$_base_info['edituserocc']}', 
                            `user_addr` = '{$_base_info['edituseraddr']}' WHERE 
                            `user_baseinfo`.`user_id` = {$_user_info['user_id']};");
    }
    else
    {
        mysql_query("INSERT INTO `user_baseinfo` (`user_id`, 
                                                  `user_uid`, 
                                                  `user_sex`, 
                                                  `user_realname`, 
                                                  `user_birth`, 
                                                  `user_occupation`, 
                                                  `user_addr`) 
                                          VALUES ('{$_user_info['user_id']}', 
                                                  '{$_user_info['user_uid']}', 
                                                  '{$_base_info['editusersex']}', 
                                                  '{$_base_info['editrealname']}', 
                                                  '{$_base_info['editbirthday']}', 
                                                  '{$_base_info['edituserocc']}', 
                                                  '{$_base_info['edituseraddr']}')");
    }
}


function _check_userbirth($_year,$_month,$_day)
{
    $_date = $_year.'-'.$_month.'-'.$_day;
    $_isdate = strtotime($_date);
    
    if(($_isdate === false) || ($_isdate >= time()))
    {
        _alert_back('日期格式不正确');
    }
    else
    {
         return $_date;
    } 
}

?>