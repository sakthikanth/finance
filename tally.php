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
         

$tot_invest=0;
        q("select invest_amount from investments where fin_id=$fin_id");
        for($n=0;$n<count($invest_amount);$n++){
            
            if(count($invest_amount)==1){
                $tot_invest+=$invest_amount;
            }else{
                $tot_invest+=$invest_amount[$n];
            }
            
        }
        
        
        
        q("select comm_amount from extras where fin_id=$fin_id order by log_id desc limit 1");
        
        $comm_amt=$comm_amount;
        
        q("select total_interest from interest_income where fin_id=$fin_id order by log_id desc limit 1");
        $tot_int_amount=$total_interest;
        
        q("select dbk_cnt as c from tally where fin_id=$fin_id order by log_id desc limit 1");
        
        q("select my_date from amount_status where fin_id=$fin_id");
        $tot_cnt=count($my_date);
        
       
        q("select log_id,outer_asal_amt from stl_asal_logs where fin_id=$fin_id order by log_id desc limit 1");
        
        
        $stl_asal_out=$outer_asal_amt;
        
        q("select log_id,outer_asal_amt from hp_asal_logs where fin_id=$fin_id order by log_id desc limit 1");
        
        $hp_asal_out=$outer_asal_amt;
        
                
                
        q("select `off_exp`, `slry_exp`, `rr_exp`, `ad_exp`, `otr_exp`, `bnk_exp`,tot_expense from extra_expense where fin_id=$fin_id order by exp_id desc limit 1");
    
        if(count($off_exp)>0){
            
        }else{
           $off_exp=0;
                    $slry_exp=0;
                    $rr_exp=0;
                    $ad_exp=0;
                    $otr_exp=0;
                    $bnk_exp=0; 
        }
        
        $tot_expense_amt=$tot_expense;
        
        q("select remain_bal from amount_status where fin_id=$fin_id order by log_id desc limit 1");
        
        $dbk_remain=$remain_bal;
        
        $tot_main=$tot_invest+$tot_int_amount;
        
        $tot_out_amt=$stl_asal_out+$hp_asal_out+$tot_expense_amt;
        
        q("select invest_amount as sinv from saami_account where fin_id=$fin_id");
       
        
        $tally_amt=$dbk_remain+$tot_out_amt;
        
        $mean_df=$tot_main-$tally_amt;
        
         if($c!=$tot_cnt){
             
                 $year= $_SESSION['cur_year'];
                $month= $_SESSION['cur_month'];
                $day=$_SESSION['cur_day'];
              
               $d_t = new DateTime('now', new DateTimezone('Asia/Kolkata'));
                
                $hr=$d_t->format('g');
                $min=$d_t->format('i');
                $noon=$d_t->format('A');
                
                
                $date=$_SESSION['cur_date']." $hr:$min $noon";
                $entries_date=$_SESSION['show_date'];
                
                                                  $inv_p_int=$tot_invest+$tot_int_amount+$sinv;

                              $tot_expnes=$dbk_remain+$hp_asal_out+$stl_asal_out+$off_exp+$slry_exp+$rr_exp+$ad_exp+$bnk_exp+$otr_exp;

       q("INSERT INTO `tally` (`log_id`, `date_entry`, `invest_amt`, `interest_amt`, `money_out`, `mo_reason`, `stl_asal_out`, `hp_asal_out`, `remaining_bal`, `dbk_cnt`, `tally_amt`, `tot_main`,`fin_id`,`off_exp`, `slry_exp`, `rr_exp`, `ad_exp`, `otr_exp`, `bnk_exp`)"
               . "  VALUES (NULL, '$entries_date', '$tot_invest', '$tot_int_amount', '$tot_expense_amt', '', '$stl_asal_out', '$hp_asal_out', '$dbk_remain', '$tot_cnt', '$inv_p_int', '$tot_expnes',$fin_id,$off_exp,$slry_exp,$rr_exp,$ad_exp,$otr_exp,$bnk_exp);");     
        }
       
        
        
        
        ?>
