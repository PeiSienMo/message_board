<?php
/**
 * Created by PhpStorm.
 * User: 惠普
 * Date: 2019/4/9
 * Time: 22:02
 */

session_start();

//检测是否登录，若没登录则转向登录界面
if(!isset($_SESSION['id'])){
    header("Location:user_login.html");
    exit();
}


include('connect_mysql.php');
$conn = connect_mysql();

$id = $_SESSION['id'];
$name = $_SESSION['name'];


if (isset($_FILES['imgfile']['tmp_name'])
    && is_uploaded_file($_FILES['imgfile']['tmp_name']))
{
    $imgFile = $_FILES['imgfile'];
    $upErr = $imgFile['error'];

    if($upErr==0){
        $img_type=$imgFile['type'];
        if($img_type=='image/jpeg'||$img_type=='image/png'||$img_type=='image/gif'){
            $img_name = $imgFile['name'];
            $imgTmpFile = $imgFile['tmp_name'];

            $ext_pos = strrpos($img_name,'.');//返回字符串filename中'.'号最后一次出现的数字位置
            $ext = substr($img_name,$ext_pos+1);
            date_default_timezone_set('Asia/Shanghai');//设置时区
            $date=date('Ymdhis');//得到当前时间,如;20070705163148
            $img_name = $name.$date.'.'.$ext;

            //查同名文件
            $res = mysqli_query($conn,"SELECT * FROM photo where name ='$name'");
            $res_arr = mysqli_fetch_array($res);
            if($res_arr){
                    mysqli_query($conn,"DELETE FROM `photo` WHERE name ='$name'");//删除原图在数据库的文件
                    unlink($res_arr['address']);//删除原图在服务器的文件
            }

            move_uploaded_file($imgTmpFile, 'E:\xampp\htdocs\message_board\headPortrait\\'.$img_name);
            $address = 'headPortrait/'.$img_name;
            $sql = "insert into photo (name,address) values ('$name','$address')";
            $result = mysqli_query($conn,$sql);
            if($result){
                header("location:user_center.php");
            }else{
                echo '上传失败';
            }

        }else{
            echo '仅限上传gif，png，jpeg格式的图片'.'<a href="http://localhost/img/upload_photo.html">点击此处返回上传界面</a>';
        }
    }
}
else{
    echo '图片上传失败';
}


