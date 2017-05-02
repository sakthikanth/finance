<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

session_start();
if(empty($_SESSION['fin_id']) || empty($_SESSION['user_id'])) echo "Empty Sess";

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
                     

$fin_id=$_SESSION['fin_id'];

    $hp_id=$_REQUEST['hp_id'];
    $int_amount=$_REQUEST['int_amount'];
    $due_month=$_REQUEST['asal_month'];
    $tot_amount=$_REQUEST['tot_amount'];
    $asal_amt=$_REQUEST['asal_amt'];
  
    
    
    require './my.php';
    
    
    q("select remaining_asal,next_due_date,due_paid_cnt,current_interest,diff_amount from loan_leagure_hp where fin_id=$fin_id and hp_id=$hp_id");
    
    
   
        {
            $commision=0;
        
           
      
         $paid_int_amount=$due_month*$current_interest;
         if($int_amount<$paid_int_amount){
             $paid_int_amount=$int_amount;
         }else{
                   $commision=$int_amount-$paid_int_amount;
     
         }
         
         $int_p_asal=$int_amount+$asal_amt;
         $pay_chk=1;
         if($tot_amount>$int_p_asal){
             $diff_amts=$tot_amount-$int_p_asal;
             $commision+=$diff_amts;
              
         }else{
             
             if($tot_amount>=$asal_amt){
                    if($tot_amount<$int_p_asal){
                 $diff_amts=$int_p_asal-$tot_amount;
                 if($commision>=$diff_amts){
                 $commision-=$diff_amts;
                     
                 }else{
                     $paid_int_amount-=$diff_amts;
                 }
                 
             }
             
             }else{
                  $pay_chk=0;
             }
          
         }
       
           if($pay_chk==1){
              
        $paid_month=$due_month+$due_paid_cnt;
        
         $new_remain_asal=$remaining_asal-$asal_amt;
         $day_a_mnth=30*$due_month;
         
                     $pre_day=  substr($next_due_date, strpos($next_due_date, "-")+4,  2);
                    $pre_mnth=substr($next_due_date, strpos($next_due_date, "-")+1,  2);
                    $pre_tyear=  substr($next_due_date, 0,4);
                    
                    
                          $year= $_SESSION['cur_year'];
                $month= $_SESSION['cur_month'];
                $day=$_SESSION['cur_day'];
                
                $hr=date('g');
                $min=date('i');
                $noon=  date('A');
                $pre_day=$pre_day-1+1;
                $pre_mnth=$pre_mnth-1+1;
                $pre_tyear=$pre_tyear-1+1;
                
                                $date=$_SESSION['cur_date']." $hr:$min $noon";
                                $entries_date=$_SESSION['show_date'];

                         $new_next_asl_dt=  calc_next_date($day_a_mnth, $pre_day, $pre_mnth, $pre_tyear);

                
                  $psd_day=  substr($new_next_asl_dt, strpos($new_next_asl_dt, "-")+4,  2);
                    $psd_mnth=substr($new_next_asl_dt, strpos($new_next_asl_dt, "-")+1,  2);
                    $psd_tyear=  substr($new_next_asl_dt, 0,4);
                    
                
                $cur_date="$year$month$date";
                $paid_asal_date="$psd_tyear$psd_mnth$psd_day";
                
                if($cur_date<=$paid_asal_date){
                    $pend_sts=1;
                }else{
                    $dt1=  date_create($new_next_asl_dt);
                    $dt2=  date_create("$year-$month-$day");
                
                    $diff=  date_diff($dt2,$dt1);
                    $diff_val=$diff->format("%a");
                    if($diff_val>30){
                        $pend_sts=3;
                    }else{
                        $pend_sts=2;
                    }
                }
                
     
         
         
    
    q("select remain_bal from amount_status where fin_id=$fin_id order by log_id desc limit 1");
    $remain_main_bal=$remain_bal;
    $new_remain_bal=$remain_main_bal+$asal_amt+$paid_int_amount;
    
    
        q("update loan_leagure_hp set remaining_asal=$new_remain_asal,due_paid_cnt=$paid_month,next_due_date='$new_next_asl_dt',due_pend_sts=$pend_sts where fin_id=$fin_id and hp_id=$hp_id");

   q("select outer_asal_amt from hp_asal_logs where fin_id=$fin_id order by log_id desc limit 1");
   
   $new_outer_asal=$outer_asal_amt-$asal_amt;
   
   
   q("select total_interest as ti_amount from interest_income where fin_id=$fin_id order by log_id desc limit 1");
   
    
    $ti_amount+=$current_interest*$due_month;
         $last_id=0;
                   if($commision>0){
                         q("select tot_comm as tot_commison from extras where fin_id=$fin_id order by log_id desc limit 1");
                       
                       $tot_commison+=$commision;
                       
                       q("insert into extras (comm_amount,comm_word,fin_id,cus_id,date,tot_comm,acc_type)"
                               . "      values($commision,'Commision',$fin_id,$hp_id,'$date',$tot_commison,'HP')");
                
                     q("select log_id as lid from extras where fin_id=$fin_id order by log_id desc limit 1 ");
                         if($lid!=NULL){
                     $last_id=$lid;
                         
                     }   
                        
                     }
                
     q("INSERT INTO `hp_asal_logs` (`log_id`, `hp_id`, `fin_id`, `asal_in`, `asal_out`, `date`, `tot_rem_asal`,`int_amount`,`outer_asal_amt`,`due_months`,`due_duration`,comm_id) "
             . "                                VALUES (NULL, '$hp_id', '$fin_id', $asal_amt, 0, '$date', $new_remain_asal,$paid_int_amount,$new_outer_asal,$due_month,'$new_next_asl_dt',$last_id);");
                
                q("insert into interest_income (fin_id,acc_type,cus_id,int_amount,date,total_interest)"
                                        . "values($fin_id,'HP',$hp_id,$paid_int_amount,'$date',$ti_amount)");
                
                
              
           
              
q("insert into amount_status (fin_id,cust_id,loan_type,remain_bal,asal_in,my_date,interest,date_entry)"
            . "values($fin_id,$hp_id,'HP',$new_remain_bal,$asal_amt,'$date',$paid_int_amount,'$entries_date')");
    
    
    echo 'Paid';
    
  
           }   
                else{
                    echo "Not";
                }
    
    }
    
      