<?php
            session_start();
            
            if(empty($_SESSION['fin_id']) || empty($_SESSION['user_id'])) header ("location:home.php");
            
            $fin_id=$_SESSION['fin_id'];
            require './my.php';
            
            $asal_amt=$_REQUEST['asal_amt'];
            $log_id=$_REQUEST['log_id'];
            $stl_id=$_REQUEST['stl_id'];
            
               $year= $_SESSION['cur_year'];
                $month= $_SESSION['cur_month'];
                $day=$_SESSION['cur_day'];
                
                   $dt = new DateTime('now', new DateTimezone('Asia/Kolkata'));
                $hr=$dt->format('g');
                $min=$dt->format('i');
                $noon=$dt->format('A');
                
                $date=$_SESSION['cur_date']." $hr:$min $noon";
                 $entry_date=$_SESSION['show_date'];
         
          q("select remain_bal from amount_status where fin_id=$fin_id order by log_id desc limit 1");
                     q("select remaining_asal as old_rem from loan_leagure_stl where fin_id=$fin_id and stl_id=$stl_id");
 
                           q("select interest_rate from customers_stl where fin_id=$fin_id and stl_id=$stl_id");
                          
                           $new_asal=$old_rem+$asal_amt;
                           $remain_bal-=$asal_amt;
              $r= q("insert into  amount_status (asal_out,fin_id,cust_id,remain_bal,loan_type,delt,my_date,date_entry)values($asal_amt,$fin_id,$stl_id,$remain_bal,'STL',1,'$date','$entry_date')");
                         
                           if($r){
                               $ni=$new_asal*($interest_rate/100);
                               
                               $et=q("update loan_leagure_stl set remaining_asal=$new_asal,current_interest=$ni where fin_id=$fin_id and stl_id=$stl_id");
                               if($et){
                                   q("delete from stl_asal_logs where log_id=$log_id ");
                                   if($new_asal>0){
                            q("update customers_stl set person_status=1 where fin_id=$fin_id and stl_id=$stl_id");
                            
                        }
                                   echo "upt";
                               }
                           }
                           
                           
                           
                           ?>