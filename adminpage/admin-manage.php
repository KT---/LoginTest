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
    
//     require dirname(__FILE__).'./../function/login-register.func.php';
//     require dirname(__FILE__).'./../include/mysql.inc.php';
       require dirname(__FILE__).'./../function/edit-info.func.php';
    
    if(!isset($_COOKIE['LT_uid']))
    {
        echo "<script language=javascript>location.href='../index.php';</script>";
    }
    
    $_mysql_fetch = mysql_fetch_assoc(mysql_query("SELECT * FROM `user_info` WHERE `user_uid` LIKE '{$_COOKIE['LT_uid']}'"));
    if($_mysql_fetch['user_jurisdiction'] == 'user')
    {
        echo "<script language=javascript>location.href='../index.php';</script>";
    }
    
    if(isset($_GET['act']))
    {
        if(!isset($_GET['code']) || ($_GET['code'] != $_SESSION['identitycode']))
        { 
            _jumplocation('admin-manage.php');
            exit;
        }
        
        /***************************************************删除用户********************************************************/
        if($_GET['act']=='delete')
        {
            $_deleted_mysql_fetch = mysql_fetch_assoc(mysql_query("SELECT * FROM `user_info` WHERE `user_uid` LIKE '{$_GET['value']}'"));
            if(isset($_deleted_mysql_fetch['user_uid']) && $_deleted_mysql_fetch['user_uid'] != null)
            {
                $_deleted_mysql_fetch['user_delete_time'] = date("Y-m-d H:i:s",time()+8*60*60);
                @mysql_query("INSERT INTO `user_deleted`(`user_id`,`user_uid`,`user_phone`,`user_pwd`,`user_rts`,`user_rt`,`user_email`,`user_name`,`user_jurisdiction`,`user_deleted_time`)
                    VALUES('{$_deleted_mysql_fetch['user_id']}','{$_deleted_mysql_fetch['user_uid']}','{$_deleted_mysql_fetch['user_phone']}',
                    '{$_deleted_mysql_fetch['user_pwd']}','{$_deleted_mysql_fetch['user_rts']}','{$_deleted_mysql_fetch['user_rt']}','{$_deleted_mysql_fetch['user_email']}',
                    '{$_deleted_mysql_fetch['user_name']}','{$_deleted_mysql_fetch['user_jurisdiction']}','{$_deleted_mysql_fetch['user_delete_time']}')") or die('数据库执行错误:'.mysql_error().print_r($_deleted_mysql_fetch));
                
                mysql_query("DELETE FROM `user_info` WHERE `user_info`.`user_uid` = '{$_GET['value']}'");
                _aler_jump('删除成功', 'admin-manage.php');
            }
            else
            {
                _alert_back('用户不存在');
            }
        }
        /*******************************************************************************************************************/
        
        /***************************************************编辑用户信息********************************************************/
        else if($_GET['act'] == 'edit')
        {
            $_edit_mysql_fetch = mysql_fetch_assoc(mysql_query("SELECT * FROM `user_info` WHERE `user_uid` LIKE '{$_GET['value']}'"));
            $_baseinfo_mysql_fetch = mysql_fetch_assoc(mysql_query("SELECT * FROM `user_baseinfo` WHERE `user_uid` LIKE '{$_GET['value']}'"));
            if(isset($_GET['func']))
            {
                switch ($_GET['func'])
                {
                    case 'editlogininfo':_checkupdata_editlogininfo($_POST,$_edit_mysql_fetch);break;
                    case 'editpwd':_checkupdata_editpwd($_POST['editpassword'],$_POST['editpassword_confirm'],$_edit_mysql_fetch);break;
                        
                }
                _aler_jump('操作成功', 'admin-manage.php');
            } 
        }
        /*******************************************************************************************************************/
        
        /***************************************************添加管理员********************************************************/
        else if($_GET['act'] == 'add-manager')
        {
            $_manager_info = array();
            if(isset($_POST['managername']))
            {
            /*******************检查验证码，检查用户名、邮箱、电话号码、密码格式正确性，并写连同时间戳及页面唯一标识码入缓存***********************/
            $_manager_info['managername'] = _check_username($_POST['managername']);
             $_manager_info['manageremail'] = _check_email($_POST['manageremail']); //检查用户名email地址格式合法性
             $_manager_info['managerphonenum'] = _check_phonenum($_POST['managerphonenum'],11);
            $_manager_info['managerpwd'] = sha1(md5(_check_password($_POST['managerpwd'],6,30,$_POST['managerpwd_confirm'])));//检查密码格式及加密
            $_manager_info['$_timestamp'] = time()+8*60*60;
            $_manager_info['timesignup'] = date("Y-m-d H:i:s",$_manager_info['$_timestamp']);
            $_manager_info['uid'] = md5($_manager_info['$_timestamp']+19901117);
            /*******************************************************************************************************/
            
            /****************************检查用户名、邮箱、电话号码是否被注册****************************************/
            _check_mysql_repetition('user_name', 'user_info', 'user_name', $_manager_info['managername'],'用户名已被注册!');
            _check_mysql_repetition('user_email', 'user_info', 'user_email', $_manager_info['manageremail'],'邮箱已被注册!');
            _check_mysql_repetition('user_phone', 'user_info', 'user_phone', $_manager_info['managerphonenum'],'电话号码已被注册!');
            /*******************************************************************************************************/
            
            /****************************将用户注册信息写入数据库***********************************************/
            @mysql_query("INSERT INTO `user_info`(`user_uid`,`user_phone`,`user_pwd`,`user_rts`,`user_rt`,`user_email`,`user_name`,`user_jurisdiction`)
                VALUES('{$_manager_info['uid']}','{$_manager_info['managerphonenum']}','{$_manager_info['managerpwd']}',
                '{$_manager_info['$_timestamp']}','{$_manager_info['timesignup']}','{$_manager_info['manageremail']}',
                '{$_manager_info['managername']}','admin')") or die('数据库执行错误:'.mysql_error());
            /**********************************************************************************************/
            
            _aler_jump('添加成功', 'admin-manage.php');
            }
            
        }
        /*******************************************************************************************************************/
    }


    $_SESSION['identitycode'] = md5(mt_rand());//生成页面唯一标识码
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1, user-scalable=no"/>
<title>管理系统-平台管理员</title>

<link href="../bootstrap-3.3.5-dist/css/bootstrap.min.css" title="" rel="stylesheet" />
<link title="" href="../css/style.css" rel="stylesheet" type="text/css"  />
<link title="blue" href="../css/dermadefault.css" rel="stylesheet" type="text/css"/>
<link href="../css/templatecss.css" rel="stylesheet" title="" type="text/css" />
<link rel="shortcut icon" href="../icon/pooh.ico" />	
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

               <!----------------------------------------编辑管理员信息------------------------------------------------------>
               <?php if(isset($_GET['act']) && $_GET['act'] == 'edit'){ ?>
                   <div style='width:1200px;'>
                       <form name="editlogininfo" method="post" style='margin:50px 0 0 100px;width:auto;border:1px solid #bbbbbb;'
                             action="admin-manage.php?act=edit&func=editlogininfo&value=<?php echo $_edit_mysql_fetch['user_uid'];?>&code=<?php echo $_SESSION['identitycode'];?>" >
                       <h4 style ="font-size:20px;" align="center"><strong>登陆信息</strong></h4>
                                <p style ="font-size:18px;margin:20px 0 10px 0;"> 
                                    <label for="editmid" style='margin-left:50px;width:100px;'>管理员编号:</label>
                                    <span id="edituserid" style ="font-size:18px;"><?php echo $_edit_mysql_fetch['user_id']; ?></span>
                                </p>
                                <p style ="font-size:18px;margin:20px 0 10px 0;"> 
                                    <label for="editusername"  style='margin-left:50px;width:100px;'>管理员名称:</label>
                                    <input id="editusername" name="editusername" required="required" type="text" style='width:350px;'
                                           value=<?php echo $_edit_mysql_fetch['user_name']; ?> />
                                </p>
                                <p style ="font-size:18px;margin:20px 0 10px 0;">           
                                    <label for="editemail"  style='margin-left:50px;width:100px;'>邮 箱:</label>
                                    <input id="editemail" name="editemail" required="required" type="email"  style='width:350px;'
                                           value=<?php echo $_edit_mysql_fetch['user_email']; ?> /> 
                                </p>
                                <p style ="font-size:18px;margin:20px 0 10px 0;">          
                                    <label for="editphonenum"  style='margin-left:50px;width:100px;'>联系电话:</label>
                                    <input id="editphonenum" name="editphonenum" required="required" type="text" style='width:350px;'
                                           value=<?php echo $_edit_mysql_fetch['user_phone']; ?> />
                                    <input type="submit" value="保存" style="width:100px;float:right; margin-right:30px;"/> 
                                </p>
                       </form>

                       <form name="editpwd" method="post" style="margin:30px 0 0 100px ;width:auto;border:1px solid #bbbbbb;"
                             action="admin-manage.php?act=edit&func=editpwd&value=<?php echo $_edit_mysql_fetch['user_uid'];?>&code=<?php echo $_SESSION['identitycode'];?>">
                       <h4 style ="font-size:20px;" align="center"><strong>密码修改</strong></h4>
                                <input type="hidden" name="edituserid" value=<?php echo $_edit_mysql_fetch['user_uid'];?> />
                                <p style ="font-size:18px;margin:20px 0 10px 0;"> 
                                    <label for="editpassword" class="youpasswd" style='margin-left:50px;width:100px;'>密 码：</label>
                                    <input id="editpassword" name="editpassword" required="required" type="password" style='width:350px;'/>
                                </p>
                                <p style ="font-size:18px;margin:20px 0 10px 0;"> 
                                    <label for="editpassword_confirm" class="youpasswd" style='margin-left:50px;width:100px;'>确认密码：</label>
                                    <input id="editpassword_confirm" name="editpassword_confirm" required="required" type="password" style='width:350px;'/>
                                    <input type="submit" value="保存" style="width:100px;float:right; margin-right:30px;"/>
                                </p>
                      </form>
                      <div style="text-align: center;margin:10px 0 50px 0;"><a href="admin-manage.php" style="font-size: 18px;">【返回】</a></div>
                      
               </div>
               <!----------------------------------------------------------------------------------------------------->
               
               <!----------------------------------------添加管理员------------------------------------------------------>
               <?php }else if(isset($_GET['act']) && $_GET['act'] == 'add-manager'){ ?>
                <div style='width:1200px;'>
                       <form name="editlogininfo" method="post" style='margin:50px 0 0 100px;width:auto;border:1px solid #bbbbbb;'
                             action="admin-manage.php?act=add-manager&code=<?php echo $_SESSION['identitycode'];?>" >
                       <h4 style ="font-size:20px;" align="center"><strong>添加管理员</strong></h4>
                                <p style ="font-size:18px;margin:20px 0 10px 0;"> 
                                    <label for="managername"  style='margin-left:50px;width:100px;'>管理员名称:</label>
                                    <input id="managername" name="managername" required="required" type="text" style='width:350px;' />
                                </p>
                                <p style ="font-size:18px;margin:20px 0 10px 0;">           
                                    <label for="manageremail"  style='margin-left:50px;width:100px;'>邮   箱:</label>
                                    <input id="manageremail" name="manageremail" required="required" type="email"  style='width:350px;' /> 
                                </p>
                                <p style ="font-size:18px;margin:20px 0 10px 0;">          
                                    <label for="managerphonenum"  style='margin-left:50px;width:100px;'>联系电话:</label>
                                    <input id="managerphonenum" name="managerphonenum" required="required" type="text" style='width:350px;'/>
                                </p>
                                <p style ="font-size:18px;margin:20px 0 10px 0;"> 
                                    <label for="managerpwd" class="youpasswd" style='margin-left:50px;width:100px;'>密   码：</label>
                                    <input id="managerpwd" name="managerpwd" required="required" type="password" style='width:350px;'/>
                                </p>
                                <p style ="font-size:18px;margin:20px 0 10px 0;"> 
                                    <label for="managerpwd_confirm" class="youpasswd" style='margin-left:50px;width:100px;'>确认密码：</label>
                                    <input id="managerpwd_confirm" name="managerpwd_confirm" required="required" type="password" style='width:350px;'/>
                                    <input type="submit" value="添加管理员" style="width:120px;float:right; margin-right:30px;"/>
                                </p>
                       </form>
                      <div style="text-align: center;margin:10px 0 50px 0;"><a href="admin-manage.php" style="font-size: 18px;">【返回】</a></div>
                      
               </div>
               
               <!----------------------------------------------------------------------------------------------------->
               
               <!----------------------------------------管理员信息显示------------------------------------------------------>
               <?php }else if(!isset($_GET['act'])){?>
               <div class="row newslist" style="margin:30px 0 0 50px ;width:1800px;">
                  <div class="col-md-8">
                    <div class="panel panel-default"> 
                         <div class="panel-body">
                         <div class="w5 pull-left text-center"><strong>序号</strong></div>
                         <div class="w10 pull-left text-center"><strong>管理员编号</strong></div>
                         <div class="w15 pull-left text-center"><strong>管理员名称</strong></div>
                         <div class="w20 pull-left text-center"><strong>邮箱</strong></div>
                         <div class="w20 pull-left text-center"><strong>电话号码</strong></div>
                         <div class="w20 pull-left text-center"><strong>添加时间</strong></div>
                         <div class="w10 pull-left text-center"><strong>操作</strong></div></div>
                      <?php   

                        $_i = mysql_fetch_assoc(mysql_query("select max(user_id) from user_info"))['max(user_id)'];
                        $num = 1;
                        for($_j=1;$_j<=$_i;$_j++)
                        {
                            $_mysql_fetch = mysql_fetch_assoc(mysql_query("SELECT * FROM `user_info` WHERE `user_id` LIKE $_j"));
                            if(($_mysql_fetch['user_jurisdiction']!='admin')){continue;}
                      ?>
                            <div class="panel-body">
                                <div class="w5 pull-left text-center"><?php echo $num++; ?></div>
                                <div class="w10 pull-left text-center"><?php echo $_mysql_fetch['user_id']; ?></div>
                                <div class="w15 pull-left text-center"><?php echo $_mysql_fetch['user_name']; ?></div>
                                <div class="w20 pull-left text-center"><?php echo $_mysql_fetch['user_email']; ?></div>
                                <div class="w20 pull-left text-center"><?php echo $_mysql_fetch['user_phone']; ?></div>
                                <div class="w20 pull-left text-center"><?php echo $_mysql_fetch['user_rt']; ?></div>
                                <div class="text-center" >
                                    <a style='text-decoration:none;' href="admin-manage.php?act=edit&value=<?php echo $_mysql_fetch['user_uid'];?>&code=<?php echo $_SESSION['identitycode'];?>">
                                        <button>编辑</button>
                                    </a>
                                    <a href="javascript:if(confirm('确实要删除管理员吗?'))location='admin-manage.php?act=delete&value=<?php echo $_mysql_fetch['user_uid']; ?>&code=<?php echo $_SESSION['identitycode']; ?>'">                       
                                        <button>删除</button>
                                    </a>
                                </div>
                            </div>
                       <?php 
                        } ?>
                            <div style="text-align: center;margin:50px 0 20px 0;">
                                <a href="admin-manage.php?act=add-manager&code=<?php echo $_SESSION['identitycode'];?>"style="font-size: 18px;"><button>添加管理员</button></a>
                            </div>
                       <?php 
                        } 
                        mysql_close();
                       ?>
                       
                    </div>
                  </div>
                </div>
              </div>
              <!------------------------------------------------------------------------------------------------------------------->
            </div>
       </div>			
	 </div>
</body>
</html>


