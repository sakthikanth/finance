<?php
            session_start();
            
            if(empty($_SESSION['user_id'])) header("location:index.php");
                        if(empty($_SESSION['fin_id'])) header("location:fin_accounts.php");

            
            require './my.php';
            
            $fin_id=$_SESSION['fin_id'];
            
            $q=q("select finance_name as fn from finance_accounts where fin_id=$fin_id");
            if($q){
                if($fn!=NULL){
                    $_SESSION['fin_id']=$fin_id;
                }else{
                    header("location:index.php");
                }
            }
                  function convert_rup_format($rup_val){
        
                                       $amt_len=$rup_val+"";
            
                $b=0;
                $amt_conv="";
                $m=0;
                        //echo $amt_len;
                for($n=strlen($amt_len)-1;$n>=0;$n--){
                    $b++;
                    $amt_conv.=substr($amt_len,$n,1);
                  
                  
                    if($b>=3){
                       $amt_conv.=",";
                       $b=0;
                       $m=1;
                       
                    }
                    if($b>=2 && $m==1){
                        $amt_conv.=",";
                        $b=0;
                   
                    }
                   
                }
              $conv_amt= strrev($amt_conv);
              
              if(is_numeric(strpos($conv_amt, ",")) && strpos($conv_amt, ",")==0){
                                $conv_amt= substr($conv_amt, 1, strlen($conv_amt));

              }
                       

              return $conv_amt;

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
        <link rel="stylesheet" href="css/stl_accounts.css" />
        <script src="js/jquery.js" ></script>
        <link rel="stylesheet" href="css/homepage.css" />
        <script src="js/bootstrap.min.js"></script>
        <title>Velmurugan Finance</title>
    </head>
    <body>
  <?php include './header.php'; ?>
        <div class="container">
            <?php 
                
                q("select hp_id from customers_hp where fin_id=$fin_id");
                $tot_user=  count($hp_id);
                ?>
            <div class="PG_ttl col-lg-12">
                
                
                HP Accounts of <?php echo $fn;  ?> Finance
            </div>
            <div class="ttl_info col-lg-12">
                <?php
                if($tot_user==0){
                    ?><font color="crimson">No Customers</font><?php
                }else{
                    ?> Total <?php echo $tot_user ?> Customers<?php
                }
                ?>
               
            </div>
            <div class="PG_content_holder">
                <div class="PG_ch_inner">
                    <table class="table table-striped table-responsive">
                        <thead>
                                
                        <th>
                            S.No
                        </th> 
                        <th>
                            HP No
                        </th>
                        <th>
                            Name
                        </th>
                        <th>
                            Date
                        </th>
                        <th>
                            Loan Amount
                        </th>
                        <th>
                            View User
                        </th>
                        </thead>
                        <tbody>
                            <?php
                              
                            if(isset($_REQUEST['pagi'])){
                                $pagi_word=" and hp_id <=".$_REQUEST['pagi'].' ';
                                $pagi_recv=$_REQUEST['pagi'];
                            }else
                            {
                                $pagi_word="";
                                 $pagi_recv=0;

                            }
                            
                            q("select name as p_name,hp_id as sid,loan_amount as la,reg_date from customers_hp where fin_id=$fin_id $pagi_word  order by hp_id desc limit 20");
                            
                            for($n=0;$n<count($p_name);$n++){
                                if(count($p_name)==1){
                                    $loan_amount=$la;
                                    $stl_id=$sid;
                                    $e_date=$reg_date;
                                    $name=$p_name;
                                }else{
                                         $loan_amount=$la[$n];
                                    $stl_id=$sid[$n];
                                    $e_date=$reg_date[$n];
                                     $name=$p_name[$n];
                                }
                                
                                
                                
                                ?>
                            <tr>
                                <td>
                                    <?php echo $n+1; ?>
                                </td>
                                <td>
                                    <?php echo $stl_id; ?>
                                </td>
                                <td>
                                    <?php echo $name; ?>
                                </td>
                                <td>
                                    <?php echo $e_date; ?>
                                </td>
                                <td>
                                     <?php
                                    if($loan_amount!=0){
                                   ?>Rs. <?php    echo convert_rup_format($loan_amount); ?> /-
                                            
                                       <?php
                                    }
                                    ?>
                                </td>
                                <td>
                                    <a href="view_hp_user.php?hp_id=<?php echo $stl_id; ?>">
                                        <button>
                                        View
                                    </button>
                                    </a>
                                </td>
                                
                            </tr>
                                    <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    <div class="col-lg-12 pagi_hold">
                        <ul class="pagination pagination-lg">
                            <li><a href="#" onclick="change_prev()">&laquo;</a></li>
                            <?php
                            
                          
                            $pg_cnt=0;
                            
        q("select name as p_name,hp_id as log_id,loan_amount as la,reg_date from customers_hp where fin_id=$fin_id  order by hp_id desc");

                            $pagi_cnt=0;
                            $pagi_num=0;
                            $blocked=0;
                            
                            $tot_page=0;
                            $put=0;
                            
                                 $show=0;
                            $t_cnt=count($p_name);
                            while($t_cnt>20){
                                $t_cnt-=20;
                                $tot_page+=1;
                            }
                                                            $tot_page+=1;

                           
                            for($n=0;$n<count($p_name);$n++){
                                $pagi_cnt++;
                                if($pagi_cnt>=20){
                                    $pagi_cnt=0;
                                }
                                if($pagi_cnt==1){
                                
                                    $pagi_num++;
                                  
                                    if(!isset($_REQUEST['pagi']) && $pagi_num==1){
                                        $pagi_recv=$log_id[$n];
                                    }
                                   
                                    
                                    if($pagi_recv==$log_id[$n]){
                                        $act="class='active'";
                                        $show=1;
                                      
                                      $put=$pagi_num;
                                    }else
                                    {
                                        $act="";
                                   
                                    }
                                    
                                   if($blocked==0  ) {
                                         $pg_cnt++;
                                         ?> <li <?php echo $act; ?> ><a id="page_<?php echo $pg_cnt; ?>" href="hp_customers.php?pagi=<?php echo $log_id[$n]; ?>"><?php echo $pagi_num; ?></a></li><?php
                                       
                                   }
                                

                                   }else{
                                    
                                }
                            }
                            
                            ?>
           
                            <li><a href="#" onclick="change_next()">&raquo;</a></li>
                        </ul><br>
                    </div>
                    
                </div>
                
            </div>
            
        </div>
        <script>
        
        cliked=<?php echo $put;  ?>;
        max=<?php echo $pg_cnt; ?>;
        
        function change_next(){
            cliked+=1;
            if(cliked>=max){
               cliked=max; 
            }
            document.getElementById('page_'+cliked).click();
           
        }
        function change_prev(){
            cliked-=1;
            if(cliked<=0){
                cliked=1;
            }
                      document.getElementById('page_'+cliked).click();

            
        }
        
        </script>
    </body>
</html>
