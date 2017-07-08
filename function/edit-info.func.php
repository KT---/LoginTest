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

function _check_updatainsert_editbaseinfo($_base_info)
{
    
}

?>