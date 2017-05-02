<?php

session_start();
unset($_SESSION['user_id']);
unset($_SESSION['fin_id']);

foreach ($_SESSION as $ses=>$val){
    unset($_SESSION[$ses]);
}
session_destroy();
if(empty($_SESSION['user_id'])){
    header("location:index.php");

}

