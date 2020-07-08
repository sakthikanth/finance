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
        <link rel="stylesheet" href="css/pdf_file.css" />
        <script src="js/jquery.js" ></script>
        <script src="js/bootstrap.min.js"></script>
        <title>Velmurugan Finance</title>
    </head>
    <body>
      
 
        <div class="container">
          <div class="col-lg-12 logs_top_holder">
              <h2 style="text-align: left">Velmurugan Finance</h2>
              <h3 style="text-align: center">
                HP Pendings of <?php echo $fn;  ?> Finance
            </h3>
            
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
                             
                   $year= $_SESSION['cur_year'];
                $month= $_SESSION['cur_month'];
                $day=$_SESSION['cur_day'];
                
                $hr=date('g');
                $min=date('i');
                $noon=date('A');
                
                $date=$_SESSION['cur_date']." $hr:$min $noon";
                    echo $date;
                ?>
                    </td>
                <tr>
                                       <th>
                        Customer
                    </th>
                    <td>
                        <?php
                        if(isset($_REQUEST['cust_id'])){
                            
                            if($_REQUEST['cust_id']=="0" || $_REQUEST['cust_id']==0 ){
                                echo "General";
                            }else{
                                q("select user_namw from users where users_id=".$_REQUEST['cust_id']."");
                                echo $user_name;
                            }
                        }else{
                            echo "All";
                        }
                        
                        ?>
                    </td> 
                </tr>

                </tr>
            </table>
            </div>
            <?php
            
                       $pg_cnt=0;
                    
            $p_arr=  array();
                            $year= $_SESSION['cur_year'];
                $month= $_SESSION['cur_month'];
                $day=$_SESSION['cur_day'];
                
                $hr=date('g');
                $min=date('i');
                $noon=date('A');
                
                $date="$day-$month-$year $hr:$min $noon";
                              
                            if(isset($_REQUEST['pagi'])){
                                $pagi_word="and hl.log_id <=".$_REQUEST['pagi'].' ';
                                $pagi_recv=$_REQUEST['pagi'];
                            }else
                            {
                                $pagi_word="";
                                 $pagi_recv=0;

                            }
                            
                                if(isset($_REQUEST['cust_id'])){
                
                $cust_wrd="and c.users_id=".$_REQUEST['cust_id'];
            }else{
                $cust_wrd="";
            }
            
            
                            //next int date = paid int date
                            $r=q("select distinct hl.fin_id as fid,hl.next_due_date as nid,hl.due_paid_cnt as due_paid_cnt,hl.log_id as log_id,hl.hp_id as hid,hl.current_interest as current_interest,hl.asal_amount_rate as asal_amount_rate,hl.diff_amount as diff_amount from loan_leagure_hp as hl inner join customers_hp as c where c.fin_id=$fin_id and hl.fin_id=$fin_id $pagi_word $cust_wrd order by nid  limit 20");
                           
                       $cur_date="$year-$month-$day";
                       
                       $all_pend_mnths="";
                        $tot_pend_array=array();
                            for($n=0;$n<count($nid);$n++){
                                if(count($nid)==1){
                                   
                                    $paid_due_date=$nid;
                                    $hp_id=$hid;
                                    $paid_months=$due_paid_cnt;
                                    $ci=$current_interest;
                                    $asal_rate_amt=$asal_amount_rate;
                                    $diff_amt_word=$diff_amount;
                                    $fin_id=$fid;
                                    
                                    
                                }else{
                                    
                                    $paid_due_date=$nid[$n];
                                    $hp_id=$hid[$n];
                                    $paid_months=$due_paid_cnt[$n];
                                    
                                    $ci=$current_interest[$n];
                                    $asal_rate_amt=$asal_amount_rate[$n];
                                    $diff_amt_word=$diff_amount[$n];
                                    $fin_id=$fid[$n];
                                    
                   
                                                                        
                                }
                                  $ext_amount=substr($diff_amt_word,4,  strlen($diff_amt_word));
                                 $diff_act=  substr($diff_amt_word,0,1);
                                 
                                 
                                 
                              
                                if($n>=20){
                                    break;
                                }
                                $dt1=  date_create($paid_due_date);
                                $dt2=  date_create($cur_date);
                                
                                $diff=  date_diff($dt2,$dt1);
                                $diff_val=$diff->format("%a");
                                $h_ref="view_hp_user.php?hp_id=".$hp_id."&fin_id=".$fin_id;
                                
                                $pend_amt=0;
                                $pending_mnth=0;
                                $tot_pend_days=$diff_val;
                                while($tot_pend_days>=30){
                                    $tot_pend_days-=30;
                                    $pending_mnth+=1;
                                }
                                if($tot_pend_days<30 && $tot_pend_days>0){
                                    $pending_mnth+=1;
                                }
                                
                                if($pending_mnth>1){
                                    $tot_due=$pending_mnth*($asal_rate_amt+$ci);
                                    if($diff_act=='a'){
                                        $tot_due+=$ext_amount;
                                    }else{
                                        $tot_due-=$ext_amount;
                                    }
                                }
                     q("select person_status,name as p_name,mob_no,due_months from customers_hp where fin_id=$fin_id and hp_id=$hp_id");

                                if($person_status==2 || $person_status=="2")
                                    {
                                               $pending_mnth=0;
                                     }
                              
                                if($pending_mnth>1){
                                        
                                    q("select finance_name as fns from finance_accounts where fin_id=$fin_id");
                                    $all_pend_mnths.=$pending_mnth.',';
                                    $tot_d_month=$due_months;
                                 
                                    $tot_pend_array[]="
                                <td>
                                    ".$hp_id."
                                </td>
                                <td>
                                    ".$fns."
                                </td>
                                <td>
                                   ".$p_name."
                                </td>
                                <td>
                                  ".$mob_no."
                                </td>
                                <td>
                                    ".$pending_mnth."
                                      
                                </td>
                                <td>
                                    Rs. ".convert_rup_format($tot_due)." /-
                                </td>
                                 <td>
                                Rs. ".  convert_rup_format($asal_rate_amt+$ci)." 
                                </td>
                                <td>
                                    Pending From  ".$paid_due_date." 
                                </td>
                                <td>
                                    <a href=\"".$h_ref."\"> <button>
                                        View
                                    </button>
                                    </a>
                                </td>";
                                      
                                    ?>
                                 
                                        <?php
                                }
                                
                                
                            }
                             
                              $put=1;
                               if(count($tot_pend_array)==0){
                                   ?><h2  style="text-align: center;color: green">No Pending Lists</h2><?php
                               }else{
                                ?><div class="PG_content_holder">
                <div class="PG_ch_inner">
                    <table class="table table-striped table-responsive">
                        <thead>

                        <th>
                            S.no
                        </th> 
                        <th>
                            HP No
                        </th>
                        <th>
                            Finance
                        </th>
                        <th>
                            Name
                        </th>
                        <th>
                            Mob No
                        </th>
                        <th>
                            Pending months
                        </th>
                        <th>
                            Due Amount
                        </th>
                        <th>
                            Due / month
                        </th>
                        <th>
                            pending from
                        </th>
                        <th>
                            View User
                        </th>
                        </thead>
                        <tbody>
                            <?php
                          
                       {
                                  $c=0;
                            for($n=0;$n<count($tot_pend_array);$n++){
                                
                                $c++;
                                ?><tr>
                                    <td>
                                        <?php echo $c; ?>
                                    </td>
                                    <?php  echo $tot_pend_array[$n]; ?>
                                    </tr>
                                    <?php
                               
                               
                            } 
                            }
                            ?>
                        </tbody>
                    </table>
                    <?php
                             
                           $r=q("select distinct hl.next_due_date as nid,hl.log_id as log_id from loan_leagure_hp as hl inner join customers_hp as c where c.fin_id=$fin_id and hl.fin_id=$fin_id $pagi_word $cust_wrd   order by nid desc ");
                           
                        
                            $pagi_num=0;
                            $blocked=0;
                            
                            $tot_page=0;
                            $put=0;
                            
                                 $show=0;
                            $t_cnt=count($nid);
                             while($t_cnt>20){
                                $t_cnt-=20;
                                $tot_page+=1;
                            }
                                                            $tot_page+=1;
                                                                
                                                            if($tot_page>1){
                                                                ?>
                                                                    <div class="col-lg-12 pagi_hold">
                        <ul class="pagination pagination-lg">
                            <li><a href="#" onclick="change_prev()">&laquo;</a></li>
                            <?php
                            
                          
                     
                           
                           
                            for($n=0;$n<count($nid);$n++){
                                 if(count($nid)==1){
                                   
                                    $paid_int_date=$nid;
                                }else{
                                   $paid_int_date=$nid[$n];
                                   
                               }
                                
                                  $dt1=  date_create($paid_int_date);
                                $dt2=  date_create($cur_date);
                                
                                $diff=  date_diff($dt2,$dt1);
                                $diff_val=$diff->format("%a");
                                
                                if($diff_val>30){
                                    $pagi_cnt++;
                                }
                                
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
                                         $put=1;
                                   
                                    }
                                    
                                   if($blocked==0  ) {
                                         $pg_cnt++;
                                         ?> <li <?php echo $act; ?> ><a id="page_<?php echo $pg_cnt; ?>" href="hp_pendings.php?pagi=<?php echo $log_id[$n]; ?>"><?php echo $pagi_num; ?></a></li><?php
                                       
                                   }
                                

                                   }
                            }
                            
                            ?>
           
                            <li><a href="#" onclick="change_next()">&raquo;</a></li>
                        </ul><br>
                    </div>
                                                                    <?php
                                                            }
                    ?>
                    
                    
                    
                    
                </div>
                
            </div>
                                    <?php   
                               }
                       
            ?>
            
            
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
          function sort_users(its_id){
            if(its_id==="all" ){
                            urls='hp_pendings.php';
 
            }else{
                if( its_id==="gen"){
                     urls='hp_pendings.php?cust_id=0';
                }else{
                    urls='hp_pendings.php?cust_id='+its_id;
                }
                             

            }
                window.location.href=urls;
                
        }
        </script>
    </body>
</html>
