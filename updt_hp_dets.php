<?php
            session_start();
            
            if(empty($_SESSION['fin_id'])) header ("location:home.php");
            
            $fin_id=$_SESSION['fin_id'];
            require './my.php';
 
                $year= $_SESSION['cur_year'];
                $month= $_SESSION['cur_month'];
                $day=$_SESSION['cur_day'];
             
               $d_t = new DateTime('now', new DateTimezone('Asia/Kolkata'));
                
                $hr=$d_t->format('g');
                $min=$d_t->format('i');
                $noon=$d_t->format('A');
                
                  
                $date=$_SESSION['cur_date']." $hr:$min $noon";
                        foreach($_REQUEST as $req=>$val){
                          $$req=mysqli_real_escape_string($dbc,$val);
                        
                       }
                        
                       $entries_date=$_SESSION['show_date'];
                       
                            $loan_day=$_REQUEST['day_loan'];
                             $loan_mnth=$_REQUEST['day_month'];
                             $loan_year=$_REQUEST['day_year'];
                             
                             if($loan_day<=9){
                                 $loan_day="0".$loan_day;
                             }
                             if($loan_mnth<=9){
                                 $loan_mnth="0".$loan_mnth;
                             }
                             
                              $new_loan_date="$loan_day-$loan_mnth-$loan_year";
                            
                              
                       if(!empty($new_loan_amt) && !empty($int_amount) ){
                           q("select remain_bal from amount_status where fin_id=$fin_id order by log_id desc limit 1");
                           
                           q("select remaining_asal as old_rem from loan_leagure_hp where fin_id=$fin_id and hp_id=$hp_id");
                           
                           q("select tot_rem_asal from hp_asal_logs where fin_id=$fin_id order by log_id desc limit 1");
                           
                           q("select outer_asal_amt from hp_asal_logs where fin_id=$fin_id order by log_id limit 1");
                           if($rem_asal>$old_rem){
                               
                               $diff_amt=$rem_asal-$old_rem;
                               $remain_bal-=$diff_amt;
                               $asal_wrd="asal_out";
                               $tot_rem_asal+=$diff_amt;
                               $outer_asal_amt+=$diff_amt;
                               
                               
                               q("insert into hp_asal_logs (fin_id,hp_id,asal_out,tot_rem_asal,outer_asal_amt)values($fin_id,$hp_id,$diff_amt,$tot_rem_asal,$outer_asal_amt)");
                               
                           }
                           if($rem_asal<$old_rem){
                               
                               $diff_amt=$old_rem-$rem_asal;
                               $remain_bal+=$diff_amt;
                               $asal_wrd="asal_in";
                                $tot_rem_asal-=$diff_amt;
                               $outer_asal_amt-=$diff_amt;
                               
                               
                               q("insert into hp_asal_logs (fin_id,hp_id,asal_in,tot_rem_asal,outer_asal_amt)values($fin_id,$hp_id,$diff_amt,$tot_rem_asal,$outer_asal_amt)");
                              
                           }
                        
                           if($rem_asal!=$old_rem){
                         {
                                       $rs=q("update customers_hp set  `name`='$p_name', `age`='$p_age', `occupation`='$p_occup', `father_name`='$p_fname', `perm_add`='$p_addr', `mob_no`='$p_mob', `asset_dets`='$p_asset', `j_person_name`='$j_name', `j_age`='$j_age', `j_fname`='$j_fname', `j_address`='$j_addr', `j_mob_no`='$j_mob', `j_assets`='$j_asset', `interest_rate`=$new_int_rate,   `loan_amount`= $new_loan_amt , `reg_date`='$date', `j_occup`='$j_occup', `nick_name`='$p_nname', `ip_addr`='".$_SERVER['REMOTE_ADDR']."',int_amount=$int_amount,due_months=$due_months,users_id=$cust_of ,reg_date='$new_loan_date' WHERE fin_id=$fin_id and hp_id=$hp_id");
                                        if($rs){
                                                                     $rt=  q("update loan_leagure_hp set remaining_asal=$rem_asal,current_interest=$int_amount where fin_id=$fin_id");
                                                                        if($rt){
                          $r= q("insert into  amount_status ($asal_wrd,fin_id,cust_id,remain_bal,loan_type,delt,my_date,date_entry)values($diff_amt,$fin_id,$hp_id,$remain_bal,'hp',1,'$date','$entries_date')");

                                                                            echo "upt";
                                                                        }
                                        }
                         }   
                           }else{
                         
         $rs=q("update customers_hp set  `name`='$p_name', `age`='$p_age', `occupation`='$p_occup', `father_name`='$p_fname', `perm_add`='$p_addr', `mob_no`='$p_mob', `asset_dets`='$p_asset', `j_person_name`='$j_name', `j_age`='$j_age', `j_fname`='$j_fname', `j_address`='$j_addr', `j_mob_no`='$j_mob', `j_assets`='$j_asset', `j_occup`='$j_occup', `nick_name`='$p_nname', `ip_addr`='".$_SERVER['REMOTE_ADDR']."',interest_rate=$new_int_rate,due_months=$due_months,users_id=$cust_of,reg_date='$new_loan_date' WHERE fin_id=$fin_id and hp_id=$hp_id");
 if($rs){
               
                                                                            echo "upt";
                                    }
                           }
                           
                           
                         
                       
                           
                         
                       }else{
                           echo "Empty";
                       }
                       ?>