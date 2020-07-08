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
        <link rel="stylesheet" href="css/pdf_file.css" />
        <script src="js/jquery.js" ></script>
        <script src="js/bootstrap.min.js"></script>
        <title>Velmurugan Finance</title>
    </head>
    <body>
      
    </script>
  <?php // include './header.php'; ?>
        <div class="container ">
            <h2 style="text-align: left">Velmurugan Finance</h2>
              <h3 style="text-align: center">
                STL Pendings of <?php echo $fn;  ?> Finance
            </h3>
            
            <table class="table">
                <tr>
                    <th>
                        Finance
                    </th>
                    <td>
                        <?php echo ucfirst($fn); ?>
                    </td>
                </tr>
                <tr>
                    <th>
                        Date
                    </th>
                    <td>
                        <?php 
                             
                   $year= $_SESSION['cur_year'];
                $month= $_SESSION['cur_month'];
                $day=$_SESSION['cur_day'];
                
                $hr=date('g');
                $min=date('i');
                $noon=date('A');
                
                $date=$_SESSION['cur_date']." $hr:$min $noon";
                echo $date;       
                ?>
                    </td>
                <tr>
                                       <th>
                        Customer
                    </th>
                    <td>
                        <?php
                        if(isset($_REQUEST['cust_id'])){
                            
                            if($_REQUEST['cust_id']=="0" || $_REQUEST['cust_id']==0 ){
                                echo "General";
                            }else{
                                q("select user_namw from users where users_id=".$_REQUEST['cust_id']."");
                                echo $user_name;
                            }
                        }else{
                            echo "All";
                        }
                        
                        ?>
                    </td> 
                </tr>

                </tr>
            </table>
            <?php
            
              $p_arr=array();
                              $year= $_SESSION['cur_year'];
                $month= $_SESSION['cur_month'];
                $day=$_SESSION['cur_day'];
                
                $hr=date('g');
                $min=date('i');
                $noon=date('A');
                
                $date="$day-$month-$year $hr:$min $noon";
                              
                            if(isset($_REQUEST['pagi'])){
                                $pagi_word=" sl.log_id <=".$_REQUEST['pagi'].' ';
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
            
            $pg_cnt=0;
            $put=1;
              $tot_pend_array=array();
                            //next int date = paid int date
                            $r=q("select distinct sl.fin_id as fid,sl.next_int_date as nid,sl.log_id as log_id,sl.stl_id as sid,sl.pend_month as pend_month from loan_leagure_stl as sl inner join customers_stl as c where c.fin_id=$fin_id and sl.fin_id=$fin_id $pagi_word $cust_wrd   order by nid  limit 20");
                          
                            //      q("SELECT CURDATE() as cur_date");
                       $cur_date="$year-$month-$day";
              
                            for($n=0;$n<count($nid);$n++){
                                if(count($nid)==1){
                                   
                                    $paid_int_date=$nid;
                                    $stl_ids=$sid;
                                    $pend_months=$pend_month;
                                    
                                    $fin_id=$fid;
                                    
                                    
                                }else{
                                   $paid_int_date=$nid[$n];
                                   $stl_ids=$sid[$n];
                                   $pend_months=$pend_month[$n];
                                   $fin_id=$fid[$n];
                                   
                                   
                                    
                                }
                              
                                if($n>=20){
                                    break;
                                }
                                $dt1=  date_create($paid_int_date);
                                $dt2=  date_create($cur_date);
                                
                                $diff=  date_diff($dt2,$dt1);
                                $diff_val=$diff->format("%a");
                                   $pending_mnth=0;
                                $tot_pend_days=$diff_val;
                                
                                while($tot_pend_days>30){
                                    $tot_pend_days-=30;
                                    $pending_mnth+=1;
                                }
                                if($tot_pend_days<30 && $tot_pend_days>0){
                                    $pending_mnth+=1;
                                }
                                
                                $tot_pend_amt=0;
                                
                                
                                $h_ref="view_stl_user.php?stl_id=".$stl_ids."&fin_id=".$fin_id;
                                
                                                                    q("select name as p_name,mob_no,person_status from customers_stl where fin_id=$fin_id and stl_id=$stl_ids");
                                                                    if($person_status==2 || $person_status=="2"){
                                                                        $pending_mnth=0;
                                                                    }
                                                                    
                                                                    
                                                                    

                                if($pending_mnth>1){
                                    q("select int_amount as ita from stl_interest_sts where fin_id=$fin_id and stl_id=$stl_ids");
                                   for($mp=0;$mp<count($ita);$mp++){
                                       if(count($ita)==1){
                                           $tot_pend_amt+=$ita;
                                       }else{
                                           $tot_pend_amt+=$ita[$mp];
                                       }
                                   }
                                  q("select finance_name as fns from finance_accounts where fin_id=$fin_id");

      q("select current_interest as ci,ext_amount from loan_leagure_stl where fin_id=$fin_id and stl_id=$stl_ids");

                                     $p_arr[]=$pending_mnth;
                                     
                                    $tot_pend_array[]="
                                <td>
                                    ".$stl_ids."
                                </td>
                                <td>
                                    ".$fns."
                                </td>
                                <td>
                                   ".$p_name."
                                </td>
                                <td>
                                  ".$mob_no."
                                </td>
                                <td>
                                    ".$pending_mnth." 
                                      
                                </td>
                                <td>
                                    Rs. ".convert_rup_format($tot_pend_amt)." /-
                                </td>
                                <td>
                                Rs. ".  convert_rup_format($ci+$ext_amount)."
                                </td>
                                <td>
                                    Pending From  ".$paid_int_date." 
                                </td>
                                
                            ";
                                    ?>
                               
                                        <?php
                                }
                                
                                
                            }
                            
                            if(count($p_arr)==0){
               ?><h2  style="text-align: center;color: green">No Pending Lists</h2><?php
                             
                            }else{
                                ?><div class="PG_content_holder">
                <div class="PG_ch_inner">
                    <table class="table table-striped table-responsive">
                        <thead>

                        <th>
                            S.no
                        </th> 
                        <th>
                            STL No
                        </th>
                        <th>
                            Finance
                        </th>
                        <th>
                            Name
                        </th>
                        <th>
                            Mob No
                        </th>
                        <th>
                            Pending months
                        </th>
                        <th>
                            Interest Amount
                        </th>
                        <th>
                            Interest / month
                        </th>
                        <th>
                            pending from
                        </th>
                        
                        </thead>
                        <tbody>
                            <?php
                           $old=$p_arr;
                            if(count($p_arr)>0){
                              
                                 $c=0;
                            for($n=0;$n<count($tot_pend_array);$n++){
                                
                                $c++;
                                
                               
                                
                                ?><tr>
                                    <td>
                                        <?php echo $c; ?>
                                    </td>
                                    <?php  echo $tot_pend_array[$n]; ?>
                                    </tr>
                                    <?php
                               
                               
                            } 
                            }
                          
                            ?>
                        </tbody>
                    </table>
                    
                    
                </div>
                
            </div>
                                    <?php
                            }
                            
                            
            ?>
            
            
        </div>
    </body>
</html>
