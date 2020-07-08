<?php
            session_start();
            
            if(empty($_SESSION['fin_id']) || empty($_SESSION['user_id'])) header ("location:home.php");
            
            $fin_id=$_SESSION['fin_id'];
            require './my.php';
         
            
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
                  
                    
                    
                    if(count($stl_id)==0){
                        header("location:home.php");
                    }
                    $loan_bt_dt=$loan_date;
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
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
        <link rel="stylesheet" href="css/bootstrap.min.css" />
        <link rel="stylesheet" href="css/header.css" />
        <link rel="stylesheet" href="css/create_account.css" />
        <link rel="stylesheet" href="css/view_stl_user.css" />
        <link rel="stylesheet" href="css/homepage.css" />
        <script src="js/jquery.js" ></script>
        <script src="js/bootstrap.min.js"></script>
        <title>Velmurugan Finance</title>
    </head>
    <body>
        <?php
                    include './header.php';
                    
                      $q24s=q("select remaining_asal as psa,next_int_date as nxd,paid_status,current_interest,pending_sts from loan_leagure_stl where fin_id=$fin_id and stl_id=$stl_id");

                     $interest_amount=$current_interest;
                     
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
        
        <div class="col-lg-12">
            <div class="account_type_hdr col-lg-12">
                <h2 style="display: inline-block"> STL Account No : </h2> <h2 style="color: maroon;display: inline-block"><?php echo $stl_id ?></h2>
                <div class="main_info col-lg-12">
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
                        <a href="view_stl_user.php?stl_id=<?php echo $stl_id; ?>" style="text-decoration: none"><button>
                        <font>View Profile</font>
                            </button></a>
                    </div>
                    <?php
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
                           
                            $int_amount+=$current_interest;
                       
                        $diff_val-=30;
                        
                        
                    }
                  
                    if($diff_val<30 && $diff_val>0){
                        $int_pen_cnt+=1;
                           
                            $int_amount+=$current_interest;
                     
                    }
                  
                    if($cur_dates==$paid_int_date){
                        $int_pen_cnt+=1;
                           
                            $int_amount+=$current_interest;
                     
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
                                                             . " VALUES (NULL, '$stl_id', '$fin_id', '$current_interest', '$current_interest', '1','$pend_date');");
                        
                    }
                    
                   
                    q("update loan_leagure_stl set pend_month=$int_pen_cnt,paid_status=2 where fin_id=$fin_id and stl_id=$stl_id ");

                }  else {
              
                }
                
                
                  
    q("select int_amount as p_int from stl_interest_sts where fin_id=$fin_id and stl_id=$stl_id");

    for($n=0;$n<count($p_int);$n++){
        if(count($p_int)==1){
            $tot_int_upto+=$p_int;
        }else{
            $tot_int_upto+=$p_int[$n];
        }
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
            q("select paid_status from loan_leagure_stl where fin_id=$fin_id and stl_id=$stl_id");
            if($psa=="0" && $paid_status==1){
                         q("update customers_stl set person_status=2 where stl_id=$stl_id");

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
                              Loan Amount
                          </div>
                          <div class="amnt_inp">
                              Rs. <input class="col-lg-12"  type="number" name="new_loan_amt" id="upt_loan_amt" oninput="put_new_loan_dets()" placeholder="Loan Amount" value="<?php 

                              echo ($loan_amount); ?>" /> /-
                          </div> 
                    </div>
                                        
                    
                    <div class="loan_details">
                            <div class="loan_amount_hold">
                                Loan Date 
                                 </div>
                            <div class="amnt_inp">
                              <?php echo $reg_date;
                        
                              ?>
                            </div>
                    </div>
                  
                    <div class="loan_details">
                             <div class="loan_amount_hold">
                         Interest Rate
                    </div>
                        <div class="amnt_inp">
                            <input class="col-lg-12"  type="number" name="new_int_rate" oninput="put_new_loan_dets()"  placeholder="Interest Rate" id="upt_int_rate" value="<?php
                           echo $interest_rate;
                            ?>" /> %
                        </div>
                        
                    
                    </div> 
                    </div>

                    <div class="side_holder col-lg-6">
                                <div class="loan_details">
                                   <div class="loan_amount_hold">
                              Remaining to be Paid
                          </div>
                          <div class="amnt_inp">

                              Rs. <span id="upt_rem_asal"><?php


                              echo convert_rup_format($psa); ?></span> /-
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

                                 Rs. <span id="updt_int_amount"><?php echo convert_rup_format($interest_amount); ?></span> /-
                             </div>



                             </div>

                    </div>
                    <div class="loan_details col-lg-12">
                         <div class="inp_disc"><h2 style="color: maroon">Date</h2> </div>
                                  <div class="">
                                      <div style="display: inline-block">
                                             Day<select id="day_loan">
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
                                              Month
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
                                          Year
                                          
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
                    <div class="col-lg-12" style="text-align: center">
                     <div class="col-lg-3">
                       
                    </div>
                        <div class="payment_sts col-lg-6" onclick="updt_loan_dets()">
                        Update
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
                                    <th>
                                        Delete
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                
                                q("select asal_in as ain,date as a_date,tot_rem_asal as his_rem,log_id as a_log from stl_asal_logs where fin_id=$fin_id and stl_id=$stl_id order by log_id asc");
                                
                                $tot_asal_in_amt=0;
                                $tot_rem_abal=0;
                                for($n=1;$n<count($ain);$n++){
                                    
                                    if(count($ain)==1){
                                    
                                    $asal_in_amt=$ain;
                                    $a_dates=$a_date;
                                    $tot_asal_in_amt+=$asal_in_amt;
                                    $tot_rem_abal=$his_rem;
                                    $a_logid=$a_log;
                                            
                                        
                                    }else{
                                         
                                    $asal_in_amt=$ain[$n];
                                    $a_dates=$a_date[$n];
                                    $tot_asal_in_amt+=$asal_in_amt;
                                   $tot_rem_abal=$his_rem[$n];
                                   $a_logid=$a_log[$n];
                                   
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
                                        <td>
                                            <?php
                                            if($n>0){
                                                ?>
                                            <font title="Delete" style="cursor: pointer" onclick="delt_this_asal(<?php echo $asal_in_amt; ?>,<?php echo $a_logid; ?>);" color="crimson">X</font>
                                         
                                                    <?php
                                            }
                                            ?> 
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
                                    <th>
                                        Delete
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                
                                q("select comm_id,log_id as i_log,int_amount as int_am,date as ain,acc_type as act,int_months as paid_imnth from interest_income where fin_id=$fin_id and cus_id=$stl_id and acc_type='stl' order by log_id asc");
                                $tot_int_amt=0;
                                for($n=0;$n<count($int_am);$n++){
                                    
                                    if(count($int_am)==1){
                                         $int_in_amt=$int_am;
                                    $i_date=$ain;
                                    $tot_int_amt+=$int_in_amt;
                                    $p_int_monts=$paid_imnth;
                                    $i_logid=$i_log;
                                    $comms_id=$comm_id;
                                    }else{
                                         $int_in_amt=$int_am[$n];
                                    $i_date=$ain[$n];
                                    $tot_int_amt+=$int_in_amt;
                                   $p_int_monts=$paid_imnth[$n];
                                   $i_logid=$i_log[$n];
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
                                         <td>
                                            <?php
                                            {
                                                ?>
                                            <font title="Delete" style="cursor: pointer" onclick="delt_this_intrst(<?php echo $int_in_amt; ?>,<?php echo $i_logid; ?>,<?php echo $p_int_monts ?>,<?php echo   $comms_id; ?>);" color="crimson">X</font>
                                         
                                                    <?php
                                            }
                                            ?> 
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

                <script type="text/javascript">
                    loan_amt=<?php echo $loan_amount; ?>;
                    paid_asal=<?php echo $loan_amount-$psa; ?>;
                    int_rate=<?php
                    if($interest_rate==NULL){
                        $interest_rate=0;
                    }
                    echo $interest_rate; ?>;
                    stl_id=<?php echo $stl_id; ?>;
                
    
                function put_new_loan_dets(){
                    
                    var new_loan_amt=$('#upt_loan_amt').val()-1+1;
                    var new_int_rate=$('#upt_int_rate').val()-1+1;
                   
                  
                    var rem_to_pay=0;
                    if(new_loan_amt>paid_asal){
                        rem_to_pay=new_loan_amt-paid_asal;
                         var int_rate_amount=rem_to_pay*(new_int_rate/100);
                        $('#upt_rem_asal').html(convert_rupee_format(rem_to_pay));
                        $('#updt_int_amount').html(convert_rupee_format(Math.round(int_rate_amount)));
                    }
                    
                }    
                
                function updt_loan_dets(){
                    var updt_crn=confirm("Confirm Update ?");
                    if(updt_crn===true){
                          var new_loan_amt=$('#upt_loan_amt').val()-1+1;
                    var new_int_rate=$('#upt_int_rate').val()-1+1;
                   var day_loan=$('#day_loan').val();
                   var day_mnth=$('#day_month').val();
                   var day_year=$('#day_year').val();
                   
                  
                    var rem_to_pay=0;
                    if(new_loan_amt>paid_asal){
                        rem_to_pay=new_loan_amt-paid_asal;
                         var int_rate_amount=rem_to_pay*(new_int_rate/100);
                         var urls='updt_stl_loan_det.php';
                           var cus_of=$('#cus_of').val();
                         var fmdt=new FormData();
                         fmdt.append('new_loan_amt',new_loan_amt);
                         fmdt.append('new_int_rate',new_int_rate);
                         fmdt.append('int_amount',int_rate_amount);
                         fmdt.append('rem_asal',rem_to_pay);
                         fmdt.append('stl_id',stl_id);
                                 
                          fmdt.append('cus_of',cus_of);
                          fmdt.append('day_loan',day_loan);
                          fmdt.append('day_month',day_mnth);
                          fmdt.append('day_year',day_year);
                          
            
                         $('.form_container input').each(function(){
                          fmdt.append($(this).attr('name'),$(this).val());   
                         });
                         
                         $.ajax({
                url: urls,  
                dataType: 'text',  
                cache: false,
                contentType: false,
                processData: false,
                data: fmdt,                         
                type: 'post',
                success: function(psr){
  alert(psr);
             if(psr==='upt'){
                      alert("Updated");
                   window.location.href='edit_stl_user.php?stl_id='+stl_id;
             }
   
                }
	    
                 });
                    }
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
        function delt_this_asal(asl_amt,log_id){
            
            var cnrm=confirm("Confirm Delete this Asal ?");
            if(cnrm===true){
                         var urls='delt_asal.php';
            var fmdt=new FormData();
            fmdt.append('asal_amt',asl_amt);
            fmdt.append('log_id',log_id);
            fmdt.append('stl_id',stl_id);
           
            
            
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
                   window.location.href='edit_stl_user.php?stl_id='+stl_id;
             }
   
                }
	    
                 }); 
            }
            
  
        }
        
        function delt_this_intrst(int_amt,log_id,int_month,comm_id){
                 var cnrm=confirm("Confirm Delete this Interest ?");
            if(cnrm===true)
            {
                         var urls='delt_interest.php';
                       
            var fmdt=new FormData();
            fmdt.append('int_amt',int_amt);
            fmdt.append('log_id',log_id);
            fmdt.append('stl_id',stl_id);
            fmdt.append('int_month',int_month);
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
                  alert(psr);
              if(psr==='delt'){
                   window.location.href='edit_stl_user.php?stl_id='+stl_id;
             }
   
                }
	    
                 }); 
            }
            
        }
        
                </script>
      
    </body>
</html>