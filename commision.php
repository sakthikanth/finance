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
        <link rel="stylesheet" href="css/homepage.css" />
        <link rel="stylesheet" href="css/stl_accounts.css" />
        <link rel="stylesheet" href="css/day_book.css" />
        
        <script src="js/jquery.js" ></script>
        <script src="js/bootstrap.min.js"></script>
        <title>Velmurugan Finance</title>
    </head>
    <body>
  <?php include './header.php'; ?>
        <div class="container">
            <div class="col-lg-12">
            <div class="PG_ttl col-lg-6">
                Commision of <?php echo $fn;  ?> Finance

            </div>
            <div class="col-lg-6 day_selector">
                <span>
                    Goto Date
                </span>
                <div class="">
                    <select id="day_val">
                        
                        <?php
                        
                       
                    $asc="";
                           if(isset($_REQUEST['my_date'])){
                   $rec_date=$_REQUEST['my_date'];
                        
                      $rec_day= substr($rec_date, strpos($rec_date, "-")+4,  2);
                       $rec_mnth=substr($rec_date, strpos($rec_date, "-")+1,  2);
                    $rec_year=  substr($rec_date, 0,4);
                    
                   
                    
                     $pagi_word=" and date regexp '$rec_day-$rec_mnth-$rec_year' ";
                              $asc="asc";  
                                 
                    
                            }else
                            {
                $rec_day=$_SESSION['cur_day'];
                $rec_mnth=$_SESSION['cur_month'];
                $rec_year=$_SESSION['cur_year'];
                
                $pagi_word="";
                $asc="desc";
                            }
                            
                            
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
                            if($n==$rec_year){
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
                
            </div>
            <div class="PG_content_holder">
                <div class="PG_ch_inner">
                    <table class="table table-striped table-responsive">
                        <thead>

                        <th>
                            S.no
                        </th>   
                        <th>
                            Account
                        </th>
                        <th>
                            Name
                        </th>
                        <th>
                            Date 
                        </th>
                        <th>
                            Discription
                        </th>
                        <th>
                            Commision Amount
                        </th>
                        <th>
                            Total Commision
                        </th>
                        <th>
                            View User
                        </th>
                        </thead>
                        <tbody>
                            <?php
                              
                            if(isset($_REQUEST['pagi'])){
                                $pagi_word.=" and log_id <=".$_REQUEST['pagi'].' ';
                                $pagi_recv=$_REQUEST['pagi'];
                            }else
                            {
                                $pagi_word.="";
                                 $pagi_recv=0;

                            }
                            
                            $comm_per_day=0;
                            $r=q("select comm_amount,acc_type,cus_id,date,tot_comm,comm_word from extras where fin_id=$fin_id $pagi_word  order by log_id $asc limit 20");
                            
                       
                            for($n=0;$n<count($comm_amount);$n++){
                                if(count($comm_amount)==1){
                                   
                                    $commision=$comm_amount;
                                    $acc_types=$acc_type;
                                    
                                    $cus_ids=$cus_id;
                                    $c_date=$date;
                                    $total_comm=$tot_comm;
                                    $comm_words=$comm_word;
                                    
                                    
                                }else{
                                    $commision=$comm_amount[$n];
                                    $acc_types=$acc_type[$n];
                                    $c_date=$date[$n];
                                    $cus_ids=$cus_id[$n];
                                     $total_comm=$tot_comm[$n];
                                     $comm_words=$comm_word[$n];
                                    
                                }
                                $comm_per_day+=$commision;
                              if($acc_types=="STL"){
                                 $acc_no="STL No : ".$cus_ids; 
                              }else{
                                    $acc_no="HP No : ".$cus_ids; 
                              }
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
                                
                                
                                ?>
                       
                            <tr>
                                
                                <td>
                                    <?php echo $n+1; ?>
                                </td>
                                <td>
                                    <?php echo $acc_no; ?>
                                </td>
                                <td>
                                    <?php echo $p_name; ?>
                                </td>
                                <td>
                                    <?php echo $c_date; ?>
                                </td>
                                <td>
                                    <?php echo $comm_words; ?>
                                </td>
                                <td>
                                     Rs. <?php    echo convert_rup_format($commision); ?> /-
                                      
                                </td>
                                <td>
                                    Rs. <?php echo convert_rup_format($total_comm) ?> /-
                                </td>
                                <td>
                                    <a href="<?php echo $h_ref; ?>"> <button>
                                        View
                                    </button>
                                    </a>
                                </td>
                            </tr>
                       
                                    <?php
                            }
                            ?>
                        </tbody>
                        
                        <?php
                        if(isset($_REQUEST['my_date'])){
                            ?>
                        <thead style="color: maroon" colspan="3">
                            <tr>
                                <th>
                                    Total
                                </th>
                                <th colspan="4">
                                    Commision @ <?php echo $rec_day.'-'.$rec_mnth.'-'.$rec_year ?> day
                                </th>
                                <th >
                                    Rs. <?php echo convert_rup_format($comm_per_day) ?> /-
                                </th>
                            </tr>
                        </thead>
                                <?php
                        }
                        ?>
                    </table>
                    <div class="col-lg-12 pagi_hold">
                        <ul class="pagination pagination-lg">
                            <li><a href="#" onclick="change_prev()">&laquo;</a></li>
                            <?php
                            
                          
                            $pg_cnt=0;
                          
                         
                      $r=q("select comm_amount,fin_id,acc_type,cus_id,date,log_id from extras where fin_id=$fin_id $pagi_word  order by log_id desc ");
 
                            $pagi_cnt=0;
                            $pagi_num=0;
                            $blocked=0;
                            
                            $tot_page=0;
                            $put=0;
                            
                                 $show=0;
                            $t_cnt=count($comm_amount);
                            while($t_cnt>20){
                                $t_cnt-=20;
                                $tot_page+=1;
                            }
                                                            $tot_page+=1;

                           
                            for($n=0;$n<count($comm_amount);$n++){
                                $pagi_cnt++;
                                if($pagi_cnt>=20){
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
                                         ?> <li <?php echo $act; ?> ><a id="page_<?php echo $pg_cnt; ?>" href="commision.php?pagi=<?php echo $log_id[$n]; ?>"><?php echo $pagi_num; ?></a></li><?php
                                       
                                   }
                                

                                   }else{
                                    
                                }
                            }
                            
                            ?>
           
                            <li><a href="#" onclick="change_next()">&raquo;</a></li>
                        </ul><br>
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
            window.location.href='commision.php?my_date='+url_dt;
        }
        </script>
    </body>
</html>
