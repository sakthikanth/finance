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
        <link rel="stylesheet" href="css/stl_accounts.css" />
        <script src="js/jquery.js" ></script>
        <script src="js/bootstrap.min.js"></script>
        <title>Velmurugan Finance</title>
    </head>
    <body>
  <?php include './header.php'; ?>
        <div class="container">
           <div class="col-lg-12 logs_top_holder">
            <div class="PG_ttl col-lg-6">
                STL Pendings of <?php echo $fn;  ?> Finance
            </div>
            <div class="loan_details col-lg-6">
                             <div class="loan_amount_hold">
                      Sort by Customers
                    </div>
                    <div class="amnt_inp">
                        <select required name="cus_of" onchange="sort_users(this.value)">
                            <option value="all">All</option>
                            <?php
                            
                            q("select user_name,users_id from  users");
                            
                            for($n=0;$n<count($user_name);$n++){
                                if(count($user_name)==1){
                                $use_name=$user_name;   
                                $cus_use_id=$users_id;
                                }else{
                                $use_name=$user_name[$n];    
                                $cus_use_id=$users_id[$n];
                                }
                                
                                if($_REQUEST['cust_id']==$cus_use_id){
                                    $sel="selected";
                                }else{
                                    $sel="";
                                }
                                ?><option <?php echo $sel; ?> value="<?php echo $cus_use_id; ?>"><?php echo $use_name; ?></option><?php
                            }
                            
                            ?>
                        </select>
                    </div>
                        <div class="amnt_inp" id="int_rupees_conv"></div>

                          
                        
                        
                    
                    </div>
                
            </div>
            <?php
            
              $p_arr=array();
                            $year=date('Y');
                $month=date('m');
                $day=date('d');
                $hr=date('g');
                $min=date('i');
                $noon=date('A');
                
                $date="$day-$month-$year $hr:$min $noon";
                              
                            if(isset($_REQUEST['pagi'])){
                                $pagi_word=" sl.log_id <=".$_REQUEST['pagi'].' ';
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
            
            $pg_cnt=0;
            $put=1;
            
                            //next int date = paid int date
                            $r=q("select sl.fin_id as fid,sl.next_int_date as nid,sl.log_id as log_id,sl.stl_id as sid,sl.pend_month as pend_month from loan_leagure_stl as sl inner join customers_stl as c where sl.fin_id=$fin_id $pagi_word $cust_wrd and sl.stl_id=c.stl_id  order by sl.log_id desc limit 20");
                            
                       $cur_date="$year-$month-$day";
                            for($n=0;$n<count($nid);$n++){
                                if(count($nid)==1){
                                   
                                    $paid_int_date=$nid;
                                    $stl_ids=$sid;
                                    $pend_months=$pend_month;
                                    
                                    $fin_id=$fid;
                                    
                                    
                                }else{
                                   $paid_int_date=$nid[$n];
                                   $stl_ids=$sid[$n];
                                   $pend_months=$pend_month[$n];
                                   $fin_id=$fid[$n];
                                   
                                   
                                    
                                }
                              
                                if($n>=20){
                                    break;
                                }
                                $dt1=  date_create($paid_int_date);
                                $dt2=  date_create($cur_date);
                                
                                $diff=  date_diff($dt2,$dt1);
                                $diff_val=$diff->format("%a");
                                   $pending_mnth=0;
                                $tot_pend_days=$diff_val;
                                
                                while($tot_pend_days>30){
                                    $tot_pend_days-=30;
                                    $pending_mnth+=1;
                                }
                                if($tot_pend_days<30 && $tot_pend_days>0){
                                    $pending_mnth+=1;
                                }
                                
                                $tot_pend_amt=0;
                                
                                
                                $h_ref="view_stl_user.php?stl_id=".$stl_ids;
                                                                    q("select name as p_name,mob_no,person_status from customers_stl where fin_id=$fin_id and stl_id=$stl_ids");
                                                                    if($person_status==2 || $person_status=="2"){
                                                                        $pending_mnth=0;
                                                                    }

                                if($pending_mnth>1){
                                    q("select int_amount as ita from stl_interest_sts where fin_id=$fin_id and stl_id=$stl_ids");
                                   for($mp=0;$mp<count($ita);$mp++){
                                       if(count($ita)==1){
                                           $tot_pend_amt+=$ita;
                                       }else{
                                           $tot_pend_amt+=$ita[$mp];
                                       }
                                   }
                                  q("select finance_name as fns from finance_accounts where fin_id=$fin_id");

                                     $p_arr[]=$pending_mnth;
                                     
                                    $tot_pend_array[$pending_mnth]="
                                <td>
                                    ".$stl_ids."
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
                                    Rs. ".convert_rup_format($tot_pend_amt)." /-
                                </td>
                                <td>
                                    Pending From  ".$paid_int_date." 
                                </td>
                                <td>
                                    <a href=\"".$h_ref."\"> <button>
                                        View
                                    </button>
                                    </a>
                                </td>
                            ";
                                    ?>
                               
                                        <?php
                                }
                                
                                
                            }
                            
                            if(count($p_arr)==0){
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
                            STL No
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
                            Interest Amount
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
                          
                            if(count($p_arr)>0){
                                  sort($p_arr);
                                  $c=0;
                            for($n=count($p_arr)-1;$n>=0;$n--){
                                
                                $b=$p_arr[$n];
                                $c++;
                                ?><tr>
                                    <td>
                                        <?php echo $c; ?>
                                    </td>
                                    <?php  echo $tot_pend_array[$b]; ?>
                                    </tr>
                                    <?php
                               
                               
                            } 
                            }
                          
                            ?>
                        </tbody>
                    </table>
                    <div class="col-lg-12 pagi_hold">
                        <?php
                        
                             
                          
                            $pg_cnt=0;
                          
                         
                          $r=q("select sl.next_int_date as nid,sl.pend_month as pend_month,sl.log_id as log_id from loan_leagure_stl as sl inner join customers_stl as c where sl.fin_id=$fin_id $pagi_word $cust_wrd and sl.stl_id=c.stl_id  order by sl.log_id");
                            
                            $pagi_cnt=0;
                            $pagi_num=0;
                            $blocked=0;
                            
                            $tot_page=0;
                            $put=0;
                            
                                 $show=0;
                            $t_cnt=count($pend_month);
                            while($t_cnt>20){
                                $t_cnt-=20;
                                $tot_page+=1;
                            }
                                                            $tot_page+=1;
                                                            if($tot_page>1){
                                                                ?>
                       <ul class="pagination pagination-lg">
                            <li><a href="#" onclick="change_prev()">&laquo;</a></li>
                            <?php
                       

                                                            
                           
                            for($n=0;$n<count($pend_month);$n++){
                                 if(count($pend_month)==1){
                                   
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
                                
                                
                              if($pagi_cnt>=20 ){
                                
                                    $pagi_cnt=0;
                                }
                                if($pagi_cnt==1 && $diff_val>30){
                                
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
                                         ?> <li <?php echo $act; ?> ><a id="page_<?php echo $pg_cnt; ?>" href="stl_pendings.php?pagi=<?php echo $log_id[$n]; ?>"><?php echo $pagi_num; ?></a></li><?php
                                       
                                   }
                                

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
            if(its_id==="all"){
                            urls='stl_pendings.php';
 
            }else{
                             urls='stl_pendings.php?cust_id='+its_id;

            }
                window.location.href=urls;
                
        }
        </script>
    </body>
</html>
