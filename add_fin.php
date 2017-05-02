<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

session_start();

if(empty($_SESSION['user_id']) || empty($_SESSION['add_cus'])){
    echo 'es';
}else{
    
    require './my.php';
    
    $uname=  mysqli_real_escape_string($dbc,$_REQUEST['fname']);
    
    if(!empty($uname) ){
       $t= q("select finance_name from finance_accounts where finance_name='$uname'");
        if($t==true && count($finance_name)==0){
               $r=q("insert into finance_accounts(finance_name)values('$uname')");
    if($r){
        $_SESSION['add_cus']="";
        unset($_SESSION['add_cus']);
        echo 's';
    }else{
        echo 'n';
    }
        }else{
            echo "ae";
        }
        
    
     
    }else{
        echo 'em';
    }

}