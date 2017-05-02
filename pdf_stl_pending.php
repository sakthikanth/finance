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
 <?php
 $cust_of_name="All";
       q("select user_name,users_id from  users");
                            
                            for($n=0;$n<count($user_name);$n++){
                                if(count($user_name)==1){
                                $use_name=$user_name;   
                                $cus_use_id=$users_id;
                                }else{
                                $use_name=$user_name[$n];    
                                $cus_use_id=$users_id[$n];
                                }
                                if(isset($_REQUEST['cust_id'])){
                                      if($_REQUEST['cust_id']==$cus_use_id ){
                                    $sel="selected";
                                    $cust_of_name=$use_name;
                                    
                                }
                                
                                }else{
                                 $cust_of_name="All";

                                }
                              
                            }
                           
      ?>
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
                
            
               $d_t = new DateTime('now', new DateTimezone('Asia/Kolkata'));
                
                $hr=$d_t->format('g');
                $min=$d_t->format('i');
                $noon=$d_t->format('A');
                   
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
                                $cust_of_name="General";
                            }else{
                                q("select user_name from users where users_id=".$_REQUEST['cust_id']."");
                                echo $user_name;
                                                                $cust_of_name=$user_name;

                            }
                        }else{
                            echo "All";
                        }
                        
                        ?>
                    </td> 
                </tr>

            </table>
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
                            pending from
                        </th>
                        </thead>
                        <tbody>
                          
                     
                        
            <?php
            
              $p_arr=array();
                             $year= $_SESSION['cur_year'];
                $month= $_SESSION['cur_month'];
                $day=$_SESSION['cur_day'];
                                       $cur_date="$year-$month-$day";

                
            
               $d_t = new DateTime('now', new DateTimezone('Asia/Kolkata'));
                
                $hr=$d_t->format('g');
                $min=$d_t->format('i');
                $noon=$d_t->format('A');
                
                $date="$day-$month-$year $hr:$min $noon";
                              
                            if(isset($_REQUEST['pagi'])){
                                $pagi_word=" and log_id >= ".$_REQUEST['pagi'].' ';
                                $pagi_recv=$_REQUEST['pagi'];
                            }else
                            {
                                $pagi_word="";
                                 $pagi_recv=0;

                            }
            
                            if(isset($_REQUEST['cust_id'])){
                
                $cust_wrd="and users_id=".$_REQUEST['cust_id'];
            }else{
                $cust_wrd="";
            }
            
            $pg_cnt=0;
            $put=1;
              $tot_pend_array=array();
                       
              include './calc_prev_date.php';
              $tar_int_date=  calc_prev_date(30, $cur_date);
            
              $tot_cnt=0;
              $last_id_arr=array();
              q("select fin_id as fids,stl_id as sids,name as p_name,mob_no as mobi_no from customers_stl where fin_id=$fin_id $cust_wrd $pagi_word and person_status=1 order by stl_id asc ");
                if(count($fids)>0){
              for($m=0;$m<count($fids);$m++){
                    if(count($fids)==1){
                    $finc_id=$fids;
                    $stl_ids=$sids;
                    $p_names=$p_name;
                    $mob_nos=$mobi_no;
                        
                    }else{
                         $finc_id=$fids[$m];
                    $stl_ids=$sids[$m];
                    $p_names=$p_name[$m];
                    $mob_nos=$mobi_no[$m];
                   
                    }
                    q("select current_interest as cit,next_int_date as nid,ext_amount from loan_leagure_stl where next_int_date < '$tar_int_date' and fin_id=$fin_id and stl_id=$stl_ids ");
                   if(count($cit)>0){
                       $tot_cnt++;
                       if($tot_cnt>=21){
                           break;
                       }
                                          $dt1=  date_create($nid);
                                $dt2=  date_create($cur_date);
                                
                                $diff=  date_diff($dt2,$dt1);
                                $diff_val=$diff->format("%a");
                                $cur_int=$cit;
                                $h_ref="view_stl_user.php?stl_id=".$stl_ids."&fin_id=".$finc_id;
                                
                                $pend_amt=0;
                                $pending_mnth=0;
                                $tot_pend_days=$diff_val;
                                while($tot_pend_days>=30){
                                    $tot_pend_days-=30;
                                    $pending_mnth+=1;
                                }
                                if($tot_pend_days<30 && $tot_pend_days>0){
                                    $pending_mnth+=1;
                                }
                              
                                  $pre_day= substr($nid, strpos($nid, "-")+4,  2);
                       $pre_mnth=substr($nid, strpos($nid, "-")+1,  2);
                    $pre_tyear=  substr($nid, 0,4);
                       q("select pend_month ,tot_int_amt as paid_cur_int from loan_leagure_stl  where fin_id=$finc_id and stl_id=$stl_ids");

                if($pending_mnth>=$pend_month){
                    
                    
                    $mean_df=$pending_mnth-$pend_month;
                    
                    for($n=0;$n<$mean_df;$n++){
                        
                        q("select pend_date as pn from stl_interest_sts where fin_id=$finc_id and stl_id=$stl_ids order by log_id desc limit 1");
              
                        if($pn==NULL){
                            $pn_day=$pre_day;
                            $pn_mnth=$pre_mnth;
                            $pn_tyear=$pre_tyear;
                            
                        }else{
                        $pn_day=  substr($pn, strpos($pn, "-")+4,  2);
                        $pn_mnth=substr($pn, strpos($pn, "-")+1,  2);
                        $pn_tyear=  substr($pn, 0,4);

                        }
                        
                        $cnt_date_int=30;
                        
                        $pend_date=  calc_next_date($cnt_date_int, $pn_day, $pn_mnth, $pn_tyear);
                
                        q("INSERT INTO `stl_interest_sts` (`log_id`, `stl_id`, `fin_id`, `int_amount`, `int_rate_amt`, `int_months`,`pend_date`)"
                                                             . " VALUES (NULL, '$stl_ids', '$finc_id', '".($cur_int)."', '$cur_int', '1','$pend_date');");
                        
                    }
                    
                   
                    q("update loan_leagure_stl set pend_month=$pending_mnth,paid_status=2 where fin_id=$finc_id and stl_id=$stl_ids ");

                }elseif($pend_month>$pending_mnth && $pending_mnth>0){
                    $difs=$pend_month-$pending_mnth;
                   q("update loan_leagure_stl set pend_month=$pending_mnth where fin_id=$finc_id and stl_id=$stl_ids");

                    q("delete from stl_interest_sts where fin_id=$finc_id and stl_id=$stl_ids order by log_id desc limit $difs");
                }elseif($int_pen_cnt==0){
                                       q("delete from stl_interest_sts where fin_id=$finc_id and stl_id=$stl_ids");
 
                }   
                
                
                  
    q("select int_amount as p_int from stl_interest_sts where fin_id=$finc_id and stl_id=$stl_ids");
$tot_int_upto=0;
    for($n=0;$n<count($p_int);$n++){
        if(count($p_int)==1){
            $tot_int_upto+=$p_int;
        }else{
            $tot_int_upto+=$p_int[$n];
        }
        $tot_int_upto+=$ext_amount;
    }
    
    ?>
                <tr>
                    <td>
                        <?php echo $tot_cnt; ?>
                    </td>
                    <td>
                        <?php echo $stl_ids ?>
                    </td>
                    <td>
                        <?php echo $fn; ?>
                    </td>
                    <td>
                        <?php echo $p_names ?>
                    </td>
                    <td>
                        <?php echo $mob_nos; ?>
                    </td>
                    <td>
                        <?php echo $pending_mnth ?>
                    </td>
                    <td>
                        Rs. <?php echo convert_rup_format($tot_int_upto); ?> /-
                    </td>
                     <td>
                        
                        
                        <?php
                        $pre_day=$pre_day-1+1;
                        $pre_mnth=$pre_mnth-1+1;
                        $pre_tyear=$pre_tyear-1+1;
                        
                        echo "$pre_day-$pre_mnth-$pre_tyear";  ?>
                    </td>
                   
                </tr>
        <?php 
                   }
         
               
                            }
                         
              

                }            

               
                      if($tot_cnt==0){
                    ?><tr>
                        <td colspan="9" style="text-align: center">
                            <font color='green'>No Pending Customers of <?php echo ucfirst($cust_of_name); ?></font>
                        </td>
                    </tr>
                        <?php
                } 
             
                            
                          
                     
                            
                            
            ?>
            
               </tbody>
                    </table>
            
        </div>
    </body>
</html>
