<?php
/**
 * Created by PhpStorm.
 * User: Mo
 * Date: 2018/6/5
 * Time: 22:21
 */


session_start();

//检测是否登录，若没登录则转向登录界面
if(!isset($_SESSION['id'])){
    header("Location:user_login.html");
    exit();
}

require_once 'connect_mysql.php';
$conn = connect_mysql();

$id = $_SESSION['id'];
$name = $_SESSION['name'];



if (empty($_POST['message']) || empty($_POST['sender']) || empty($_POST['addressee'])){
    echo '<a href="private_room.php">返回</a>';
    die('error:信息录入失败');
}


$message = $_POST['message'];
$sender = $_POST['sender'];
$addressee = $_POST['addressee'];

$query = mysqli_query($conn,"select * from user where name = '$addressee' limit 1");
$result=mysqli_fetch_assoc($query);
if(!$result){
    die('收件人不存在<a href="private_room.php">私人空间</a><br />');
}
require_once 'strTObin.php';
if(StrToBin($name) != StrToBin($sender)){
    die('出错：寄件人非本人');
}

require_once 'strTObin.php';
if(StrToBin($sender) == StrToBin($addressee)){
    die('出错：收件人为本人<a href="private_room.php">私人空间</a><br />');
}
date_default_timezone_set('Asia/Shanghai');//设置时区
$pub_time = date('YmdHis');

$sendermessage = $sender.'_message';
$addresseemessage = $addressee.'_message';
$sql = "insert into $sendermessage (num,sender,addressee,message,pub_time) values (null,'$sender','$addressee','$message',$pub_time)";

mysqli_query($conn,$sql);

$sql1 = "insert into $addresseemessage (num,sender,addressee,message,pub_time) values (null,'$sender','$addressee','$message',$pub_time)";
mysqli_query($conn,$sql1);

header("location:private_room.php");
