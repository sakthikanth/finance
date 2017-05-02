<?php

session_start();

if($_REQUEST['date']!=""){
$_SESSION['cur_date']=$_REQUEST['s_date'];


$_SESSION['show_date']=$_REQUEST['date'];
    echo "Date Set ".$_SESSION['show_date'];
}else{
    echo "Date Not Set";
}

