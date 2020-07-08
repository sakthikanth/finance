<?php
            session_start();
            
            if(empty($_SESSION['user_id'])) header("location:index.php");
                        if(empty($_SESSION['fin_id'])) header("location:fin_accounts.php");

            
            require './my.php';
            
            $fin_id=$_SESSION['fin_id'];
            
            $q=q("select finance_name as fn from finance_accounts where fin_id=$fin_id");
            if($q){
                if($fn!=NULL){
                    $_SESSION['fin_id']=$fin_id;
                }else{
                    header("location:fin_accounts.php");
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

  <?php 
  
       $year= $_SESSION['cur_year'];
                $month= $_SESSION['cur_month'];
                $day=$_SESSION['cur_day'];
                
           
                $hr=date('g');
                $min=date('i');
                $noon=date('A');
    if(isset($_REQUEST['my_date'])){
                  
                                $date=$_REQUEST['my_date'];
                                $pagi_word="and date_entry regexp '$date'";
                                 
                    
                            }else
                            {
                
                $date="$year-$month-$day";
                
                            }
                             
                            
                            $recnt_date="";
                            
                            $chng=0;
                            
                            $tot_remain_bal=0;
                             $p_log_id=0;
                              $n_log_id=0;
                            $next_date="";
                             if(isset($_REQUEST['pre_id'])){
                                $id_wrd=" and log_id > ".$_REQUEST['pre_id'];
                                $asc="asc";
                                $n_log_id=$_REQUEST['pre_id'];
                               
                            }elseif(isset($_REQUEST['next_id']) ){
                               $id_wrd=" and log_id <= ".$_REQUEST['next_id'];
                                 $p_log_id=$_REQUEST['next_id'];
                                  $asc="desc";
                            }else{
                                $id_wrd="";
                                 $asc="desc";
                            }
                            $go_dt="";
                            if(isset($_REQUEST['my_date'])){
                                $id_wrd="";
                                 $p_log_id=0;
                                  $asc="asc";
                                  $go_dt="and date_entry regexp '".$_REQUEST['my_date']."'";
                            }
                            
                            include './calc_prev_date.php';
              
                            if(count($_REQUEST)==0){
                                
                               q("select date_entry as last_date from amount_status where fin_id=$fin_id order by log_id desc limit 1");
                               
                               $lim_word="date_entry regexp '".$last_date."' ";
                              
                               $next_lim_date=calc_prev_date(1,$last_date);
                               $lim_word.="or date_entry regexp '".$next_lim_date."' ";
                                 
                               $next_lim_date=calc_prev_date(1,$next_lim_date);
                               $lim_word.="or date_entry regexp '".$next_lim_date."' and ";
                               
                               
                               
                               
                            }else{
                                $lim_word="";
                            }
                            
                           $rt= q("select date_entry as my_en_date from amount_status where $lim_word fin_id=$fin_id $id_wrd $go_dt order by log_id desc limit 1");
                         
                            if(count($my_en_date)==0 || !$rt){
            $rt= q("select date_entry as my_en_date from amount_status where fin_id=$fin_id  order by log_id desc limit 1");

           if(count($my_en_date)==0){
              $my_en_date= "$year-$month-$day";
           }
                               // header("location:day_book.php");
                            }
                            $rec_day=  substr($my_en_date, strpos($my_en_date, "-")+4,  2);
                    $rec_mnth=substr($my_en_date, strpos($my_en_date, "-")+1,  2);
                    $rec_tyear=  substr($my_en_date, 0,4);
                    

                         $ttl_date="$rec_day-$rec_mnth-$rec_tyear";
                       
                         q("select log_id as l_dbk_id from amount_status where fin_id=$fin_id order by log_id desc limit 1");
                         
                         
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
        <link rel="stylesheet" href="css/homepage.css" />
        <link rel="stylesheet" href="css/stl_accounts.css" />
        <link rel="stylesheet" href="css/day_book.css" />
        <script src="js/jquery.js" ></script>
        <script src="js/bootstrap.min.js"></script>
        <title>Velmurugan Finance</title>
    </head>
    <body>
        <?php include './header.php';  ?>
        <div class="col-lg-12">
            <div class="top_holder col-lg-12">
                            <div class="PG_ttl col-lg-4">
                Day Book of <?php echo $fn;  ?> Finance 
               
            </div>
            <div class="col-lg-4 day_selector">
                <span>
                    Goto Date
                </span>
                <div class="">
                    <select id="day_val">
                        
                        <?php
                        $sl="";
                        for($n=1;$n<=31;$n++){
                            if($n==$rec_day){
                                $sl="selected";
                            }else{
                                $sl="";
                            }
                            ?><option <?php echo $sl; ?> value="<?php echo $n; ?>"><?php echo $n; ?></option><?php 
                        }
                        ?>
                    </select>
                    
                    <select id="month_val">
                        <?php
                      $slm="";
                        for($n=1;$n<=12;$n++){
                              if($n==$rec_mnth){
                                  $slm="selected";
                              }else{
                                  $slm="";
                              }
                            ?><option <?php echo $slm; ?> value="<?php echo $n; ?>"><?php echo $n; ?></option><?php 
                        }
                        ?>
                    </select>
                    <select id="year_val">
                         <?php
                        $sly="";
                        for($n=2013;$n<=2030;$n++){
                            if($n==$rec_tyear){
                                $sly="selected";
                            }else{
                                $sly="";
                            }
                            ?><option <?php echo $sly; ?> value="<?php echo $n; ?>"><?php echo $n; ?></option><?php 
                        }
                        ?>
                    </select>
                    <button onclick="goto_date()">
                        Go
                    </button>
                </div>
            </div>
             <div class="date_hint col-lg-4">
                   Date :  <?php echo $ttl_date; ?>
                </div>
            </div>
            <?php
            q("select log_id as nm from amount_status where fin_id=$fin_id");
            if(count($nm)==0){
                ?><h2 style="text-align: center;color: crimson">No Day Book Entries</h2><?php
            }else
                
            {
            ?>
            <div class="PG_content_holder">
                <div class="PG_ch_inner">
                    <table class="table table-striped col-lg-12">
                        <thead>
                        <th>
                            Date
                        </th>
                         <th>
                            Name
                        </th>
                        <th>
                            Account
                        </th>   
                       <th>
                            Interest Income
                        </th>
                        <th>
                            Asal / Due Income
                        </th>
                        <th>
                            Asal Out
                        </th>
                        <th>
                            Expense/Invest Amount
                        </th>
                        <th>
                            Remaining Balance
                        </th>
                        <th>
                            View User
                        </th>
                            
                        </thead>
                        <tbody>
                                      <?php
                           
                            $tot_arr=array();
                           
                           
                            
                            $breaked=0;
                            $r=q("select saami as saami_amt,money_out,mo_reason,date_entry,asal_in,asal_out,interest,remain_bal,loan_type,my_date,invest_amt,cust_id,log_id,invest_id,exp_id,delt  from amount_status where fin_id=$fin_id $go_dt $id_wrd  order by log_id $asc ");
                        //echo ("select saami as saami_amt,money_out,mo_reason,date_entry,asal_in,asal_out,interest,remain_bal,loan_type,my_date,invest_amt,cust_id,log_id,invest_id,exp_id,delt  from amount_status where fin_id=$fin_id $go_dt $id_wrd  order by log_id $asc ");
                       
                            $day_asal_in=0;
                            $day_asal_out=0;
                            $day_interest=0;
                            $day_expense=0;
                            $day_invest=0;
                            $remain_bals=0;
                            
                            $hide_prev=0;
                           
                            if($l_dbk_id==0){
                                
                                $hide_prev=1;
                            }
                            
                            for($n=0;$n<count($money_out);$n++){
                                if(count($money_out)==1){
                                   
                                    $acc_types=$loan_type;
                                    $cus_ids=$cust_id;
                                    $int_amounts=$interest;
                                    $en_id=$log_id;
                                    $asal_ins=$asal_in;
                                    $asal_outs=$asal_out;
                                    $invest_amts=$invest_amt;
                                    $inv_id=$invest_id;
                                    $money_outs=$money_out;
                                    $mo_reasons=$mo_reason;
                                    $e_date=substr($my_date,0,  strpos($my_date, " "));
                                    $remain_bals=$remain_bal;
                                    $show_date=$my_date;
                                    $expense_id=$exp_id;
                                    $logg_id=$log_id;
                                    $saami_amount=$saami_amt;
                                    $delt_sts=$delt;
                                    
                                    
                                   
                                }else{
                                    
                                     $acc_types=$loan_type[$n];
                                    $cus_ids=$cust_id[$n];
                                    $int_amounts=$interest[$n];
                                    $en_id=$log_id[$n];
                                    $asal_ins=$asal_in[$n];
                                    $asal_outs=$asal_out[$n];
                                    $invest_amts=$invest_amt[$n];
                                    $inv_id=$invest_id[$n];
                                    $money_outs=$money_out[$n];
                                    $mo_reasons=$mo_reason[$n];
                                    $e_date=substr($my_date[$n],0,  strpos($my_date[$n], " "));
                                    $remain_bals=$remain_bal[$n];
                                    $show_date=$my_date[$n];
                                      $expense_id=$exp_id[$n];
                                      $logg_id=$log_id[$n];
                                        $saami_amount=$saami_amt[$n];
                                        $delt_sts=$delt[$n];
                                    
                                    
                                }
                              
                                
                                if($n==0){
                                    
                                 if(isset($_REQUEST['my_date'])){
                                     $p_log_id=$logg_id;
                                 }
                                }
                                if($asc=="desc" && $n==0){
                                    $tot_remain_bal=$remain_bals;
                                  
                                }  elseif($asc=="asc") {
                                    $tot_remain_bal=$remain_bals;
                                    
                                }
                               
                                   if(isset($_REQUEST['my_date']) && $asc=="asc" && $n==0 ){
                                     $n_log_id=$logg_id;
                                 }
                                   if($recnt_date!=$e_date && $n>0){
                                      $chng+=1;
                                      if($chng>=2){
                                          
                                          if($breaked==1){
                                               
                                              break;
                                              
                                          }
                                          
                                          if((count($log_id)-$n)>1){
                                              
                                              if(count($log_id)==1){
                                               
                                                  $next_date=substr($my_date,0,  strpos($my_date, " "));
                                              }else{
                                                  $next_date=substr($my_date[$n],0,  strpos($my_date[$n], " "));
                                              }
                                                  $n_log_id=$logg_id;
                                          }else{
                                              $next_date="";
                                          }
                                          
                                      
                                              $breaked=1;
                                                
                                                 
                                      }
                                      
                                  }
                                  
                                     $recnt_date=$e_date;
                                
                                $exp_reason="";
                              $exp_or_inv_amt=0;
                               
                                
                                $reason_name="";
                               if($acc_types=="STL" || $acc_types=="HP"){
                                   
                                if($acc_types=="STL"){
                                    $ac_tp_tr=" and stl_id=$cus_ids";
                                    $acc_no="STL No. ".$cus_ids;
                                    $h_ref="view_stl_user.php?stl_id=".$cus_ids;
                                    $from_tbl="customers_stl";
                                }else{
                                    $ac_tp_tr=" and hp_id=$cus_ids";
                                    $acc_no="HP No. ".$cus_ids;
                                    $h_ref="view_hp_user.php?hp_id=".$cus_ids;
                                     $from_tbl="customers_hp";

                                }
                                
               q("select name as p_name from $from_tbl where fin_id=$fin_id $ac_tp_tr");
               
                $reason_name=$p_name;
          
                
                               }elseif($inv_id!=0){
                                   q("select invest_id as iid,invester as invstr from investments where fin_id=$fin_id and invest_id=$inv_id");
                              $reason_name=$invstr;
                              $h_ref="add_investers.php";
                              $acc_no="Invest No : ".$inv_id;
                              $exp_reason="Invest";
                              $exp_or_inv_amt=$invest_amts;
                                  }else{
                                      
                                      if($mo_reason!="" ){
                                          q("select exp_id as eid,exp_type,exp_amount from extra_expense where fin_id=$fin_id and exp_id=$expense_id order by exp_id desc limit 1");
                                          $reason_name=$mo_reasons;
                                          $acc_no="Exp No: $expense_id";
                                         $h_ref="money_expense.php?exp_type=".  substr($exp_type, 0,  strpos($exp_type, "_"));
                                           
                                         $exp_tps=substr($exp_type, 0,  strpos($exp_type, "_"));
                                           if($exp_tps=="o"){
                                                $exp_word="Office Expense";
                                            }elseif($exp_tps=="s"){
                                                $exp_word="Salary Expense";
                                            }elseif($exp_tps=='rr'){
                                                $exp_word="Room Rent Expense";
                                            }elseif ($exp_tps=='ad') {
                                                $exp_word="Advance Expense";
                                            }elseif ($exp_tps=='bnk') {
                                                $exp_word="Bank Expense";
                                            }elseif ($exp_tps=='otr') {
                                                $exp_word="Other Expense";
                                            }else{
                                                $exp_word=""; 
                                            }
                                            
                                            if($delt_sts==1){
                                                $exp_word.="Expense";
                                            }
                                            $exp_reason=$exp_word;
                                            $exp_or_inv_amt=$money_outs;

                                      }
                                      if($saami_amount!=0){
                                           $exp_or_inv_amt=$saami_amount;
                                           $exp_reason="Invest";
                                            $acc_no="";
                                            $h_ref="add_investers.php";
                                            $reason_name="Saami";
                                      }
                                      
                                  }
                               $d_a="";
                                  if($asal_ins!=0){
                                      
                                      if($acc_types=="STL"){
                                          $d_a="Asal In ";
                                      }else{
                                          $d_a="Due In ";
                                          $asal_ins+=$int_amounts;
                                      }
                                      
                                     $asal_in_wrd="$d_a Rs. <font>".convert_rup_format($asal_ins)." /-</font>";
                                       if($delt_sts==1){
                                                $asal_in_wrd.="<font color='red'>( Deleted )</font>";
                                            }
                                  }else{
                                      $asal_in_wrd="";
                                  }
                                      if($int_amounts!=0 && $d_a!="Due In "){
                                        
                                        $int_amnt_wrd='Interest Rs. <font>'.  convert_rup_format($int_amounts).' /-</font>';
                                    if($delt_sts==1){
                                                $int_amnt_wrd.="<font color='red'>( Deleted )</font>";
                                            }
                                        }else{
                                        $int_amnt_wrd='';
                                    }
                                     
                                   if($asal_outs!=0){
                                  
                                     $asal_out_wrd=" Asal Out Rs. <font>".convert_rup_format($asal_outs)." /-</font>";
                                 if($delt_sts==1){
                                                $asal_out_wrd.="<font color='red'>( Added loan )</font>";
                                            }
                                     }else{
                                       $asal_out_wrd="";
                                  }
                                   
                                    if($exp_or_inv_amt!=0 || $money_outs!=0){
                                      $exp_in_wrd=$exp_reason."  Rs. <font>".convert_rup_format($exp_or_inv_amt).'  /-</font>';
                                       if($delt_sts==1){
                                                $exp_in_wrd.="<font color='red'>( Deleted )</font>";
                                            }
                                      }else{
                                        $exp_in_wrd='';
                                        
                                    }
                                    
                                   
                                      
                                    if($breaked==0){
                                       if($logg_id==$l_dbk_id){
                                        $hide_prev=1;
                                       
                                    }
                                         if(isset($_REQUEST['pre_id'])){
                                                         $p_log_id=$logg_id;
                                                     }
                                                         $day_asal_in+=$asal_ins;
                                $day_asal_out+=$asal_outs;
                                $day_interest+=$int_amounts;
                                $day_invest+=$invest_amts;
                                $day_expense+=$money_outs;
                                   
                                             $tot_arr[]='<tr>
                                
                                <td>
                                    '.$show_date.' 
                                </td>
                                <td>
                                    '.$reason_name.' 
                                </td>
                                <td>
                                    
                                    
                                    '.$acc_no.' 
                                </td>
                                <td>
                                   
                                    '.$int_amnt_wrd.'
                                </td>
                                <td>
                               '.$asal_in_wrd.'
                                </td>
                                <td>
                                   '.$asal_out_wrd.'
                                </td>
                               
                                <td>
                                    '.$exp_in_wrd.'
                                </td>
                                 <td>
                                     Rs. <font>'.convert_rup_format($remain_bals).' /-</font>
                                </td>
                                <td>
                                    <a href="'.$h_ref.'"> <button>
                                        View
                                    </button>
                                    </a>
                                </td>
                            </tr>';
                                    }
                           
                                  
                                ?>
                       
                            
                       
                                    <?php
                            }
                            
                            if($n_log_id!=0){
                             ?>
                                 <tr id="fst_row">
                                <td colspan="9" style="text-align: center">
                                    <button class="show_more_btn" onclick="load_more('<?php echo $n_log_id ?>')">Show Previous</button>
                                    
                                </td>
                            </tr><?php   
                            }
                          ?>
                            
                  
                            <?php
                            if(isset($_REQUEST['pre_id']) || isset($_REQUEST['my_date'])){
                            for($n=0;$n<count($tot_arr);$n++){
                                echo $tot_arr[$n];
                            }    
                            }else{
                            for($n=count($tot_arr)-1;$n>=0;$n--){
                                echo $tot_arr[$n];
                            }    
                            }
                            
                            ?>
                        </tbody>
                        <thead style="background-color: #c8e6c9" class="tot_day_bal">
                        <th>
                            Total
                        </th>
                        <th>
                            
                        </th>
                        <th>
                            
                        </th>
                        <th class="per_day_amt">
                            <?php 
                            if($day_interest!=0 && isset($_REQUEST['my_date'])){
                                echo "Interest Rs. ".  convert_rup_format($day_interest).' /-';
                            }
                            ?>
                            
                        </th>
                        <th class="per_day_amt">
                              <?php 
                            if($day_asal_in!=0 && isset($_REQUEST['my_date'])){
                                echo "Asal In Rs. ".  convert_rup_format($day_asal_in).' /-';
                            }
                            ?>
                           
                        </th>
                        <th class="per_day_amt">
                              <?php 
                            if($day_asal_out!=0 && isset($_REQUEST['my_date'])){
                                echo "Asal Out Rs. ".  convert_rup_format($day_asal_out).'  /-';
                            }
                            ?>
                           
                        </th>
                        <th class="per_day_amt">
                            <?php 
                            if($day_expense!=0 && isset($_REQUEST['my_date'])){
                                echo "Expense Rs. ".  convert_rup_format($day_expense).' /-';
                            }
                            ?>
                        </th>
                        <th colspan="2">
                            <?php 
                            if($tot_remain_bal!=0){
                                echo "Remaining Rs. ".  convert_rup_format($tot_remain_bal).' /-';
                            }
                            ?>
                        </th>
                        </thead>
                    </table>
                  
                    <div class="change_holder col-lg-12">
                        <div class="sep_chng">
                            
                    
                        <?php
                        
                        if($hide_prev==0){
                            ?>
                        <a  href="day_book.php?pre_id=<?php echo $p_log_id; ?>"><div class="change_item col-lg-6">
                            Previous
                            
                            </div></a><?php
                        }else{
                            ?><div class="col-lg-6">
                            
                            
                            </div><?php
                        }
                        ?>
                </div>
                        <div class="sep_chng">
                        <?php
                        
                        if($n_log_id!=0){
                                ?>
                        <a href="day_book.php?next_id=<?php echo $n_log_id; ?>"><div class="change_item col-lg-6">
                                Next 
                            </div></a>
                                <?php
                        }else{
                            ?><div class="col-lg-6">
                            
                            
                            </div><?php
                        }
                        ?>
                        </div>

                    </div>
                </div>
               
            </div>
            <?php } ?>
        </div>
        <script type="text/javascript">
   
        function goto_date(){
         
            var day=$('#day_val').val();
            var mnth=$('#month_val').val();
            var year=$('#year_val').val();
            if(day<10){
                day="0"+day;
            }
            if(mnth<10){
                mnth="0"+mnth;
            }
            var url_dt=year+'-'+mnth+'-'+day;
            window.location.href='day_book.php?my_date='+url_dt;
        }
        
        function load_more(next_id){
            $('.per_day_amt').html('');
            $('#fst_row').html("Loading Please wait...");
            var urls='load_dbk.php?next_id='+next_id;
            var fmdt=new FormData();
           $.ajax({
                url: urls,  
                dataType: 'text',  
                cache: false,
                contentType: false,
                processData: false,
                data: fmdt,                         
                type: 'post',
                success: function(psr){
     $('#asal_pay_text').html(psr);
     $('#fst_row').remove();
     $('tbody').prepend(psr);
                }
	    
     });
        }
        
        </script>
    </body>
</html>
