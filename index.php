<?php
session_start();


                $year=date('Y');
                $month=date('m');
                $day=date('d');
                $hr=date('g');
                $min=date('i');
                $noon=date('A');
                $_SESSION['cur_day']=$day;
                $_SESSION['cur_month']=$month;
                $_SESSION['cur_year']=$year;
                
                if($day<=9){
                    $cday="0".$day;
                }
                if($month<=9){
                    $cmnth="0".$month;
                }
                
                $_SESSION['show_date']="$year-$month-$day";
                $_SESSION['cur_date']="$day-$month-$year";
                
if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) header("location:fin_accounts.php");

$enter_login=0;
if(!empty($_REQUEST['user_name']) && !empty($_REQUEST['pass_word'])){
    require './my.php';
    $user_name=  mysqli_real_escape_string($dbc,$_REQUEST['user_name']);
    $pass_word= mysqli_real_escape_string($dbc,$_REQUEST['pass_word']);
    
    
    $q=q("select user_id from admin_dets where username='$user_name' and password='$pass_word'");
    if($q){
        if($user_id!=NULL){
            
            $_SESSION['user_id']="$user_id";
            
            echo '<h2 style="color:green">Login Success...</h2>Redirecting Please wait...<script>window.location.href="fin_accounts.php"</script>';
        }else{
            
            $q2=q("select users_id as u from users where user_name='$user_name' and passwd='$pass_word'");
            if($u!=NULL && $q2){
                    $_SESSION['user_id']="$u";
            
            echo '<h2 style="color:green">Login Success...</h2>Redirecting Please wait...<script>window.location.href="fin_accounts.php"</script>';
      
            }else{
                 $enter_login=1;
            }
           
             
        }
    }
            
}else{
    $enter_login=2;
}

if($enter_login>0)
{
    ?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
        <link rel="stylesheet" href="css/bootstrap.min.css" />
        <script src="js/jquery.js" ></script>
        <title>Velmurugan Finance</title>
        <style>
            /*
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
*/
/* 
    Created on : Nov 26, 2016, 9:03:35 AM
    Author     : Sakthikanth
*/
.title_bar div{
    display: inline-block;
    padding: 10px;
    text-align:center;
    
}

.title_bar{
    text-align: center;
    padding: 10px;
    background-color: #34495e;
    box-shadow: 0px 0px 10px 0px #34495e;
}
.title_text_cont{
    
    color: white;
    font-size: 30px;
}
input
{
    padding: 7px;
    width: 300px;
    border: 0px;
    padding-left: 10px;
    font-size: 20px;
}
li button{
    padding: 7px;
    width: 100px;
    border: 0px;
     font-size: 20px;
}
.seacr_container{
    text-align: center;
}
.logout_btn button{
    background-color: #b71c1c;
    color: white;
    font-size: 20px;
    padding: 7px !important;
    
        
}

.finance_item{
    display: inline-block;
    padding: 10px;
    
    
}
.innder{
    padding:70px;
    background-color: whitesmoke;
    border: 1px solid lightgrey;
    //width: 200px;
    text-align: center;
    box-shadow: 0px 0px 10px 0px lightgrey;
    cursor: pointer;
}
.fin_acc_ttl,.fin_item_container{
    text-align: center;
}
.fin_acc_ttl{
    font-size: 35px;
    padding: 30px;
}
.finance_text{
    font-size: 20px;
}
.add_acnt_holder{
    padding: 10px;
    text-align: right;
}
.add_acnt_btn{
    padding: 10px;
    color: white;
    background-color: #1a237e;
    display: inline-block;
    cursor: pointer;
    box-shadow: 0px 0px 2px 0px #1a237e;
}

th{
    padding: 30px;
    
}
table{
    text-align: center;
}

.form_item{
    display: inline-block;
    padding: 10px;
}
.form_container{
    text-align: center;
}
.form_item input{
    border: 1px solid #1a237e;
}
.form_inps div{
    font-size: 20px;
}

.subt_item{
    padding: 10px;
}
.subt_btn{
    border:1px solid lightgrey;
}
.black_screen{
    position: fixed;
    width: 100%;
    height: 100%;
    margin: 0px;
    left: 0px;
    right: 0px;
    top: 0px;
    bottom: 0px;
    background-color: rgba(0,0,0,0.5);
    text-align: center;
}
.black_screen .admin_promt_screen{
    z-index: 101 !important;
    text-align: center;
    background-color: whitesmoke;
    display: inline-block;
    padding: 20px;
    margin-top: 10%;
    box-shadow: 0px 0px 1px 0px whitesmoke;;
}
thead th{
    text-align: center;
}
.admin_promt_screen td{
    font-size: 17px;
    color: maroon;
    border: 0px !important;;
}
.admin_promt_screen input{
    padding: 10px;
}
.admin_promt_screen button{
    border: 1px solid lightgrey;
    box-shadow: 0px 0px 2px 0px lightgrey;
    
    
}
.admin_promt_screen div{
    padding: 10px;
    margin-top: 5px;
}
.admin_promt_screen input{
    border: 1px solid lightgrey;
    font-size: 17px;
}
.admin_promt_screen *{
   
  
}
.fin_item_container .finance_item{
    color: #34495e;
   
}
.finance_text{
     font-size: 25px;
}
.finance_text:hover{
      background-color: #34495e;
    color: white
}
.finance_text:hover,.finance_innder:hover{
     background-color: #34495e;
    color: white; 
    
}
.finance_innder{
    padding: 10px;
    border: 1px solid lightgrey;
    width: 300px;
   box-shadow: 0px 0px 5px 0px lightgrey;
    
}
.finance_text{
    padding: 50px;
    
}
.finance_item{
    transform:rotate(360deg);
}

.close_btn{
    background-color: white;
   display: inline-block;
    padding: 10px;
    border-radius: 30px;
    font-size:20px;
  width: 47px;
    text-align: center;
    color: crimson;
    font-weight: bold;
    box-shadow: 0px 0px 12px 0px crimson;
    margin-top:10px;
    position:absolute;
    cursor:pointer;
}
.cb_holder{
    text-align: left;
    
}
.form_container{
    padding: 10px;
    padding-top: 30px;
}
nav .dropdown-menu a:hover {
    color: black !important;
}
        </style>
    </head>
    <body>
        
        <div class="">
                    <div class="title_bar">
                       <div class="title_text_cont">
                           <div>
                               <img src="icons/header_logo.jpg" />
                           </div>
                           Velmurugan Finance
                       </div>
                    
                   </div>
            <div class="container">
                
                <div class="fin_acc_ttl">
                    Admin Login
                </div>
                <form action="" method="post" >
                <div class="form_container">
                    <div class="form_inps">
                            <div class="form_item">  
                                Username
                            </div>
                            <div class="form_item">
                                <input type="text" placeholder="Enter Username" name="user_name" />
                            </div>
                    </div>
                    <div class="form_inps">
                            <div class="form_item">
                                Password
                            </div>
                            <div class="form_item">
                                <input type="password" placeholder="Enter Password" name="pass_word" />
                            </div>
                    </div>
                    <div class="form_inps">
                            <div class="subt_item">
                                <input type="submit" class="subt_btn" value="Submit" />
                            </div>
                    </div>
                    <?php
                    
                    if($enter_login==1){
                        ?><span style="color: red">Incorrect username or Password...</span><?php
                    }
                    ?>

                    
                    
                </div>
                </form>
               
            </div>
        </div>
      
      
        <?php
        // put your code here
        ?>
    </body>
</html>

    <?php
}

?>
