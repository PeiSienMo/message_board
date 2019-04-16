<?php
/**
 * Created by PhpStorm.
 * User: Mo
 * Date: 2018/6/3
 * Time: 22:17
 */

session_start();

//检测是否登录，若没登录则转向登录界面
if(!isset($_SESSION['id'])){
    header("Location:user_login.html");
    exit();
}

require_once 'connect_mysql.php';
$conn = connect_mysql();

//$id = $_SESSION['id'];
$name = $_SESSION['name'];

if(!isset($_POST['message']) || empty($_POST['message'])) {

    die( '没有输入留言<a href="public_room_message.php">返回</a>');

}

$message = $_POST['message'];

date_default_timezone_set('Asia/Shanghai');//设置时区
$pub_time = date('YmdHis');

$sql = "insert into public_room (num,name,message,pub_time) values (null,'$name','$message',$pub_time)";

mysqli_query($conn,$sql);

header("location:public_room_message.php");
