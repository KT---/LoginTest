/**
 * 
 */

function resetCookie(name,value,path) 
{ 
    var Days = 30; 
    var exp = new Date(); 
    exp.setTime(exp.getTime()-1); 
    document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString()+";path="+path;
    document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString()+";path="+path+"/";
    location.href = "../index.php";
} 