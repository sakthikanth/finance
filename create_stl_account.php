<?php
            session_start();
            
            if(empty($_SESSION['fin_id'])) header ("location:home.php");
            
            $fin_id=$_SESSION['fin_id'];
            require './my.php';
           $year= $_SESSION['cur_year'];
                $month= $_SESSION['cur_month'];
                $day=$_SESSION['cur_day'];
                
                      $dt = new DateTime('now', new DateTimezone('Asia/Kolkata'));
                $hr=$dt->format('g');
                $min=$dt->format('i');
                $noon=$dt->format('A');
                
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
            
            if($remain_bal==NULL){
                header("location:add_investers.php");
            }
            if(isset($_POST)){
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
                if($cust_id==""){
                    $cust_id=0;
                }
                
                $loan_day=$_REQUEST['day_loan'];
                $loan_month=$_REQUEST['day_month'];
                $loan_year=$_REQUEST['day_year'];
                
               
                
                
                $loan_amt=mysqli_real_escape_string($dbc,$_REQUEST['loan_amt']);
                $int_rate=mysqli_real_escape_string($dbc,$_REQUEST['int_rate']);
                $tot_int_amt=mysqli_real_escape_string($dbc,$_REQUEST['init_int']);
                $int_paid_status=mysqli_real_escape_string($dbc,$_REQUEST['int_paid_status']);
                
                $doc_charge_amt=$_REQUEST['doc_charge_amt'];
                $ext_amount=$_REQUEST['extra_amount'];
                $cur_int_amt=$_REQUEST['cur_int_amount'];
                
                $orig_int_amt= $cur_int_amt+$ext_amount;
                
               
                
                if($tot_int_amt>$orig_int_amt){
                    $diff_amt=$tot_int_amt-$orig_int_amt;
                    $ext_amount+=$diff_amt;
                }elseif($orig_int_amt>$tot_int_amt){
                    $diff_amt=$orig_int_amt-$tot_int_amt;
                    $ext_amount-=$diff_amt;
                    if($ext_amount==0){
               $cur_int_amt-=$diff_amt;         
                    }else{
                        $ext_amount-=$diff_amt;
                    }
                    
                }
                
                
                 
                if($loan_day<=9){
                    $loan_day="0".$loan_day;
                }
                if($loan_month<=9){
                    $loan_month="0".$loan_month;
                    
                }
                
                $loan_date_for_int="$loan_year-$loan_month-$loan_day";
                $loan_date_for_show="$loan_day-$loan_month-$loan_year $hr:$min $noon";

                
                $date="$day-$month-$year $hr:$min $noon";
                
                $correct_ins=0;
              {
                    
                       q("select stl_id as new_stl from customers_stl where fin_id=$fin_id order by log_id desc limit 1");
               
                 if($new_stl==NULL){
                   $stl_id=1;
               }else{
                   $stl_id=$new_stl;
                   $stl_id+=1;
               }
               
               $ip_addr=$_SERVER['REMOTE_ADDR'];
                 
               $q=q("INSERT INTO `customers_stl` (`stl_id`, `fin_id`, `name`,`nick_name`, `age`, `occupation`, `father_name`, `perm_add`, `mob_no`, `asset_dets`, `j_person_name`, `j_age`, `j_fname`, `j_occup`,`j_address`, `j_mob_no`, `j_assets`, `interest_rate`, `person_status`, `loan_date`, `loan_amount`, `init_interesr`, `reg_date`,`users_id`,`ip_addr`)"
                       . " VALUES ($stl_id, '$fin_id', '$p_name','$nick_name', '$p_age', '$p_occup', '$p_fther', '$p_addr', '$p_mob', '$p_asset','$j_name', '$j_age', '$j_fther','$j_occup', '$j_addr', '$j_mob', '$j_asset', '$int_rate', '1', CURRENT_TIMESTAMP, '$loan_amt', '$cur_int_amt', '$loan_date_for_show',$cust_id,'$ip_addr');"); 
           
               if(!$q){
                   
                  header("location:home.php");
               }else{
                   q("select stl_id as ins_id from customers_stl where ip_addr='$ip_addr' and fin_id=$fin_id order by log_id desc limit 1");
                   
                   q("select stl_id as c_sid from customers_stl where stl_id=$ins_id and fin_id=$fin_id");
                   
                   if(count($c_sid)==1){
                       $correct_ins=1;
                       
                   }elseif(count($c_sid)>1){
                       q("delete from customers_stl where fin_id=$fin_id and stl_id=$c_sid and ip_addr='$ip_addr'");
                   }
                   
                   
               }
               
              
                }
                
               $remain_asal=$loan_amt;
               $paid_asal=0;
               $int_paid_date=$date;
               
             
              
               
               q("select outer_asal_amt  from stl_asal_logs where fin_id=$fin_id order by log_id desc limit 1");
    
    $outer_asal_amt+=$loan_amt;
    
    
    
     q("INSERT INTO `stl_asal_logs` (`log_id`, `stl_id`, `fin_id`, `asal_in`, `asal_out`, `date`, `tot_rem_asal`,`outer_asal_amt`) "
             . "  VALUES (NULL, '$stl_id', '$fin_id', 0, $loan_amt, '$loan_date_for_show', $loan_amt,$outer_asal_amt);");
             
               
             
               if($int_paid_status=="yes"){
                   $loan_day=$loan_day-1+1;
                   $loan_month=$loan_month-1+1;
                      $paid_status=1;
                   $pending_sts=1;
                     $ii_int_amt=$cur_int_amt;
                 
               
                  
                   $next_int_date=  calc_next_date(30, $loan_day, $loan_month, $loan_year);
               }else{
                   $next_int_date=  $loan_date_for_int;
 $paid_status=2;
                   $pending_sts=2;
                     $ii_int_amt=0;
               }
              
              
                 
               $q24=q("INSERT INTO `loan_leagure_stl` (`log_id`, `stl_id`, `fin_id`, `paid_date`, `paid_asal_amount`, `remaining_asal`, `current_interest`, `paid_status`,`next_int_date`,`pending_sts`,ext_amount)"
                       . "  VALUES (NULL, '$stl_id', '$fin_id', '$loan_date_for_show',   '$paid_asal', '$loan_amt', '$cur_int_amt', '$paid_status','$next_int_date',$pending_sts,$ext_amount);");
               
               if($doc_charge_amt>0){
                       q("select tot_comm from extras where fin_id=$fin_id order by log_id desc limit 1");
                       
                       $tot_comm+=$doc_charge_amt;
                       
                       q("insert into extras (comm_amount,comm_word,fin_id,cus_id,date,tot_comm,acc_type)"
                               . "      values($doc_charge_amt,'Document Charge',$fin_id,$ins_id,'$loan_date_for_show',$tot_comm,'STL')");
                   }
                     $qa=q("select remain_bal as rbl from amount_status where fin_id=$fin_id order by log_id desc limit 1");
               $remain_main_bal=$rbl-$loan_amt;
               
            
             
               $qi=q("INSERT INTO `amount_status` (`log_id`, `date_entry`, `asal_in`, `interest`, `remain_bal`, `fin_id`, `cust_id`, `loan_type`, `my_date`, `invest_id`, `invest_amt`, `asal_out`)"
                       . "                              VALUES (NULL,'$loan_date_for_int', 0, 0, $remain_main_bal, $fin_id, '$stl_id', 'STL', '$loan_date_for_show', '', '', '$loan_amt');");
           
                   if($int_paid_status=="yes"){
                         if($ext_amount>0){
                                   q("select tot_comm as tot_commison from extras where fin_id=$fin_id order by log_id desc limit 1");
                       
                       $tot_commison+=$ext_amount;
                       
                       q("insert into extras (comm_amount,comm_word,fin_id,cus_id,date,tot_comm,acc_type)"
                               . "      values($ext_amount,'Commision',$fin_id,$ins_id,'$loan_date_for_show',$tot_commison,'STL')");
                
                            }
                              q("select total_interest from interest_income where fin_id=$fin_id order by log_id desc limit 1");
                                 $total_interest+=$cur_int_amt;
                           
                                 q("insert into interest_income (fin_id,acc_type,cus_id,int_amount,date,total_interest,int_months)values($fin_id,'STL',$stl_id,$cur_int_amt,'$loan_date_for_show',$total_interest,1)");

                                $qa=q("select remain_bal as dbk_rem from amount_status where fin_id=$fin_id order by log_id desc limit 1");
                                            $dbk_rem+=$cur_int_amt;
                                            
                                 $qi=q("INSERT INTO `amount_status` (`log_id`, `date_entry`, `asal_in`, `interest`, `remain_bal`, `fin_id`, `cust_id`, `loan_type`, `my_date`, `invest_id`, `invest_amt`, `asal_out`)"
                       . "  VALUES (NULL,'$loan_date_for_int', 0, '$cur_int_amt', $dbk_rem, $fin_id, '$ins_id', 'STL', '$loan_date_for_show', '', '', '');");
               
                   }
                 
              
              header("location:view_stl_user.php?stl_id=$stl_id");
               
               }else{
                  // header("location:home.php");
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
        ?>
        
        <div class="">
            <div class="account_type_hdr">
                Create STL Account
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
                                      <input class="col-lg-12"  type="text" value="" placeholder="Name" name="p_name" />
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
                                  
                                      <input class="col-lg-12" id="mobi_no"  type="text" placeholder="Mobile No" value="" name="p_mob" />
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
                                          <option value=""> Select</option>
                                          <?php for($n=1;$n<=31;$n++){
                                              
                                              ?><option value="<?php echo $n; ?>"><?php  echo $n;?></option><?php     
                                          } ?>
                                          
                                      </select>
                                      </div>
                                          
                                      <div  style="display: inline-block">
                                             
                                              <select name="day_month">
                                          <option value="">Select</option>
                                          <?php for($n=1;$n<=12;$n++){
                                          ?><option value="<?php echo $n; ?>"><?php  echo $n;?></option><?php     
                                          } ?>
                                          
                                      </select>
                                      
                                      </div>
                                      <div  style="display: inline-block">
                                    
                                          
                                      <select name="day_year">
                                            <option value="">Select</option>
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
                              <input required  type="text" max="<?php echo $remain_bal; ?>" id="loan_amount" oninput="calc_int_amnt()" name="loan_amt" placeholder="Enter Amount" />

                          </div>
                        <div class="amnt_inp" id="rupees_conv"></div>
                    </div>
                    <div class="loan_details">
                        
                          <div class="loan_amount_hold">
                              Remaining balance
                          </div>
                          <div class="amnt_inp">
                              <input required  type="number" id="remain_balnc" readonly value="<?php echo $remain_bal; ?>" oninput="calc_int_amnt()"  placeholder="Enter Amount" />

                          </div>
                        <div class="amnt_inp" id="remain_rupees_conv"></div>
                    </div>
                    <div class="loan_details">
                            <div class="loan_amount_hold">
                                Interest Rate 
                                 </div>
                            <div class="amnt_inp">
                                <input required  type="text" value="0"  name="int_rate" id="interest_rates"  oninput="calc_int_amnt()" placeholder="Enter Interest" />

                            </div>
                        <div class="amnt_inp" id="int_perc_conv"></div>

                    </div>
                     <div class="loan_details">
                            <div class="loan_amount_hold">
                                Current Interest Amount
                                 </div>
                            <div class="amnt_inp">
                                  <input required  type="number" value=""  name="cur_int_amount" id="cur_int_amt" readonly=""  placeholder="Interest Amount" />

                            </div>
                        <div class="amnt_inp" id="cur_int_val"></div>

                    </div>
                  
                    
                    <div class="loan_details">
                            <div class="loan_amount_hold">
                               My Interest Rate 
                                 </div>
                            <div class="amnt_inp">
                                <input required  type="text" value="0"  name="my_int_rate" id="my_interest_rates"  oninput="calc_int_amnt()" placeholder="Enter Interest" />

                            </div>
                        <div class="amnt_inp" id="my_int_rate_val"></div>

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
                                Document Charge
                                 </div>
                            <div class="amnt_inp">
                                <input required   type="number"  value="0" oninput="calc_int_amnt()"  name="doc_charge_amt" id="doc_amount"  placeholder="Enter Document Charge" />

                            </div>
                        <div class="amnt_inp" id="doc_amount_val"></div>

                    </div>
                   <div class="loan_details">
                             <div class="loan_amount_hold">
                         Interest / month
                    </div>
                    <div class="amnt_inp">
                        <input required  type="number" value=""  name="init_int" id="interest_amount"  placeholder="Interest Amount" />
                        
                    </div>
                        <div class="amnt_inp" id="int_rupees_conv"></div>
                      </div>
                       <div class="loan_details">
                             <div class="loan_amount_hold">
                        Initial Interest Status
                    </div>
                        <div >
                            <div style="padding: 10px"><label for="c1">Paid</label>
                                <input required  id='c1' style="padding: 10px;font-size: 20px;width: 30px;height: 30px;" type="radio" onchange="put_int_amt(this.value)"  name="int_paid_status" checked value="yes"/>
                            </div>
                            <div style="padding: 10px">
                            <label for="c2">Not Paid</label>
                            <input required  id="c2" style="padding: 10px;font-size: 20px;width: 30px;height: 30px;" type="radio" onchange="put_int_amt(this.value)"  name="int_paid_status"  value="no"/>
                            </div>
                        
                    </div>
                        
                        
                    
                    </div>
                    
                    <div class="loan_details">
                             <div class="loan_amount_hold">
                        Customer Of
                    </div>
                    <div class="amnt_inp">
                        <select required name="cus_of" id="custmr_of">
                            <option value="">General</option>
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
            
            var loan_amt=$('#loan_amount').val()-1+1;
            var int_rates=$('#interest_rates').val()-1+1;
            var int_amt=Math.round(loan_amt*(int_rates/100));
         var my_int_rate=$('#my_interest_rates').val()-1+1;
         
            var main_bal=remain_balance;
            if(loan_amt>main_bal){
                $('#loan_amount').val('');
               $('#remain_balnc').val(remain_balance);

            }else{
                
                var my_ext_amt=Math.round(loan_amt*(my_int_rate/100));
                
                $('#ext_amount').val((Math.round(my_ext_amt)));
                
               var loan_rup=convert_rupee_format(loan_amt);
               
               
                $('#cur_int_amt').val(int_amt);
                $('#cur_int_val').html("Rs. "+convert_rupee_format(int_amt));
                $('#rupees_conv').html("Rs "+loan_rup+" /-");
                $('#remain_balnc').val(remain_balance-loan_amt);
                $('#remain_rupees_conv').html("Rs "+convert_rupee_format(remain_balance-loan_amt)+" /-");
         $('#interest_amount').val((int_amt+my_ext_amt));
            $('#int_rupees_conv').html("Rs "+convert_rupee_format((int_amt+my_ext_amt))+" /-");
                        $('#int_perc_conv').html($('#interest_rates').val()+" %");
                        $('#ext_amount_val').html("Rs. "+convert_rupee_format(Math.round(my_ext_amt))+" /-");
                        $('#my_int_rate_val').html(my_int_rate+" %");
                        $('#doc_amount_val').html(("Rs. "+convert_rupee_format(Math.round($('#doc_amount').val())))+" /-");
   
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
           
          if(isNaN($('#loan_amount').val()) || $('#loan_amount').val()===''){
          alert('Enter Correct loan amount');
          }else{
                   var loan_amt=$('#loan_amount').val()-1+1;
        blocked=0;
        if(loan_amt>remain_balance){
            blocked=1;
        }   
        
        
      var int_rates=$('#interest_rates').val();
      int_rates+=-1+1;
      allowed=1;
      if(Math.round(int_rates===0) || int_rates===0 || int_rates==="0"){
                        blocked=4;
                           var int_zero=confirm("Confirm 0 % Interest ?");
                           if(int_zero===false){
                             allowed=2;
                           }
          }
      
      bn=0;
      $('input:not(.titlebar_input)').each(function(){
          bn++;
          var this_val=$(this).val().trim();
          
          if(bn<=2){
               if(this_val===""){
              blocked=3;
              $(this).css("border","1px solid crimson");
          }else{
                            $(this).css("border","1px solid lightgrey");

          }
          }
         
      });
       $('#loan_amount').css("border","1px solid crimson !important");
      if(isNaN(loan_amt) || loan_amt===''){
            $('#loan_amount').css("border","1px solid crimson");
      }else{
            $('#loan_amount').css("border","1px solid lightgrey");
      }
      
      var mob_no=$('#mobi_no').val().trim();
      if(mob_no===''){
          blocked=8;
            $('#mobi_no').css("border","1px solid crimson");
      }else{
             $('#mobi_no').css("border","1px solid lightgrey");
      }
      bn=0;
      $('textarea').each(function(){
          bn++;
          if(bn<=1){
                    var this_val=$(this).val().trim();
          
          if(this_val===""){
              blocked=3;
              $(this).css("border","1px solid crimson");
          }else{
                            $(this).css("border","1px solid lightgrey");

          }
          }
    
      });
      
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
      alert('Select valid date ');
        }
      
           if(blocked===0 && allowed==1){
                         $('#stl_form').submit();
  
           }else{
               if(blocked===4){
                    alert("Enter number for amount");
               }else{
                   
                   if(blocked===8){
                        alert("Enter Mobile No");
                   }else
                  {
                      if(allowed===2){
                          
                      }else{
                           alert("Fill in required fields");
                      }
                        
                   }
             
                   
               }
                                   

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
            
            $('textarea').keyup(function (e){
                
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
        </script>
    </body>
</html>