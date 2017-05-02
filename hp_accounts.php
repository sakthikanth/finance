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
        <link rel="stylesheet" href="css/homepage.css" />
        <script src="js/jquery.js" ></script>
        <script src="js/bootstrap.min.js"></script>
        <title>Velmurugan Finance</title>
    </head>
    <body>
  <?php include './header.php'; ?>
        <div class="container">
            <div class="col-lg-12 logs_top_holder">
            <div class="PG_ttl col-lg-6">
                HP Asal Logs of <?php echo $fn;  ?> Finance
            </div>
            <div class="loan_details col-lg-6">
                             <div class="loan_amount_hold">
                      Sort by Customers
                    </div>
                    <div class="amnt_inp">
                        <select required name="cus_of" onchange="sort_users(this.value)">
                            <option value="all">All</option>
                           <?php
                            $sel="";
                              if( isset($_REQUEST['cust_id'])){
                                  if($_REQUEST['cust_id']==0) $sel="selected";
                                       
                                    }
                            ?>
                            <option value="gen" <?php  echo $sel;?>>General</option>
                            
                            <?php
                            
                            q("select user_name,users_id from  users");
                            
                            for($n=0;$n<count($user_name);$n++){
                                if(count($user_name)==1){
                                $use_name=$user_name;   
                                $cus_use_id=$users_id;
                                }else{
                                $use_name=$user_name[$n];    
                                $cus_use_id=$users_id[$n];
                                }
                                
                                if($_REQUEST['cust_id']==$cus_use_id){
                                    $sel="selected";
                                }else{
                                    $sel="";
                                }
                                ?><option <?php echo $sel; ?> value="<?php echo $cus_use_id; ?>"><?php echo $use_name; ?></option><?php
                            }
                            
                            ?>
                        </select>
                    </div>
                        <div class="amnt_inp" id="int_rupees_conv"></div>

                          
                        
                        
                    
                    </div>
                
            </div>
            
            <div class="PG_content_holder">
                <div class="PG_ch_inner">
                    <table class="table table-striped table-responsive">
                        <thead>

                        <th>
                            HP No.
                        </th>   
                        <th>
                            Name
                        </th>
                        <th>
                            Date
                        </th>
                        <th>
                            Asal in
                        </th>
                        <th>
                            Asal out
                        </th>
                        <th>
                            Outer Asal
                        </th>
                        <th>
                            View User
                        </th>
                        </thead>
                        <tbody>
                            <?php
                              
                            if(isset($_REQUEST['pagi'])){
                                $pagi_word="and h.log_id <=".$_REQUEST['pagi'].' ';
                                $pagi_recv=$_REQUEST['pagi'];
                            }else
                            {
                                $pagi_word="";
                                 $pagi_recv=0;

                            }
                                if(isset($_REQUEST['cust_id'])){
                
                $cust_wrd="and c.users_id=".$_REQUEST['cust_id'];
            }else{
                $cust_wrd="";
            }
            
                            
                            $r=q("select distinct h.asal_in as asal_in,h.asal_out as asal_out,h.outer_asal_amt as outer_asal_amt,h.date as date,h.hp_id as hp_id,h.log_id as log_id from hp_asal_logs as h inner join customers_hp as c where c.fin_id=$fin_id $pagi_word $cust_wrd order by h.log_id desc limit 20");
                            
                       
                            for($n=0;$n<count($asal_in);$n++){
                                if(count($asal_in)==1){
                                    $p_asal_in=$asal_in;
                                    $p_asal_out=$asal_out;
                                    $t_outer_asal=$outer_asal_amt;
                                    $e_date=$date;
                                    $p_stl_id=$hp_id;
                                    echo $hp_id;
                                }else{
                                        $p_asal_in=$asal_in[$n];
                                    $p_asal_out=$asal_out[$n];
                                    $t_outer_asal=$outer_asal_amt[$n];
                                    $e_date=$date[$n];
                                    $p_stl_id=$hp_id[$n];
                                    
                                }
                              
                                q("select name as p_name from customers_hp where fin_id=$fin_id and hp_id=$p_stl_id");
                                
                                
                                ?>
                       
                            <tr>
                                
                                <td>
                                    <?php echo $p_stl_id; ?>
                                </td>
                                <td>
                                    <?php echo $p_name; ?>
                                </td>
                                <td>
                                    <?php echo $e_date; ?>
                                </td>
                                <td>
                                     <?php
                                    if($p_asal_in!=0){
                                   ?>Rs. <?php    echo convert_rup_format($p_asal_in); ?> /-
                                            
                                       <?php
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if($p_asal_out!=0){
                                   ?>Rs. <?php    echo convert_rup_format($p_asal_out); ?> /-
                                            
                                       <?php
                                    }
                                    ?>
                                </td>
                                <td>
                                    Rs. <?php echo convert_rup_format($t_outer_asal); ?> /-
                                </td>
                                <td>
                                    <a href="view_hp_user.php?hp_id=<?php echo $p_stl_id; ?>"> <button>
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
                          
                         
                         $r=q("select distinct h.asal_in as asal_in,h.log_id as log_id from hp_asal_logs as h inner join customers_hp as c where c.fin_id=$fin_id $cust_wrd  order by h.log_id desc");
                            
                            $pagi_cnt=0;
                            $pagi_num=0;
                            $blocked=0;
                            
                            $tot_page=0;
                            $put=0;
                            
                                 $show=0;
                            $t_cnt=count($asal_in);
                            while($t_cnt>20){
                                $t_cnt-=20;
                                $tot_page+=1;
                            }
                                                            $tot_page+=1;

                           
                            for($n=0;$n<count($asal_in);$n++){
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
                                         ?> <li <?php echo $act; ?> ><a id="page_<?php echo $pg_cnt; ?>" href="hp_accounts.php?pagi=<?php echo $log_id[$n]; ?>"><?php echo $pagi_num; ?></a></li><?php
                                       
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
                 function sort_users(its_id){
            if(its_id==="all"){
                            urls='hp_accounts.php';
 
            }else{
                if(its_id==="gen"){
                    urls='hp_accounts.php?cust_id=0';
                }else{
                    
                      urls='hp_accounts.php?cust_id='+its_id;
                }
                           

            }
                window.location.href=urls;
                
        }
        </script>
    </body>
</html>
