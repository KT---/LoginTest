<?php
/* ===================================
*	tytel		:index.php
*	version		:v1.0
*	By			:KT
*	Data		:2017年6月5日
*   function    :访问默认页面，执行跳转功能
=======================================*/
    //启用$_SESSION超级全局变量
    session_start();
    //定义变量标识符，防止inc、func文件恶意调用
    define('LT_req',true);
    //调用index.inc.php
    require dirname(__FILE__).'/include/index.inc.php';


//     $_SESSION['HTTP_REFERER'] =md5('index.php');
//    print_r ($_SERVER);
//       echo $_SERVER['HTTP_HOST'];   
     header("Location:".JumpUrl); 
?>
