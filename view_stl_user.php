<?php
            session_start();
            
         // if(empty($_SESSION['fin_id'])) header ("location:fin_accounts.php");
                require './my.php';
            if(isset($_REQUEST['fin_id'])){
                
                $fin_id=$_REQUEST['fin_id'];
                $tr=q("select fin_id as cfin_id from finance_accounts where fin_id=$fin_id");
                if($tr){
                    if($cfin_id!=NULL && count($cfin_id)==1){
                        $_SESSION['fin_id']=$cfin_id;
                        $fin_id=$_SESSION['fin_id'];
                    }else{
                        
            header("location:home.php");
                    }
                }
                
            }elseif(isset($_SESSION['fin_id'])){
                $fin_id=$_SESSION['fin_id'];
            }else{
                header("location:home.php");
            }
            
            
            $q=q("select finance_name as fn from finance_accounts where fin_id=$fin_id");
           
            ?>

<?php
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
              $stl_id=$_GET['stl_id'];
                    
                    $q2=q("select stl_id, fin_id, name, age, occupation, father_name,j_occup, perm_add, mob_no, asset_dets, j_person_name, j_age, j_fname, j_address, j_mob_no, j_assets, interest_rate, person_status, loan_date, loan_amount, init_interesr, reg_date,nick_name FROM customers_stl WHERE fin_id=$fin_id and stl_id=$stl_id");
                  
                    if(count($stl_id)==0 || !$q2){
                        header("location:home.php");
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
        <link rel="stylesheet" href="css/homepage.css" />
            <link rel="stylesheet" href="css/view_stl_user.css" />
            <link rel="stylesheet" href="css/create_account.css" />
        <script src="js/jquery.js" ></script>
        <script src="js/bootstrap.min.js"></script>
        <title>Velmurugan Finance</title>
    </head>
    <body>
        <?php
                    include './header.php';
                    
                      $q24s=q("select remaining_asal as psa,next_int_date as nxd,paid_status,current_interest,pending_sts,ext_amount from loan_leagure_stl where fin_id=$fin_id and stl_id=$stl_id");

                   
                    
                     $interest_amount=$current_interest;;
                     
                     function calc_next_date($cnt_date,$day,$month,$year){
                         
                         $next_date=$cnt_date;
                       
                         
               
               
               switch ($month){
                   case 1:
                       $month_days=31;
                       break;
                   case 2:
                       if(($year%4)==0){
                        $month_days=29;   
                       }else{
                         $month_days=28;
  
                       }
                       break;
                   case 3:
                       $month_days=31;
                       break;
                   case 4:
                       $month_days=30;
                       break;
                   case 5:
                       $month_days=31;
                       break;
                   case 6:
                       $month_days=30;
                       break;
                   case 7:
                       $month_days=31;
                       break;
                   case 8:
                       $month_days=31;
                       break;
                   case 9:
                       $month_days=30;
                       break;
                   case 10:
                       $month_days=31;
                       break;
                   case 11:
                       $month_days=30;
                       break;
                   case 12:
                       $month_days=31;
                       break;
                   
                   
                       
               }
               
               
               $my_month=$month;
               $tar_year=$year;
               
               $my_day=$month_days-$day;
               while($my_day<=$next_date){
                   $my_month+=1;
                   
                    switch ($my_month){
                   case 1:
                       $month_days=31;
                       break;
                   case 2:
                       if(($year%4)==0){
                        $month_days=29;   
                       }else{
                         $month_days=28;
  
                       }
                       break;
                   case 3:
                       $month_days=31;
                       break;
                   case 4:
                       $month_days=30;
                       break;
                   case 5:
                       $month_days=31;
                       break;
                   case 6:
                       $month_days=30;
                       break;
                   case 7:
                       $month_days=31;
                       break;
                   case 8:
                       $month_days=31;
                       break;
                   case 9:
                       $month_days=30;
                       break;
                   case 10:
                       $month_days=31;
                       break;
                   case 11:
                       $month_days=30;
                       break;
                   case 12:
                       $month_days=31;
                       break;
                   
                   
                       
               }
               $my_day+=$month_days;
               if($my_month>12){
                   $tar_year+=1;
                    $my_month=1;
               }
               
               
               }
               $tar_mnth=$my_month;
               if($my_day>$next_date){
                   $diff=$my_day-$next_date;
                   $my_day=$month_days-$diff;
                   
                   
               }
               if($my_day==0){
                   $my_day=1;
               }
               
               
               
               
               if($tar_mnth<=9){
                   $tar_mnth="0".$tar_mnth;
               }
               if($my_day<=9){
                   $my_day="0".$my_day;
               }
                $next_int_date="$tar_year-$tar_mnth-$my_day";
               return $next_int_date;
                     }
                     
        ?>
        
        <div class="container col-lg-12">
            <div class="account_type_hdr">
                <h2 style="display: inline-block"> STL Account No : </h2> <h2 style="color: maroon;display: inline-block"><?php echo $stl_id ?></h2>
                <div class="main_info">
                    <div class="prof_info col-lg-6">
                        
                         <div>
                             <font>Name</font> : <?php echo ucfirst($name); ?>
                        </div>
                          <div>
                        <font>Mobile No</font> : <?php echo ucfirst($mob_no); ?>
                        </div>
                        <div>
                        <font>Nick name</font> : <?php echo ucfirst($nick_name); ?>
                        </div>
                        <div>
                            <?php
                            q("select users_id as his_cust_id from customers_stl where fin_id=$fin_id and stl_id=$stl_id");
                            q("select user_name as uname from users where users_id=$his_cust_id");
                            if($uname==NULL){
                                $custmr_name="General";
                            }else{
                                 $custmr_name=  ucfirst($uname);
                            }
                            ?>
                            <font>Customer Of</font> : <?php echo $custmr_name; ?>
                        </div>
                        <a href="stl_user_dtl.php?stl_id=<?php echo $stl_id; ?>" style="text-decoration: none"><button>
                        <font>View Profile</font>
                            </button></a>
                    </div>
                    <?php
                      $cnt=0;
                           $year= $_SESSION['cur_year'];
                $month= $_SESSION['cur_month'];
                $day=$_SESSION['cur_day'];
             
               $d_t = new DateTime('now', new DateTimezone('Asia/Kolkata'));
                
                $hr=$d_t->format('g');
                $min=$d_t->format('i');
                $noon=$d_t->format('A');
                
                 
                $pre_day=  substr($nxd, strpos($nxd, "-")+4,  2);
                    $pre_mnth=substr($nxd, strpos($nxd, "-")+1,  2);
                    $pre_tyear=  substr($nxd, 0,4);
                    
                      $nad_day= substr($nxd, strpos($nxd, "-")+4,  2);
                       $nad_mnth=substr($nxd, strpos($nxd, "-")+1,  2);
                    $nad_tyear=  substr($nxd, 0,4);
                    
                    $next_asd="$nad_tyear$nad_mnth$nad_day";
                    $next_asd=$next_asd-1+1;
                    $cur_dates="$year$month$day";
                    
                    $asl_to_paid=0;
                    
                    $dt1=  date_create($nxd);
                    $dt2=  date_create("$year-$month-$day");
                    $diff= date_diff($dt2, $dt1);
                    $diff_val=$diff->format("%a");
                    $cnt_asal=0;
                   

                    $asal_pend_motth=0;
          $int_amount=0;
          $int_pen_cnt=0;
            $tot_int_upto=0;
                  $tot_mnth_pend=0;
          
                $paid_int_date="$nad_tyear$nad_mnth$nad_day";
                $paid_int_date=$paid_int_date-1+1;
                $cur_dates=$cur_dates-1+1;
                
                
                
                
                if($psa==0 && $paid_status==1){
                    
                }else{
                
                
                if($cur_dates<$paid_int_date){
                   
                }else{
                    
                  
                    while($diff_val>=30){
                       
                     $int_pen_cnt+=1;
                           
                            $int_amount+=$current_interest+$ext_amount;
                       
                        $diff_val-=30;
                        
                        
                    }
                  
                    if($diff_val<30 && $diff_val>0){
                        $int_pen_cnt+=1;
                           
                            $int_amount+=$current_interest+$ext_amount;
                     
                    }
                  
                    if($cur_dates==$paid_int_date){
                        $int_pen_cnt+=1;
                           
                            $int_amount+=$current_interest+$ext_amount;
                     
                    }
             
                }
              
                q("select pend_month ,tot_int_amt as paid_cur_int from loan_leagure_stl  where fin_id=$fin_id and stl_id=$stl_id");

                if($int_pen_cnt>$pend_month){
                    
                    $paid_cur_int=$int_amount+$paid_cur_int;
                    
                    $mean_df=$int_pen_cnt-$pend_month;
                    
                    for($n=0;$n<$mean_df;$n++){
                        
                        q("select pend_date as pn from stl_interest_sts where fin_id=$fin_id and stl_id=$stl_id order by log_id desc limit 1");
              
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
                                                             . " VALUES (NULL, '$stl_id', '$fin_id', '".($current_interest)."', '$current_interest', '1','$pend_date');");
                        
                    }
                    
                   
                    q("update loan_leagure_stl set pend_month=$int_pen_cnt,paid_status=2 where fin_id=$fin_id and stl_id=$stl_id ");

                }  elseif($pend_month>$int_pen_cnt ){
                    $difs=$pend_month-$int_pen_cnt;
                   
                    q("update loan_leagure_stl set pend_month=$int_pen_cnt where fin_id=$fin_id and stl_id=$stl_id");
                    q("delete from stl_interest_sts where fin_id=$fin_id and stl_id=$stl_id order by log_id desc limit $difs");
                }elseif($int_pen_cnt==0){
                                       q("delete from stl_interest_sts where fin_id=$fin_id and stl_id=$stl_id");
 
                } 
                
            
                  
    q("select int_amount as p_int from stl_interest_sts where fin_id=$fin_id and stl_id=$stl_id");

    for($n=0;$n<count($p_int);$n++){
        if(count($p_int)==1){
            $tot_int_upto+=$p_int;
        }else{
            $tot_int_upto+=$p_int[$n];
        }
        $tot_int_upto+=$ext_amount;
    }
                }
                
              
    
                    ?>
                  <div class="account_info col-lg-6">
                        <div>
                            <font>Total Interest upto Today</font> : Rs. <?php echo convert_rup_format($tot_int_upto); ?> /-<br><br>
                        </div>
                        <div>
                            
                      
                        <font>Status </font> : <?php
                       
                        $nad_date="$nad_day-$nad_mnth-$nad_tyear";
                        if($int_pen_cnt==1){
                            $next_dt=  calc_next_date(30, $nad_day, $nad_mnth, $nad_tyear);
                                
                        $nxd_day= substr($nxd, strpos($next_dt, "-")+4,  2);
                       $nxd_mnth=substr($next_dt, strpos($next_dt, "-")+1,  2);
                    $nxd_tyear=  substr($next_dt, 0,4);
                           
                            ?><span style="color:crimson">Not Paid upto </span><?php echo "$nxd_day-$nxd_mnth-$nxd_tyear";
                        }
                        if($int_pen_cnt>1){
                            ?><span style="color:crimson">Pending from </span><?php echo $nad_date;
                        }
                        if($int_pen_cnt==0){
                            if($psa==0){
                             ?>   <span style="color:crimson">Closed at </span><?php echo $nad_date;
                            }else{
                                 ?><span style="color:green">Paid upto </span><?php echo $nad_date;
                            }
                            
                        }
                        ?>
                              </div>
                    </div>
                    
                    </div>
                    
                </div>
            </div>
            <?php
            q("select person_status from customers_stl where fin_id=$fin_id and stl_id=$stl_id");
            if($person_status==2){
                       //  q("update customers_stl set person_status=2 where stl_id=$stl_id and fin_id=$fin_id");

                ?><h2 style="color: crimson;text-align: center;padding: 20px;">Account Closed</h2><?php
            }
            
            ?>
                 <?php
                            if($psa==0 || $psa=="0"){
                                $asal_sts="Asal Paid";
                                $a_click="";
                            }else{
                                $asal_sts= "Pay Asal ( Remaining Rs.".convert_rup_format($psa)." )";
                                $a_click='onclick="$(\'#payment_asal_cont\').slideToggle();$(\'#asal_amount\').focus();"';
                            }
                            ?>
                      
            <div class="payment_container col-lg-12">
                
                <div class="asal_container col-lg-6">
                        <div class="payment_sts" id="asal_pay_text" <?php echo $a_click; ?> >
                     
                         <?php echo $asal_sts; ?>
                    </div>
                    <div class="payment_items_cont"  id="payment_asal_cont" style="display: none">
                           
                        <div class="item_val_cont" >
                        <div class="item_inp_cont">
                              <span class="inp_disc">Asal</span>

                              <input type="number" min="0" placeholder="Enter Amount" max="<?php echo convert_rup_format($psa); ?>" oninput="put_asal_val()" id="asal_amount" />
                            <span><span id="asal_amt_vals"></span></span>
                            
                        </div>
                        <div class="item_submit_cont">
                            <button onclick="pay_asal()" >Submit</button>
                            
                        </div>
                    </div>
                        
                    
                    
                </div>
                </div>
                

                
                   <?php
                        
                        if($int_pen_cnt>0){
                            $click="onclick=\"$('#payment_int_cont').slideToggle();\"";
                            
                            if($int_pen_cnt==1){
                        $paid_sts="Pay Interest Rs. ".$tot_int_upto." for ".$int_pen_cnt." month";
     
                            }else{
                        $paid_sts="Pay Interest Rs. ".$tot_int_upto." for ".$int_pen_cnt." months";

                            }
                        }else{
                            
                            $click="onclick=\"$('#payment_int_cont').slideToggle();\"";
                            if($psa==0 && $paid_status==1){
                                $paid_sts="Interest Paid Completely";
                            }else{
                            $paid_sts="Interest Paid upto this month";
         
                            }
                        }
                        ?>
                    
                <div class="int_container col-lg-6">
                    <div class="payment_sts" id="int_sts_text" <?php echo $click; ?> >
                        <?php echo $paid_sts; ?>
                    </div>
                    <div class="payment_items_cont" id="payment_int_cont" style="display: none">
                     
                        <h3 style="color: crimson">Interest Pending</h3>
                            
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>
                                    Interest
                                        
                                    </th>
                                <th>
                                    Interest Date Limit
                                </th>
                               
                                </tr>
                                
                                    
                            </thead>
                            <tbody>
                                
                                <?php
                                $tot_intrst=0;
                                $tot_months_int=0;
                                $tot_def_int_amt=0;
                                
                                q("select log_id,pend_date,int_amount as p_int,int_rate_amt as ira,int_months as im from stl_interest_sts where fin_id=$fin_id and stl_id=$stl_id");
                                for($n=0;$n<count($p_int);$n++){
                                    
                                    if(count($p_int)==1){
                                        $pen_int_amt=$p_int;
                                        $pen_int_rate=$ira;
                                        $pend_int_month=$im;
                                        $pend_int_date=$pend_date;
                                        $en_id=$log_id;
                                        
                                        
                                    }else{
                                        $pen_int_amt=$p_int[$n];
                                        $pen_int_rate=$ira[$n];
                                        $pend_int_month=$im[$n]; 
                                      $pend_int_date=$pend_date[$n];
                                      $en_id=$log_id[$n];

                                    }
                                    
                                    $tot_intrst+=$pen_int_amt+$ext_amount;
                                      $tot_def_int_amt+=$pen_int_amt;
                                    $pen_int_amt+=$ext_amount;
                                  
                                    $tot_months_int+=$pend_int_month;
                                    
                                    ?>
                                <tr>
                                    <td>
                                     Rs. <?php echo convert_rup_format($pen_int_amt); ?> /-
                                    </td>
                                    <td>
                                          <?php 
                                          
                         $pnd_day=  substr($pend_int_date, strpos($pend_int_date, "-")+4,  2);
                        $pnd_mnth=substr($pend_int_date, strpos($pend_int_date, "-")+1,  2);
                        $pnd_year=  substr($pend_int_date, 0,4);
                        $pnd_day=$pnd_day-1+1;
                        $pnd_mnth=$pnd_mnth-1+1;
                        $pn_tyear=$pnd_year-1+1;
                                        ?> 
                                  
                                         <?php echo "$pnd_day-$pnd_mnth-$pnd_year"; ?> 
                                    </td>
                                       
                                </tr>
                                
                                    
                                        <?php
                                    
                                }
                                
                                ?>
                            </tbody>
                            <thead>
                                <tr>
                                    <th>
                                        Rs. <span id="tot_int_amt_val"><?php echo convert_rup_format($tot_intrst); ?></span> /- for <input type="number" placeholder="Enter month" id="tar_int_mnth" width="25" oninput="put_tot_int_amt()" value="<?php echo $tot_months_int;  ?>" />months
                                    </th>
                                   
                                    <th>
                                        <input type="number" id="int_amt_val" value="<?php echo $tot_intrst; ?>" />
                                        <input type="hidden" id="def_cur_int_amt" value="<?php echo $tot_def_int_amt ; ?>" />
                                        <?php 
                                        
                                        if($psa==0){
                                            ?><input type="checkbox" id="close_acc_btn"  onchange="add_close_acc()" value="yes" /> Close Account<?php
                                        }
                                        ?>
                                    </th>
                                    <th>
                                        <button id="pay_int_btn" onclick="pay_interest()" class="col-lg-12">
                                            Pay
                                        </button>
                                    </th>
                                    
                                </tr>
                            </thead>
                            
                            
                        </table>
                    
                    
                </div>
                </div>
             
            </div>

                  <div class="bottom_holder col-lg-12">
                            <div class="side_holder col-lg-6">
                                           <div class="loan_details">
                        
                          <div class="loan_amount_hold">
                              Loan Amount
                          </div>
                          <div class="amnt_inp">
                           Rs. <?php 

                           echo convert_rup_format($loan_amount); ?> /-
                          </div> 
                    </div>
                                        
                    
                    <div class="loan_details">
                            <div class="loan_amount_hold">
                                Loan Date 
                                 </div>
                            <div class="amnt_inp">
                              <?php echo $reg_date; ?>
                            </div>
                    </div>
                  
                    <div class="loan_details">
                             <div class="loan_amount_hold">
                         Interest Rate
                    </div>
                        <div class="amnt_inp">
                            <?php
                           echo $interest_rate;
                            ?> %
                        </div>
                        
                    
                    </div> 
                    </div>

                    <div class="side_holder col-lg-6">
                                <div class="loan_details">
                                   <div class="loan_amount_hold">
                              Remaining to be Paid
                          </div>
                          <div class="amnt_inp">

                              Rs. <?php


                              echo convert_rup_format($psa); ?> /-
                          </div>



                          </div>
                              <div class="loan_details">
                                      <div class="loan_amount_hold">
                                  Interest Date Limit
                             </div>
                             <div class="amnt_inp">

                                 <?php echo "$pre_day-$pre_mnth-$pre_tyear"; ?>
                             </div>



                             </div>
                              <div class="loan_details">
                                      <div class="loan_amount_hold">
                                 Current Interest Amount
                             </div>
                             <div class="amnt_inp">

                                 Rs. <?php echo convert_rup_format($interest_amount); ?> /-
                             </div>



                             </div>

                    </div>
                    
                    
                    
                  
                    </div>

                            <div class="logs_holder container col-lg-12">
                                
                                <div class="col-lg-6">
                                    <div class="payment_sts">
                                        Asal Logs
                                    </div>
                                    <div id="asal_log_holder">
                            <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>
                                        Date
                                    </th>
                                    <th>
                                        Asal paid
                                    </th>
                                    <th>
                                        Remaining Asal
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                
                                q("select asal_in as ain,date as a_date,tot_rem_asal as his_rem from stl_asal_logs where fin_id=$fin_id and stl_id=$stl_id order by log_id asc");
                                
                                $tot_asal_in_amt=0;
                                $tot_rem_abal=0;
                                for($n=0;$n<count($ain);$n++){
                                    
                                    if(count($ain)==1){
                                    
                                    $asal_in_amt=$ain;
                                    $a_dates=$a_date;
                                    $tot_asal_in_amt+=$asal_in_amt;
                                    $tot_rem_abal=$his_rem;
                                        
                                    }else{
                                         
                                    $asal_in_amt=$ain[$n];
                                    $a_dates=$a_date[$n];
                                    $tot_asal_in_amt+=$asal_in_amt;
                                   $tot_rem_abal=$his_rem[$n];
                                    }
                                   
                                    
                                    ?><tr>
                                        <td>
                                            <?php echo $a_dates; ?>
                                        </td>
                                        <td>
                                            Rs. <?php echo convert_rup_format($asal_in_amt); ?> /-
                                        </td>
                                        <td>
                                            Rs. <?php echo convert_rup_format($tot_rem_abal); ?> /-
                                        </td>
</tr>
                                        <?php
                                }
                                ?>
                            </tbody>
                            <thead>
                                <tr>
                                    <th>
                                        Total
                                    </th>
                                    <th>
                                        Rs. <?php echo convert_rup_format($tot_asal_in_amt); ?> /-
                                    </th>
                                    <th>
                                        Rs. <?php echo convert_rup_format($tot_rem_abal); ?> /-
                                    </th>
                                </tr>
                            </thead>
                                
                            
                        </table>
                                        
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="payment_sts">
                                        Interest Logs
                                    </div>
                                    <div id="int_log-holder">
                           
                            <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>
                                        Date
                                    </th>
                                    <th>
                                        Interest Paid
                                    </th>
                                    <th>
                                        Total
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                
                                q("select int_amount as int_am,date as ain,acc_type as act,int_months as paid_imnth,comm_id from interest_income where fin_id=$fin_id and cus_id=$stl_id and acc_type='stl' order by log_id asc");
                                $tot_int_amt=0;
                                for($n=0;$n<count($int_am);$n++){
                                    
                                    if(count($int_am)==1){
                                         $int_in_amt=$int_am;
                                    $i_date=$ain;
                                    $tot_int_amt+=$int_in_amt;
                                    $p_int_monts=$paid_imnth;
                                    
                                    $comms_id=$comm_id;
                                    }else{
                                        
                                         $int_in_amt=$int_am[$n];
                                    $i_date=$ain[$n];
                                    $tot_int_amt+=$int_in_amt;
                                   $p_int_monts=$paid_imnth[$n];
                                    $comms_id=$comm_id[$n];
                                    }
                                    
                                    
                                    ?><tr>
                                        <td>
                                            <?php echo $i_date; ?>
                                        </td>
                                        <td>
                                            Rs. <?php echo convert_rup_format($int_in_amt); ?> /- ( <?php echo $p_int_monts; ?> )
                                        </td>
                                        <td>
                                            Rs. <?php echo convert_rup_format($tot_int_amt); ?> /-
                                        </td>
                                        </tr>
                                        <?php
                                }
                                ?>
                            </tbody>
                            
                            <thead>
                                <tr>
                                    <th>
                                        Total
                                    </th>
                                    <th>
                                        Interest Income
                                    </th>
                                    <th>
                                        Rs. <?php echo convert_rup_format($tot_int_amt); ?> /-
                                    </th>
                                </tr>
                            </thead>
                                
                            
                        </table> 
                                    </div>
                                </div>
                                
                             

                            </div>

        
        <?php  echo "<script>rem_asal=".$psa.";stl_idss=".$stl_id.";tot_int_month=".$tot_months_int.";max_int=".$tot_intrst.";cur_interesst=".($current_interest+$ext_amount).";intrest_rate=".$interest_rate.";def_interest=".$current_interest.";</script>"; ?>
        <script type="text/javascript">
     
     function put_asal_val(){
         
                var asal_amt=$('#asal_amount').val()-1+1;
                $('#asal_amt_vals').html(" Rs. "+convert_rupee_format(asal_amt)+" /-");
       
         
     }
       function convert_rupee_format(rup_str){
            var amt_len=rup_str+"";
                
                b=0;
                amt_conv="";
                m=0;
                for(n=amt_len.length-1;n>=0;n--){
                    b++;
                    amt_conv+=amt_len[n];
                  
                    if(b>=3){
                       amt_conv+=",";
                       b=0;
                       m=1;
                    }
                    if(b>=2 && m===1){
                        amt_conv+=",";
                        b=0;
                    }
                }
              
            var last_len=amt_conv.lastIndexOf(",");
               var tot_len=amt_conv.length;
               if((tot_len-last_len)===1){
                  amt_conv=amt_conv.substr(0,tot_len-1);

               }
               var conv_amt="";
              for(n=amt_conv.length-1;n>=0;n--){
                  conv_amt+=amt_conv[n];
              }
              return conv_amt;

        }
     function pay_interest(){
         
         var verf=confirm("Confirm pay Interest ?");
         if(verf===true){
               var ca=null;
         if(close_acc===1){
             ca=confirm("Confirm Close Account ?");
             
         }
         if(ca===true || ca===null){
                               $('#payment_int_cont').slideToggle();

                  
                       var tot_int_amnt=$('#int_amt_val').val()-1+1;
                       var def_int_amt=$('#def_cur_int_amt').val()-1+1;
                       var comm_amt=tot_int_amnt-def_int_amt;
                       
                       if(def_int_amt>tot_int_amnt){
                       def_int_amt=tot_int_amnt;
                       
                        }
                       
                 var mod_amt=null;
                 if(tot_int_amnt<max_int){
                    
                       

                    mod_amt= confirm("Interest amount reduced from "+max_int+" to "+tot_int_amnt+".Do you Proceed ?");
                 }
                 if(tot_int_amnt>max_int){
                    
                       

                     mod_amt=confirm("Interest amount increased from "+max_int+" to "+tot_int_amnt+".Do you Proceed ?");
                 }
                 
                 
                 if(mod_amt===null || mod_amt===true){
                     $('#int_sts_text').text("Processing");
                 var urls="pay_interest.php";
                 var fmdt=new FormData();
                 
                 var stl_id=stl_idss;
                 fmdt.append('stl_id',stl_id);
                 var rem_mnth=$('#tar_int_mnth').val()-1+1;;
                 
                 if(isNaN(rem_mnth) || isNaN(def_int_amt)){
                  alert("Enter number for month & Amount");   
                 }else{
                 fmdt.append('int_amount',def_int_amt);
                 fmdt.append('remv_months',rem_mnth);
                 fmdt.append('close_acc',close_acc);
                 fmdt.append('comm_amt',comm_amt);
                 
                 
  $.ajax({
                url: urls,  
                dataType: 'text',  
                cache: false,
                contentType: false,
                processData: false,
                data: fmdt,                         
                type: 'post',
                success: function(psr){
      $('#payment_int_cont').slideUp();
         $('#int_sts_text').html(psr);
         //alert(psr);
         window.location.href='';
     
                }
	    
     });
                 }
            
                 
              

                 
                 }
                

         }
         

         }
       
     }
     function c(a){
         console.log(a);
     }
     function pay_asal(){
         
         var asal_amt=$('#asal_amount').val();
         if(asal_amt>0 && asal_amt<=rem_asal){
            var pay_condrm= confirm("Confirm Pay Asal Rs."+asal_amt+" ? ");
        if(pay_condrm===true){
             $('#asal_pay_text').html("Processing");
            $('#payment_asal_cont').slideToggle();
            var urls="pay_asal.php";
            var fmdt=new FormData();
            fmdt.append("stl_id",stl_idss);
            fmdt.append("asal_amt",asal_amt);
            
          
  $.ajax({
                url: urls,  
                dataType: 'text',  
                cache: false,
                contentType: false,
                processData: false,
                data: fmdt,                         
                type: 'post',
                success: function(psr){
     $('#asal_pay_text').html(psr);
     window.location.href='view_stl_user.php?stl_id='+stl_idss;
                }
	    
     });

        }
         }else{
             alert("Enter Valid Amount");
         }
     }
     
     last_int_amt=0;
     function put_tot_int_amt(){
         tot_int_amount=0;
         h=0;
         var tar_mnth=$('#tar_int_mnth').val()-1+1;
         
        
          var tot_tar_amt=cur_interesst*tar_mnth;
         
         var tot_def_int=def_interest*tar_mnth;
         
         $('#int_amt_val').val(Math.round(tot_tar_amt));
         $('#def_cur_int_amt').val(Math.round(tot_def_int));
         $('#tot_tar_int_mnth').html(tar_mnth);
         $('#tot_int_amt_val').html(tot_tar_amt);
     }
     
     close_acc=0;
     function add_close_acc(){
         
         var ids=$(':checkbox:last-child').attr('id');
         if(document.getElementById(ids).checked===true){
           close_acc=1;
         }else{
             close_acc=0;
         }
       
     }
     
     $(document).ready(function (){
         $("#asal_amount").keyup(function(e){
         var key=e.which || e.keyCode;
         if(key===13){
             pay_asal();
             
         }
         });
     });
    
        </script>
    </body>
</html>