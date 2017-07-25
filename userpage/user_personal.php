<?php
/* ===================================
 *	tytel		:
 *	version		:v1.0
 *	By			:KT
 *	Data		:2017年6月15日
 *  function    :
 =======================================*/

    //启用$_SESSION超级全局变量
    session_start();
    //定义变量标识符，防止inc、func文件恶意调用
    define('LT_req',true);
    
    require dirname(dirname(__FILE__)).'/function/login-register.func.php';
    require dirname(dirname(__FILE__)).'/include/mysql.inc.php';
    
    if(!isset($_COOKIE['LT_uid']))
    {
        echo "<script language=javascript>location.href='index.php';</script>";
    }
    
    $_mysql_fetch = mysql_fetch_assoc(mysql_query("SELECT * FROM `user_info` WHERE `user_uid` LIKE '{$_COOKIE['LT_uid']}'"));
    $_baseinfo_mysql_fetch = mysql_fetch_assoc(mysql_query("SELECT * FROM `user_baseinfo` WHERE `user_uid` LIKE '{$_COOKIE['LT_uid']}'"));
    
    $_SESSION['identitycode'] = md5(mt_rand());//生成页面唯一标识码
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1, user-scalable=no"/>
<script src="../JS/common.js" type="text/javascript"></script>
<title>个人中心</title>

<link href="../bootstrap-3.3.5-dist/css/bootstrap.min.css" title="" rel="stylesheet" />
<link title="" href="../css/style.css" rel="stylesheet" type="text/css"  />
<link title="blue" href="../css/dermadefault.css" rel="stylesheet" type="text/css"/>
<link href="../css/templatecss.css" rel="stylesheet" title="" type="text/css" />
<!-- <script src="script/jquery-1.11.1.min.js" type="text/javascript"></script> -->
<!-- <script src="script/jquery.cookie.js" type="text/javascript"></script> -->
<script src="../bootstrap-3.3.5-dist/js/bootstrap.min.js" type="text/javascript"></script>
</head>

<body>
<div class="nav navbar-default navbar-mystyle navbar-fixed-top">
  <div class="navbar-header">
<!--     <button class="navbar-toggle" > 
     <span class="icon-bar"></span> 
     <span class="icon-bar"></span> 
     <span class="icon-bar"></span> 
    </button> -->
    <a class="navbar-brand mystyle-brand"><span class="glyphicon glyphicon-home"></span></a></div>
  <div class="collapse navbar-collapse">
    <ul class="nav navbar-nav">
      <li class="li-border"><a class="mystyle-color" href="user-home.php"> 奶油猪登陆管理系统</a></li>
        <div class="time-title pull-right">
          <div class="year-month pull-right">
            <p><span><?php echo date('Y',time()); ?></span><?php echo '年'.date('m',time()).'月'.date('d',time()).'日';?></p>
          </div>
        </div>
    </ul>
    
    <ul class="nav navbar-nav pull-right">
       <li class="dropdown li-border"><a href="#" class="dropdown-toggle mystyle-color" ><?php echo '邮箱：'.$_mysql_fetch['user_email'];?></a></li>
            <li class="li-border dropdown"><a href="javascript:resetCookie('LT_uid','0','/LoginTest')" class="mystyle-color" > 登出</a></li>
    </ul>
  </div>
