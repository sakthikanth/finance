<?php
session_start();
if(empty($_SESSION['fin_id']) || empty($_SESSION['user_id'])) echo "Empty Sess";

$fin_id=$_SESSION['fin_id'];

    $stl_id=$_REQUEST['stl_id'];
    $remv_month=$_REQUEST['remv_months'];
    $int_amt=$_REQUEST['int_amount'];
    $close_acc=$_REQUEST['close_acc'];
    $comm_amt=$_REQUEST['comm_amt'];
    
        $rem_mnth_arr = $remv_month;
    
    if($int_amt>=0){
        
       require './my.php';
    
             
                    $year= $_SESSION['cur_year'];
                $month= $_SESSION['cur_month'];
                $day=$_SESSION['cur_day'];
                
                $hr=date('g');
                $min=date('i');
                $noon=date('A');
                
                $date=$_SESSION['cur_date']." $hr:$min $noon";
                
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

   q("select next_int_date as nxd,current_interest,pending_sts,paid_status,pend_month from loan_leagure_stl where fin_id=$fin_id and stl_id=$stl_id");
   
   $new_pend_month=$pend_month;
    $next_mnth=$remv_month;
   if($close_acc==1){
       q("select int_amount as pend_im from stl_intrerest_sts where fin_id=$fin_id and stl_id=$stl_id");
       
       $tar_mnth=count($pend_im);
       $new_pend_month-=count($pend_im);
   }else{
       
       q("select pend_month as pmnth from loan_leagure_stl where fin_id=$fin_id and stl_id=$stl_id");
       if($remv_month>=$pmnth && $pmnth!=0){
           $tar_mnth=$pmnth;
          
       }else{
           $tar_mnth=$remv_month;
       }
       
       
       $new_pend_month-=$tar_mnth;
   }
   
                       q("select remaining_asal as remb from  loan_leagure_stl where fin_id=$fin_id and stl_id=$stl_id");

   $day_int_month=30*$next_mnth;
   
   
                    $pre_day=  substr($nxd, strpos($nxd, "-")+4,  2);
                    $pre_mnth=substr($nxd, strpos($nxd, "-")+1,  2);
                    $pre_tyear=  substr($nxd, 0,4);
                    
                    $pre_day=$pre_day-1+1;
                    $pre_mnth=$pre_mnth-1+1;
                    $pre_tyear=$pre_tyear-1+1;
                    
                    
             $fin_day=  calc_next_date($day_int_month, $pre_day, $pre_mnth, $pre_tyear);
              
                $cur_date="$year$month$day";
               
                $cur_date=$cur_date-1+1;
                
               
                    $int_day=  substr($fin_day, strpos($fin_day, "-")+4,  2);
                    $int_mnth=substr($fin_day, strpos($fin_day, "-")+1,  2);
                    $int_tyear=  substr($fin_day, 0,4);
                
                    
                $int_date="$int_tyear$int_mnth$int_day";
        
                $int_date=$int_date-1+1;
                
                  if($close_acc==1){
                    q("delete from stl_interest_sts where fin_id=$fin_id and stl_id=$stl_id");
                     $pay_dtot=0;
                   
                }else{
                   
                 q("delete from stl_interest_sts where fin_id=$fin_id and stl_id=$stl_id limit $remv_month");
  
                
                }
                
                if($int_date>=$cur_date){
            
                    echo "Paid Completely";
                
                    q("update loan_leagure_stl set next_int_date='$fin_day',paid_status=1,pend_month=$new_pend_month where stl_id=$stl_id and fin_id=$fin_id");
                    
                    
                }else{
                   
                    
                    $cur_date="$year-$month-$day";
                    
                    $date1=  date_create($cur_date);
                    $date2=date_create($fin_day);
                    $diff=  date_diff($date1,$date2);
                    $diff_day=$diff->format("%a");
                    if($diff_day>30){
                        $ps=3;
                    }else{
                        $ps=2;
                    }
                    
                    echo "Paid for ".$remv_month." months";
                    if($close_acc==1){
                         
                    if($remb==0){
                        $p_sts=1;
                    }else{
                        $p_sts=2;
                    }
                    }else{
                     $p_sts=2;   
                    }
                    
               q("update loan_leagure_stl set next_int_date='$fin_day',paid_status=$p_sts,pend_month=$new_pend_month where stl_id=$stl_id and fin_id=$fin_id");

                }
                
                if($comm_amt>0){
                         q("select tot_comm as tot_commison from extras where fin_id=$fin_id order by log_id desc limit 1");
                       
                       $tot_commison+=$comm_amt;
                       
                       q("insert into extras (comm_amount,comm_word,fin_id,cus_id,date,tot_comm,acc_type)"
                               . "      values($comm_amt,'Commision',$fin_id,$stl_id,'$date',$tot_commison,'STL')");
                
                     
                }
                
                $tot_his_paid_int=0;
                
              
               $entries_date=$_SESSION['show_date'];
               
                
                
                q("select total_interest from interest_income where fin_id=$fin_id order by log_id desc limit 1");
                
                $total_interest+=$int_amt;
                   $last_id=0;
                   if($comm_amt>0){
                     q("select log_id as lid from extras where fin_id=$fin_id order by log_id desc limit 1 ");
                     if($lid!=NULL){
                     $last_id=$lid;
                         
                     }   
                       
                   }
                        
                q("insert into interest_income (fin_id,acc_type,cus_id,int_amount,date,total_interest,int_months,int_duration,comm_id)values($fin_id,'STL',$stl_id,$int_amt,'$date',$total_interest,$next_mnth,'$fin_day',$last_id)");
                
                q("select remain_bal from amount_status where fin_id=$fin_id order by log_id desc limit 1");
                $remain_bal+=$int_amt;
                q("INSERT INTO `amount_status` (`log_id`, `date_entry`, `asal_in`, `interest`, `remain_bal`, `fin_id`, `cust_id`, `loan_type`, `my_date`, `invest_id`, `invest_amt`, `asal_out`)"
                        . " VALUES (NULL, '$entries_date', '', '$int_amt', '$remain_bal', '$fin_id', '$stl_id', 'STL', '$date', '', '', '');");
                    
                 
   
  
    }else{
        echo "Enter valid Amount";
    }
   
    ?>