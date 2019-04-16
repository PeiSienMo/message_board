<?php
/**
 * Created by PhpStorm.
 * User: Mo
 * Date: 2018/6/2
 * Time: 17:20
 */
session_start();


 //注销登录
  if(@$_GET['action'] == "logout"){
      unset($_SESSION['id']);
      unset($_SESSION['name']);
      echo '注销登录成功！点击此处 <a href="user_login.html">登录</a>';
      exit;
 }

//检查是否输入用户账号
if(!isset($_POST['name']) || empty($_POST['name']))
{
    die('没有输入用户账号<a href="user_login.html">返回</a>');
}

//检查是否输入用户密码
if(!isset($_POST['password']) || empty($_POST['password']))
{
    die('没有输入用户密码<a href="user_login.html">返回</a>');
}

//链接数据库
require_once 'connect_mysql.php';
$conn = connect_mysql();

//登录
$name = $_POST['name'];
$password = $_POST['password'];
$password=md5($password);
//匹配账号密码
$password_query = mysqli_query($conn,"select * from user where name = '$name' and user_password = '$password' limit 1");
if(!$password_query){
    echo $name."未注册，出错<a href='user_register.html'>注册</a>";
}else {
    if ($result = mysqli_fetch_array($password_query)) {
        //登录成功
        $_SESSION['name'] = $name;
        $_SESSION['id'] = $result['id'];

        //数据库里匹配是否此用户有上传过头像
        $res = mysqli_query($conn, "SELECT * FROM photo where name ='$name'");
        $res_arr = mysqli_fetch_array($res);
        if ($res_arr) {
            $photo_address = $res_arr['address'];
        } else {
            $photo_address = 'headPortrait/original.png';
        }

//输出信息
        echo '<img src="' . $photo_address . '" width="100px" height="100px" >' . '<br />';

        echo $name, ' 欢迎你！进入 <a href="user_center.php">用户中心</a><br />';
        echo ' <a href="public_room_message.php">公共空间</a><br />';
        echo ' <a href="private_room.php">私人空间</a><br />';
        echo '点击此处 <a href="user_login.php?action=logout">注销</a>登录！<br />';
        exit;
    } else {
        exit('登录失败！点击此处 <a href="javascript:history.back(-1);">返回</a> 重试');
    }
}