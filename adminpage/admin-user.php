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
    
    require dirname(__FILE__).'./../function/login-register.func.php';
    require dirname(__FILE__).'./../include/mysql.inc.php';
    
    if(!isset($_COOKIE['LT_uid']))
    {
        echo "<script language=javascript>location.href='index.php';</script>";
    }
    
    $_mysql_fetch = mysql_fetch_assoc(mysql_query("SELECT * FROM `user_info` WHERE `user_uid` LIKE '{$_COOKIE['LT_uid']}'"));
    if($_mysql_fetch['user_jurisdiction'] == 'user')
    {
        echo "<script language=javascript>location.href='../index.php';</script>";
    }




?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1, user-scalable=no"/>
<title>用户主页</title>

<link href="../bootstrap-3.3.5-dist/css/bootstrap.min.css" title="" rel="stylesheet" />
<link title="" href="../css/style.css" rel="stylesheet" type="text/css"  />
<link title="blue" href="../css/dermadefault.css" rel="stylesheet" type="text/css"/>
<link href="../css/templatecss.css" rel="stylesheet" title="" type="text/css" />
<!-- <script src="script/jquery-1.11.1.min.js" type="text/javascript"></script> -->
<!-- <script src="script/jquery.cookie.js" type="text/javascript"></script> -->
<script src="../bootstrap-3.3.5-dist/js/bootstrap.min.js" type="text/javascript"></script>
<script src="../JS/common.js" type="text/javascript"></script>
</head>

<body>
<div class="nav navbar-default navbar-mystyle navbar-fixed-top">
  <div class="navbar-header">
    <a class="navbar-brand mystyle-brand"><span class="glyphicon glyphicon-home"></span></a></div>
  <div class="collapse navbar-collapse">
    <ul class="nav navbar-nav">
      <li class="li-border"><a class="mystyle-color" href="admin-home.php"> 奶油猪登陆管理系统</a></li>
        <div class="time-title pull-right">
          <div class="year-month pull-right">
            <p><span><?php echo date('Y',time()); ?></span><?php echo '年'.date('m',time()).'月'.date('d',time()).'日';?></p>
          </div>
        </div>
    </ul>
    
    <ul class="nav navbar-nav pull-right">
       <li class="dropdown li-border"><a href="#" class="dropdown-toggle mystyle-color" ><?php echo '管理员：'.$_mysql_fetch['user_name'];?></a></li>
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
        <?php if($_mysql_fetch['user_jurisdiction'] == 'root'){?>
          <li>
            <div class="showtitle" style="width:100px;"><img src="../images/leftimg.png" />平台管理员</div>
            <a href="admin-manage.php"><span class="sublist-icon glyphicon glyphicon-star"></span><span class="sub-title">平台管理员</span></a> 
          </li>
        <?php } ?>
          <li>
            <div class="showtitle" style="width:100px;"><img src="../images/leftimg.png" />用户管理</div>
            <a href="admin-user.php"><span class="sublist-icon glyphicon glyphicon-user"></span><span class="sub-title">用户管理</span></a> 
          </li>
          <li>
            <div class="showtitle" style="width:100px;"><img src="../images/leftimg.png" />交易记录</div>
            <a href="#"><span class="sublist-icon glyphicon glyphicon-usd"></span><span class="sub-title">交易记录</span></a> 
          </li>
          <li>
            <div class="showtitle" style="width:100px;"><img src="../images/leftimg.png" />车辆管理</div>
            <a href="#"><span class="sublist-icon glyphicon glyphicon-road"></span><span class="sub-title">车辆管理</span></a>
          </li>
          <li>
            <div class="showtitle" style="width:100px;"><img src="../images/leftimg.png" />客服问题处理</div>
            <a href="#"><span class="sublist-icon glyphicon glyphicon-comment"></span><span class="sub-title">客服问题处理</span></a>
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
               <div class="row newslist" style="margin:30px 0 0 50px ;width:2000px;">
                  <div class="col-md-8">
                    <div class="panel panel-default"> 
                         <div class="panel-body">
                         <div class="w5 pull-left text-center"><strong>序号</strong></div>
                         <div class="w10 pull-left text-center"><strong>用户编号</strong></div>
                         <div class="w15 pull-left text-center"><strong>用户名</strong></div>
                         <div class="w20 pull-left text-center"><strong>邮箱</strong></div>
                         <div class="w20 pull-left text-center"><strong>电话号码</strong></div>
                         <div class="w20 pull-left text-center"><strong>添加时间</strong></div>
                         <div class="w10 pull-left text-center"><strong>操作</strong></div></div>
                      <?php   
                        if(isset($_GET['show']) && $_GET['show']=='all')
                        {
                            $_i = mysql_fetch_assoc(mysql_query("select max(user_id) from user_info"))['max(user_id)'];
                        }
                        else
                        {
                            $_i = 10;
                        } 
                        $num = 1;
                        for($_j=1;$_j<=$_i;$_j++)
                        {
                            $_mysql_fetch = mysql_fetch_assoc(mysql_query("SELECT * FROM `user_info` WHERE `user_id` LIKE $_j"));
                            if($_mysql_fetch['user_jurisdiction']!='user'){continue;}
                      ?>
                            <div class="panel-body">
                                <div class="w5 pull-left text-center"><?php echo $num++; ?></div>
                                <div class="w10 pull-left text-center"><?php echo $_mysql_fetch['user_id']; ?></div>
                                <div class="w15 pull-left text-center"><?php echo $_mysql_fetch['user_name']; ?></div>
                                <div class="w20 pull-left text-center"><?php echo $_mysql_fetch['user_email']; ?></div>
                                <div class="w20 pull-left text-center"><?php echo $_mysql_fetch['user_phone']; ?></div>
                                <div class="w20 pull-left text-center"><?php echo $_mysql_fetch['user_rt']; ?></div>
                                <div class="text-center\">
                                    <a href="admin-user.php?act=edit&value=<?php echo $_mysql_fetch['user_uid']; ?>">
                                        <button>编辑</button>
                                    </a>
                                    <a href="javascript:if(confirm('确实要删除该内容吗?'))location='admin-user.php?act=delete&value=<?php echo $_mysql_fetch['user_uid']; ?>'">
                                        <button>删除</button>
                                    </a>
                                </div>
                            </div>
                       <?php }                                                                                                              ?>
                            <div class="panel-body text-center">
                       <?php if(!isset($_GET['show'])){                                                                                     ?>
                                    <a href="admin-user.php?show=all" style="color:#5297d6;">展开所有记录</a>
                       <?php }else{ ?>
                                    <a href="admin-user.php" style="color:#5297d6;">收起所有记录</a>
                       <?php }                                                                                                              ?>
                    </div>
                  </div>
               </div>
               <!------------------------------------------------------------------------------------------------------------------->
               </div>
            </div>
       </div>			
	 </div>
</body>
</html>
