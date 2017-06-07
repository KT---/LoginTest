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
    define('Login_inc',true);
    define('Login_func',true);
    
   require dirname(__FILE__).'/function/login.func.php';
    // if(!($_SESSION['HTTP_REFERER'] == md5('index.php')))
    // {
    //     exit('非法登入！');
    // }

    //表单提交本页后进行验证
    if(isset($_GET['act']) && $_GET['act'] == 'login')//判断$_GET['act']是否被定义，决定是否进行表单内容审核验证
    {
        if(!($_POST['verifcode'] == $_SESSION['verifcode']))//核对验证码verifcode
        {
             echo "<script language=javascript>alert('验证码错误');history.back();</script>";
        }
        if(!($_SESSION['identitycode'] == $_POST['IdentityCode']))//验证唯一表示码$_SESSION['identitycode']
        {
             echo "<script language=javascript>alert('表单提交错误');history.back();</script>";
        }
        if(!_check_email($_POST['username']))//检查用户名email地址格式合法性
        {
            echo "<script language=javascript>alert('非法用户名');history.back();</script>";
        }
    //     print_r($_POST);
        echo '登陆成功';
    }


    $_SESSION['identitycode'] = md5(mt_rand());
?>
<!DOCTYPE html>
<html lang="en" class="no-js"> 
    <head>
        <meta charset="UTF-8" />
        <!-- <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">  -->
        <title>奶油小猪客户管理系统</title>
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
                <h1>奶油小猪<span>客户管理系统</span></h1>
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
                                <h1>登陆</h1> 
                                <p> 
                                    <label for="username"  data-icon="u" >账户名称 </label>
                                    <input id="username" name="username" required="required" type="text" placeholder="用户名或邮箱地址"/>
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
                            <form  action="mysuperscript.php" autocomplete="on"> 
                                <h1> Sign up </h1> 
                                <p> 
                                    <label for="usernamesignup" class="uname" data-icon="u">Your username</label>
                                    <input id="usernamesignup" name="usernamesignup" required="required" type="text" placeholder="mysuperusername690" />
                                </p>
                                <p> 
                                    <label for="emailsignup" class="youmail" data-icon="e" > Your email</label>
                                    <input id="emailsignup" name="emailsignup" required="required" type="email" placeholder="mysupermail@mail.com"/> 
                                </p>
                                <p> 
                                    <label for="passwordsignup" class="youpasswd" data-icon="p">Your password </label>
                                    <input id="passwordsignup" name="passwordsignup" required="required" type="password" placeholder="eg. X8df!90EO"/>
                                </p>
                                <p> 
                                    <label for="passwordsignup_confirm" class="youpasswd" data-icon="p">Please confirm your password </label>
                                    <input id="passwordsignup_confirm" name="passwordsignup_confirm" required="required" type="password" placeholder="eg. X8df!90EO"/>
                                </p>
                                <p class="signin button"> 
									<input type="submit" value="Sign up"/> 
								</p>
                                <p class="change_link">  
									Already a member ?
									<a href="#tologin" class="to_register"> Go and log in </a>
								</p>
                            </form>
                        </div>
						
                    </div>
                </div>  
            </section>
        </div>
    </body>
</html>