</div>
<div class="down-main">
  <div class="left-main left-full">
    <div class="sidebar-fold"><span class="glyphicon glyphicon-menu-hamburger"></span></div>
    <div class="subNavBox">
      <div class="sBox">
        <ul class="navContent" style="display:block">
          <li class="active">
            <div class="showtitle" style="width:100px;"><img src="../images/leftimg.png" />个人中心</div>
            <a href="user_personal.php"><span class="sublist-icon glyphicon glyphicon-user"></span><span class="sub-title">个人中心</span></a> 
          </li>
          <li>
            <div class="showtitle" style="width:100px;"><img src="../images/leftimg.png" />消费记录</div>
            <a href="#"><span class="sublist-icon glyphicon glyphicon-credit-card"></span><span class="sub-title">消费记录</span></a> 
          </li>
          <li>
            <div class="showtitle" style="width:100px;"><img src="../images/leftimg.png" />车辆管理</div>
            <a href="#"><span class="sublist-icon glyphicon glyphicon-road"></span><span class="sub-title">车辆管理</span></a>
          </li>
          <li>
            <div class="showtitle" style="width:100px;"><img src="../images/leftimg.png" />联系客服</div>
            <a href="#"><span class="sublist-icon glyphicon glyphicon-comment"></span><span class="sub-title">联系客服</span></a>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <div class="right-product my-index right-full">
     <div class="container-fluid">
	   <div class="info-center">
       
       <!---标题及时间----->
            <div class="info-title">
              <div class="pull-left">
                <h4 style ="font-size:35px;"><strong><?php echo $_mysql_fetch['user_name'];?></strong></h4>
                <p style = "font-size:22px;">欢迎登录管理系统！</p>
              </div>
              <div class="clearfix"></div>
            </div>

               
               <!-------------------------------------------信息主体页面----------------------------------------------------------->
               <!----------------------------------------编辑用户信息------------------------------------------------------>
                   <div style='width:1200px;'>
                     <div style='margin:50px 0 0 100px;width:auto;border:1px solid #bbbbbb;'> 
                       <h4 style ="font-size:20px;" align="center"><strong>登陆信息</strong></h4>
                                <p style ="font-size:18px;margin:20px 0 10px 0;"> 
                                    <label for="userid" style='margin-left:50px;width:100px;'>用户编号:</label>
                                    <span id="userid" style ="font-size:18px;"><?php echo $_mysql_fetch['user_id']; ?> </span>
                                </p>
                                <p style ="font-size:18px;margin:20px 0 10px 0;"> 
                                    <label for="username"  style='margin-left:50px;width:100px;'>用 户 名:</label>
                                    <span id="username" style ="font-size:18px;"><?php echo $_mysql_fetch['user_name']; ?> </span>
                                </p>
                                <p style ="font-size:18px;margin:20px 0 10px 0;">           
                                    <label for="useremail"  style='margin-left:50px;width:100px;'>邮 箱:</label>
                                    <span id="useremail" style ="font-size:18px;"><?php echo $_mysql_fetch['user_email']; ?> </span>
                                </p>
                                <p style ="font-size:18px;margin:20px 0 10px 0;">          
                                    <label for="userphonenum"  style='margin-left:50px;width:100px;'>联系电话:</label>
                                    <span id="userphonenum" style ="font-size:18px;"><?php echo $_mysql_fetch['user_phone']; ?> </span>
                                    <a href="#"><button style="width:100px;float:right; margin-right:30px;">编辑</button></a>
                                </p>
                      </div>
 
                      <div style='margin:50px 0 0 100px;width:auto;border:1px solid #bbbbbb;'> 
                        <h4 style ="font-size:20px;" align="center"><strong>基本信息</strong></h4>
                                <p style ="font-size:18px;margin:20px 0 10px 50px;"> 
                                    <label for="usersex" class="sex" style='width:100px;' >性 别:</label>
                                    <span id="usersex" style ="font-size:18px;"><?php 
                                          if($_baseinfo_mysql_fetch['user_sex']=='W'){
                                              echo "女";
                                          }else{echo "男";}?></span>
                                </p>
                                <p style ="font-size:18px;margin:20px 0 10px 0;">          
                                    <label for="realname" class="realname" style='margin-left:50px;width:100px;'>真实姓名:</label>
                                    <span id="realname" style ="font-size:18px;"><?php 
                                                if($_baseinfo_mysql_fetch['user_realname'] != null)
                                                {
                                                    echo $_baseinfo_mysql_fetch['user_realname'];
                                                }
                                                if($_baseinfo_mysql_fetch['user_birth'] != null && $_baseinfo_mysql_fetch['user_birth'] != '1900-01-01')
                                                {
                                                    $_user_birth = explode('-', $_baseinfo_mysql_fetch['user_birth']);
                                                }
                                           ?></span>
                                </p>
                                <p style ="font-size:18px;margin:20px 0 10px 0;">          
                                    <label for="editbirthday" class="phone" style='margin-left:50px;width:100px;'>出生年月:</label>
                                    <span id="editbirthday-y" style ="font-size:18px;"><?php if(isset($_user_birth)){echo $_user_birth[0]."年";}?></span>
                                    <span id="editbirthday-m" style ="font-size:18px;"><?php if(isset($_user_birth)){echo $_user_birth[1]."月";}?></span>
                                    <span id="editbirthday-d" style ="font-size:18px;"><?php if(isset($_user_birth)){echo $_user_birth[2]."日";}?></span>
                                </p>
                                <p style ="font-size:18px;margin:20px 0 10px 0;">          
                                    <label for="userocc" class="phone" style='margin-left:50px;width:100px;'>行 业:</label>
                                    <span id="userocc" style ="font-size:18px;"><?php 
                                                if($_baseinfo_mysql_fetch['user_occupation']!= null)
                                                {
                                                    echo $_baseinfo_mysql_fetch['user_occupation'];
                                                }
                                           ?></span>
                                </p>
                                <p style ="font-size:18px;margin:20px 0 10px 0;">          
                                    <label for="useraddr" class="phone" style='margin-left:50px;width:100px;'>联系地址:</label>
                                    <span id="useraddr" style ="font-size:18px;"><?php
                                                if($_baseinfo_mysql_fetch['user_addr']!= null)
                                                {
                                                    echo $_baseinfo_mysql_fetch['user_addr'];
                                                }?></span>
                                    <a href="#"><button style="width:100px;float:right; margin-right:30px;">编辑</button></a>
                                </p>
                      </div>
                      <div style="text-align: center;margin:10px 0 50px 0;"><a href="user-home.php" style="font-size: 18px;">【返回】</a></div>      
                    </div>
                 <!------------------------------------------------------------------------------------------------------------------->
               </div>
            </div>
       </div>			
	 </div>
</body>
</html>

