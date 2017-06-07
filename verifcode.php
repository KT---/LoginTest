<?php
/* ===================================
*	tytel		:
*	version		:
*	By			:KT
*	Data		:2017年6月5日
=======================================*/
session_start();
$codenum = null;
for($i=0;$i<4;$i++)
{
    $codenum .= dechex(mt_rand(0,15));
}
$_SESSION['verifcode'] = $codenum;

$codewidth = 80;
$codeheight = 25;
$codeimg = imagecreatetruecolor($codewidth, $codeheight);

$_white = imagecolorallocate($codeimg, 220, 255, 255);
$_black = imagecolorallocate($codeimg, 0, 0, 0);

imagefill($codeimg, 0, 0, $_white);
//imagerectangle($codeimg, 0, 0,$codewidth-1, $codeheight-1, $_black);

//随机线条*6
for($i=0;$i<6;$i++)
{
    $rand_color = imagecolorallocate($codeimg, mt_rand(100,200),mt_rand(100,200),mt_rand(100,200));
     imageline($codeimg,
               mt_rand(2,$codewidth/2),
               mt_rand(2,$codeheight-2),
               mt_rand($codewidth/2,$codewidth-2),
               mt_rand(2,$codeheight-2),
               $rand_color);
}
//创建随机背景雪花
for($i=0;$i<50;$i++)
{
    $rand_color = imagecolorallocate($codeimg, mt_rand(200,255),mt_rand(200,255),mt_rand(200,255));
    imagestring($codeimg,1,mt_rand(1,$codewidth),mt_rand(1,$codeheight),'*', $rand_color);
}
//输出验证码
for($i=0;$i<4;$i++)
{
    $rand_color = imagecolorallocate($codeimg, mt_rand(0,155),mt_rand(0,155),mt_rand(0,155));
    imagestring($codeimg,
                5,
                mt_rand($i*($codewidth-2)/4+3,($i+1)*($codewidth-2)/4-5),
                mt_rand(0, $codeheight/2),
                $_SESSION['verifcode'][$i],
                $rand_color);
    
}


header('Content-Type:image/png');
imagepng($codeimg);

imagedestroy($codeimg); 

?>