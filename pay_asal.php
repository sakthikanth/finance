<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

session_start();
if(empty($_SESSION['fin_id']) || empty($_SESSION['user_id'])) echo "Empty Sess";

$fin_id=$_SESSION['fin_id'];

    $stl_id=$_REQUEST['stl_id'];
    $asal_amt=$_REQUEST['asal_amt'];
    
    require './my.php';
    
    q("select interest_rate as int_rate from customers_stl where fin_id=$fin_id and stl_id=$stl_id");
    
    q("select remaining_asal as remb from loan_leagure_stl where fin_id=$fin_id and stl_id=$stl_id");
    
    if($remb>=$asal_amt)
        {
       
        
    
         $new_remain_asal=$remb-$asal_amt;
    $new_interest=$new_remain_asal*($int_rate/100);
    
    q("update loan_leagure_stl set remaining_asal=$new_remain_asal,current_interest=$new_interest where fin_id=$fin_id and stl_id=$stl_id");
    
    q("select remain_bal from amount_status where fin_id=$fin_id order by log_id desc limit 1");
    
    q("select outer_asal_amt  from stl_asal_logs where fin_id=$fin_id order by log_id desc limit 1");
    
    $outer_asal_amt-=$asal_amt;
    
    
    $remain_main_bal=$remain_bal;
    $new_remain_bal=$remain_main_bal+$asal_amt;
    
           $year= $_SESSION['cur_year'];
                $month= $_SESSION['cur_month'];
                $day=$_SESSION['cur_day'];
                
                $hr=date('g');
                $min=date('i');
                $noon=date('A');
                
                $date=$_SESSION['cur_date']." $hr:$min $noon";
                $entries_date=$_SESSION['show_date'];
               
                
    q("insert into amount_status (fin_id,cust_id,loan_type,remain_bal,asal_in,my_date,date_entry)"
            . "values($fin_id,$stl_id,'STL',$new_remain_bal,$asal_amt,'$date','$entries_date')");
    
    
     q("INSERT INTO `stl_asal_logs` (`log_id`, `stl_id`, `fin_id`, `asal_in`, `asal_out`, `date`, `tot_rem_asal`,outer_asal_amt)"
             . " VALUES (NULL, '$stl_id', '$fin_id', $asal_amt, 0, '$date', $new_remain_asal,$outer_asal_amt);");
             
             
  
    echo "Pay Asal ( Remaining Rs.".$new_remain_asal." )";
 
    }else{
        echo "Not valid";
    }
    
      