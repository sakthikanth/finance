

<?php
            session_start();
            
            if(empty($_SESSION['fin_id']) || empty($_SESSION['user_id'])) header ("location:home.php");
            
            $fin_id=$_SESSION['fin_id'];
            require './my.php';
         
            
            $q=q("select finance_name as fn from finance_accounts where fin_id=$fin_id");
           
            ?>

<?php

                    
                    $hp_id=$_GET['hp_id'];
                    
                    $q2=q("select hp_id, fin_id, name,nick_name, age, due_months,occupation, father_name, perm_add, mob_no, asset_dets, j_person_name, j_age, j_fname, j_address, j_mob_no, j_assets, interest_rate,j_occup, person_status, loan_date, loan_amount, int_amount, reg_date FROM customers_hp WHERE fin_id=$fin_id and hp_id=$hp_id");
                    
                    if(count($name)==0){
                         header("location:home.php");
                    }
                    
                                 $lb_day=  substr($reg_date,0,2)-1+1;
                    $lb_mnth=substr($reg_date, strpos($reg_date, "-")+1,2)-1+1;
                    
                   
                    $lb_year=  substr($reg_date, 6,4)-1+1;
                     
                    $lb_day=$lb_day-1+1;
                    $lb_mnth=$lb_mnth-1+1;
                    $lb_year=$lb_year-1+1;
                    
                    
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
                        <a href="view_hp_user.php?hp_id=<?php echo $hp_id; ?>" style="text-decoration: none"><button>
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
            if($psa=="0" ){
                q("update customers_hp set person_status=2 where hp_id=$hp_id");
                ?><h2 class="col-lg-12" style="color: crimson;text-align: center;padding: 20px;">Account Closed</h2><?php
            }
           
            ?>
                <div class="clearfix"></div>
                 
                      <div class="form_container col-lg-12">
               
                    <div class="person_det_cont col-lg-6">
                        <div class="orig_pers_ttl">
                            Person Details
                        </div>
                        <div class="tot_det_holder">
                            <div class="single_inp_det col-lg-12">
                                  <div class="inp_disc">Name</div>
                                  <div class="input_con">
                                      <input class="col-lg-12"  type="text" value="<?php echo ucfirst($name);  ?>" name="p_name" />
                                  </div>
                                
                            </div>
                            <div class="single_inp_det col-lg-12">
                                  <div class="inp_disc">Nick Name</div>
                                  <div class="input_con">
                                      <input class="col-lg-12"  type="text" value="<?php echo ucfirst($nick_name);  ?>" name="p_nname" />
                                  </div>
                                
                            </div>
                            
                            <div class="single_inp_det col-lg-12">
                                  <div class="inp_disc">Age</div>
                                  <div class="input_con">
                                      <input class="col-lg-12"  type="text" placeholder="Age" value="<?php echo ucfirst($age); ?>" name="p_age" />
                                  </div>
                                
                            </div>
                            <div class="single_inp_det col-lg-12">
                                  <div class="inp_disc">Occupation</div>
                                  <div class="input_con">
                                      <input class="col-lg-12"  type="text" placeholder="Occupation" value="<?php echo ucfirst($occupation); ?>" name="p_occup" />
                                  </div>
                                
                            </div>
                            <div class="single_inp_det col-lg-12">
                                  <div class="inp_disc">Father Name</div>
                                  <div class="input_con">
                                      <input class="col-lg-12"  type="text" placeholder="Father Name" value="<?php echo ucfirst($father_name); ?>" name="p_fname" />
                                  </div>
                                
                            </div>
                            <div class="single_inp_det col-lg-12">
                                  <div class="inp_disc">Address</div>
                                  <div class="input_con">
                               
                                      <textarea class="col-lg-12"  type="text" oninput="$('#p_addrs').val(this.value);" placeholder="Address"><?php echo ucfirst($perm_add); ?></textarea>
                                      <input type="hidden" value="<?php echo ucfirst($perm_add); ?>" id="p_addrs" name="p_addr"/>
                                  </div>
                            </div>
                            <div class="single_inp_det col-lg-12">
                                  <div class="inp_disc">Mobile</div>
                                  <div class="input_con">
                                  
                                      <input class="col-lg-12"  type="text" placeholder="Mobile No" value="<?php echo ucfirst($mob_no); ?>" name="p_mob" />
                                  </div>
                            </div>
                            <div class="single_inp_det col-lg-12">
                                  <div class="inp_disc">Assets</div>
                                  <div class="input_con">
                                 
                                      <input class="col-lg-12"  type="text" placeholder="Assets" value="<?php echo ucfirst($asset_dets); ?>" name="p_asset" />
                                  </div>
                            </div>
                            
                            
                          
                            
                        </div>
                    </div>
                
                    <div class="person_det_cont col-lg-6">
                        <div class="orig_pers_ttl">
                           Jamin Person Details
                        </div>
                        <div class="tot_det_holder">
                            <div class="single_inp_det col-lg-12">
                                  <div class="inp_disc">Name</div>
                                  <div class="input_con">
                                      <input class="col-lg-12"  type="text" value="<?php echo ucfirst($j_person_name);  ?>" name="j_name" />
                                  </div>
                                
                            </div>
                            
                            <div class="single_inp_det col-lg-12">
                                  <div class="inp_disc">Age</div>
                                  <div class="input_con">
                                      <input class="col-lg-12"  type="text" placeholder="Age" value="<?php echo ucfirst($j_age); ?>" name="j_age" />
                                  </div>
                                
                            </div>
                            <div class="single_inp_det col-lg-12">
                                  <div class="inp_disc">Occupation</div>
                                  <div class="input_con">
                                      <input class="col-lg-12"  type="text" placeholder="Occupation" value="<?php echo ucfirst($j_occup); ?>" name="j_occup" />
                                  </div>
                                
                            </div>
                            <div class="single_inp_det col-lg-12">
                                  <div class="inp_disc">Father Name</div>
                                  <div class="input_con">
                                      <input class="col-lg-12"  type="text" placeholder="Father Name" value="<?php echo ucfirst($j_fname); ?>" name="j_fname" />
                                  </div>
                                
                            </div>
                            <div class="single_inp_det col-lg-12">
                                  <div class="inp_disc">Address</div>
                                  <div class="input_con">
                               
                                  <textarea class="col-lg-12"  type="text" oninput="$('#j_addrs').val(this.value);" placeholder="Address"><?php echo ucfirst($j_address); ?></textarea>
                                      <input type="hidden" value="<?php echo ucfirst($j_address); ?>" id="j_addrs" name="j_addr"/>
                                  </div>
                            </div>
                            <div class="single_inp_det col-lg-12">
                                  <div class="inp_disc">Mobile</div>
                                  <div class="input_con">
                                  
                                      <input class="col-lg-12"  type="text" placeholder="Mobile No" value="<?php echo ucfirst($j_mob_no); ?>" name="j_mob" />
                                  </div>
                            </div>
                            <div class="single_inp_det col-lg-12">
                                  <div class="inp_disc">Assets</div>
                                  <div class="input_con">
                                 
                                      <input class="col-lg-12"  type="text" placeholder="Assets" value="<?php echo ucfirst($j_assets); ?>" name="j_asset" />
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
                              Rs. <span id="asal_per_month"><?php 

                              echo convert_rup_format(round($loan_amount/$due_months)); ?></span> / month
                          </div>
                    </div>
                                        
                    
                            <div class="loan_details">
                                      <div class="loan_amount_hold">
                                  Interest Amount
                             </div>
                             <div class="amnt_inp">
                                    
                                 
                                 Rs. <span id="int_amount"><?php
                                
                               
                                 echo convert_rup_format($ci); ?></span> / month
                             </div>



                             </div>
                              <div class="loan_details">
                                      <div class="loan_amount_hold">
                                 Current Due Amount
                             </div>
                             <div class="amnt_inp">

                                 Rs. <span id="cur_due_amt"><?php echo convert_rup_format($ci+$asal_amount_rate); ?></span> / month
                             </div>



                             </div>
                                <div class="loan_details">
                                      <div class="loan_amount_hold">
                                 Total Due Amount
                             </div>
                             <div class="amnt_inp">

                                 Rs. <span id="tot_due_amt"><?php echo convert_rup_format($due_months*($ci+$asal_amount_rate)); ?></span> for <span id="fin_due_months"><?php echo $due_months; ?></span> months
                             </div>



                             </div>
