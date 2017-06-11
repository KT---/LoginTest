<?php
/* ===================================
*	tytel		:
*	version		:
*	By			:KT
*	Data		:2017年6月5日
=======================================*/


    //启用$_SESSION超级全局变量
    session_start();
    //定义变量标识符，防止inc、func文件恶意调用
    define('LT_req',true);
    
   require dirname(__FILE__).'/function/login-register.func.php';
   require dirname(__FILE__).'/include/mysql.inc.php';
    // if(!($_SESSION['HTTP_REFERER'] == md5('index.php')))
    // { 
    //     exit('非法登入！');
    // }
    //表单提交本页后进行验证
    if(isset($_POST['IdentityCode']) && isset($_GET['act']) && $_GET['act'] == 'login')//判断$_GET['act']、$_POST['IdentityCode']是否被定义，决定是否进行表单内容审核验证
    {
        $_login_info = Array();
        _check_identityCode($_POST['IdentityCode'],$_SESSION['identitycode']);//验证表单唯一识别码
        _check_verifcode(4,$_POST['verifcode'],$_SESSION['verifcode']);//检查验证码
        $_login_info['username'] = $_POST['username']; //不检查用户名email地址格式合法性
        $_login_info['password'] = _check_password($_POST['password'],6,30);//检查密码格式
        $_login_info['loginkeeping'] = isset($_POST['loginkeeping']);
        
        
        echo '<br/><br/>';
        print_r($_login_info);
        unset($_login_info);
//        echo date("Y-m-d H:i:s",time()+8*60*60);        
    }
    else if(isset($_POST['IdentityCode']) && isset($_GET['act']) && $_GET['act'] == 'register')
    {
        $_register_info = Array();
        _check_identityCode($_POST['IdentityCode'],$_SESSION['identitycode']);//验证表单唯一识别码
        _check_verifcode(4,$_POST['verifcode'],$_SESSION['verifcode']);//检查验证码
        $_register_info['usernamesignup'] = _check_username($_POST['usernamesignup']);
        $_register_info['emailsignup'] = _check_email($_POST['emailsignup']); //检查用户名email地址格式合法性
        $_register_info['phonenumsignup'] = _check_phonenum($_POST['phonenumsignup']);
        $_register_info['passwordsignup'] = sha1(md5(_check_password($_POST['passwordsignup'],6,30,$_POST['passwordsignup_confirm'])));//检查密码格式及加密
        $_register_info['$_timestamp'] = time()+8*60*60;
        $_register_info['timesignup'] = date("Y-m-d H:i:s",$_register_info['$_timestamp']);
        $_register_info['uid'] = md5($_register_info['$_timestamp']+19901117);
        
        /***将用户注册信息写入数据库*******/
        @mysql_query("INSERT INTO `user_info`(
            `user_uid`, 
            `user_phone`, 
            `user_pwd`, 
            `user_rts`, 
            `user_rt`, 
            `user_email`, 
            `user_name`) 
            VALUES (
            '{$_register_info['uid']}',
            '{$_register_info['phonenumsignup']}',
            '{$_register_info['passwordsignup']}',
            '{$_register_info['$_timestamp']}',
            '{$_register_info['timesignup']}',
            '{$_register_info['emailsignup']}',
            '{$_register_info['usernamesignup']}')") or die('数据库执行错误:'.mysql_error());
//        print_r($_register_info);
        /******************************************************/
        mysql_close();
        
        _jumplocation('注册成功','index.php');
    }

    $_SESSION['identitycode'] = md5(mt_rand());
