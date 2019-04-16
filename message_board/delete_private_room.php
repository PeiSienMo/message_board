<?php
/**
 * Created by PhpStorm.
 * User: Mo
 * Date: 2018/6/6
 * Time: 20:33
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
    echo '<a href="private_room.php">私人空间</a><br />';
    die('url出错：服务器未成功获取信息');

}else {

    //连接数据库
    require_once 'connect_mysql.php';
    $conn = connect_mysql();

    $ID = intval($_GET['ID']);
    $name = $_GET['name'];
    $name_message = $name . '_message';

//执行删除语句
    $sql = "delete from $name_message where num = $ID  ";
    mysqli_query($conn, $sql);

    header("location:private_room.php");
}