<div class="loan_details">
                             <div class="loan_amount_hold">
                        Customer Of
                    </div>
                    <div class="amnt_inp">
                        <select required id="cus_of">
                            <option value="0">Select</option>
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
                                if(ucfirst($use_name)==$custmr_name){
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

                    <div class="side_holder col-lg-6">
                        <div class="loan_details">
                                   <div class="loan_amount_hold">
                              Loan Amount
                          </div>
                          <div class="amnt_inp">

                              Rs. <input type="number" placeholder="Loan Amount" value="<?php


                              echo ($loan_amount); ?>" oninput="put_new_loan_amt()" id="upt_loan_amt" /> /-
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
                            <input type="text" oninput="put_new_loan_amt()" min="0.1" placeholder="Interest rate" id="upt_int_rate" value="<?php
                          echo ($interest_rate);
                            ?>" /> %
                        </div>
                        
                    
                    </div> 
                            
                        <div class="loan_details">
                             <div class="loan_amount_hold">
                         Due Months
                    </div>
                        <div class="amnt_inp">
                            <input type="number" min="<?php echo $due_paid_cnt; ?>" oninput="put_new_loan_amt()" placeholder="Due months" id="upt_due_month" value="<?php
                          echo ($due_months);
                            ?>"/> months
                        </div>
                        
                    
                    </div> 
                            
                          
                           
                         
                    </div>
                    
                    <div class="loan_details col-lg-12">
                         <div class="inp_disc"><h2 style="color: maroon">Date</h2> </div>
                                  <div class="">
                                      <div style="display: inline-block">
                                        <select id="day_loan">
                                          <option value=""> Select</option>
                                          <?php for($n=1;$n<=31;$n++){
                                              
                                              if($n==$lb_day){
                                                  $sel="selected";
                                              }else{
                                                  $sel="";
                                              }
                                              
                                              ?><option <?php echo $sel; ?> value="<?php echo $n; ?>"><?php  echo $n;?></option><?php     
                                          } ?>
                                          
                                      </select>
                                      </div>
                                          
                                      <div  style="display: inline-block">
                                             
                                              <select id="day_month">
                                          <option value="">Select</option>
                                          <?php for($n=1;$n<=12;$n++){
                                               if($n==$lb_mnth){
                                                  $sel="selected";
                                              }else{
                                                  $sel="";
                                              }
                                              
                                          ?><option <?php echo $sel; ?> value="<?php echo $n; ?>"><?php  echo $n;?></option><?php     
                                          } ?>
                                          
                                      </select>
                                      
                                      </div>
                                      <div  style="display: inline-block">
                                        
                                      <select id="day_year">
                                            <option value="">Select</option>
                                          <?php for($n=2013;$n<=2016;$n++){
                                               if($n==$lb_year){
                                                  $sel="selected";
                                              }else{
                                                  $sel="";
                                              }
                                              
                                          ?><option <?php echo $sel; ?> value="<?php echo $n; ?>"><?php  echo $n;?></option><?php     
                                          } ?>
                                          
                                      </select>
                                      
                                      </div>
                                  
                                  
                                          </div>
                            </div>
                    
                  
                    </div>
                <div class="col-lg-12">
                    <div class="col-lg-3">
                        
                    </div>
                    <div class="payment_sts col-lg-6" style="text-align: center" onclick="update_hp_dets()">
                        Update
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="clearfix"></div>
                <div class="clearfix"></div>
                <div class="due_det_text col-lg-12">
                    Due Details
                </div>
                
                <?php
                 q("select log_id as lid,asal_in as my_asal,int_amount as my_int,outer_asal_amt as tot_out,date as log_date,tot_rem_asal as my_tot_rem,due_months as paid_due_mnths,due_duration as ddr,comm_id from hp_asal_logs where fin_id=$fin_id and hp_id=$hp_id order by log_id asc");
                                
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
                                        Duration
                                    </th>
                                    <th>
                                        Remaining Due
                                    </th>
                                    <th>
                                        Delete
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
                                   $due_duration=$ddr;
                                   $d_logid=$lid;
                                   $comms_id=$comm_id;
                                   
                                   
                                        
                                    }else{
                                            $in_asal=$my_asal[$m];
                                    $asal_outer=$tot_out[$m];
                                    $entry_date=$log_date[$m];
                                      $inte_amt=$my_int[$m];
                                    $rem_hos_asal=$my_tot_rem[$m];
                                    $due_paid_months=$paid_due_mnths[$m];
                                    $due_duration=$ddr[$m];
                                    $d_logid=$lid[$m];
                                    $comms_id=$comm_id[$m];

                                    
                                    }
                                    $tot_month_paid+=$due_paid_months;
                                    $tot_asal_in+=$in_asal;
                                    $tot_int_in+=$inte_amt;
                                    $tot_due_in+=$in_asal+$inte_amt;
                                    
                                  $tot_int_to_pay-=$inte_amt;
                                
                                  $dur_day= substr($due_duration, strpos($due_duration, "-")+4,  2);
                       $dur_mnth=substr($due_duration, strpos($due_duration, "-")+1,  2);
                    $dur_tyear=  substr($due_duration, 0,4);  
                    $due_dates="$dur_day-$dur_mnth-$dur_tyear";
                                  
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
                                <?php echo $due_dates; ?>
                            </td>
                            <td>
                                Rs. <?php
                                
                                $rem_due_rup=convert_rup_format("".($rem_hos_asal+$tot_int_to_pay)."");
                                echo $rem_due_rup; ?>
                            </td>
                            <td>
                    <font title="Delete" style="cursor: pointer" onclick="delt_this_due(<?php echo $in_asal; ?>,<?php echo $inte_amt; ?>,<?php echo $due_paid_months ?>,<?php echo $d_logid; ?>,<?php echo $comms_id; ?>);" color="crimson">X</font>

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
                                    <th>
                                        
                                    </th>
                                    
                                </tr>
                            </thead>
                                
                                
                            
                        </table>
                            
                        <?php  }?>
                    </div>
                </div>
                
            
            
            
        </div>
         <script type="text/javascript">
     
    hp_id=<?php echo $hp_id ?>;
     tot_asal_mnth=<?php echo $due_months; ?>;
     due_paid_month=<?php echo $due_paid_cnt; ?>;
     ext_amount=<?php echo $ext_amount; ?>;
     diff_act="<?php echo $diff_act ?>";
     paid_asal=<?php echo ($loan_amount-$psa); ?>;
     
    
  function put_new_loan_amt(){
      
      var new_loan_amt=$('#upt_loan_amt').val()-1+1;
      var int_rate=$('#upt_int_rate').val()-1+1;
      var due_months=$('#upt_due_month').val()-1+1;
      if(isNaN(int_rate)){
          int_rate=0;
      }
      if(isNaN(due_months)){
          due_months=0;
      }
      if(isNaN(new_loan_amt)){
          new_loan_amt=0;
      }
      var new_due_mnth=0;
      if(due_months>due_paid_month){
             new_due_mnth=due_months;
    
      }else{
                    new_due_mnth=tot_asal_mnth;
   
      }
      
      if(new_loan_amt>paid_asal){
          
          
              var asal_amt=new_loan_amt-paid_asal;
              var asal_p_mnth=Math.round(new_loan_amt/due_months);
              var int_amt=Math.round(new_loan_amt*(int_rate/100));
              if(diff_act==="a"){
                  int_amt+=ext_amount;
              }else{
                  int_amt-=ext_amount;
              }
              var cur_due=int_amt+asal_p_mnth;
              var tot_due_amt=new_due_mnth*cur_due;
              $('#asal_per_month').html(convert_rupee_format(asal_p_mnth));
              $('#int_amount').html(convert_rupee_format(int_amt));
              $('#cur_due_amt').html(convert_rupee_format(cur_due));
              $('#tot_due_amt').html(convert_rupee_format(tot_due_amt));
              $('#fin_due_months').html(new_due_mnth);
              
              
      }
  
      
      
      
      
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
        
        
        function update_hp_dets(){
           var cnfrm=confirm("Confirm Update ?");
         if(cnfrm===true){
               var new_loan_amt=$('#upt_loan_amt').val()-1+1;
      var int_rate=$('#upt_int_rate').val()-1+1;
      var due_months=$('#upt_due_month').val()-1+1;
        var day_loan=$('#day_loan').val();
                   var day_mnth=$('#day_month').val();
                   var day_year=$('#day_year').val();
                 
      if(isNaN(int_rate)){
          blocked=1;
      }
      if(isNaN(due_months)){
            blocked=2;
      }
      if(isNaN(new_loan_amt)){
            blocked=3;
      }
      var new_due_mnth=0;
      if(due_months>due_paid_month){
             new_due_mnth=due_months;
    
      }else{
                    new_due_mnth=tot_asal_mnth;
   
      }
      blk=0;
      if(new_loan_amt<paid_asal){
          blk=1;
      }
     
      if(blk===0){
          
          
              var asal_p_mnth=Math.round(new_loan_amt/due_months);
              var int_amt=Math.round(new_loan_amt*(int_rate/100));
              if(diff_act==="a"){
                  int_amt+=ext_amount;
              }else{
                  int_amt-=ext_amount;
              }
             
              var int_amount=new_loan_amt*(int_rate/100);
              var rem_asal=new_loan_amt-paid_asal;
              var cust_of=$('#cus_of').val();
            
    var fmdt=new FormData();
    fmdt.append('new_loan_amt',new_loan_amt);
    fmdt.append('rem_asal',rem_asal);
    fmdt.append('int_amount',int_amount);
    fmdt.append('asal_per_mnth',asal_p_mnth);
    fmdt.append('new_int_rate',int_rate);
    fmdt.append('due_months',new_due_mnth);
    fmdt.append('hp_id',hp_id);
    fmdt.append('cust_of',cust_of);
   
    fmdt.append('day_loan',day_loan);
                          fmdt.append('day_month',day_mnth);
                          fmdt.append('day_year',day_year);
    
         $('.form_container input').each(function(){
                          fmdt.append($(this).attr('name'),$(this).val());   
                         });
     
     var urls="updt_hp_dets.php";
     
              $.ajax({
                url: urls,  
                dataType: 'text',  
                cache: false,
                contentType: false,
                processData: false,
                data: fmdt,                         
                type: 'post',
                success: function(psr){
      
              if(psr==='upt'){
                   window.location.href='edit_hp_user.php?hp_id='+hp_id;
             }
   
                }
	    
                 }); 
              
              
      }
  
      
 
    
         }
  
    
    }
    
    function delt_this_due(asal,inte,mnth,lid,comm_id){
            var cnfrm=confirm("Delete this Due ?");
            
            if(cnfrm===true){
                      var urls="delt_hp_due.php";
        var fmdt=new FormData();
        fmdt.append('asal',asal);
        fmdt.append('inte',inte);
        fmdt.append('mnth',mnth);
        fmdt.append('log_id',lid);
        fmdt.append('hp_id',hp_id);
        fmdt.append('comm_id',comm_id);
        
           $.ajax({
                url: urls,  
                dataType: 'text',  
                cache: false,
                contentType: false,
                processData: false,
                data: fmdt,                         
                type: 'post',
                success: function(psr){
          
              if(psr==='delt'){
                    
                   window.location.href='edit_hp_user.php?hp_id='+hp_id;
             }
   
                }
	    
                 });   
            }

        
    }
        </script>
    </body>
</html>