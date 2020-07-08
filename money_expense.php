<?php


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
            session_start();
            
                 if(isset($_REQUEST['pagi'])){
                                $pagi_word="and exp_id <=".$_REQUEST['pagi'].' ';
                                $pagi_recv=$_REQUEST['pagi'];
                            }else
                            {
                                $pagi_word="";
                                 $pagi_recv=0;

                            }
                            
                            
            $total_expense=0;
            
                $year= $_SESSION['cur_year'];
                $month= $_SESSION['cur_month'];
                $day=$_SESSION['cur_day'];
                
               $d_t = new DateTime('now', new DateTimezone('Asia/Kolkata'));
                
                $hr=$d_t->format('g');
                $min=$d_t->format('i');
                $noon=$d_t->format('A');
                
                $date=$_SESSION['cur_date']." $hr:$min $noon";
                
                
                $entries_date=$_SESSION['show_date'];
                
            if(empty($_SESSION['fin_id'])) header ("location:home.php");
            
            $fin_id=$_SESSION['fin_id'];
            require './my.php';
            $rem_amt=0;
            
        q("select remain_bal as kkk from amount_status where fin_id=$fin_id order by log_id desc limit 1");
            
            if($kkk==NULL){
                header("location:add_investers.php");
            }
            
          
            
                $exp_type=$_REQUEST['exp_type'];
                if($exp_type=="o"){
                    $exp_word="Office";
               
                }elseif($exp_type=="s"){
                    $exp_word="Salary";
                    
                }elseif($exp_type=='rr'){
                    $exp_word="Room Rent";
                    
                }elseif ($exp_type=='ad') {
      $exp_word="Advance";
                   
                }elseif ($exp_type=='bnk') {
      $exp_word="Bank";
                    
                }elseif ($exp_type=='otr') {
      $exp_word="Other";
     
                }else{
                    header("location:index.php");
                }
                
                $exp_tp=$exp_type."_jsk";
            
            
            if(isset($_REQUEST['pers_nm']) && isset($_REQUEST['per_amt'])){
                
                $pers_nm=array();
                $pers_amt=array();
              foreach($_REQUEST['pers_nm'] as $name){
                  $pers_nm[]=  ucfirst($name);
                 
              }
              foreach($_REQUEST['per_amt'] as $name){
                  $pers_amt[]=$name;
              }
           
              $n=-1;
             q("select exp_amount as nm from extra_expense where fin_id=$fin_id and exp_type='$exp_tp' $pagi_word order by exp_id desc limit 10");

                         
                          if($nm==NULL){
                              $tot_count=0;
                          }  else {
                          $tot_count=count($nm);    
                          }
                 
              
             $cnt=0;
             $remain=0;
             $m=-1;
          $tot_expense=0;
          
               foreach($_REQUEST['per_amt'] as $name){
                  $cnt++;
                   
                   if(is_numeric($name) && !empty($name))
                       {
                     
                       $m=$m+1;
                        if($cnt>$tot_count || $tot_count==0){
                        
                            $q33=q("select remain_bal as amts from amount_status where fin_id=$fin_id order by log_id desc limit 1");
                          
                               
                          
                            
                            q("SELECT  `off_exp`, `slry_exp`, `rr_exp`, `ad_exp`, `otr_exp`, `bnk_exp` FROM `extra_expense` WHERE fin_id=$fin_id order by exp_id desc limit 1");
                             
                       if($off_exp!=NULL && count($off_exp)>0){
                      
                            
                       }else{
                        $off_exp=0;
                            $slry_exp=0;
                            $rr_exp=0;
                            $otr_exp=0;
                            $ad_exp=0;
                            $bnk_exp=0;
                          
                       }
                               
                           switch ($exp_type){
                                case "o":
                                   $off_exp+=$name;
                                   break;
                                case"s":
                                    $slry_exp+=$name;
                                    break;
                                case "rr";
                                    $rr_exp+=$name;
                                    break;
                                case "ad";
                                    $ad_exp+=$name;
                                    break;
                                case "otr":
                                    $otr_exp+=$name;
                                    break;
                                case "bnk":
                                    $bnk_exp+=$name;
                                    break;
                                    
                                      
                                    
                            }
                            
                          
                           q("select tot_expense from extra_expense where fin_id=$fin_id order by exp_id desc limit 1");
                           $tot_expense+=$name;
                           q("insert into extra_expense (fin_id,exp_amount,discription,exp_type,date,tot_expense,`off_exp`, `slry_exp`, `rr_exp`, `ad_exp`, `otr_exp`, `bnk_exp`)"
                                                        . "values($fin_id,$name,'$pers_nm[$m]','$exp_tp','$date',$tot_expense,$off_exp,$slry_exp,$rr_exp,$ad_exp,$otr_exp,$bnk_exp)");
                            q("select exp_id as lst_id from extra_expense order by exp_id desc limit 1");
                         
                            $exp=$name;
                            $remain=$amts-$exp;
                            $q23=q("INSERT INTO `amount_status` (`log_id`, `date_entry`, `money_out`, `mo_reason`, `remain_bal`, `fin_id`, `cust_id`, `loan_type`,`my_date`,`exp_id`) "
                                                                . "VALUES (NULL, '$entries_date', '$exp', '$pers_nm[$m]', $remain, $fin_id, 0, 0,'$date','$lst_id');");
                        }
                       } 
              }
              
              
              
              
              
              
            }else{

            }
                        $q=q("select finance_name as fn from finance_accounts where fin_id=$fin_id");

            
            ?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
        <link rel="stylesheet" href="css/bootstrap.min.css" />
        <link rel="stylesheet" href="css/header.css" />
        <link rel="stylesheet" href="css/add_invest.css" />
        <link rel="stylesheet" href="css/homepage.css" />
        <script src="js/jquery.js" ></script>
        
        <script src="js/bootstrap.min.js"></script>
        <title>Velmurugan Finance</title>
    </head>
    
    <body>
        
        <?php include './header.php'; ?>
        <div class="col-lg-12">
            <div class="top_container col-lg-12">
                <div class="ttl_main col-lg-6">
                Expense Of  
                
              <?php  echo $exp_word; 
          
             $q2=q("select exp_type ,exp_amount,date,discription,tot_expense,exp_id as eid from extra_expense where fin_id=$fin_id and exp_type='$exp_tp' $pagi_word order by exp_id desc limit 10");

              ?>
                
            </div>
                <div class="max_bal_hold col-lg-6">
                    Remaining Rs <?php
                     q("select remain_bal as kkk from amount_status where fin_id=$fin_id order by log_id desc limit 1");
                    echo convert_rup_format($kkk) ?> /-
                </div>
            </div>
            
               
            <form action="./money_expense.php?exp_type=<?php echo $_REQUEST['exp_type']; ?>" id="form_inv" name="my_form" method="post">
                  <table class="table table-striped">
                <thead>
                <th>
                    S.no
                </th>
                <th>
                    Date
                </th>
                <th>
                    Discription
                </th>
                <th>
                    Amount
                </th>
                <th>
                    Rs
                </th>
                <th>
                    Delete
                </th>
                
                </thead>
            
            
           
                <tbody>

            
                        
              <?php
                if($q2){
                    $tot_cost=0;
                     $exp_amt=0;
                            $exp_date="";
                            $exp_disc='';
                            $tc=0;
                    for($n=count($exp_amount)-1;$n>=0;$n--){
                        $tc++;
                       
                        if(count($exp_amount)==1){
                         
                            $exp_amt=$exp_amount;
                            $exp_date=$date;
                        
                            $exp_disc=$discription;
                            $exp_id=$eid;
                        }else{
                       
                            $exp_amt=$exp_amount[$n];
                            $exp_date=$date[$n];
                            $exp_disc=$discription[$n];
                                 $exp_id=$eid[$n];
                             

                        }
                            $total_expense+=$exp_amt;
                        
                        $exp_amt=$exp_amt-1+1;
                        
                    
                        ?>
                    <tr>
                        <td>
                            <?php echo $tc; ?>
                        </td>
                        <td>
                            <?php  echo $exp_date; ?>
                        </td>
                        <td>
                            <input readonly="" type="text" placeholder="Enter <?php echo $exp_word; ?> expense Discription" value="<?php echo $exp_disc; ?>" name="pers_nm[]"  class="pers_names col-lg-10" />
                        </td>
                        <td>
                            <input type="number" readonly=""  placeholder="Expense Amount" name="per_amt[]" value="<?php echo $exp_amt; ?>" oninput="goto_conv(this.value,'#rup_cnt_<?php echo $n; ?>')" class="pers_amount col-lg-10" />

                            
                        </td>
                        <td>
                        <td>
                            Rs.<span id="rup_cnt_<?php echo $n; ?>"><?php echo convert_rup_format($exp_amt); ?></span> /-
                        </td>
                        <td>
                        <font title="Delete" style="cursor: pointer" onclick="delt_this_exp(<?php echo $exp_amt; ?>,<?php echo $exp_id; ?>,this)" color="crimson">X</font>

                        </td>
                    </tr>
                 
                            <?php
                    }
                   
                }
                ?>
      </tbody>
                    </table>
                  <div class="col-lg-12 pagi_hold" style="text-align: center">
                        <ul class="pagination pagination-lg">
                            <?php
                 q("select exp_amount,exp_id as log_id from extra_expense where fin_id=$fin_id and exp_type='$exp_tp' order by exp_id desc");
   $pg_cnt=0;
                          
                         
                          
                            $pagi_cnt=0;
                            $pagi_num=0;
                            $blocked=0;
                            
                            $tot_page=0;
                            $put=0;
                            
                                 $show=0;
                            $t_cnt=count($exp_amount);
                            while($t_cnt>10){
                                $t_cnt-=10;
                                $tot_page+=1;
                            }
                               
                             if($tot_page>1){
                                 ?><li><a href="#" onclick="change_prev()">&laquo;</a></li><?php
                             }
                            ?>
                            
                            <?php
                            
                          
                                                      $tot_page+=1;

                           
                            for($n=0;$n<count($exp_amount);$n++){
                                
                                 $tot_cost+=$exp_amount[$n];
                                $pagi_cnt++;
                                if($pagi_cnt>=10){
                                    $pagi_cnt=0;
                                }
                                if($pagi_cnt==1 && $tot_page>1){
                                
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
                                         ?> <li <?php echo $act; ?> ><a id="page_<?php echo $pg_cnt; ?>" href="money_expense.php?exp_type=<?php echo $_REQUEST['exp_type']; ?>&pagi=<?php echo $log_id[$n]; ?>"><?php echo $pagi_num; ?></a></li><?php
                                       
                                   }
                                

                                   }else{
                                    
                                }
                            }
                           
                            if(($tot_page-1)>0){
                                ?>  <li><a href="#" onclick="change_next()">&raquo;</a></li><?php
                            }
                            ?>
           
                          
                        </ul><br>
                    </div>
              </form>
            <div class="add_btn_hold">
                <div class="ad_btn" onclick="add_person()">Add Expense</div>
                
            </div>
  <?php  echo "<script>tot_cnt=".$tc.";</script>"; ?>
         
            <div class="tot-inv_cost_hold">
                <div class="tot_cost_hdr">
                    Total Expenses
                </div>
                <div class="tot_cost">
                   Rs. <?php echo$total_expense; ?> /-
                    
                </div>
            </div>
            <div class="subt_holder">
                <div onclick="subt_form()">Submit</div>
                
            </div>
            
        </div>
        
        <script type="text/javascript">
          //  var cnt=tot_cnt;
          
          
         $(document).ready(function(){
             $('.pers_names').keyup(function(e){
                 var key=e.which || e.keyCode;
                 if(key===13){
                     subt_form();
                 }
             });
               $('.pers_amount').keyup(function(e){
                 var key=e.which || e.keyCode;
                 if(key===13){
                     subt_form();
                 }
             });
         });
      
            function add_person(){
                tot_cnt++;
                var pers_cont='<tr>\
                        <td>\
                            '+tot_cnt+'\
                        </td>\
                        <td>\
                           <?php
                             $year=date('Y');
                $month=date('m');
                $day=date('j');
                $hr=date('g');
                $min=date('i');
                $noon=date('A');
                
                $date=$_SESSION['cur_date']." $hr:$min $noon";
                           echo $date; ?>\
                        </td>\
                        <td>\
                            <input type="text" placeholder="Enter <?php echo $exp_word; ?> expense Discription" value="" name="pers_nm[]" class="pers_names col-lg-10" />\
                        </td>\
                        <td>\
           <input type="text"  placeholder="Expense Amount" name="per_amt[]" value="" class="pers_amount col-lg-10" oninput="goto_conv(this.value,\'#rup_cnt_'+tot_cnt+'\')" />\
</td>\
    <td>\
    Rs. <span id="rup_cnt_'+tot_cnt+'">0</span> /-\
    </td>\
                    </tr>';
               
                $('tbody').append(pers_cont);
            }
            
            
            function subt_form(){
                
                block=0;
                var person_names=new Array();
                var amounts=new Array();
                
                n=-1;
                
                $('.pers_names').each(function (){
                    n++;
                    
                    person_names[n]=$(this).val();
                }
                    );
            n=-1;
             $('.pers_amount').each(function (){
                    n++;
                    
                    if($(this).val()==="" || isNaN($(this).val())){
                      if(person_names[n]===""){
                          //$(this).css({"border","1px "});
                          $(this).css("border","1px solid lightgrey");
                          
                      }else{
                           block=1;
                          if( isNaN($(this).val())){
                          block=2;
                }
               
                
                         
                      $(this).css('border','1px solid crimson');

                      }
                    amounts[n]=$(this).val();
                    
                   
                    }else{
                        
                        $(this).css("border","1px solid lightgrey");
                        amounts[n]=$(this).val();
                            
                }
                  if(amounts[n]>max_bal){
                     block=6;
                   
                 }else{
                   
                 }
                   
                }
             );
     
     
     n=-1;
     
     $('.pers_names').each(function(){
         n++;
    if($(this).val()===""){
    
            if(amounts[n]!==""){
                          $(this).css('border','1px solid crimson');
                          block=1;

            }else{
                                 $(this).css('border','1px solid lightgrey');

            }
        }else{
                                         $(this).css('border','1px solid lightgrey');
        }
    
    } );
     
            if(block===1){
            
    alert("Please fill in Required Fields");
    
    }else{
        if(block===2){
           alert("Please Enter Numeric value for Amount");

        }else{
            if(block===6){
            alert("Enter min value to remaining balance");
            }else{
            $('#form_inv').submit();

            }
            
        }
    
    }
            
            
            }
        </script>
            <script>
        
        cliked=<?php echo $put;  ?>;
        max=<?php echo $pg_cnt; ?>;
        max_bal=<?php echo $kkk; ?>;
        
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
         function convert_rupee_format(rup_str){
            var amt_len=rup_str+"";
                
               var b=0;
                var amt_conv="";
                m=0;
                for(n=amt_len.length-1;n>=0;n--){
                    b++;
                    amt_conv+=amt_len[n];
                  
                    if(b>=3){
                       amt_conv+=",";
                       b=0;
                       m=1;
                    }
                    if(b>=2 && m===1){
                        amt_conv+=",";
                        b=0;
                    }
                }
              
            var last_len=amt_conv.lastIndexOf(",");
               var tot_len=amt_conv.length;
               if((tot_len-last_len)===1){
                  amt_conv=amt_conv.substr(0,tot_len-1);

               }
               var conv_amt="";
              for(n=amt_conv.length-1;n>=0;n--){
                  conv_amt+=amt_conv[n];
              }
             
              return conv_amt;

        }
        function goto_conv(its_val,its_id){
            its_val=its_val-1+1;
            if(its_val>max_bal){
               alert("Cant be geater than balance amount ...");
               $(this).val(0);
                $(its_id).html(0);
                
            }else{
                 $(its_id).html(convert_rupee_format(Math.round(its_val)));
            }
           
        }
        
        function delt_this_exp(exp_amt,exp_id,its_elem){
            
          
            
            exp_type='<?php echo $_REQUEST['exp_type']; ?>';
              var cnfrm=confirm("Delete this Expense ?");
            if(cnfrm===true){
                $(its_elem).text('Deleting');
               var fmdt=new FormData();
            fmdt.append('exp_amt',exp_amt);
            fmdt.append('exp_tp',exp_type);
            fmdt.append('exp_id',exp_id);
            
            var urls="delt_expense.php";
             $.ajax({
                url: urls,  
                dataType: 'text',  
                cache: false,
                contentType: false,
                processData: false,
                data: fmdt,                         
                type: 'post',
                success: function(psr){
        
              if(psr==='delt'){
                                  $(its_elem).text('Deleted');

                   window.location.href='';
             }else{
        alert(psr);     
        }
   
                }
	    
                 });   
            }
           
            
        }
        </script>
    </body>
</html>