<?php
            session_start();
            
            if(empty($_SESSION['user_id'])) header("location:index.php");
                       // if(empty($_SESSION['fin_id'])) header("location:fin_accounts.php");

            
            require './my.php';
            
            if(isset($_REQUEST['fin_id'])){
                            $fin_id=$_REQUEST['fin_id'];
                            $_SESSION['fin_id']=$fin_id;

            }elseif(isset ($_SESSION['fin_id'])){
                                            $fin_id=$_SESSION['fin_id'];

              
            }else{
                  header("location:fin_accounts.php");
            }
            
            $q=q("select finance_name as fn from finance_accounts where fin_id=$fin_id");
            if($q){
                if($fn!=NULL){
                    $_SESSION['fin_id']=$fin_id;
                }else{
                    header("location:index.php");
                }
            }
                
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
        <link rel="stylesheet" href="css/header.css" />
        <link rel="stylesheet" href="css/home.css" />
        <link rel="stylesheet" href="css/homepage.css" />
        <script src="js/jquery.js" ></script>
        <script src="js/bootstrap.min.js"></script>
        <title>Velmurugan Finance</title>
    </head>
    <body>
  <?php include './header.php'; ?>
        <div class="container">
            <div class="col-lg-12">
                
            </div>
            <div class="fin_name_cont">
                    <div class="acct_hdr">
                        Finance Account

                    </div>

                    <div class="accnt_ttl"><?php
                    if($q){
                        
                        echo ucfirst($fn);
                    }
                    ?></div>
            </div>
            <div class="item_container col-lg-12">
                <div class="row_hold">
                    <div class="item_holderss"><div onclick="goto_page('stl_accounts.php')" class="each_item">
                    <div class="img_holder">
                        <img src="icons/hp_s.png"
                    </div>
                    <div class="disc_holder">
                        STL Asals
                    </div>
                </div>
                
                    </div>
                    </div>
                            
                
                       <div class="item_holderss">
                           <div onclick="goto_page('hp_accounts.php')" class="each_item">
                    <div class="img_holder">
                        <img src="icons/bike.png"
                    </div>
                    <div class="disc_holder">
                        HP Asals
                    </div>
                </div>
                
                       </div>
                </div>
                <div class="item_holderss">
                    <div onclick="goto_page('interest_income.php')" class="each_item">
                    <div class="img_holder">
                        <img src="icons/interests.png"
                    </div>
                    <div class="disc_holder">
                       Interest
                    </div>
                </div>
                
                </div>
                </div>  
              
         
            
                </div>
                 <div class="row_hold">
                     <div class="item_holderss">
                      <div onclick="goto_page('tally.php')" class="each_item">
                           <div class="img_holder">
                               <img src="icons/tallly.png"
                           </div>
                           <div class="disc_holder">
                               Tally
                           </div>
                       </div>

                     </div>
                     </div>
                
                       <div class="item_holderss">
                           <div onclick="goto_page('day_book.php')" class="each_item">
                    <div class="img_holder">
                        <img src="icons/day_book.png"
                    </div>
                    <div class="disc_holder">
                        Day Book
                    </div>
                </div>
                
                       </div>
                </div>
                <div class="item_holderss">
                  
                        <div class="each_item" onclick="goto_page('add_investers.php')">
                    <div class="img_holder">
                        <img src="icons/invest.png"
                    </div>
                    <div class="disc_holder">
                        Investments
                    </div>
                </div>
                
                </div>

                </div>  
              
         
            
                </div>
                

            
            </div>
        
         
            
      
            
        </div>
    </body>
   
</html>