?>
<!DOCTYPE html>
<html lang="en" class="no-js"> 
    <head>
        <meta charset="UTF-8" />
        <!-- <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">  -->
        <title>奶油猪客户管理系统</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <meta name="description" content="Login and Registration Form with HTML5 and CSS3" />
        <meta name="keywords" content="html5, css3, form, switch, animation, :target, pseudo-class" />
        <meta name="author" content="Codrops" />
        <link rel="shortcut icon" href="icon/pooh.ico">  
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
            <section>				
                <div id="container_demo" >
                    <!-- hidden anchor to stop jump http://www.css3create.com/Astuce-Empecher-le-scroll-avec-l-utilisation-de-target#wrap4  -->
                    <a class="hiddenanchor" id="toregister"></a>
                    <a class="hiddenanchor" id="tologin"></a>
                    <div id="wrapper">
                        <div id="login" class="animate form">
                            <form method="post" action="LoginZh-cn.php?act=login"  autocomplete="on" >
                                <input type="hidden" name="IdentityCode" value=<?php echo $_SESSION['identitycode'];?>>
                                <h1>登 陆</h1> 
                                <p> 
                                    <label for="username"  data-icon="u" >账户名称 </label>
                                    <input id="username" name="username"  type="text" placeholder="用户名或邮箱地址"/>
                                </p>
                                <p> 
                                    <label for="password" data-icon="p">密码 </label>
                                    <input id="password" name="password" required="required" type="password" placeholder="6~30位数字及英文字母" />
                                </p>
                                <p id="verifcode"> 
									<label for="verifcode" >验证码 </label><br />
                                    <input id="verifcode" name="verifcode" required="required" type="text" placeholder="4位验证码"/>
								    <img src = "verifcode.php" id="codepng" onclick="javascript:this.src='verifcode.php?tm='+Math.random()"/>
								</p>
                                <p class="keeplogin"> 
									<input type="checkbox" name="loginkeeping" id="loginkeeping" value="loginkeeping" /> 
									<label for="loginkeeping">保持登录状态 </label>
								</p>
                                <p class="login button"> 
                                    <input type="submit" value="登&nbsp&nbsp陆" /> 
								</p>
                                <p class="change_link">
									 还没有<strong>账号</strong>吗？
									<a href="#toregister" class="to_register">加入我们</a>
								</p>
                            </form>
                        </div>
                       
                        <div id="register" class="animate form">
                            <form  method="post" action="LoginZh-cn.php?act=register" autocomplete="on">
                            <input type="hidden" name="IdentityCode" value=<?php echo $_SESSION['identitycode'];?>> 
                                <h1>注 册</h1> 
                                <p> 
                                    <label for="usernamesignup" class="uname" data-icon="U">用户名</label>
                                    <input id="usernamesignup" name="usernamesignup" required="required" type="text" placeholder="4~20位字符" />
                                </p>
                                <p> 
                                    <label for="emailsignup" class="youmail" data-icon="E" >邮箱</label>
                                    <input id="emailsignup" name="emailsignup" required="required" type="email" placeholder="注册电子邮件"/> 
                                </p>
                                <p> 
                                    <label for="phonenumsignup" class="phone" data-icon="T" >联系电话</label>
                                    <input id="phonenumsignup" name="phonenumsignup" required="required" type="text" placeholder="注册电话号码"/> 
                                </p>
                                <p> 
                                    <label for="passwordsignup" class="youpasswd" data-icon="P">密码</label>
                                    <input id="passwordsignup" name="passwordsignup" required="required" type="password" placeholder="6~30位数字及英文字母"/>
                                </p>
                                <p> 
                                    <label for="passwordsignup_confirm" class="youpasswd" data-icon="CP">确认密码</label>
                                    <input id="passwordsignup_confirm" name="passwordsignup_confirm" required="required" type="password" placeholder="重复输入密码"/>
                                </p>
                                <p id="verifcode"> 
									<label for="verifcode" data-icon="V">验证码 </label><br />
                                    <input id="verifcode" name="verifcode" required="required" type="text" placeholder="4位验证码"/>
								    <img src = "verifcode.php" id="codepng" onclick="javascript:this.src='verifcode.php?tm='+Math.random()"/>
								</p>
                                <p class="signin button"> 
									<input type="submit" value="注 册"/> 
								</p>
                                <p class="change_link">  
									已经有账号？
									<a href="#tologin" class="to_register">去登陆</a>
								</p>
                            </form>
                        </div>
						
                    </div>
                </div>  
            </section>
        </div>
    </body>
</html>