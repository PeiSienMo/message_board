<?php
/**
 * Created by PhpStorm.
 * User: Mo
 * Date: 2018/6/2
 * Time: 12:07
 */
require_once 'connect_mysql.php';
$conn = connect_mysql();

require_once 'register_error.php';

$name = $_POST['name'];

$name_message = $name.'_message';

$password = $_POST['password'];
$password=md5($password);
$gender = $_POST['gender'];
date_default_timezone_set('Asia/Shanghai');//设置时区
$register_time = date('YmdHis');
$result=mysqli_query($conn,"insert into user (id,name,user_password,gender,register_time) values (null,'$name','$password',$gender,$register_time)");
if($result){

    $sql = 'create table '.$name_message.' (
num int primary key auto_increment,
sender varchar(255) not null,
addressee varchar(255) not null,
message varchar(255) not null,
pub_time datetime not null
)charset utf8';

    mysqli_query($conn,$sql);
    echo $name.'注册成功<br>';

}
else{
    echo '注册出错';
}

?>
<a href="user_login.html">登录页面</a>



