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
            _jumplocation('admin-user.php');
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
                _alert_back('删除成功');
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
                    case 'editbaseinfo':_check_updatainsert_editbaseinfo($_POST,$_edit_mysql_fetch);break;
                        
                }
                _aler_jump('操作成功', 'admin-user.php');
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
<title>管理系统-用户管理</title>

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

               <!----------------------------------------编辑用户信息------------------------------------------------------>
               <?php if(isset($_GET['act']) && $_GET['act'] == 'edit'){ ?>
                   <div style='width:1200px;'>
                       <form name="editlogininfo" method="post" style='margin:50px 0 0 100px;width:auto;border:1px solid #bbbbbb;'
                             action="admin-user.php?act=edit&func=editlogininfo&value=<?php echo $_edit_mysql_fetch['user_uid'];?>&code=<?php echo $_SESSION['identitycode'];?>" >
                       <h4 style ="font-size:20px;" align="center"><strong>登陆信息</strong></h4>
                                <p style ="font-size:18px;margin:20px 0 10px 0;"> 
                                    <label for="edituserid" style='margin-left:50px;width:100px;'>用户编号:</label>
                                    <span id="edituserid" style ="font-size:18px;"><?php echo $_edit_mysql_fetch['user_id']; ?></span>
                                </p>
                                <p style ="font-size:18px;margin:20px 0 10px 0;"> 
                                    <label for="editusername"  style='margin-left:50px;width:100px;'>用 户 名:</label>
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
                             action="admin-user.php?act=edit&func=editpwd&value=<?php echo $_edit_mysql_fetch['user_uid'];?>&code=<?php echo $_SESSION['identitycode'];?>">
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
 
                      <form name="editbaseinfo" method="post" style='margin:50px 0 0 100px;width:auto;border:1px solid #bbbbbb;'
                            action="admin-user.php?act=edit&func=editbaseinfo&value=<?php echo $_edit_mysql_fetch['user_uid'];?>&code=<?php echo $_SESSION['identitycode'];?>">
                      <h4 style ="font-size:20px;" align="center"><strong>基本信息</strong></h4>
                                <p style ="font-size:18px;margin:20px 0 10px 50px;"> 
                                    <label for="editusersex" class="sex" style='width:100px;' >性 别:</label>
                                    <input id="editusersex" name="editusersex" type="radio" 
                                           <?php if($_baseinfo_mysql_fetch['user_sex']=='M'){echo "checked=\"checked\"";}?> 
                                           value='M' style='margin-left:10px;'/> 男
                                    <input id="editusersex" name="editusersex" type="radio" 
                                           <?php if($_baseinfo_mysql_fetch['user_sex']=='W'){echo "checked=\"checked\"";}?>
                                           value='W' style='margin-left:10px;'/> 女
                                </p>
                                <p style ="font-size:18px;margin:20px 0 10px 0;">          
                                    <label for="editrealname" class="realname" style='margin-left:50px;width:100px;'>真实姓名:</label>
                                    <input id="editrealname" name="editrealname" type="text" style='width:350px;' 
                                           <?php 
                                                if($_baseinfo_mysql_fetch['user_realname'] != null)
                                                {
                                                    echo "value=".$_baseinfo_mysql_fetch['user_realname'];
                                                }
                                                if($_baseinfo_mysql_fetch['user_birth'] != null && $_baseinfo_mysql_fetch['user_birth'] != '1900-01-01')
                                                {
                                                    $_user_birth = explode('-', $_baseinfo_mysql_fetch['user_birth']);
                                                }
                                           ?> />
                                </p>
                                <p style ="font-size:18px;margin:20px 0 10px 0;">          
                                    <label for="editbirthday" class="phone" style='margin-left:50px;width:100px;'>出生年月:</label>
                                    <input id="editbirthday" name="editbirthday-y" type="text" style='width:100px;'<?php if(isset($_user_birth)){echo "value=".$_user_birth[0];}?> /> 年
                                    <input id="editbirthday" name="editbirthday-m" type="text" style='width:75px;' <?php if(isset($_user_birth)){echo "value=".$_user_birth[1];}?> /> 月
                                    <input id="editbirthday" name="editbirthday-d" type="text" style='width:75px;' <?php if(isset($_user_birth)){echo "value=".$_user_birth[2];}?> /> 日     
                                </p>
                                <p style ="font-size:18px;margin:20px 0 10px 0;">          
                                    <label for="edituserocc" class="phone" style='margin-left:50px;width:100px;'>行 业:</label>
                                    <input id="edituserocc" name="edituserocc" type="text" style='width:350px;'
                                           <?php 
                                                if($_baseinfo_mysql_fetch['user_occupation']!= null)
                                                {
                                                    echo "value=".$_baseinfo_mysql_fetch['user_occupation'];
                                                }
                                           ?> />
                                </p>
                                <p style ="font-size:18px;margin:20px 0 10px 0;">          
                                    <label for="edituseraddr" class="phone" style='margin-left:50px;width:100px;'>联系地址:</label>
                                    <textarea id="edituseraddr" name="edituseraddr"  style="width:350px;height:60px;" ><?php
                                                if($_baseinfo_mysql_fetch['user_addr']!= null)
                                                {
                                                    echo $_baseinfo_mysql_fetch['user_addr'];
                                                }?></textarea>      
                                    <input type="submit" value="保存" style="width:100px;float:right; margin-right:30px;"/>
                                </p>
                      </form>
                      <div style="text-align: center;margin:10px 0 50px 0;"><a href="admin-user.php" style="font-size: 18px;">【返回】</a></div>
                      
               </div>
               <!--------------------------------------------------------------------------------------------------->

               <!----------------------------------------用户信息显示------------------------------------------------------>
               <?php }else if(!isset($_GET['act'])){?>
               <div class="row newslist" style="margin:30px 0 0 50px ;width:1800px;">
                  <div class="col-md-8">
                    <div class="panel panel-default"> 
                         <div class="panel-body">
                         <div class="w5 pull-left text-center"><strong>序号</strong></div>
                         <div class="w10 pull-left text-center"><strong>用户编号</strong></div>
                         <div class="w15 pull-left text-center"><strong>用户名称</strong></div>
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
                                <div class="text-center" >
                                    <a style='text-decoration:none;' href="admin-user.php?act=edit&value=<?php echo $_mysql_fetch['user_uid'];?>&code=<?php echo $_SESSION['identitycode'];?>">
                                        <button>编辑</button>
                                    </a>
                                    <a href="javascript:if(confirm('确实要删除该用户吗?'))location='admin-user.php?act=delete&value=<?php echo $_mysql_fetch['user_uid']; ?>&code=<?php echo $_SESSION['identitycode']; ?>'">
                                        <button>删除</button>
                                    </a>
                                </div>
                            </div>
                       <?php } ?>
                            <div class="panel-body text-center">
                       <?php if(!(isset($_GET['show']) && $_GET['show']=='all')){                                                                                     ?>
                                    <a href="admin-user.php?show=all" style="color:#5297d6;">展开所有记录</a>
                       <?php }else{ ?>
                                    <a href="admin-user.php" style="color:#5297d6;">收起所有记录</a>
                       <?php }
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


