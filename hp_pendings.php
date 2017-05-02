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
        <link rel="stylesheet" href="css/homepage.css" />
        <script src="js/jquery.js" ></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/jspdf.debug.js"></script>
        <title>Velmurugan Finance</title>
    </head>
    <body>
        <script>
        function print_pdf(pagin,cust_id){
            
            
           file_name='';
           if(pagin!==''){
               file_name+='pagi='+pagin+'&';
           }
           if(cust_id!==""){
               file_name+="cust_id="+cust_id;
           }
          
               $('.pdf_btn').text('Processing...');
               var fmdt=new FormData();
              var urls='pdf_hp_pending.php?'+file_name;
           $.ajax({
                url: urls,  
                dataType: 'text',  
                cache: false,
                contentType: false,
                processData: false,
                data: fmdt,                         
                type: 'post',
                success: function(psr){
                        create_pdf_html(psr);
                }
	    
     });
            
           
        }
         function create_pdf_html(html_cont){
             var urls="creaate_html_file.php";
             var fmdt=new FormData();
             fmdt.append('html_cont',html_cont);
             fmdt.append('tar_file','hp_pdf_html');
               $.ajax({
                url: urls,  
                dataType: 'text',  
                cache: false,
                contentType: false,
                processData: false,
                data: fmdt,                         
                type: 'post',
                success: function(psr){
                    var req_file="pdf.php?req_url=hp_pdf_html";
                  window.location.href=req_file;
                                       $('.pdf_btn').text('Success').delay(3000).text("Save as Pdf");

                }
	    
     });
         }
        </script>
         
  <?php include './header.php';
      function calc_next_date($cnt_date,$day,$month,$year){
                         
                         $next_date=$cnt_date;
                       
                         
               
               
               switch ($month){
                   case 1:
                       $month_days=31;
                       break;
                   case 2:
                       if(($year%4)==0){
                        $month_days=29;   
                       }else{
                         $month_days=28;
  
                       }
                       break;
                   case 3:
                       $month_days=31;
                       break;
                   case 4:
                       $month_days=30;
                       break;
                   case 5:
                       $month_days=31;
                       break;
                   case 6:
                       $month_days=30;
                       break;
                   case 7:
                       $month_days=31;
                       break;
                   case 8:
                       $month_days=31;
                       break;
                   case 9:
                       $month_days=30;
                       break;
                   case 10:
                       $month_days=31;
                       break;
                   case 11:
                       $month_days=30;
                       break;
                   case 12:
                       $month_days=31;
                       break;
                   
                   
                       
               }
               
               
               $my_month=$month;
               $tar_year=$year;
               
               $my_day=$month_days-$day;
               while($my_day<=$next_date){
                   $my_month+=1;
                   
                    switch ($my_month){
                   case 1:
                       $month_days=31;
                       break;
                   case 2:
                       if(($year%4)==0){
                        $month_days=29;   
                       }else{
                         $month_days=28;
  
                       }
                       break;
                   case 3:
                       $month_days=31;
                       break;
                   case 4:
                       $month_days=30;
                       break;
                   case 5:
                       $month_days=31;
                       break;
                   case 6:
                       $month_days=30;
                       break;
                   case 7:
                       $month_days=31;
                       break;
                   case 8:
                       $month_days=31;
                       break;
                   case 9:
                       $month_days=30;
                       break;
                   case 10:
                       $month_days=31;
                       break;
                   case 11:
                       $month_days=30;
                       break;
                   case 12:
                       $month_days=31;
                       break;
                   
                   
                       
               }
               $my_day+=$month_days;
               if($my_month>12){
                   $tar_year+=1;
                    $my_month=1;
               }
               
               
               }
               $tar_mnth=$my_month;
               if($my_day>$next_date){
                   $diff=$my_day-$next_date;
                   $my_day=$month_days-$diff;
                   
                   
               }
               if($my_day==0){
                   $my_day=1;
               }
               
               
               
               
               if($tar_mnth<=9){
                   $tar_mnth="0".$tar_mnth;
               }
               if($my_day<=9){
                   $my_day="0".$my_day;
               }
                $next_int_date="$tar_year-$tar_mnth-$my_day";
               return $next_int_date;
                     }
  ?>
        <div class="container">
           <div class="col-lg-12 logs_top_holder">
            <div class="PG_ttl col-lg-6">
                HP Pendings of <?php echo $fn;  ?> Finance
            </div>
            <div class="loan_details col-lg-6">
               
                             <div class="loan_amount_hold">
                      Sort by Customers
                    </div>
                 
                    <div class="amnt_inp">
                        <select required name="cus_of" onchange="sort_users(this.value)">
                            <option value="all">All</option>
                            <?php
                            $sel="";
                            $cust_of_name="All";
                              if( isset($_REQUEST['cust_id'])){
                                  if($_REQUEST['cust_id']==0) $sel="selected"; $cust_of_name="General";
                                       
                                    }
                            ?>
                            <option value="gen" <?php  echo $sel;?>>General</option>
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
                                
                                if($_REQUEST['cust_id']==$cus_use_id ){
                                    $sel="selected";
                                    $cust_of_name=$use_name;
                                }else{
                                    $sel="";
                                }
                                ?><option <?php echo $sel; ?> value="<?php echo $cus_use_id; ?>"><?php echo $use_name; ?></option><?php
                            }
                            
                            ?>
                        </select>
                    </div>
                <div>
                     <?php
                if(isset($_REQUEST['pagi'])){
                    $pdf_pagi="".$_REQUEST['pagi'];
                }else{
                    $pdf_pagi="";
                }
                if(isset($_REQUEST['cust_id'])){
                    $pdf_cust="".$_REQUEST['cust_id'];
                }else{
                    $pdf_cust="";
                }
                
                ?>
                    <button class="pdf_btn" onclick="print_pdf('<?php echo $pdf_pagi."','".$pdf_cust; ?>')">Save as Pdf</button>
              </div>
                        <div class="amnt_inp" id="int_rupees_conv"></div>

                          
                        
                        
                    
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
                            Pending from
                        </th>
                        <th>
                            View User
                        </th>
                        </thead>
                        <tbody>
                          
                     
                        
            <?php
            
              $p_arr=array();
                             $year= $_SESSION['cur_year'];
                $month= $_SESSION['cur_month'];
                $day=$_SESSION['cur_day'];
                                       $cur_date="$year-$month-$day";

                
            
               $d_t = new DateTime('now', new DateTimezone('Asia/Kolkata'));
                
                $hr=$d_t->format('g');
                $min=$d_t->format('i');
                $noon=$d_t->format('A');
                
                $date="$day-$month-$year $hr:$min $noon";
                              
                            if(isset($_REQUEST['pagi'])){
                                $pagi_word=" and log_id >= ".$_REQUEST['pagi'].' ';
                                $pagi_recv=$_REQUEST['pagi'];
                            }else
                            {
                                $pagi_word="";
                                 $pagi_recv=0;

                            }
            
                            if(isset($_REQUEST['cust_id'])){
                
                $cust_wrd="and users_id=".$_REQUEST['cust_id'];
            }else{
                $cust_wrd="";
            }
            
            $pg_cnt=0;
            $put=1;
              $tot_pend_array=array();
                       
              include './calc_prev_date.php';
              $tar_int_date=  calc_prev_date(30, $cur_date);
            
              $tot_cnt=0;
              $last_id_arr=array();
              q("select fin_id as fids,hp_id as sids,name as p_name,mob_no as mobi_no,due_months as tot_due_month  from customers_hp where fin_id=$fin_id $cust_wrd $pagi_word and person_status=1 order by hp_id asc");
                if(count($fids)>0){
              for($m=0;$m<count($fids);$m++){
                    if(count($fids)==1){
                    $finc_id=$fids;
                    $hp_ids=$sids;
                    $p_names=$p_name;
                    $mob_nos=$mobi_no;
                        
                    }else{
                         $finc_id=$fids[$m];
                    $hp_ids=$sids[$m];
                    $p_names=$p_name[$m];
                    $mob_nos=$mobi_no[$m];
                   
                    }
                    q("select diff_amount,asal_amount_rate as aar,current_interest as cit,next_due_date as nid from loan_leagure_hp where next_due_date < '$tar_int_date' and fin_id=$fin_id and hp_id=$hp_ids ");
                   if(count($cit)>0){
                       $tot_cnt++;
                       if($tot_cnt>=21){
                           break;
                       }
                                          $dt1=  date_create($nid);
                                $dt2=  date_create($cur_date);
                                
                                $diff=  date_diff($dt2,$dt1);
                                $diff_val=$diff->format("%a");
                                $cur_int=$cit;
                                $h_ref="view_hp_user.php?hp_id=".$hp_ids."&fin_id=".$finc_id;
                                
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
                              if($pending_mnth>=$tot_due_month){
                                  $pending_mnth=$tot_due_month;
                              }
                                  $pre_day= substr($nid, strpos($nid, "-")+4,  2);
                       $pre_mnth=substr($nid, strpos($nid, "-")+1,  2);
                    $pre_tyear=  substr($nid, 0,4);
                
                                      $due_p_month=($aar+$cit);

                   $ext_amount=substr($diff_amount,4,  strlen($diff_amount));
                     $diff_act=  substr($diff_amount,0,1);
                     if($diff_act=='a'){
                         $due_p_month+=$ext_amount;
                     }else{
                        $due_p_month-=$ext_amount;

                     }
               $due_pend_month=$due_p_month*$pending_mnth;
              
                    
    
    ?>
                <tr>
                    <td>
                        <?php echo $tot_cnt; ?>
                    </td>
                    <td>
                        <?php echo $hp_ids ?>
                    </td>
                    <td>
                        <?php echo $fn; ?>
                    </td>
                    <td>
                        <?php echo $p_names ?>
                    </td>
                    <td>
                        <?php echo $mob_nos; ?>
                    </td>
                    <td>
                        <?php echo $pending_mnth ?>
                    </td>
                    <td>
                        Rs. <?php echo convert_rup_format($due_pend_month); ?> /-
                    </td>
                    <td>
                        Rs. <?php echo convert_rup_format($due_p_month); ?> /-
                    </td>
                    <td>
                        
                        
                        <?php
                        $pre_day=$pre_day-1+1;
                        $pre_mnth=$pre_mnth-1+1;
                        $pre_tyear=$pre_tyear-1+1;
                        
                        echo "$pre_day-$pre_mnth-$pre_tyear";  ?>
                    </td>
                   <td>
                        <a href="<?php echo  $h_ref; ?>"> <button>
                                        View
                                    </button>
                                    </a>
                                </td>
                </tr>
        <?php 
                   }
         
               
                            }
                 
                }         
                if($tot_cnt==0){
                    ?><tr>
                        <td colspan="10">
                            <font color='green'>No Pending Customers of <?php echo ucfirst($cust_of_name); ?></font>
                        </td>
                    </tr>
                        <?php
                }

               
                   
             
                            
                          
                     
                            
                            
            ?>
            
               </tbody>
                    </table>
                     <div class="col-lg-12 pagi_hold">
                        <ul class="pagination pagination-lg">
                              <li><a href="#" onclick="change_prev()">&laquo;</a></li>
                    <?php 
                    $page_cnt=0;
                    $page_num=0;
                                  q("select fin_id as fids,hp_id as sids,name as p_name,mob_no as mobi_no from customers_hp where fin_id=$fin_id $cust_wrd and person_status=1 order by hp_id asc ");
                                    for($n=0;$n<count($fids);$n++){
                                        
                                          if(count($fids)==1){
                    $finc_id=$fids;
                    $hp_idss=$sids;
                    $p_names=$p_name;
                    $mob_nos=$mobi_no;
                        
                    }else{
                         $finc_id=$fids[$n];
                    $hp_idss=$sids[$n];
                    $p_names=$p_name[$n];
                    $mob_nos=$mobi_no[$n];
                   
                    }
                    
                         q("select current_interest as cits from loan_leagure_hp where next_due_date < '$tar_int_date' and fin_id=$finc_id and hp_id=$hp_idss ");
                            if(count($cits)>0){
                                
                                $page_cnt++;
                                  if($page_cnt==1 ){
                                  $page_num++;
                                 
                                                                            $act="";

                                      if($pagi_recv==$hp_idss){
                                          $act="class='active'";
                                          $put=$page_num;
                                      }else{
                                          if(!isset($_REQUEST['pagi'])){
                                                    $act="class='active'";
                                                          $put=$page_num;
                                          }
                                          if($page_num>1 && !isset ($_REQUEST['pagi'])){
                                              $act="";
                                          }
                                      }
                                                                    
             ?> <li <?php echo $act; ?> ><a id="page_<?php echo $page_num; ?>" href="hp_pendings.php?pagi=<?php echo $hp_idss; ?>"><?php echo $page_num; ?></a></li><?php

 
                                  
                                
                            }
                            if($page_cnt>=20){
                                $page_cnt=0;
                              
                            }
                            
                            }
                           
                            
                           
                            }

                    ?> <li><a href="#" onclick="change_next()">&raquo;</a></li>
                        </ul>
                     </div>
                </div>
                
            </div>
        </div>
        <script>
        
        cliked=<?php echo $put;  ?>;
        max=<?php echo $page_num; ?>;
        
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
