<?php

    session_start();
    
    print_r($_COOKIE);
    echo '<br/>';
    echo base64_decode($_COOKIE['LT_ts']).'<br/>';
    echo $_SESSION['identitycode'];
    if($_COOKIE['LT_ic'] != $_SESSION['identitycode'])
    {
        exit('非法访问');
    }

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
       </div>
    </body>
</html>