<?php
session_start();
if(empty($_SESSION['fin_id']) || empty($_SESSION['user_id'])) echo "Empty Sess";

$fin_id=$_SESSION['fin_id'];

    $hp_id=$_REQUEST['hp_id'];
    $int_month=$_REQUEST['int_month'];
    $int_amt=$_REQUEST['int_amount'];
    
    if($int_amt>0){
       require './my.php';
    
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

   q("select next_int_date as nxd,current_interest,pending_sts,paid_status from loan_leagure_hp where fin_id=$fin_id and hp_id=$hp_id");
   
   $day_int_month=30*$int_month;
 
                    $pre_day=  substr($nxd, strpos($nxd, "-")+4,  2);
                    $pre_mnth=substr($nxd, strpos($nxd, "-")+1,  2);
                    $pre_tyear=  substr($nxd, 0,4);
                    
                    if($paid_status==2){
                    $fin_day= "$pre_tyear-$pre_mnth-$pre_day";
                        
                    }else{
                        
                    $fin_day=  calc_next_date($day_int_month, $pre_day, $pre_mnth, $pre_tyear);

                    }
                    
                     $year= $_SESSION['cur_year'];
                $month= $_SESSION['cur_month'];
                $day=$_SESSION['cur_day'];
                
                $hr=date('g');
                $min=date('i');
                $noon=date('A');
                
                $date=$_SESSION['cur_date']." $hr:$min $noon";
                $cur_date="$year$month$day";
               
                $cur_date=$cur_date-1+1;
                
               
                    $int_day=  substr($fin_day, strpos($fin_day, "-")+4,  2);
                    $int_mnth=substr($fin_day, strpos($fin_day, "-")+1,  2);
                    $int_tyear=  substr($fin_day, 0,4);
                
                    
                $int_date="$int_tyear$int_mnth$int_day";
                $int_date=$int_date-1+1;
                
                
                if($int_date>=$cur_date){
            
                    echo "Paid Completely";
                    
                    q("update loan_leagure_hp set  paid_status=1,pending_sts=1,next_int_date='$fin_day' where hp_id=$hp_id and fin_id=$fin_id");
                    
                    
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
                    
                    echo "Paid for $int_month months";
                                        q("update loan_leagure_hp set paid_status=1,pending_sts=$ps,next_int_date='$fin_day' where hp_id=$hp_id and fin_id=$fin_id");

                }
                q("insert into interest_income (fin_id,acc_type,cus_id,int_amount,date)values($fin_id,'HP',$hp_id,$int_amt,'$cur_date')");
                
                q("select remain_bal from amount_status order by log_id desc limit 1");
                
                q("INSERT INTO `amount_status` (`log_id`, `date_entry`, `asal_in`, `interest`, `remain_bal`, `fin_id`, `cust_id`, `loan_type`, `my_date`, `invest_id`, `invest_amt`, `asal_out`)"
                        . " VALUES (NULL, '$date', '', '$int_amt', '$remain_bal', '$fin_id', '$hp_id', 'HP', '$date', '', '', '');");
                    
                 
   



  
    }else{
        echo "Already Paid";
    }
   
    ?>