<?php
/**
 * Created by PhpStorm.
 * User: Mo
 * Date: 2018/6/2
 * Time: 12:57
 */



if(!isset($_POST['name']) || empty($_POST['name']))
{
    die('没有输入用户账号');
}else{
    $name = $_POST['name'];
    if(strlen($name)<6)
    {
        die('用户名字过短，请输入6-15位的字母加数字密码');
    }
    if(strlen($name)>15){
        die('用户名字过长，请输入6-15位的字母加数字密码');
    }
}
$name = $_POST['name'];

require_once 'connect_mysql.php';
$conn = connect_mysql();

$res = mysqli_query($conn,"SELECT * FROM user where name ='$name'");
$res_arr = mysqli_fetch_array($res);
if($res_arr){
 die('用户已存在，请重新<a href="user_register.html">注册</a>');
}



if(!isset($_POST['password']) || empty($_POST['password']))
{
    die('没有输入用户密码');
}else{
    $password = $_POST['password'];
    if(strlen($password)<6)
    {
        die('用户密码过短，请输入6-15位的字母加数字密码');
    }
    if(strlen($password)>15){
        die('用户密码过长，请输入6-15位的字母加数字密码');
    }
}


if(!isset($_POST['password_01']) || empty($_POST['password_01']))
{
    die('没有输入确认密码');
}


require_once 'strTObin.php';
if(strTObin($_POST['password']) != strTObin($_POST['password_01'])){
    die('两次密码输入不相同');
}

