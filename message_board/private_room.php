<?php
/**
 * Created by PhpStorm.
 * User: Mo
 * Date: 2018/6/5
 * Time: 22:05
 */

session_start();

//检测是否登录，若没登录则转向登录界面
if(!isset($_SESSION['id'])){
    header("Location:user_login.html");
    exit();
}

$id = $_SESSION['id'];
$name = $_SESSION['name'];


require_once 'connect_mysql.php';
$conn = connect_mysql();

mysqli_query($conn,"use message_board");


$namemessage = $name.'_message';

$sql ="select * from $namemessage";
$res=mysqli_query($conn,$sql);
$date_num =  mysqli_num_rows($res);

echo '<br>';
echo '一共有留言'.$date_num.'条';
echo '<br>';

echo '<table style="text-align: left" border="1" >';
echo '<caption><marquee direction="left" widtn="800" height="60" bgcolor="white" ><h1 style="color:black" align="center">私密留言板<h1></caption>';
echo '<tr><td>id</td><td>头像</td><td>寄件人</td><td>收件人</td><td>信息</td><td>留言时间</td></tr>';

for ($i=0;$i<$date_num;$i++){
    $res_arr = mysqli_fetch_assoc($res);
    $num = $res_arr['num'];
    $sender = $res_arr['sender'];
    $addressee = $res_arr['addressee'];
    $message = $res_arr['message'];
    $pub_time=$res_arr['pub_time'];

    //数据库里用姓名匹配
    $res1 = mysqli_query($conn,"SELECT * FROM photo where name ='$sender'");
    $res_arr1 = mysqli_fetch_array($res1);
    if($res_arr1){
        $photo_address = $res_arr1['address'];
    }else{
        $photo_address = 'headPortrait/original.png';
    }
    $address='<img src="'.$photo_address.'" width="60px" height="60px" >';

    echo "<tr><td>$num</td><td>$address</td><td>$sender</td><td>$addressee</td><td>$message</td><td>$pub_time</td>
<td><a href='delete_private_room.php?ID=$num&name=$name'>删除</a></td></tr>";
}



echo '</table>';
?>

<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>留言</title>
    </head>
    <body>
    <form action="insert_private_room.php" enctype="multipart/form-data" method="post">
        <div>寄件人：
            <input name="sender" type="text" value="<?php echo $name; ?>">
        </div>
        <div>收件人：
            <input name="addressee" type="text">
        </div>
        <textarea cols="10" rows="10" name="message" style=" width: 450px;height: 100px">
    </textarea>
        <br>
        <input value="提交按钮" type="submit" onclick="this">
    </form>
    </body>
    </html>


    <?php
    echo '<a href="user_center.php">用户中心</a>   ';
    echo ' <a href="public_room_message.php">公共空间</a><br />';
    echo ' <a href="private_room.php">私人空间</a><br />';
    echo '点击此处 <a href="user_login.php?action=logout">注销</a> 登录！<br />';
    echo '<br>';

if(empty($id)){
    header("location:user_login01.php");
}
