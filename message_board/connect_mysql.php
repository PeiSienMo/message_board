<?php
/**
 * Created by PhpStorm.
 * User: Mo
 * Date: 2018/6/2
 * Time: 11:49
 */
function connect_mysql() //构建链接数据库函数,方便部署代码时应变不同数据库，减少修改量
{
    $conn = mysqli_connect('localhost', 'root', '');

//判断是否链接数据库成功
    if (!$conn) {
        die('<br>连接失败');
    }

//选择message_board数据库
/*mysql_select_db() 函数设置活动的 MySQL 数据库。
如果成功，则该函数返回 true。如果失败，则返回 false。*/
    $res = mysqli_select_db($conn, 'message_board');
    if(!$res){
        //如果没有该数据库则创建此数据库以及相应使用的表则创建
        $sql = 'create database message_board';
        $res1 = mysqli_query($conn,$sql);
        if($res1){

            mysqli_select_db($conn, 'message_board');

            $sql = 'create table photo (
            id tinyint(50) primary key auto_increment,
            name varchar(255) not null,
            address varchar(255) not null
            )charset utf8';
            mysqli_query($conn,$sql);

            $sql = 'create table public_room (
            num int(20) primary key auto_increment,
            name varchar(255) not null,
            message varchar(255) not null,
            pub_time datetime not null
            )charset utf8';
            mysqli_query($conn,$sql);

            $sql = 'create table user (
            id int(20) primary key auto_increment,
            name varchar(255) not null,
            user_password text not null,
            gender tinyint(4) not null,
            register_time date not null
            )charset utf8';
            mysqli_query($conn,$sql);

        }else{
            die('创建数据库失败');
        }

    }
    return $conn;
}