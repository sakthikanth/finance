<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require './my_sqlc.php';
$c=0;
$rt=  mysqli_query($dbc, "show tables");
 
   //$cnt_valss="insert into backup_table (`admin_dets`,`amount_status`, `backup_table`,`customers_hp`, `customers_stl`,`extra_expense`, `extras`, file_size_tbl, `finance_accounts`, `hp_asal_logs`, `interest_income`, `investments`, `loan_leagure_hp`,`loan_leagure_stl`,  `saami_account`, `stl_asal_logs`, `stl_interest_sts`, `tally`, `users`) values (";
while($row1=  mysqli_fetch_array($rt,MYSQLI_NUM)){
     $tbl_name=$row1[0];
     
    $er=  mysqli_query($dbc, "delete from $tbl_name where fin_id=4");
    
    if($er){
        echo "Deleted";
    }else{
        echo "not deleted". mysqli_error($dbc);
    }
    
}

