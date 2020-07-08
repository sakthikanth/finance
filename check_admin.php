<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

session_start();


require './my.php';
$user_name=  mysqli_real_escape_string($dbc,$_REQUEST['uname']);
$pass_word=  mysqli_real_escape_string($dbc,$_REQUEST['upass']);

$r=q("select user_id as u from admin_dets where username='$user_name' and password='$pass_word'");
if(!empty($u) && $u!=NULL && $r==true){
    $_SESSION['add_cus']=$u;
    echo 's';
}else{
    echo 'n';
}