<?php   
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
    <body>
  <?php include './header.php'; ?>
        <div class="col-lg-12">
            <div class="PG_ttl">
                Tally Logs of <?php echo $fn;  ?> Finance
            </div>
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
                            
                            

                           q("SELECT `off_exp`, `slry_exp`, `rr_exp`, `ad_exp`, `otr_exp`, `bnk_exp`,`log_id`, `date_entry`, `invest_amt`, `interest_amt`, `money_out`, `mo_reason`, `stl_asal_out`, `hp_asal_out`, `remaining_bal`, `dbk_cnt`, `tally_amt`, `tot_main`,log_id as lids FROM `tally` where fin_id=$fin_id $pagi_word order by log_id desc limit 2"); 
                       
                            for($n=0;$n<count($lids);$n++){
                                if(count($lids)==1){
                                   
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
                                    
                                    $logs_id=$lids;
                                    
                                    
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
                                    $logs_id=$lids[$n];
                                     $chk_date=substr($show_date[$n],0,  strpos($show_date[$n], " "));
                                    
                                }
                              
                            
                                
                               
                                
                                ?>
                        <tbody>
                            <tr >
                                <td rowspan="12">
                                    <?php
                                     $sh_day= substr($show_date, strpos($show_date, "-")+4,  2);
                       $sh_mnth=substr($show_date, strpos($show_date, "-")+1,  2);
                    $sh_tyear=  substr($show_date, 0,4);
                                    echo "$sh_day-$sh_mnth-$sh_tyear"; ?>
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
                                  <button style="border: 1px solid gray" id="print_btn<?php echo $logs_id ?>"  onclick="print_pdf(<?php echo $logs_id; ?>)">Save as Pdf</button></a>
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
                                   $tally=$total_main_amt-$tot_expnes;
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
                    <div class="col-lg-12 pagi_hold">
                        
                        <?php
                                    $pg_cnt=0;
                          
                         
                            q("select log_id from tally where fin_id=$fin_id order by log_id desc");
                          
                            $pagi_cnt=0;
                            $pagi_num=0;
                            $blocked=0;
                            
                            $tot_page=0;
                            $put=0;
                            
                                 $show=0;
                            $t_cnt=count($log_id);
                            while($t_cnt>=2){
                                $t_cnt-=2;
                                $tot_page+=1;
                            }
                                                            $tot_page+=1;

                           if($tot_page>1){
                               ?>
                                   <ul class="pagination pagination-lg">
                            <li><a href="#" onclick="change_prev()">&laquo;</a></li>
                            <?php
                            
                          
                
                            for($n=0;$n<count($log_id);$n++){
                                $pagi_cnt++;
                                if($pagi_cnt>=2){
                                    $pagi_cnt=0;
                                }
                                if($pagi_cnt==1){
                                
                                    $pagi_num++;
                                  
                                    if(!isset($_REQUEST['pagi']) && $pagi_num==1){
                                        $pagi_recv=$log_id[$n];
                                    }
                                   
                                   
                                    
                                    if($pagi_recv==$log_id[$n]){
                                        $act="class='active'";
                                        $show=1;
                                      
                                      $put=$pagi_num;
                                    }else
                                    {
                                        $act="";
                                   
                                    }
                                    
                                   if($blocked==0  ) {
                                         $pg_cnt++;
                                         ?> <li <?php echo $act; ?> ><a id="page_<?php echo $pg_cnt; ?>" href="tally.php?pagi=<?php echo $log_id[$n]; ?>"><?php echo $pagi_num; ?></a></li><?php
                                       
                                   }
                                

                                   }else{
                                    
                                }
                            }
                            
                            ?>
           
                            <li><a href="#" onclick="change_next()">&raquo;</a></li>
                        </ul><br><?php
                           }
                        ?>
                        
                    </div>
                    
                </div>
                
            </div>
            
        </div>
        <script>
        
        cliked=<?php echo $put;  ?>;
        max=<?php echo $pg_cnt; ?>;
        
        function change_next(){
            cliked+=1;
            if(cliked>=max){
               cliked=max; 
            }
            document.getElementById('page_'+cliked).click();
           
        }
        function change_prev(){
            cliked-=1;
            if(cliked<=0){
                cliked=1;
            }
                      document.getElementById('page_'+cliked).click();

            
        }
        
        </script>
         <script>
        function print_pdf(log_id){
            
            
           file_name='';
           if(log_id!==''){
               file_name+='log_id='+log_id;
           }
           
          
               $('#print_btn'+log_id).text('Processing...');
               var its_id='#print_btn'+log_id;
               var fmdt=new FormData();
              var urls='print_tally.php?'+file_name;
           $.ajax({
                url: urls,  
                dataType: 'text',  
                cache: false,
                contentType: false,
                processData: false,
                data: fmdt,                         
                type: 'post',
                success: function(psr){
                        create_pdf_html(psr,its_id);
                }
	    
     });
            
           
        }
         function create_pdf_html(html_cont,id_nm){
             var urls="creaate_html_file.php";
             var fmdt=new FormData();
             fmdt.append('html_cont',html_cont);
             fmdt.append('tar_file','tally_pdf_html');
               $.ajax({
                url: urls,  
                dataType: 'text',  
                cache: false,
                contentType: false,
                processData: false,
                data: fmdt,                         
                type: 'post',
                success: function(psr){
                    var req_file="pdf.php?req_url=tally_pdf_html";
                  window.location.href=req_file;
                                       $(id_nm).text('Success').delay(2000).text("Save as Pdf");

                }
	    
     });
         }
        </script>
    </body>
</html>

        