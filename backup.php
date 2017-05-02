<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$c=0;
$rt=  mysqli_query($dbc, "show tables");
 $ins_qury="";
 
 $updated=0;
 
 $fst_qq=  mysqli_query($dbc,"SELECT  `admin_dets`,`amount_status`,`file_size_tbl`,`backup_table`, `customers_hp`, `customers_stl`,`extra_expense`, `extras`,  `finance_accounts`, `hp_asal_logs`, `interest_income`, `investments`, `loan_leagure_stl`, `loan_leagure_hp`, `saami_account`, `stl_asal_logs`, `stl_interest_sts`, `tally`, `users` FROM `backup_table` order by log_id desc limit 1");
 if($fst_qq){
     if(mysqli_num_rows($fst_qq)>0){
     $row_fsq=  mysqli_fetch_array($fst_qq,MYSQLI_ASSOC);
     foreach ($row_fsq as $inds=>$vaals){
         
         $$inds=$vaals;
         
     }    
     }else{
  
         mysqli_query($dbc, "INSERT INTO `backup_table` (`log_id`, `admin_dets`, `amount_status`, `backup_table`, `customers_hp`, `customers_stl`, `extras`, `extra_expense`, `finance_accounts`, `hp_asal_logs`, `interest_income`, `investments`, `loan_leagure_stl`, `loan_leagure_hp`, `saami_account`, `stl_asal_logs`, `stl_interest_sts`, `tally`, `users`, `file_size_tbl`) VALUES (NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');");
         $fst_qq=  mysqli_query($dbc,"SELECT  `admin_dets`,`amount_status`,`file_size_tbl`,`backup_table`, `customers_hp`, `customers_stl`,`extra_expense`, `extras`,  `finance_accounts`, `hp_asal_logs`, `interest_income`, `investments`, `loan_leagure_stl`, `loan_leagure_hp`, `saami_account`, `stl_asal_logs`, `stl_interest_sts`, `tally`, `users` FROM `backup_table` order by log_id desc limit 1");
 if($fst_qq){
     if(mysqli_num_rows($fst_qq)>0){
     $row_fsq=  mysqli_fetch_array($fst_qq,MYSQLI_ASSOC);
     foreach ($row_fsq as $inds=>$vaals){
         
         $$inds=$vaals;
     }
              
     }

 }
     }
     
     
 }
 

 
   $cnt_valss="insert into backup_table (`admin_dets`,`amount_status`, `backup_table`,`customers_hp`, `customers_stl`,`extra_expense`, `extras`, file_size_tbl, `finance_accounts`, `hp_asal_logs`, `interest_income`, `investments`, `loan_leagure_hp`,`loan_leagure_stl`,  `saami_account`, `stl_asal_logs`, `stl_interest_sts`, `tally`, `users`) values (";
