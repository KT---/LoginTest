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
    
    if(isset($_GET['code']))
    {
//         if($_GET['code'] != $_SESSION['identitycode'])
//         { 
//             _alert_back('数据提交出错！');
//             exit;
//         }
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
    }



    $_SESSION['identitycode'] = md5(mt_rand());//生成页面唯一标识码
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
<link href="../css/editform.css" rel="stylesheet" title="" type="text/css" />
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
             <?php if(isset($_GET['act']) && $_GET['act'] == 'edit'){?>
             <div id="main">
                <form id="baseInfoForm" name="baseInfoForm" method="post" class="infoForm">
                    <div id="main-profile" class="parts">
                        <p>
                            <label>当前头像：</label>
                            <span class="pf-avatar-box">
                                <a class="pf-avatar"></a>
                                <a href="#" class="pf-edit-avatar">编辑头像</a>
                            </span>
                        </p>
                        <p>
                            <label>昵称：<em>*</em></label>
                            <input id="J_uniqueName-mask" class="f-txt" type="text" value="狂晕的KT" maxlength="25">
                            <input id="J_uniqueName" name="_fm.b._0.u" type="hidden" value="狂晕的KT" maxlength="25">
                        </p>
                        <p class="input-help-text"></p>
                        <p>
                            <label>真实姓名：</label>
                            <input id="J_realname-mask" class="f-txt" type="text" value="邝韵涛" maxlength="6">
                            <input id="J_realname" name="_fm.b._0.r" type="hidden" value="邝韵涛" maxlength="6">
                        </p>
                        <p>
                            <label>性别：<em>*</em></label>
                            <label for="J_gender1" class="except"><input id="J_gender1" type="radio" name="_fm.b._0.g" value="0"  checked="checked" />男</label>
                            <label for="J_gender2" class="except"><input id="J_gender2" type="radio" name="_fm.b._0.g" value="1" />女</label>
                        </p>
                        <p>
                            <label>生日：</label>
                            <select id="J_Year" name="_fm.b._0.y">
                                <option  >年</option>
                                                            <option value="1940"  >1940</option>
                                                            <option value="1941"  >1941</option>
                                                            <option value="1942"  >1942</option>
                                                            <option value="1943"  >1943</option>
                                                            <option value="1944"  >1944</option>
                                                            <option value="1945"  >1945</option>
                                                            <option value="1946"  >1946</option>
                                                            <option value="1947"  >1947</option>
                                                            <option value="1948"  >1948</option>
                                                            <option value="1949"  >1949</option>
                                                            <option value="1950"  >1950</option>
                                                            <option value="1951"  >1951</option>
                                                            <option value="1952"  >1952</option>
                                                            <option value="1953"  >1953</option>
                                                            <option value="1954"  >1954</option>
                                                            <option value="1955"  >1955</option>
                                                            <option value="1956"  >1956</option>
                                                            <option value="1957"  >1957</option>
                                                            <option value="1958"  >1958</option>
                                                            <option value="1959"  >1959</option>
                                                            <option value="1960"  >1960</option>
                                                            <option value="1961"  >1961</option>
                                                            <option value="1962"  >1962</option>
                                                            <option value="1963"  >1963</option>
                                                            <option value="1964"  >1964</option>
                                                            <option value="1965"  >1965</option>
                                                            <option value="1966"  >1966</option>
                                                            <option value="1967"  >1967</option>
                                                            <option value="1968"  >1968</option>
                                                            <option value="1969"  >1969</option>
                                                            <option value="1970"  >1970</option>
                                                            <option value="1971"  >1971</option>
                                                            <option value="1972"  >1972</option>
                                                            <option value="1973"  >1973</option>
                                                            <option value="1974"  >1974</option>
                                                            <option value="1975"  >1975</option>
                                                            <option value="1976"  >1976</option>
                                                            <option value="1977"  >1977</option>
                                                            <option value="1978"  >1978</option>
                                                            <option value="1979"  >1979</option>
                                                            <option value="1980"  >1980</option>
                                                            <option value="1981"  >1981</option>
                                                            <option value="1982"  >1982</option>
                                                            <option value="1983"  >1983</option>
                                                            <option value="1984"  >1984</option>
                                                            <option value="1985"  >1985</option>
                                                            <option value="1986"  >1986</option>
                                                            <option value="1987"  >1987</option>
                                                            <option value="1988"  >1988</option>
                                                            <option value="1989"  >1989</option>
                                                            <option value="1990"  >1990</option>
                                                            <option value="1991"   selected="selected"  >1991</option>
                                                            <option value="1992"  >1992</option>
                                                            <option value="1993"  >1993</option>
                                                            <option value="1994"  >1994</option>
                                                            <option value="1995"  >1995</option>
                                                            <option value="1996"  >1996</option>
                                                            <option value="1997"  >1997</option>
                                                            <option value="1998"  >1998</option>
                                                            <option value="1999"  >1999</option>
                                                            <option value="2000"  >2000</option>
                                                            <option value="2001"  >2001</option>
                                                            <option value="2002"  >2002</option>
                                                            <option value="2003"  >2003</option>
                                                            <option value="2004"  >2004</option>
                                                            <option value="2005"  >2005</option>
                                                            <option value="2006"  >2006</option>
                                                            <option value="2007"  >2007</option>
                                                            <option value="2008"  >2008</option>
                                                            <option value="2009"  >2009</option>
                                                            <option value="2010"  >2010</option>
                                                            <option value="2011"  >2011</option>
                                                            <option value="2012"  >2012</option>
                                                            <option value="2013"  >2013</option>
                                                            <option value="2014"  >2014</option>
                                                            <option value="2015"  >2015</option>
                                                            <option value="2016"  >2016</option>
                                                            <option value="2017"  >2017</option>
                                                        </select>
                            <select id="J_Month" name="_fm.b._0.m">
                                <option  >月</option>
                                                            <option value="1"  >1</option>
                                                            <option value="2"  >2</option>
                                                            <option value="3"  >3</option>
                                                            <option value="4"  >4</option>
                                                            <option value="5"  >5</option>
                                                            <option value="6"  selected="selected"   >6</option>
                                                            <option value="7"  >7</option>
                                                            <option value="8"  >8</option>
                                                            <option value="9"  >9</option>
                                                            <option value="10"  >10</option>
                                                            <option value="11"  >11</option>
                                                            <option value="12"  >12</option>
                                                        </select>
                            <select  id="J_Date"  name="_fm.b._0.d">
                                <option  >日</option>
                                                            <option value="1"  >1</option>
                                                            <option value="2"  >2</option>
                                                            <option value="3"  >3</option>
                                                            <option value="4"  >4</option>
                                                            <option value="5"  >5</option>
                                                            <option value="6"  >6</option>
                                                            <option value="7"  >7</option>
                                                            <option value="8"  >8</option>
                                                            <option value="9"  >9</option>
                                                            <option value="10"  >10</option>
                                                            <option value="11"  >11</option>
                                                            <option value="12"  >12</option>
                                                            <option value="13"  >13</option>
                                                            <option value="14"  >14</option>
                                                            <option value="15"  >15</option>
                                                            <option value="16"  >16</option>
                                                            <option value="17"  >17</option>
                                                            <option value="18"  >18</option>
                                                            <option value="19"  >19</option>
                                                            <option value="20"  >20</option>
                                                            <option value="21"  >21</option>
                                                            <option value="22"  >22</option>
                                                            <option value="23"  >23</option>
                                                            <option value="24"  >24</option>
                                                            <option value="25"  >25</option>
                                                            <option value="26"  >26</option>
                                                            <option value="27"  >27</option>
                                                            <option value="28"  >28</option>
                                                            <option value="29"  selected="selected"   >29</option>
                                                            <option value="30"  >30</option>
                                                            <option value="31"  >31</option>
                                                        </select>
                        </p>
                        <div class="sns-msg" id="J_birthdayTip" style="display:none;">
                            <p class="error">生日如果填写的话请填写完整！</p>
                        </div>
                                                    <p>
                            <label>居住地：</label>
                            <select name="_fm.b._0.p" id="J_redstar_province" ></select>
                            <select name="_fm.b._0.c" id="J_redstar_city"  ></select>
                            <select name="_fm.b._0.a" id="J_redstar_area"  ></select>
                            <input id="divisionCode" value="440113" type="hidden" name="_fm.b._0.di" />
                        </p>
                        <div class="sns-msg" id="J_redstarTip" style="display:none;">
                            <p class="error">居住地所在的省市区为必填项！</p>
                        </div>
                                                    <p>
                            <label>家乡：</label>
                            <select id="J_live_province" name="_fm.b._0.ho"></select>
                            <select id="J_live_city" name="_fm.b._0.hom"></select>
                            <select id="J_live_area" name="_fm.b._0.home"></select>
                            <input type="hidden" name="_fm.b._0.l" value="440103" id="liveDivisionCode"/>
                        </p>
                    </div>
                    <div class="act skin-blue">
                        <span class="btn n-btn">
                            <button type="submit" id="J_saveProfile">保存</button>
                            <div style="width:1px; height:1px; overflow:hidden; " >
                                <input type="submit" ></input>
                            </div>
                        </span>
                    </div>
                </form>
             </div>
             <?php }else{?>
               <!-----------------------------------------用户列表显示--------------------------------------------------------->
               <div class="row newslist" style="margin:30px 0 0 50px ;width:2000px;">
                  <div class="col-md-8">
                    <div class="panel panel-default"> 
                         <div class="panel-body">
                         <div class="w5 pull-left text-center"><strong>序号</strong></div>
                         <div class="w10 pull-left text-center"><strong>用户编号</strong></div>
                         <div class="w15 pull-left text-center"><strong>用户名</strong></div>
                         <div class="w20 pull-left text-center"><strong>邮箱</strong></div>
                         <div class="w20 pull-left text-center"><strong>电话号码</strong></div>
                         <div class="w20 pull-left text-center"><strong>注册时间</strong></div>
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
                                    <a href="admin-user.php?act=edit&value=<?php echo $_mysql_fetch['user_uid']; ?>&code=<?php echo $_SESSION['identitycode']; ?>">
                                        <button>编辑</button>
                                    </a>
                                    <a href="javascript:if(confirm('确实要删除该用户吗?'))location='admin-user.php?act=delete&value=<?php echo $_mysql_fetch['user_uid']; ?>&code=<?php echo $_SESSION['identitycode']; ?>'">
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
                       <?php }}                                                                                                              ?>
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
