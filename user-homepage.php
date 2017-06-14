<?php
/* ===================================
 *	tytel		:user-homepage.php
 *	version		:v1.0
 *	By			:KT
 *	Data		:2017年6月5日
 *  function    :登录成功后跳转主页面（测试）
 =======================================*/


//启用$_SESSION超级全局变量
session_start();
//定义变量标识符，防止inc、func文件恶意调用
define('LT_req',true);

require dirname(__FILE__).'/function/login-register.func.php';
require dirname(__FILE__).'/include/mysql.inc.php';

if(!isset($_COOKIE['LT_uid']))
{
    echo "<script language=javascript>location.href='index.php';</script>";
}
$_mysql_fetch = mysql_fetch_assoc(mysql_query("SELECT * FROM `user_info` WHERE `user_uid` LIKE '{$_COOKIE['LT_uid']}'"));
print_r($_mysql_fetch);

mysql_close();
?>
<!DOCTYPE html>
<html lang="zh-cn" class="no-js"> 
    <head>
        <meta charset="UTF-8" />
        <!-- <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">  -->
        <title>主页</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <meta name="description" content="Login and Registration Form with HTML5 and CSS3" />
        <meta name="keywords" content="html5, css3, form, switch, animation, :target, pseudo-class" />
        <meta name="author" content="Codrops" />
        <link rel="shortcut icon" href="./icon/pooh.ico">  
        <link rel="stylesheet" type="text/css" href="css/demo.css" />
        <link rel="stylesheet" type="text/css" href="css/style.css" />
		<link rel="stylesheet" type="text/css" href="css/animate-custom.css" />
    </head>
    <body>
        <div class="container">
            <header>
                <h1>奶油猪<span>客户管理系统</span></h1>
				<nav class="codrops-demos">
<!-- 					<a href="LoginZh-cn.php" class="current-demo">简体中文</a>
					<a href="index2.html">繁體中文</a>
					<a href="index3.html">English</a> -->
				</nav>
            </header> 
       </div>
    </body>
</html>