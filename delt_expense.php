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
                       
                     
            $exp_amt=$_REQUEST['exp_amt'];
            $exp_id=$_REQUEST['exp_id'];
            $exp_type=$_REQUEST['exp_tp'];
        
              q("select discription as  mo_reason from extra_expense where exp_id=$exp_id");
         q("select off_exp,ad_exp,rr_exp,bnk_exp,otr_exp,slry_exp,tot_expense as total_expense from extra_expense where fin_id=$fin_id order by exp_id desc limit 1");
         
         $total_expense-=$total_expense;
         
         
                   switch ($exp_type){
                                case "o":
                                   $off_exp-=$exp_amt;
                                   break;
                                case"s":
                                    $slry_exp-=$exp_amt;
                                    break;
                                case "rr";
                                    $rr_exp-=$exp_amt;
                                    break;
                                case "ad";
                                    $ad_exp-=$exp_amt;
                                    break;
                                case "otr":
                                    $otr_exp-=$exp_amt;
                                    break;
                                case "bnk":
                                    $bnk_exp-=$exp_amt;
                                    break;
                                    
                                      
                                    
                            }
         
         q("select remain_bal from amount_status where fin_id=$fin_id order by log_id desc limit 1");
             $remain_bal+=$exp_amt;
             
            q("delete from extra_expense where exp_id=$exp_id");           
                       q("insert into extra_expense (fin_id,off_exp,ad_exp,rr_exp,bnk_exp,otr_exp,slry_exp,tot_expense)values($fin_id,$off_exp,$ad_exp,$rr_exp,$bnk_exp,$otr_exp,$slry_exp,$total_expense)");
                       
               $r= q("insert into  amount_status (money_out,fin_id,remain_bal,delt,my_date,exp_id,mo_reason,date_entry)values($exp_amt,$fin_id,$remain_bal,1,'$date',$exp_id,'$mo_reason','$entry_date')");
               if($r){
                  
                   {
                   
                        echo 'delt';
                   
                   }
               }