while($row1=  mysqli_fetch_array($rt,MYSQLI_NUM)){
    $ins_qury.="";
    $c++;
    $tbl_name=$row1[0];
    $clm_names="";
    $lst_clm="";
    $er=  mysqli_query($dbc, "show columns from $tbl_name");
    $all_clms=array();
    while($row2=  mysqli_fetch_array($er,MYSQLI_NUM)){
        $clm_names.="`".$row2[0]."` ,";
        $lst_clm=$row2[0];
        $all_clms[]=$row2[0];
    }
    $clm_names=  substr($clm_names, 0,  strlen($clm_names)-1);
    
   $p_q=  mysqli_query($dbc, "SHOW KEYS FROM $tbl_name WHERE Key_name = 'PRIMARY'");
    if($p_q){
        $ro3= mysqli_fetch_assoc($p_q);
            $prim_key=$ro3['Column_name'];
        }
    
        $old_cnt=$$tbl_name;
         if($tbl_name=="backup_table"){
       
    $old_cnt=$old_cnt+1;
  
    }
    
  
    $query="select $clm_names from `$tbl_name` where `$prim_key` > $old_cnt ;";
 
 

$run_q =  mysqli_query($dbc,$query); 
   $tot_cur_cnt=mysqli_query($dbc,"select $prim_key from `$tbl_name` order by $prim_key desc limit 1");
   if($tot_cur_cnt){
          $ro66=  mysqli_fetch_array($tot_cur_cnt,MYSQLI_ASSOC);
    $last_id=$ro66[$prim_key];
       $cur_cnt=$last_id;
    if($tbl_name=="backup_table"){
        $cur_cnt=$cur_cnt;
    $old_cnt=$cur_cnt;
    }
 
   }else{
       echo "not  run".  mysqli_error($dbc);
   }
    
   if($run_q){
       
       if($cur_cnt==""){
           $cur_cnt=0;
       }
if(mysqli_num_rows($run_q)>0){
    
   $updated=1;
    $cnt_valss.=$cur_cnt.",";
    
    $ins_qury.="
insert into $tbl_name ($clm_names)values" ;
 
    while ($row5=  mysqli_fetch_array($run_q,MYSQLI_ASSOC)){
  
        $ins_qury.="(";
        foreach ($row5 as $ind=>$val){
       
        if(is_numeric($val)){
        $ins_qury.=mysqli_real_escape_string($dbc,$val).",";
            
        }else{
                    $ins_qury.="'".mysqli_real_escape_string($dbc,$val)."',";

        }
        }

       $ins_qury=substr($ins_qury, 0,  strlen($ins_qury)-1);
     
$ins_qury.="),"; 
    }
    
     
       $ins_qury=substr($ins_qury, 0,  strlen($ins_qury)-1);

   $ins_qury.=";
           ";
    
    


}else{
    $cnt_valss.="$cur_cnt,";
}

   }
    
    
}

$cnt_valss=  substr($cnt_valss,0,  strlen($cnt_valss)-1);

$cnt_valss.=");";
if($updated==1){
   // echo $cnt_valss.'<br>';
    mysqli_query($dbc,$cnt_valss);
 $q_sel_fl=  mysqli_query($dbc,"select file_size as fss,log_id as fid from file_size_tbl");
   if($q_sel_fl  ){
  if(mysqli_num_rows($q_sel_fl)==0){
      $file_cnt=1;
  }else{
      $row_file=  mysqli_fetch_array($q_sel_fl,MYSQLI_ASSOC);
      
      $file_cnt=  mysqli_num_rows($q_sel_fl);
      $old_size=$row_file['fss'];
      
  }  
  
  $file_name="./sql/backup_sql_file".($file_cnt).".sql";
           
   if(!is_file($file_name)){
  
                   $myfile = fopen($file_name, "w") or die("Unable to open file!");

   }
     
   $rrf=  fopen($file_name,"r+");
            $old_cont=  file_get_contents($file_name);
            
           
            
     $new_cont="$old_cont
             $ins_qury;
             $cnt_valss";
     
     
        fwrite($rrf, $new_cont);

     $cur_date=$_SESSION['cur_date'];
     
 $rs= file_put_contents($file_name, $new_cont);
     $file_size=  filesize($file_name);
     
     
     if(mysqli_num_rows($q_sel_fl)==0){
         
         mysqli_query($dbc,"INSERT INTO `file_size_tbl` (`log_id`, `file_name`, `file_size`, `start_date`, `end_date`) VALUES (NULL, '$file_name', '$file_size', '$cur_date', '');");
         
     }else{
         $file_id=$row_file['fid'];
        $fs_in_kb=$file_size/1024;
        $fs_in_kb=  round($fs_in_kb);
        if($fs_in_kb>1000){
         
             $file_name="backup_sql_file".($file_cnt+1).".sql";
            mysqli_query($dbc,"INSERT INTO `file_size_tbl` (`log_id`, `file_name`, `file_size`, `start_date`, `end_date`) VALUES (NULL, '$file_name', '$file_size', '$cur_date', '');");
        
        }
               mysqli_query($dbc,"Update file_size_tbl set mail_uploaded=0 where log_id=$file_id");

     }
     
       

   }else{
     
   }
     
     
    
}
  