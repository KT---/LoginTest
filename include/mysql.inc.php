<?php
/* ===================================
*	tytel		:
*	version		:
*	By			:KT
*	Data		:2017年6月11日
=======================================*/
if(!defined('LT_req')){exit('非法调用');}

	define('DB_HOST','localhost');
	define('DB_USER','root');
	define('DB_PWD','tt147258369');
	define('DB_NAME','logintest_db');
	
	$_mysqlconnet = @mysql_connect(DB_HOST,DB_USER,DB_PWD)or die('无法访问数据库');
	
	@mysql_select_db(DB_NAME)or die('数据库不存在');
	
	@mysql_query('SET NAMES UTF8')or die('字符集错误');
	
?>