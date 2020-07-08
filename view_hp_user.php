<?php
            session_start();
            
           
                require './my.php';
            if(isset($_REQUEST['fin_id'])){
                
                $fin_id=$_REQUEST['fin_id'];
                $tr=q("select fin_id as cfin_id from finance_accounts where fin_id=$fin_id");
                if($tr){
                    if($cfin_id!=NULL && count($cfin_id)==1){
                        $_SESSION['fin_id']=$cfin_id;
                        
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

                    
                    $hp_id=$_GET['hp_id'];
                    
                    $q2=q("select hp_id, fin_id, name,nick_name, age, due_months,occupation, father_name, perm_add, mob_no, asset_dets, j_person_name, j_age, j_fname, j_address, j_mob_no, j_assets, interest_rate,j_occup, person_status, loan_date, loan_amount, int_amount, reg_date FROM customers_hp WHERE fin_id=$fin_id and hp_id=$hp_id");
                    
                    if(count($name)==0 || !$q2){
                         header("location:home.php");
                    }else{
                       
                    }
                    
                    
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html >
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
        <link rel="stylesheet" href="css/bootstrap.min.css" />
        <link rel="stylesheet" href="css/header.css" />
        <link rel="stylesheet" href="css/create_account.css" />
        <link rel="stylesheet" href="css/view_user.css" />
        <link rel="stylesheet" href="css/homepage.css" />
        
        <script src="js/jquery.js" ></script>
        <script src="js/bootstrap.min.js"></script>
        <title>Velmurugan Finance</title>
    </head>
    <body >
        
        <?php
                    include './header.php';
                     $q24s=q("select asal_amount_rate,due_paid_cnt,remaining_asal as psa,next_int_date as nxd,next_due_date,paid_status,current_interest,pending_sts,diff_amount from loan_leagure_hp where fin_id=$fin_id and hp_id=$hp_id");

                     $interest_amount=$current_interest;
                     $ext_amount=substr($diff_amount,4,  strlen($diff_amount));
                     $diff_act=  substr($diff_amount,0,1);
                    
                 
                  $diff_amount=$diff_amount-1+1;
                     
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
               while($my_day<$next_date){
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
               if($my_day>=$next_date){
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
                $next_int_date="$my_day-$tar_mnth-$tar_year";
               return $next_int_date;
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
        
        <div class="container col-lg-12">
            <div class="account_type_hdr">
                <h2 style="display: inline-block"> HP Account No : </h2> <h2 style="color: maroon;display: inline-block"><?php echo $hp_id ?></h2>
                <div class="clearfix"></div><br>
                
                <div class="main_info col-sm-12">
                   
                    <?php
                    
                            if($diff_act=="s"){
                                    $ci=$current_interest-$ext_amount;
                                }else{
                                    $ci=$current_interest+$ext_amount;
                                }
           
                                
                      $cnt=0;
                         $year= $_SESSION['cur_year'];
                $month= $_SESSION['cur_month'];
                $day=$_SESSION['cur_day'];
                $hr=date('g');
                $min=date('i');
                $noon=date('A');
                
                 $pre_day=  substr($nxd, strpos($nxd, "-")+4,  2);
                    $pre_mnth=substr($nxd, strpos($nxd, "-")+1,  2);
                    $pre_tyear=  substr($nxd, 0,4);
                    
                      $nad_day= substr($next_due_date, strpos($next_due_date, "-")+4,  2);
                       $nad_mnth=substr($next_due_date, strpos($next_due_date, "-")+1,  2);
                    $nad_tyear=  substr($next_due_date, 0,4);
                    
                    
                    $next_asd="$nad_tyear$nad_mnth$nad_day";
                    $next_asd=$next_asd-1+1;
                    $cur_dates="$year$month$day";
                    
                    $asl_to_paid=0;
                    
                    $dt1=  date_create($next_due_date);
                    $dt2=  date_create("$year-$month-$day");
                    $diff= date_diff($dt2, $dt1);
                    $diff_val=$diff->format("%a");
                    $cnt_asal=0;
                   

                    $asal_pend_motth=0;
          $int_amount=0;
          $int_pen_cnt=0;
          
                $paid_asal_date="$nad_tyear$nad_mnth$nad_day";
                
                if($cur_dates<$paid_asal_date){
                 
                }else{
                   
                
                    while($diff_val>=30){
                         $cnt_asal++;

                        if($asal_pend_motth<$due_months){
                       $asal_pend_motth+=1;
                       $int_pen_cnt+=1;
                            $asl_to_paid+=$asal_amount_rate;
                            $int_amount+=$ci;
                       
                        }
                        
                        
                        $diff_val-=30;
                        
                    }
             
                    if($diff_val<30 && $diff_val>0){
                                                      $cnt_asal++; 

                         if($asal_pend_motth<$due_months){

                      $asal_pend_motth+=1;
                     $int_pen_cnt+=1;

                            $asl_to_paid+=$asal_amount_rate;
                                                         $int_amount+=$ci;

                         }
                                                  
                    }
                                    
                    if($due_paid_cnt==0 && $diff_val==0 && $asal_pend_motth<$due_months){
                         $cnt_asal++;

                      $asal_pend_motth+=1;
                            $asl_to_paid+=$asal_amount_rate;
                              $int_amount+=$ci;
                     $int_pen_cnt+=1;
                    }
                }
                  
                    
                    
                    if($cnt_asal==0){
                        q("update loan_leagure_hp set due_pend_sts=1 where fin_id=$fin_id and hp_id=$hp_id");
                    }else{
                        if($cnt_asal==1){
                         q("update loan_leagure_hp set due_pend_sts=2 where fin_id=$fin_id and hp_id=$hp_id");

                        }elseif ($cnt_asal>1) {
                      q("update loan_leagure_hp set due_pend_sts=3 where fin_id=$fin_id and hp_id=$hp_id");

            }
         
                    }
              
                   ?>
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
                            q("select users_id as his_cust_id from customers_hp where fin_id=$fin_id and hp_id=$hp_id");
                            q("select user_name as uname from users where users_id=$his_cust_id");
                            if($uname==NULL){
                                $custmr_name="General";
                            }else{
                                 $custmr_name=  ucfirst($uname);
                            }
                            ?>
                            <font>Customer Of</font> : <?php echo ucfirst($custmr_name); ?>
                        </div>
                          <a href="hp_user_dtl.php?hp_id=<?php echo $hp_id; ?>" style="text-decoration: none"><button>
                        <font>View Profile</font>
                            </button></a>
                    </div>
                    <div class="account_info col-lg-6">
                        <div>
                            <font>Total Due upto Today</font> : Rs. <?php echo convert_rup_format($asl_to_paid+$int_amount); ?> /-<br><br>
                        </div>
                        <div>
                            
                      
                        <font>Status </font> : <?php
                       
                        $nad_date="$nad_day-$nad_mnth-$nad_tyear";
                        if($cnt_asal==1){
                            $next_dt=  calc_next_date(30, $nad_day, $nad_mnth, $nad_tyear);
                               
                            
                            ?><span style="color:crimson">Not Paid upto </span><?php echo $next_dt;
                        }
                        if($cnt_asal>1){
                            ?><span style="color:crimson">Pending from </span><?php echo $nad_date;
                        }
                        if($cnt_asal==0){
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
                            <div class="clearfix"></div>

            <?php
            if($psa=="0" || $psa<=0){
                q("update customers_hp set person_status=2 where hp_id=$hp_id  and fin_id=$fin_id");
                ?><h2 class="col-lg-12" style="color: crimson;text-align: center;padding: 20px;">Account Closed</h2><?php
            }
           
            ?>
                <div class="clearfix"></div>
                    <?php
                         $tot_rem_month=$due_months-$due_paid_cnt;
                            if($tot_rem_month==0 || $psa<=0){
                                $asal_sts="Due Paid";
                                $a_click="";
                                $rem_due_sts="";
                                }else{
                               
                                if($asal_pend_motth== 1){
                                    $mp="month";
                                }else{
                                    $mp="months";
                                }
                                if($asal_pend_motth==0){
                                    $asal_sts="Due Paid upto this month ";
                                }else{
                                    
                                
                                  
                                    if($asal_pend_motth>=$tot_rem_month){
                                        $asal_pend_motth=$tot_rem_month;
                                    }
                                    
                                   $asal_sts= "Pay Due Rs. ".(($asal_amount_rate+$ci)*($asal_pend_motth))." for ".$asal_pend_motth." $mp";

                                }
                                if($asal_amount_rate==0){
                                    $cis=0;
                                }else{
                                    $cis=$ci;
                                }
                             
                                if($psa<=0){
                                    $asal_pend_motth=0;
                                    $tot_rem_month=0;
                                }
                               $rem_due_sts=" ( Remaining Rs. ".  convert_rup_format((($asal_amount_rate+$cis)*($tot_rem_month)))." for ".($tot_rem_month)." months )";
                                $a_click='onclick="$(\'#payment_asal_cont\').slideToggle();"';
                            }
                            ?>
                <div class="payment_sts_hold col-lg-12">
                      <div class="payment_sts" id="asal_pay_text" <?php echo $a_click; ?> >
                     
                         <?php echo $asal_sts; ?><small> <?php echo $rem_due_sts; ?></small>
                    </div> 
                  
                </div>

            <div class="payment_container col-lg-12">
                <div class="asal_container">
                    <div class="payment_items_cont" id="payment_asal_cont" style="display: none">
                       
                        <div class="item_val_cont"  >
                        <div class="item_inp_cont">
                            <font> Asal </font>  <input type="text" readonly placeholder="Enter Amount"  value="<?php echo $asl_to_paid ?>" id="asal_amount" />
                            <font>for</font> <input type="number"  min="1" max="<?php echo $tot_rem_month;?>"  max="<?php echo $int_pen_cnt;?>"   oninput="calc_asal_amnt()" onchange="calc_asal_amnt()" id="asal_month"   value="<?php echo $asal_pend_motth;?>"  /> <font>( months )</font>

                        </div>
                            <div class="item_inp_cont asal_month_val">
                                    
                                   <font> Interest </font>  <input type="text" readonly placeholder="Enter Amount"   value="<?php echo $int_amount ?>" id="int_amount" />

                                   <font>for</font> <input type="number"  min="1" max="<?php echo $tot_rem_month;?>"  max="<?php echo $int_pen_cnt;?>" onchange="calc_int_amnt()"   oninput="calc_int_amnt()" id="int_month"   value="<?php echo $asal_pend_motth;?>"  /> <font>( months )</font>
                            
                        </div>
                        <div class="item_inp_cont asal_month_val">
      
                            <font> Total Amount to pay</font>  <input type="number"  placeholder="Enter Amount"  value="<?php echo $int_amount+$asl_to_paid; ?>" id="tot_amount" />
                                <div class="tot_due_to_pay">
                                  
                                    Rs <span id="tot_due_topay"><?php echo convert_rup_format($int_amount+$asl_to_paid); ?></span>
                                    ( <small>Asal</small> Rs. <span id="asal_pay_cnt"><?php echo $asl_to_paid; ?></span> +
                                    <small>Interest</small> Rs. <span id="int_pay_cnt"><?php echo $int_amount; ?></span> )
                                </div>
                                    
                        </div>
                        <div class="item_submit_cont">
                            <button onclick="pay_asal()" >Submit</button>
                            
                        </div>
                    </div>
                    
                    
                </div>
                </div>
               
             
            </div>
                 <div class="bottom_holder col-lg-12">
                            <div class="side_holder col-lg-6">
                                           <div class="loan_details">
                        
                          <div class="loan_amount_hold">
                              Asal per month
                          </div>
                          <div class="amnt_inp">
                           Rs. <?php 

                           echo convert_rup_format(round($loan_amount/$due_months)); ?> / month
                          </div>
                    </div>
                                        
                    
                            <div class="loan_details">
                                      <div class="loan_amount_hold">
                                  Interest Amount
                             </div>
                             <div class="amnt_inp">
                                    
                                 
                                Rs. <?php
                                
                               
                                echo convert_rup_format($ci); ?> / month
                             </div>



                             </div>
                              <div class="loan_details">
                                      <div class="loan_amount_hold">
                                 Current Due Amount
                             </div>
                             <div class="amnt_inp">

                                Rs. <?php echo convert_rup_format($ci+$asal_amount_rate); ?> / month
                             </div>



                             </div>
                                <div class="loan_details">
                                      <div class="loan_amount_hold">
                                 Total Due Amount
                             </div>
                             <div class="amnt_inp">

                                Rs. <?php echo convert_rup_format($due_months*($ci+$asal_amount_rate)); ?> for <?php echo $due_months; ?> months
                             </div>



                             </div>

                  
                    
                    </div>

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
                              <?php echo ($reg_date); ?>
                            </div>
                    </div>
                           
                        <div class="loan_details">
                             <div class="loan_amount_hold">
                         Interest Rate
                    </div>
                        <div class="amnt_inp">
                           <?php
                          echo ($interest_rate);
                            ?> %
                        </div>
                        
                    
                    </div> 
                            
                        <div class="loan_details">
                             <div class="loan_amount_hold">
                         Due Months
                    </div>
                        <div class="amnt_inp">
                           <?php
                          echo ($due_months);
                            ?> months
                        </div>
                        
                    
                    </div> 
                            
                          
                           
                         
                    </div>
                    
                    
                    
                  
                    </div>
                <div class="clearfix"></div>
                <div class="clearfix"></div>
                <div class="clearfix"></div>
                <div class="due_det_text col-lg-12">
                    Due Details
                </div>
                
                <?php
                 q("select asal_in as my_asal,int_amount as my_int,outer_asal_amt as tot_out,date as log_date,tot_rem_asal as my_tot_rem,due_months as paid_due_mnths from hp_asal_logs where fin_id=$fin_id and hp_id=$hp_id order by log_id asc");
                                
                ?>
                <div class="log_container col-lg-12">
                    <div class="inner_container col-lg-12">
                        
                        <?php
                        
                        if(count($log_date)==1){
                            ?><h2 class="col-lg-12" style="color: crimson;text-align: center">No Paid Entries </h2><?php
                        }else{
                          
                        
                        ?>
                        
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>
                                        S.no
                                    </th>
                                    <th>
                                        Date
                                    </th>
                                    <th>
                                        Asal Amount
                                    </th>
                                    <th>
                                        Interest Amount
                                    </th>
                                    <th>
                                        Due Amount
                                    </th>
                                    <th>
                                        Remaining Due
                                    </th>
                                        
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                               
                                $i=0;
                                $e_date="";
                                $tot_int_to_pay=$due_months*$current_interest;
                                
                                $tot_asal_in=0;
                                $tot_int_in=0;
                                $tot_due_in=0;
                                $tot_month_paid=0;
                                
                                for($m=1;$m<count($log_date);$m++){
                                    
                                    $i++;
                                    if(count($log_date)==1){
                                    $in_asal=$my_asal;
                                    $asal_outer=$tot_out;
                                    $entry_date=$log_date;
                                    $inte_amt=$my_int;
                                    $rem_hos_asal=$my_tot_rem;
                                  $due_paid_months=$paid_due_mnths;

                                        
                                    }else{
                                            $in_asal=$my_asal[$m];
                                    $asal_outer=$tot_out[$m];
                                    $entry_date=$log_date[$m];
                                      $inte_amt=$my_int[$m];
                                    $rem_hos_asal=$my_tot_rem[$m];
                                    $due_paid_months=$paid_due_mnths[$m];
                                    
                                    }
                                    $tot_month_paid+=$due_paid_months;
                                    $tot_asal_in+=$in_asal;
                                    $tot_int_in+=$inte_amt;
                                    $tot_due_in+=$in_asal+$inte_amt;
                                    
                                  $tot_int_to_pay-=$inte_amt;
                                    
                                    ?>
                            <tr>
                            <td>
                                <?php echo $i; ?>
                            </td>
                            <td>
                                <?php echo $entry_date; ?>
                            </td>
                            <td>
                                <?php echo $in_asal; ?>
                            </td>
                            <td>
                                <?php echo $inte_amt; ?><small style="color: maroon"> for ( <?php echo $due_paid_months; ?> ) months</small>
                            </td>
                            <td>
                                <?php echo $in_asal+$inte_amt; ?>
                            </td>
                            <td>
                                Rs. <?php
                                
                                $rem_due_rup=convert_rup_format("".($rem_hos_asal+$tot_int_to_pay)."");
                                echo $rem_due_rup; ?>
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
                                        
                                    </th>
                                    <th>
                                        Rs. <?php echo convert_rup_format($tot_asal_in); ?> /-
                                    </th>
                                    <th>
                                          Rs. <?php echo convert_rup_format($tot_int_in); ?> /- <small style="color: maroon"> for ( <?php echo $tot_month_paid; ?> ) months</small>
                                    </th>
                                    <th>
                                         Rs. <?php echo convert_rup_format($tot_due_in); ?> /-
                                    </th>
                                    
                                </tr>
                            </thead>
                                
                                
                            
                        </table>
                            
                        <?php  }?>
                    </div>
                </div>
                
            
            
            
        </div>
        <?php echo "<script>asal_amt_rate=".$asal_amount_rate.";rem_asal=".$psa.";hp_idss=".$hp_id.";due_pend_month=".($tot_rem_month).";int_rate=".$ci.";tot_interesst=".$ci.";intrest_rate=".$ci.";tot_asal_mnth=$due_months;</script>"; ?>
        <script type="text/javascript">
     
     function calc_int_amnt(){
       var int_month=$('#int_month').val()-1+1;
         $('#asal_month').val(int_month);
                  var tot_month=$('#asal_month').val()-1+1;

         var int_rate_amt=int_rate;
         
         var tot_int_amt=int_month*int_rate_amt;
         
         
         var tot_amount=tot_month*asal_amt_rate;
         
         while(tot_amount>rem_asal){
             tot_amount-=1;
         }
         
         if(int_month===due_pend_month){
                     
           tot_amount=(rem_asal);

         }
         $('#asal_amount').val(tot_amount);
         $('#int_amount').val(tot_int_amt);
                
        $('#tot_amount').val(tot_amount+tot_int_amt);
        
 $('#tot_due_topay').html($('#tot_amount').val());
         $('#asal_pay_cnt').html(tot_amount);
         $('#int_pay_cnt').html(tot_int_amt);
         
     }
    
     function c(a){
         console.log(a);
     }
     function pay_asal(){
         
         var asal_mnth=$('#asal_month').val()-1+1;
         var asal_amt=$('#asal_amount').val()-1+1;
         var int_amt=$('#int_amount').val()-1+1;
         var tot_due=$('#tot_amount').val()-1+1;
         
         
         if(asal_mnth>0 && asal_mnth<=due_pend_month){
            var pay_condrm= confirm("Confirm Pay Due Rs."+(tot_due)+" ? ");
            var amount_topay=$('#tot_amount').val()-1+1;
      
            if(pay_condrm===true){
             $('#asal_pay_text').html("Processing");
            $('#payment_asal_cont').slideToggle();
            var urls="pay_hp_asal.php";
            var fmdt=new FormData();
            fmdt.append("hp_id",hp_idss);
            fmdt.append("asal_amt",asal_amt);
            fmdt.append("asal_month",asal_mnth);
            fmdt.append("int_amount",int_amt);
            fmdt.append("tot_amount",amount_topay);
          
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
     if(psr==="Not"){
         alert("Can't Pay less than asal amount !");
     }else{
      
              window.location.href='view_hp_user.php?hp_id='+hp_idss;

     }
                }
	    
     });

        }
         }else{
             alert("Enter Valid Month");
         }
     }
     function calc_asal_amnt(){
     
         var tot_months=$('#asal_month').val()-1+1;
         var int_month=$('#int_month').val()-1+1;
         $('#int_month').val(tot_months);
         
         var int_rate_amt=int_rate;
         
         var tot_int_amt=int_month*int_rate_amt;
         
         
         var tot_amount=tot_months*asal_amt_rate;
         
        while(tot_amount>rem_asal){
             tot_amount-=1;
         }
           if(tot_months===due_pend_month){
                     
           tot_amount=(rem_asal);

         }
         $('#asal_amount').val(tot_amount);
         $('#int_amount').val(tot_int_amt);
         
         $('#tot_amount').val(tot_amount+tot_int_amt);
         
         $('#tot_due_topay').html(tot_amount+tot_int_amt);
         $('#asal_pay_cnt').html(tot_amount);
         $('#int_pay_cnt').html(tot_int_amt);
     }
        </script>
    </body>
</html>