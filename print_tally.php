<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

            session_start();
            
            if(empty($_SESSION['user_id'])) header("location:index.php");
                        if(empty($_SESSION['fin_id'])) header("location:fin_accounts.php");

            $fin_id=$_SESSION['fin_id'];
            
            
            require './my.php';
         

           $q=q("select finance_name as fn from finance_accounts where fin_id=$fin_id");
            if($q){
                if($fn!=NULL){
                    $_SESSION['fin_id']=$fin_id;
                }else{
                    header("location:index.php");
                }
            }
                  function convert_rup_format($rup_val){
        
                                       $amt_len=$rup_val+"";
            
                $b=0;
                $amt_conv="";
                $m=0;
                        //echo $amt_len;
                for($n=strlen($amt_len)-1;$n>=0;$n--){
                    $b++;
                    $amt_conv.=substr($amt_len,$n,1);
                  
                  
                    if($b>=3){
                       $amt_conv.=",";
                       $b=0;
                       $m=1;
                       
                    }
                    if($b>=2 && $m==1){
                        $amt_conv.=",";
                        $b=0;
                   
                    }
                   
                }
              $conv_amt= strrev($amt_conv);
              
              if(is_numeric(strpos($conv_amt, ",")) && strpos($conv_amt, ",")==0){
                                $conv_amt= substr($conv_amt, 1, strlen($conv_amt));

              }
                       

              return $conv_amt;

           }
     
            ?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
        <link rel="stylesheet" href="css/bootstrap.min.css" />
        <link rel="stylesheet" href="css/header.css" />
        <link rel="stylesheet" href="css/stl_accounts.css" />
        <link rel="stylesheet" href="css/homepage.css" />
        
        <script src="js/jquery.js" ></script>
        <script src="js/bootstrap.min.js"></script>
        <title>Velmurugan Finance</title>
        <style>
            td{
  font-size: 16px;
  color: maroon;
  
}
        </style>
    </head>
    <body><small><?php
     $year= $_SESSION['cur_year'];
                $month= $_SESSION['cur_month'];
                $day=$_SESSION['cur_day'];
                
           
              
               $d_t = new DateTime('now', new DateTimezone('Asia/Kolkata'));
                
                $hr=$d_t->format('g');
                $min=$d_t->format('i');
                $noon=$d_t->format('A');
                
                echo "$day-$month-$year $hr:$min $noon";
    ?></small>
        <div class="container-fluid">
            <h1 style="text-align: center">Velmurugan Finance</h1>
            <table class="table">
                <tr>
                    <th>
                        Finance
                    </th>
                    <td>
                        <?php echo ucfirst($fn); ?>
                    </td>
                </tr>
                <tr>
                    <th>
                        Date
                    </th>
                    <td>
                        <?php 
                             
                        if(isset($_REQUEST['log_id'])){
                            $tar_id=$_REQUEST['log_id'];
                        }else{
                            header("location:home.php");
                        }
                        q("SELECT date_entry as de FROM `tally` WHERE log_id=$tar_id");
                        
           $rec_day= substr($de, strpos($de, "-")+4,  2);
                       $rec_mnth=substr($de, strpos($de, "-")+1,  2);
                    $rec_year=  substr($de, 0,4);
               
                
                echo "$rec_day-$rec_mnth-$rec_year";       
                ?>
                    </td>
               

                </tr>
            </table>
            <div class="PG_content_holder">
                <div class="PG_ch_inner">
                    <table class="table table-striped table-responsive">
                        <thead>
                                
                       
                        <th>
                            Date
                        </th>
                        <th>
                           Category
                        </th>   
                        <th>
                            Cash In
                        </th>
                        <th>
                           Cash Out
                        </th>
                        <th>
                            Remaining
                        </th>
                        
                        
                        </thead>
                       
                            <?php
                              
                            if(isset($_REQUEST['pagi'])){
                                $pagi_word="and log_id <=".$_REQUEST['pagi'].' ';
                                $pagi_recv=$_REQUEST['pagi'];
                            }else
                            {
                                $pagi_word="";
                                 $pagi_recv=0;

                            }
                            
                            

                           q("SELECT `off_exp`, `slry_exp`, `rr_exp`, `ad_exp`, `otr_exp`, `bnk_exp`,`log_id`, `date_entry`, `invest_amt`, `interest_amt`, `money_out`, `mo_reason`, `stl_asal_out`, `hp_asal_out`, `remaining_bal`, `dbk_cnt`, `tally_amt`, `tot_main`,log_id FROM `tally` where log_id=$tar_id "); 
                       
                            for($n=0;$n<count($invest_amt);$n++){
                                if(count($invest_amt)==1){
                                   
                                    $show_date=$date_entry;
                                    $invest_amount=$invest_amt;
                                    $interest_amount=$interest_amt;
                                    $exp_amounts=$money_out;
                                    $stl_asal_out_amt=$stl_asal_out;
                                    $hp_asal_out_amt=$hp_asal_out;
                                    $remaining_bal_amt=$remaining_bal;
                                    $tally_amount=$tally_amt;
                                    $total_main_amt=$tot_main;
                                    
                                    $offc_exp=$off_exp;
                                    $salry_exp=$slry_exp;
                                    $room_r_exp=$rr_exp;
                                    $adv_exp=$ad_exp;
                                    $oter_exp=$otr_exp;
                                    $bnks_exp=$bnk_exp;
                                    
                                    $logs_id=$log_id;
                                    
                                    
                                    $chk_date=substr($show_date,0,  strpos($show_date, " "));
                                    
                                    
                                }else{
                                          $show_date=$date_entry[$n];
                                    $invest_amount=$invest_amt[$n];
                                    $interest_amount=$interest_amt[$n];
                                    $exp_amounts=$money_out[$n];
                                    $stl_asal_out_amt=$stl_asal_out[$n];
                                    $hp_asal_out_amt=$hp_asal_out[$n];
                                    $remaining_bal_amt=$remaining_bal[$n];
                                    $tally_amount=$tally_amt[$n];
                                    $total_main_amt=$tot_main[$n];      
                                    
                                     $offc_exp=$off_exp[$n];
                                    $salry_exp=$slry_exp[$n];
                                    $room_r_exp=$rr_exp[$n];
                                    $adv_exp=$ad_exp[$n];
                                    $oter_exp=$otr_exp[$n];
                                    $bnks_exp=$bnk_exp[$n];
                                    $logs_id=$log_id[$n];
                                     $chk_date=substr($show_date[$n],0,  strpos($show_date[$n], " "));
                                    
                                }
                              
                            
                                
                               
                                
                                ?>
                        <tbody>
                            <tr >
                                <td rowspan="12">
                                    <?php echo $rec_day.'-'.$rec_mnth.'-'.$rec_year ?>
                                </td>
                                <td>
                                  Saami Kanaku
                                </td>
                                <td>
                                   Rs. <?php 
                                   $si=0;
                                    q("select invest_amount as si from saami_account where fin_id=$fin_id");
                                    echo convert_rup_format($si);  ?> /-
                                </td>
                                <td>
                                    
                                </td>
                                <td>
                                    
                                </td>
                            </tr>
                            <tr>
                                <td>
                                 Investment
                                </td>
                                <td>
                                   Rs <?php echo convert_rup_format($invest_amount);  ?> /-
                                </td>
                                <td>
                                    
                                </td>
                                <td>
                                    
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Interest Income
                                </td>
                                <td>
                                    Rs. <?php echo  convert_rup_format($interest_amount); ?> /-
                                </td>
                                <td>
                                    
                                </td>
                                <td>
                                    
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    STL Out
                                </td>
                                <td>
                                    
                                </td>
                                <td>
                                    Rs. <?php echo  convert_rup_format($stl_asal_out_amt); ?> /-
                                </td>
                                <td>
                                    
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    HP Out
                                </td>
                                <td>
                                    
                                </td>
                                <td>
                                    Rs. <?php echo  convert_rup_format($hp_asal_out_amt); ?> /-
                                </td>
                                <td>
                                    
                                </td>
                            </tr>
                            <tr >
                                <td >
                                    Office Expense
                                </td>
                                <td>
                                    
                                </td>
                                <td>
                                    Rs. <?php echo   convert_rup_format($offc_exp); ?> /-
                                </td>
                                <td>
                                    
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Salary Expense
                                </td>
                                <td>
                                    
                                </td>
                                <td>
                                    Rs. <?php echo   convert_rup_format($salry_exp); ?> /-
                                </td>
                                <td>
                                    
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Room Rent
                                </td>
                                <td>
                                    
                                </td>
                                <td>
                                    Rs. <?php echo  convert_rup_format($room_r_exp); ?> /-
                                </td>
                                <td>
                                    
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Bank Expense
                                </td>
                                <td>
                                    
                                </td>
                                <td>
                                    Rs. <?php echo  convert_rup_format($bnks_exp); ?> /-
                                </td>
                                <td>
                                    
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Advance Expense
                                </td>
                                <td>
                                    
                                </td>
                                <td>
                                    Rs. <?php echo  convert_rup_format($adv_exp); ?> /-
                                </td>
                                <td>
                                    
                                </td>
                            </tr>
                            
                            <tr>
                                <td>
                                    Other Expense
                                </td>
                                <td>
                                    
                                </td>
                                <td>
                                    Rs. <?php echo  convert_rup_format($oter_exp); ?> /-
                                </td>
                                <td>
                                    
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Day Book Remaining
                                </td>
                                <td>
                                    
                                </td>
                                <td>
                                    Rs. <?php echo  convert_rup_format($remaining_bal_amt); ?> /-
                                </td>
                                <td>
                                    
                                </td>
                            </tr>
                            
                              </tbody>
                              
                              <?php 
                              {
                                  ?>
                              <thead>
                              <th>
                                  Total
                              </th>
                              <th>
                              </th>
                              <th>
                                  Rs. <?php 
                                  
                                  $inv_p_int=$invest_amount+$interest_amount+$si;
                                  
                                  echo convert_rup_format($inv_p_int); ?> /-
                              </th>
                              <th>
                                 Rs. <?php
                                  
                                  $tot_expnes=$remaining_bal_amt+$hp_asal_out_amt+$stl_asal_out_amt+$offc_exp+$salry_exp+$room_r_exp+$adv_exp+$bnks_exp+$oter_exp;
                                  echo convert_rup_format($tot_expnes) ?> /-
                               </th>
                               <th>
                                   Tally
                                   Rs. <?php
                                   $tally=$total_main_amt-$tally_amount;
                                   echo convert_rup_format($tally); ?> /-
                               </th>
                              </thead>
                                      <?php
                              }
                              ?>
                       
                                    <?php
                            }
                            ?>
                      
                    </table>
                    
                    
                </div>
                
            </div>
            
        </div>
    </body>
</html>

        