<?php
/**
 * Created by PhpStorm.
 * User: Mo
 * Date: 2018/6/3
 * Time: 22:05
 */


session_start();

$id = @$_SESSION['id'];
$name = @$_SESSION['name'];

require_once 'connect_mysql.php';
$conn = connect_mysql();

mysqli_query($conn,"use message_board");

$sql ="select * from public_room";
$res=mysqli_query($conn,$sql);
$date_num =  mysqli_num_rows($res);

echo '<br>';

$public_room = 'public_room';
echo '<table border="1" style="text-align: left" >';
echo '<caption><marquee direction="left" widtn="800" height="60" bgcolor="white" ><h1 style="color:black" align="center">公共留言板<h1></caption>';
echo "<tr><td>ID</td><td>头像</td><td>名字</td><td>留言</td><td>留言时间</td></tr>";


for($i=0;$i<$date_num;$i++)
{
    $res_arr = mysqli_fetch_assoc($res);
    $send_name = $res_arr['name'];
    $num=$res_arr['num'];
    $message=$res_arr['message'];
    $pub_time=$res_arr['pub_time'];

    //数据库里用姓名匹配
    $res1 = mysqli_query($conn,"SELECT * FROM photo where name ='$send_name'");
    $res_arr1 = mysqli_fetch_array($res1);
    if($res_arr1){
        $photo_address = $res_arr1['address'];
    }else{
        $photo_address = 'headPortrait/original.png';
    }
    $address='<img src="'.$photo_address.'" width="60px" height="60px" >';

    require_once 'strTObin.php';
    if(StrToBin($send_name) == StrToBin($name)){
        echo "<tr><td>$num</td><td>$address</td><td>$send_name</td><td>$message</td><td>$pub_time</td><td><a href='edit_message_form.php?ID=$num&name=$public_room'>修改</a></td>
                <td><a href='delete_message.php?ID=$num&name=$public_room'>删除</a></td><tr>";

    }else {


        //数据库里用姓名匹配
        $res1 = mysqli_query($conn,"SELECT * FROM photo where name ='$send_name'");
        $res_arr1 = mysqli_fetch_array($res1);
        if($res_arr1){
            $photo_address = $res_arr1['address'];
        }else{
            $photo_address = 'headPortrait/original.png';
        }
        $address='<img src="'.$photo_address.'" width="60px" height="60px" >';
        echo "<tr><td>$num</td><td>$address</td><td>$send_name</td><td>$message</td><td>$pub_time</td></tr>";
    }

}

echo '</table>';

if(!empty($id)) {


//检查是否获取$_GET
    if(empty($_GET['ID']) || empty($_GET['name']) ){
        echo '<a href="public_room_message.php">公共空间</a><br />';
        die('url出错：服务器未成功获取信息');

    }else
    {

        //连接数据库
        require_once 'connect_mysql.php';
        $conn = connect_mysql();

        $ID = intval($_GET['ID']);
        $name1 = $_GET['name'];

        $result = mysqli_query($conn,"SELECT * FROM $name1 WHERE num = $ID");

        $result_arr = mysqli_fetch_assoc($result);
    }
    ?>


    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>留言</title>
    </head>
    <body>
    <form action="edit_message.php" method="post">
        <div>ID：
            <input name="ID" value="<?php echo $result_arr['num']; ?>" type="text">
        </div>
        <div>留言地址：
            <input name="name1" value="<?php echo $name1; ?>" type="text">
        </div>
        <div>留言信息：
            <textarea cols="10" rows="10" name="message" ><?php echo $result_arr['message']; ?></textarea>
        </div>


        <input type="submit" value="确定修改">
    </form>
    </body>
    </html>
    <?php
    echo '<a href="user_center.php">用户中心</a>   ';
    echo ' <a href="public_room_message.php">公共空间</a><br />';
    echo ' <a href="private_room.php">私人空间</a><br />';
    echo '点击此处 <a href="user_login.php?action=logout">注销</a> 登录！<br />';
    echo '<br>';
}else{
    require_once 'user_login.html';
}
?>