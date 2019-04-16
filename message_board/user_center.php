<?php
/**
 * Created by PhpStorm.
 * User: Mo
 * Date: 2018/6/2
 * Time: 18:23
 */

session_start();

 //检测是否登录，若没登录则转向登录界面
  if(!isset($_SESSION['id'])){
        header("Location:user_login.html");
      exit();
  }

 //包含数据库连接文件
 include('connect_mysql.php');
  $conn = connect_mysql();

 $id = $_SESSION['id'];
 $name = $_SESSION['name'];

 //数据库里用姓名匹配
$result = mysqli_query($conn,"SELECT * FROM photo where name ='$name'");
$res_arr = mysqli_fetch_array($result);
if($res_arr){
    $photo_address = $res_arr['address'];
}else{
    $photo_address = 'headPortrait/original.png';
}

//数据库里用id来匹配信息
$user_query = mysqli_query($conn,"select * from user where id=$id limit 1");
$res_arr = mysqli_fetch_array($user_query);

//输出信息
 echo '用户信息：<br />';
  echo '<img src="'.$photo_address.'" width="100px" height="100px" >'.'<br />';
?>
<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>留言</title>
    </head>
    <body>

    <form action="upload_photo.php" method="post" enctype="multipart/form-data" name="upload_form">

        <label>选择图片文件修改头像</label>
        <input name="imgfile" type="file" accept="image/gif,image/jpeg,image/png"/>

        <input name="upload" type="submit" value="上传" />
    </form>
    </body>
    </html>

  <?php
  echo '用户ID：'.$res_arr['id'].'<br />';
  echo '用户名：'.$res_arr['name'].'<br />';
  if($res_arr['gender'] == 1)
  {
      $gender = '男';
  }else{
      $gender = '女';
  }

 echo '性别：'.$gender.'<br />';
 echo '注册日期：'. $res_arr['register_time'].'<br />';

echo '<a href="user_center.php">用户中心</a>   ';
echo ' <a href="public_room_message.php">公共空间</a>';
echo ' <a href="private_room.php">私人空间</a><br />';
echo '点击此处 <a href="user_login.php?action=logout">注销</a> 登录！<br />';