<?php
            session_start();
            
            if(empty($_SESSION['fin_id'])) header ("location:home.php");
            
            $fin_id=$_SESSION['fin_id'];
            require './my.php';
            q("select remain_bal as kkk from amount_status where fin_id=$fin_id order by log_id desc limit 1");
            
            if($kkk==NULL){
                header("location:add_investers.php");
            }
             
                   $year= $_SESSION['cur_year'];
                $month= $_SESSION['cur_month'];
                $day=$_SESSION['cur_day'];
                
                $hr=date('g');
                $min=date('i');
                $noon=date('A');
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
                $next_int_date="$tar_year-$tar_mnth-$my_day";
               return $next_int_date;
                     }
            
            $q=q("select finance_name as fn from finance_accounts where fin_id=$fin_id");
            q("select remain_bal from amount_status where fin_id=$fin_id order by log_id desc limit 1");
            
          if(!empty($_REQUEST['p_name']) && !empty($_REQUEST['loan_amt']) && $remain_bal>=$_REQUEST['loan_amt'] && $_REQUEST['loan_amt']>=0){
                $p_name=ucfirst(mysqli_real_escape_string($dbc,$_REQUEST['p_name']));
                $nick_name=ucfirst(mysqli_real_escape_string($dbc,$_REQUEST['nick_p_name']));
                $p_age=ucfirst(mysqli_real_escape_string($dbc,$_REQUEST['p_age']));
                $p_occup=ucfirst(mysqli_real_escape_string($dbc,$_REQUEST['p_occup']));
                $p_fther=ucfirst(mysqli_real_escape_string($dbc,$_REQUEST['p_fname']));
                $p_addr=ucfirst(mysqli_real_escape_string($dbc,$_REQUEST['p_addrs']));
                $p_mob=ucfirst(mysqli_real_escape_string($dbc,$_REQUEST['p_mob']));
                $p_asset=ucfirst(mysqli_real_escape_string($dbc,$_REQUEST['p_asset']));
               
                $j_name=ucfirst(mysqli_real_escape_string($dbc,$_REQUEST['j_name']));
                $j_age=ucfirst(mysqli_real_escape_string($dbc,$_REQUEST['j_age']));
                $j_occup=ucfirst(mysqli_real_escape_string($dbc,$_REQUEST['j_occup']));
                $j_fther=ucfirst(mysqli_real_escape_string($dbc,$_REQUEST['j_fname']));
                $j_addr=ucfirst(mysqli_real_escape_string($dbc,$_REQUEST['j_addrs']));
                $j_mob=ucfirst(mysqli_real_escape_string($dbc,$_REQUEST['j_mob']));
                $j_asset=ucfirst(mysqli_real_escape_string($dbc,$_REQUEST['j_asset']));
                 $cust_id=$_REQUEST['cus_of'];
                
                
                $loan_amt=mysqli_real_escape_string($dbc,$_REQUEST['loan_amt']);
                $int_rate=mysqli_real_escape_string($dbc,$_REQUEST['int_rate']);
                $const_asal_amt=mysqli_real_escape_string($dbc,$_REQUEST['ret_month_amounts']);
                $asal_paid_cnt=mysqli_real_escape_string($dbc,$_REQUEST['ret_mnth']);
                  $init_int_amount=mysqli_real_escape_string($dbc,$_REQUEST['int_amount']);
             //    $init_int_sts=  mysqli_real_escape_string($dbc,$_REQUEST['int_paid_status']);
                  $pay_due_pm=mysqli_real_escape_string($dbc,$_REQUEST['cons_due_amount']);
                  
                  $doc_charge_amt=$_REQUEST['doc_charge_amt'];
                  
                  $loan_day=$_REQUEST['day_loan'];
                $loan_month=$_REQUEST['day_month'];
                $loan_year=$_REQUEST['day_year'];
                
                
                if($loan_day<=9){
                    $loan_day="0".$loan_day;
                }
                if($loan_month<=9){
                    $loan_month="0".$loan_month;
                    
                }
                
                    $loan_date_for_int="$loan_year-$loan_month-$loan_day";
                $loan_date_for_show="$loan_day-$loan_month-$loan_year $hr : $min $noon";

                
                  $diff_amount="";
                  
                  
                 $const_due_amt=$const_asal_amt+$init_int_amount;
                 if($pay_due_pm==$const_due_amt){
                     $diff_amount="add:0";
                 }else{
                     if($pay_due_pm>$const_due_amt){
                         $diff_amount="add:".($pay_due_pm-$const_due_amt);
                         
                     }else{
                         
                         $diff_amount="sub:".($const_due_amt-$pay_due_pm);
                     }
                 }
                 
                 
              
                
                $date="$day-$month-$year $hr:$min $noon";
                
                $next_due_date= "$year-$month-$day";
                  $correct_ins=0;
          
                {
                                  q("select hp_id as new_hp from customers_hp where fin_id=$fin_id order by log_id desc limit 1");
               
                 if($new_hp==NULL){
                   $hp_id=1;
               }else{
                   $hp_id=$new_hp;
                   $hp_id+=1;
               }
              
               $ip_addr=$_SERVER['REMOTE_ADDR'];
               
               $q=q("INSERT INTO `customers_hp` (`hp_id`, `fin_id`, `name`, `nick_name`,`age`, `occupation`, `father_name`, `perm_add`, `mob_no`, `asset_dets`, `j_person_name`, `j_age`, `j_fname`, `j_occup`,`j_address`, `j_mob_no`, `j_assets`, `interest_rate`, `person_status`, `loan_date`, `loan_amount`, `int_amount`, `reg_date`,`due_months`,`users_id`,`ip_addr`)"
                       . " VALUES ($hp_id, '$fin_id', '$p_name','$nick_name', '$p_age', '$p_occup', '$p_fther', '$p_addr', '$p_mob', '$p_asset','$j_name', '$j_age', '$j_fther','$j_occup', '$j_addr', '$j_mob', '$j_asset', '$int_rate', '1', CURRENT_TIMESTAMP, '$loan_amt', '$init_int_amount', '$loan_date_for_show','$asal_paid_cnt','$cust_id','$ip_addr');"); 
           
               if(!$q){
                 
                   
                   header("location:home.php");
               }else{
                     
                  
                   q("select hp_id as ins_id from customers_hp where ip_addr='$ip_addr' and fin_id=$fin_id order by log_id desc limit 1");
                   
                  
                    if($doc_charge_amt>0){
                       q("select tot_comm from extras where fin_id=$fin_id order by log_id desc limit 1");
                       
                       $tot_comm+=$doc_charge_amt;
                       
                       q("insert into extras (comm_amount,comm_word,fin_id,cus_id,date,tot_comm)"
                               . "      values($doc_charge_amt,'Document Charge',$fin_id,$ins_id,'$loan_date_for_show',$tot_comm)");
                   }
                                
               $remain_asal=$loan_amt;
               $paid_asal=0;
               $int_paid_date=$date;
               
               $paid_status=2;
                   $pending_sts=2;
              
            
              $next_int_date=  calc_next_date(30, $day, $month, $year);
               
            
   q("select outer_asal_amt from hp_asal_logs where fin_id=$fin_id order by log_id desc limit 1");
   
   $new_outer_asal=$outer_asal_amt+$loan_amt;
   
   
     q("INSERT INTO `hp_asal_logs` (`log_id`, `hp_id`, `fin_id`, `asal_in`, `asal_out`, `date`, `tot_rem_asal`,`outer_asal_amt`) "
             . "                                VALUES (NULL, '$hp_id', '$fin_id', 0, $loan_amt, '$loan_date_for_show', $loan_amt,$new_outer_asal);");
                
                 
               $q24=q("INSERT INTO `loan_leagure_hp` (`log_id`, `hp_id`, `fin_id`, `next_due_date`, `due_paid_cnt`,`asal_amount_rate`, `remaining_asal`, `current_interest`, `paid_status`,`next_int_date`,`pending_sts`,`due_pend_sts`,`diff_amount`)"
                       . "  VALUES (NULL, '$hp_id', '$fin_id', '$loan_date_for_int', 0,  '$const_asal_amt', '$remain_asal', '$init_int_amount', '$paid_status','$next_int_date',$pending_sts,2,'$diff_amount');");
               
              
               $qa=q("select remain_bal from amount_status where fin_id=$fin_id order by log_id desc limit 1");
               $remain_main_bal=$remain_bal-$loan_amt;
             
               $qi=q("INSERT INTO `amount_status` (`log_id`, `date_entry`, `asal_in`, `interest`, `remain_bal`, `fin_id`, `cust_id`, `loan_type`, `my_date`, `invest_id`, `invest_amt`, `asal_out`)"
                       . "                              VALUES (NULL, '$loan_date_for_int ', 0, 0, $remain_main_bal, $fin_id, '$hp_id', 'HP', '$loan_date_for_show', '', '', '$loan_amt');");
               
               
                   
               }
               
                }
   
  
               header("location:view_hp_user.php?hp_id=$hp_id");
               
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
        <link rel="stylesheet" href="css/create_account.css" />
        <script src="js/jquery.js" ></script>
        <link rel="stylesheet" href="css/homepage.css" />
        <link rel="stylesheet" href="css/view_stl_user.css" />
        
        <script src="js/bootstrap.min.js"></script>
        <title>Velmurugan Finance</title>
    </head>
    <body>
        <?php
                    include './header.php';
        ?>
        
        <div class="container">
            <div class="account_type_hdr">
                Create HP Account
            </div>
            <div class="form_container">
                <form class="form-group" id="stl_form" role="form" action="" method="post">
                    <div class="form_container col-lg-12">
               
                    <div class="person_det_cont col-lg-6">
                        <div class="orig_pers_ttl">
                            Person Details
                        </div>
                        <div class="tot_det_holder">
                            <div class="single_inp_det col-lg-12">
                                  <div class="inp_disc">Name</div>
                                  <div class="input_con">
                                      <input class="col-lg-12" id="pers_name"  type="text" value="" placeholder="Name" name="p_name" />
                                  </div>
                                
                            </div>
                            <div class="single_inp_det col-lg-12">
                                  <div class="inp_disc">Nick Name</div>
                                  <div class="input_con">
                                      <input class="col-lg-12"  type="text" value="" placeholder="Nick Name" name="nick_p_name" />
                                  </div>
                                
                            </div>
                            
                            <div class="single_inp_det col-lg-12">
                                  <div class="inp_disc">Age</div>
                                  <div class="input_con">
                                      <input class="col-lg-12"  type="text" placeholder="Age" value="" name="p_age" />
                                  </div>
                                
                            </div>
                            <div class="single_inp_det col-lg-12">
                                  <div class="inp_disc">Occupation</div>
                                  <div class="input_con">
                                      <input class="col-lg-12"  type="text" placeholder="Occupation" value="" name="p_occup" />
                                  </div>
                                
                            </div>
                            <div class="single_inp_det col-lg-12">
                                  <div class="inp_disc">Father Name</div>
                                  <div class="input_con">
                                      <input class="col-lg-12"  type="text" placeholder="Father Name" value="" name="p_fname" />
                                  </div>
                                
                            </div>
                            <div class="single_inp_det col-lg-12">
                                  <div class="inp_disc">Address</div>
                                  <div class="input_con">
                               
                                      <textarea class="col-lg-12"  type="text" oninput="$('#p_addrs').val(this.value);" placeholder="Address"></textarea>
                                      <input type="hidden" value="<?php echo ucfirst($perm_add); ?>" id="p_addrs" name="p_addrs"/>
                                  </div>
                            </div>
                            <div class="single_inp_det col-lg-12">
                                  <div class="inp_disc">Mobile</div>
                                  <div class="input_con">
                                  
                                      <input class="col-lg-12"  type="text" placeholder="Mobile No" value="" id="mobi_nos" name="p_mob" />
                                  </div>
                            </div>
                            <div class="single_inp_det col-lg-12">
                                  <div class="inp_disc">Assets</div>
                                  <div class="input_con">
                                 
                                      <input class="col-lg-12"  type="text" placeholder="Assets" value="" name="p_asset" />
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
                                      <input class="col-lg-12" placeholder="Name"  type="text" value="" name="j_name" />
                                  </div>
                                
                            </div>
                            
                            <div class="single_inp_det col-lg-12">
                                  <div class="inp_disc">Age</div>
                                  <div class="input_con">
                                      <input class="col-lg-12"  type="text" placeholder="Age" value="" name="j_age" />
                                  </div>
                                
                            </div>
                            <div class="single_inp_det col-lg-12">
                                  <div class="inp_disc">Occupation</div>
                                  <div class="input_con">
                                      <input class="col-lg-12"  type="text" placeholder="Occupation" value="" name="j_occup" />
                                  </div>
                                
                            </div>
                            <div class="single_inp_det col-lg-12">
                                  <div class="inp_disc">Father Name</div>
                                  <div class="input_con">
                                      <input class="col-lg-12"  type="text" placeholder="Father Name" value="" name="j_fname" />
                                  </div>
                                
                            </div>
                            <div class="single_inp_det col-lg-12">
                                  <div class="inp_disc">Address</div>
                                  <div class="input_con">
                               
                                  <textarea class="col-lg-12"  type="text" oninput="$('#j_addrs').val(this.value);" name="j_addrs" placeholder="Address"></textarea>
                                      
                                  </div>
                            </div>
                            <div class="single_inp_det col-lg-12">
                                  <div class="inp_disc">Mobile</div>
                                  <div class="input_con">
                                  
                                      <input class="col-lg-12"  type="text" placeholder="Mobile No" value="" name="j_mob" />
                                  </div>
                            </div>
                            <div class="single_inp_det col-lg-12">
                                  <div class="inp_disc">Assets</div>
                                  <div class="input_con">
                                 
                                      <input class="col-lg-12"  type="text" placeholder="Assets" value="" name="j_asset" />
                                  </div>
                            </div>
                            
                            
                          
                            
                        </div>
                    </div>
               
                  <div class=" col-lg-12">
                         <div class="inp_disc"><h2 style="color: maroon">Date</h2> </div>
                                  <div class="">
                                      <div style="display: inline-block">
                                          <select name="day_loan">
                                          <option value=""> Day</option>
                                          <?php for($n=1;$n<=31;$n++){
                                              
                                              ?><option value="<?php echo $n; ?>"><?php  echo $n;?></option><?php     
                                          } ?>
                                          
                                      </select>
                                      </div>
                                          
                                      <div  style="display: inline-block">
                                             
                                              <select name="day_month">
                                          <option value="">Month</option>
                                          <?php for($n=1;$n<=12;$n++){
                                          ?><option value="<?php echo $n; ?>"><?php  echo $n;?></option><?php     
                                          } ?>
                                          
                                      </select>
                                      
                                      </div>
                                      <div  style="display: inline-block">
                                         
                                      <select name="day_year">
                                            <option value="">Year</option>
                                          <?php for($n=2013;$n<=2016;$n++){
                                          ?><option value="<?php echo $n; ?>"><?php  echo $n;?></option><?php     
                                          } ?>
                                          
                                      </select>
                                      
                                      </div>
                                  
                                  
                                          </div>
                            </div>
                    
            </div>
                    
                    
                    
                    <div class="loan_details">
                        
                          <div class="loan_amount_hold">
                              Loan Amount
                          </div>
                     
                          <div class="amnt_inp">
                              <input required  type="number" max="<?php echo $remain_bal; ?>" id="loan_amount" oninput="calc_int_amnt()" name="loan_amt" placeholder="Enter Amount" />

                          </div>
                        <div class="amnt_inp" id="loan_amount_val"></div>
                    </div>
                    <div class="loan_details">
                        
                          <div class="loan_amount_hold">
                              Remaining balance
                          </div>
                          <div class="amnt_inp">
                              <input required  type="number" id="remain_balnc" readonly value="<?php echo $remain_bal; ?>"   placeholder="Enter Amount" />

                          </div>
                        <div class="amnt_inp" id="remain_bal_val"></div>
                    </div>
                     <div class="loan_details">
                             <div class="loan_amount_hold">
                        Asal return Month
                    </div>
                    <div class="amnt_inp">
                        <input required  type="number" oninput="calc_asal_return()" value=""  name="ret_mnth" id="ret_month"   placeholder="Total months need to pay" />
                        
                    </div>
                        <div class="amnt_inp" id="asal_return_month"></div>
  
                    </div>
                    
                   <div class="loan_details">
                             <div class="loan_amount_hold">
                       Amount to return per month 
                    </div>
                    <div class="amnt_inp">
                        <input required  type="number" value="" readonly  name="ret_month_amounts" id="ret_month_amount"   placeholder="Total months need to pay" />
                        
                    </div>
                        <div class="amnt_inp" id="asal_return_amount"></div>
  
                    </div>
                    
                    <div class="loan_details">
                            <div class="loan_amount_hold">
                                Interest Rate 
                                 </div>
                            <div class="amnt_inp">
                                <input required  type="text" value="0"  name="int_rate" id="interest_rates"  oninput="calc_int_amnt()" placeholder="Enter Interest" />

                            </div>
                        <div class="amnt_inp" id="int_rate_perc"></div>

                    </div>
                         <div class="loan_details">
                            <div class="loan_amount_hold">
                                Interest Amount 
                                 </div>
                            <div class="amnt_inp">
                                <input required readonly  type="text" value="0"  name="int_amount" id="interest_amount"  placeholder="Enter Interest" />

                            </div>
                        <div class="amnt_inp" id="int_amount_val"></div>

                    </div>
                    
                    
                         <div class="loan_details">
                            <div class="loan_amount_hold">
                               My Interest Rate 
                                 </div>
                            <div class="amnt_inp">
                                <input required  type="text" value="0"  name="my_int_rate" id="my_interest_rates"  oninput="calc_int_amnt()" placeholder="Enter Interest" />

                            </div>
                        <div class="amnt_inp" id="int_rate_perc"></div>

                    </div>
                    <div class="loan_details">
                            <div class="loan_amount_hold">
                                Extra Amount per month 
                                 </div>
                            <div class="amnt_inp">
                                <input required   type="text" readonly value="0" oninput="calc_int_amnt()"  name="extra_amount" id="ext_amount"  placeholder="Enter Amount" />

                            </div>
                        <div class="amnt_inp" id="ext_amount_val"></div>

                    </div>
               
                    <div class="loan_details">
                            <div class="loan_amount_hold">
                                Due per month 
                                 </div>
                            <div class="amnt_inp">
                                <input required   type="text" readonly value="0" oninput="//calc_int_amnt()"  name="cons_due_amount" id="due_amount"  placeholder="Enter Interest" />

                            </div>
                        <div class="amnt_inp" id="due_amount_val"></div>

                    </div>
                                   
                    <div class="loan_details">
                            <div class="loan_amount_hold">
                                Document Charge
                                 </div>
                            <div class="amnt_inp">
                                <input required   type="number"  value="0" oninput="//calc_int_amnt()"  name="doc_charge_amt" id="doc_amount"  placeholder="Enter Document Charge" />

                            </div>
                        <div class="amnt_inp" id="doc_amount_val"></div>

                    </div>
                      <div class="loan_details">
                             <div class="loan_amount_hold">
                        Customer Of
                    </div>
                    <div class="amnt_inp">
                        <select required name="cus_of">
                            <option value="">Select</option>
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
                                ?><option value="<?php echo $cus_use_id; ?>"><?php echo $use_name; ?></option><?php
                            }
                            
                            ?>
                        </select>
                    </div>
                        <div class="amnt_inp" id="int_rupees_conv"></div>
        </div>
                   

                    
                    <div class="subt_holder">
                        <div  class="subt_btn" onclick="subt_form()">Submit</div>
                    </div>
                    
                    
                    
                </form>
            </div>
            
        </div>
        <script type="text/javascript">
            <?php echo "remain_balance=$remain_bal;"; ?>
                
                 
        function calc_int_amnt(){
            
        //  console.log("a");
            
            var loan_amt=$('#loan_amount').val()-1+1;
            var tot_month=$('#ret_month').val()-1+1;
            
            if(tot_month>0){
                calc_asal_return();
          
            }
            var int_rates=$('#interest_rates').val()-1+1;
           
            if(int_rates>0){
                $('#int_rate_perc').html(int_rates+" %");
            }
         
            var main_bal=remain_balance;
            if(loan_amt>main_bal){
                $('#loan_amount').val('');
                                $('#remain_balnc').val(remain_balance);

            }
               
                
               var loan_rup=convert_rupee_format(loan_amt);

                $('#loan_amount_val').html("Rs "+loan_rup+" /-");
                $('#remain_balnc').val(remain_balance-loan_amt);
                $('#remain_bal_val').html("Rs "+convert_rupee_format(remain_balance-loan_amt)+" /-");
              

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
        
        function put_int_amt(chng){
           if(chng==="yes"){
                var loan_amt=$('#loan_amount').val()-1+1;
                var int_rate=$('#interest_rates').val();
            var int_amt=loan_amt*(int_rate/100);
            console.log(int_amt);
            $('#interest_amount').val(int_amt);
            $('#int_perc_conv').html($('#interest_rates').val()+" %");
           }else{
                           //$('#interest_amount').val(0);

           }
        }
        
        function subt_form(){
           
        var loan_amt=$('#loan_amount').val()-1+1;
        blocked=0;
        if(loan_amt>remain_balance){
            blocked=1;
        }   
      
      var int_rates=$('#interest_rates').val();
      int_rates+=-1+1;
      if(isNaN(loan_amt) || isNaN(int_rates) || int_rates<=0 || loan_amt<=0){
          
          if(Math.round(int_rates===0)){
                        blocked=4;

          }
          
            
            if(loan_amt<=0){
              
                blocked=6;
                
            }
      }
         bn=0;
      date_val=0;
      $('select:not(nav select)').each(function(){
         bn++;
         if(bn<=3){
             
             if($(this).val()===""){
               date_val=1;
              
             }
         }
      });
      
     
      
       if(date_val!==0){
      blocked=12;
      
        }
      bn=0;
      $('input:not(.titlebar_input)').each(function(){
          var this_val=$(this).val().trim();
          var thi_id=$(this).attr('id');
          clr=1;
          if($(this).val()==="" ){
              
              if(thi_id==="pers_name"){
              clr=2;
              blocked=10;
          }
          if(thi_id==="loan_amount"){
              clr=2;
                   blocked=1;
          }
          if(thi_id==="ret_month"){
              clr=2;
              blocked=7;
          }
          if(thi_id==="interest_rates"){
              clr=2;
              blocked=4;
          }
          if(thi_id==="mobi_nos"){
              clr=2;
              blocked=8;
          }
              
          }
          
          
     
          if(clr===2){
              blocked=3;
              $(this).css("border","1px solid crimson");
          }else{
                            $(this).css("border","1px solid lightgrey");

          }    
          
          
      });
      bn=0;
      
      $('textarea').each(function(){
          var this_val=$(this).val().trim();
      bn++;
            if(bn<=1){
          if(this_val===""){
              blocked=3;
              $(this).css("border","1px solid crimson");
          }else{
                            $(this).css("border","1px solid lightgrey");

          }      
            }
          
      });
      
    
      
           if(blocked===0){
               if(int_rates<=0){
              var f_l=confirm("Confirm Allow 0% Interest ?");
                if(f_l===true){
                   $('#stl_form').submit();
                }
            }else{
                 $('#stl_form').submit();
            }
                         
  
           }else{
               switch(blocked){
                   case 1:
                       alert("Loan Amount showuld be min to Remaining balance");
                       break;
                   case 2:
                       alert("Enter valid Loan Amount or Interest Rate");
                       break;
                   case 3:
                       alert("Fill in required fields");
                       break;
                   case 4:
                       alert("Enter valid Interest Rate");
                       break;
                   case 6:
                         alert("Enter valid Loan Amount");
                         break;
                   case 7:
                       alert('Enter Valid Return month');
                       break;
                   case 8:
                       alert("Enter valid mobile Number");
                       break;
                   case 10:
                       alert("Enter valid person Name");
                       break;
                   case 12:
                       alert("Select Valid date");
                       break;
                       default :
                           alert(blocked);
                           break;
                      
                      
                      
               }
              
           }
        }
        
        $(document).ready(function (){
            $('input:not(.titlebar_input)').keyup(function (e){
                
            var this_val=$(this).val().trim();
          
          if(this_val===""){
         
              $(this).css("border","1px solid crimson");
          }else{
                            $(this).css("border","1px solid lightgrey");

          }
      var key=e.which || e.keyCode;
      if(key===13){
          subt_form();
      }
            });
            
        });
        
             function calc_asal_return(){
                 
                  var loan_amt=$('#loan_amount').val()-1+1;
            var tot_month=$('#ret_month').val()-1+1;
            
            var asal_amt=loan_amt/tot_month;
            
            
            var int_rate=$('#interest_rates').val()-1+1;
            
            
            var int_amt=loan_amt*(int_rate/100);
            
             var my_int_rate=$('#my_interest_rates').val()-1+1;
            var my_amt=0;
            if(my_int_rate>=0){
             my_amt=loan_amt*(my_int_rate/100);
         $('#ext_amount').val(my_amt);
         $('#ext_amount_val').html("Rs "+convert_rupee_format(Math.round(my_amt))+" / month");
            }
            
            $('#ret_month_amount').val(Math.round(asal_amt));
                   $('#asal_return_amount').html("Rs "+convert_rupee_format(Math.round(asal_amt))+" / month");
                $('#asal_return_month').html(tot_month+" months");
                
            
            $('#interest_amount').val(Math.round(int_amt));
            $('#int_amount_val').html("Rs "+convert_rupee_format(Math.round(int_amt))+" /-");
                            $('#due_amount').val(Math.round(asal_amt+int_amt+my_amt));
                            $('#due_amount_val').html("Due Rs "+(convert_rupee_format(Math.round(asal_amt+int_amt+my_amt)))+" / month");

             }
             
          
        </script>
    </body>
</html>