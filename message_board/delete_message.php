<?php
/**
 * Created by PhpStorm.
 * User: Mo
 * Date: 2018/6/3
 * Time: 22:30
 */

session_start();

//检测是否登录，若没登录则转向登录界面
if(!isset($_SESSION['id'])){
    header("Location:user_login.html");
    exit();
}

//连接数据库
require_once 'connect_mysql.php';
$conn = connect_mysql();

$id = $_SESSION['id'];
$name = $_SESSION['name'];

//检查是否获取$_GET
if(empty($_GET['ID']) || empty($_GET['name']) ){
   echo '<a href="public_room_message.php">公共空间</a><br />';
   die('url出错：服务器未成功获取信息');
}else{
    $ID = intval($_GET['ID']);
     $name1 = $_GET['name'];
}

//执行删除语句
$sql = "delete from $name1 where num = $ID  ";
mysqli_query($conn,$sql);

header("location:public_room_message.php");