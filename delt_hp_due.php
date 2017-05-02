<?php
            session_start();
            
            if(empty($_SESSION['fin_id']) || empty($_SESSION['user_id'])) header ("location:home.php");
                   $year= $_SESSION['cur_year'];
                $month= $_SESSION['cur_month'];
                $day=$_SESSION['cur_day'];
                
               $d_t = new DateTime('now', new DateTimezone('Asia/Kolkata'));
                $hr=$d_t->format('g');
                $min=$d_t->format('i');
                $noon=$d_t->format('A');
                
                $date=$_SESSION['cur_date']." $hr:$min $noon";
                $entry_date=$_SESSION['show_date'];
            $fin_id=$_SESSION['fin_id'];
            require './my.php';
             function calc_prev_date($cnt,$day,$month,$year){
            
                 $diff_cnt=0;
              
                 
                if($cnt>$day){
                     
                     $diff_cnt=$day;
                     
                 }
                 if($day>=$cnt){
                   
                    $diff_cnt=$day-$cnt;
                    $cnt=0;
                 }
                 while ($diff_cnt<$cnt || $diff_cnt==0){
                
                      $month-=1;
                   if($month<=0){
                          $month=12;
                          $year-=1;
                      }
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
               
                $diff_cnt+=$month_days;
                        
                if($month<=0){
                    $year-=1;
                    $month=12;
                }
                 }
              
                 $mean=$diff_cnt-$cnt;
                 if($mean==0){
                     $day=1;
                 }else{
                     $day=$mean;
                 }
                 
                 if($day<=9){
                     $day="0".$day;
                 }
                 if($month<=9){
                     $month="0".$month;
                 }
                 if($year<=9){
                     $year="0".$year;
                 }
                 
                 return "$year-$month-$day";
                 
             }
                      
                     
            $int_amt=$_REQUEST['inte'];
            $log_id=$_REQUEST['log_id'];
            $hp_id=$_REQUEST['hp_id'];
            $due_month=$_REQUEST['mnth'];
            $asal=$_REQUEST['asal'];
            $comm_id=$_REQUEST['comm_id'];
            
        
            $month_days=30*$due_month;
            
                      q("select next_due_date from loan_leagure_hp where fin_id=$fin_id and hp_id=$hp_id");
            
                 $nxd_day= substr($next_due_date, strpos($next_due_date, "-")+4,  2);
                       $nxd_mnth=substr($next_due_date, strpos($next_due_date, "-")+1,  2);
                    $nxd_tyear=  substr($next_due_date, 0,4);
                    
                    $nxd_day=$nxd_day-1+1;
                    $nxd_mnth=$nxd_mnth-1+1;
                    $nxd_tyear=$nxd_tyear-1+1;
            
            $pre_due_date=  calc_prev_date($month_days, $nxd_day, $nxd_mnth, $nxd_tyear);
            
          
                
              
         
          q("select remain_bal from amount_status where fin_id=$fin_id order by log_id desc limit 1");
          q("select total_interest from interest_income where fin_id=$fin_id order by log_id desc limit 1");
          $total_interest-=$int_amt;
          $remain_bal-=($int_amt+$asal);
          $due_amt=$int_amt+$asal;
         
           $del=q("delete from hp_asal_logs where log_id=$log_id");        
           if($del){
             $r= q("insert into  amount_status (asal_in,fin_id,cust_id,remain_bal,loan_type,delt,my_date,date_entry)values($due_amt,$fin_id,$hp_id,$remain_bal,'HP',1,'$date','$entry_date')");
               if($r){
                  
                                 q("select comm_amount from extras where log_id=$comm_id");

               if($comm_amount>0){
                   
                     q("select tot_comm as tc_amt from extras where fin_id=$fin_id order by log_id desc limit 1");
                   $tc_amt-=$comm_amount;
                   
                 
                   q("insert into extras (tot_comm,date,fin_id,acc_type,comm_word,comm_amount,cus_id)values($tc_amt,'$date',$fin_id,'HP','Deleted Commision',$comm_amount,$hp_id)");
                   
               }    
                   q("select remaining_asal from loan_leagure_hp where fin_id=$fin_id and hp_id=$hp_id");
                   
                   $remaining_asal+=$asal; 
                                
                       q("insert into interest_income (fin_id,total_interest)values($fin_id,$total_interest)");
                       
                       q("select due_paid_cnt from loan_leagure_hp where fin_id=$fin_id and hp_id=$hp_id");
                       $due_paid_cnt-=$due_month;
                       
                    $e=q("update loan_leagure_hp set remaining_asal=$remaining_asal,next_due_date='$pre_due_date',due_paid_cnt=$due_paid_cnt where fin_id=$fin_id and hp_id=$hp_id");
                    if($e){
                        if($remaining_asal>0){
                            
                        q("update customers_hp set person_status=1 where fin_id=$fin_id and hp_id=$hp_id");
                            
                        }
                        echo "delt";
                    }
                   
               }

           }
