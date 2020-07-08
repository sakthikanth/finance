<?php
            session_start();
            
            if(empty($_SESSION['fin_id']) || empty($_SESSION['cur_date']) ) header ("location:home.php");
            
            $fin_id=$_SESSION['fin_id'];
            require './my.php';
         
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
                  $year= $_SESSION['cur_year'];
                $month= $_SESSION['cur_month'];
                $day=$_SESSION['cur_day'];
                
                $hr=date('g');
                $min=date('i');
                $noon=date('A');
                
                $date=$_SESSION['cur_date']." $hr:$min $noon";
                $entry_date=$_SESSION['show_date'];
                
                
           if(isset($_REQUEST['saami_amount'])){
                           q("select remain_bal as amts from amount_status where fin_id=$fin_id order by log_id desc limit 1");
                            if(count($amts)==0){
                                $fin_rem=0;
                            }else{
                                $fin_rem=$amts;
                            }
              q("select invest_amount as sami_inva from saami_account where fin_id=$fin_id");
              
              if($sami_inva==NULL){
                 
                  $saami_amt=$_REQUEST['saami_amount'];
                  
                  
                  $dbk_rem=$fin_rem+$saami_amt;
                  q("insert into saami_account(fin_id,invest_amount)values($fin_id,$saami_amt)");
                  $r=q("insert into amount_status (remain_bal,saami,my_date,fin_id)values($dbk_rem,$saami_amt,'$date',$fin_id)");
                 
              }  
           }
          
            
            if((isset($_REQUEST['pers_nm']) && isset($_REQUEST['per_amt']))  ){
                
                $pers_nm=array();
                $pers_amt=array();
              foreach($_REQUEST['pers_nm'] as $name){
                  $pers_nm[]=$name;
                  //echo $name;
              }
              foreach($_REQUEST['per_amt'] as $name){
                  $pers_amt[]=$name;
              }
           
              $n=-1;
          $q6=q("select invester as nm,invest_amount as am,invest_id from investments where fin_id=$fin_id");

                          $tot_count=count($nm);
                          if($nm==NULL){
                              $tot_count+=0;
                          }
              
                          
             $cnt=0;
             $remain=0;
             $m=-1;
               foreach($_REQUEST['per_amt'] as $name){
                  $cnt++;
                  
                   if(is_numeric($name) && !empty($name))
                       {
                       
                       $m=$m+1;
                       
                     
                        if($cnt>$tot_count|| $tot_count==0){
                            $q2=q("insert into investments (fin_id,invest_amount,invester)values($fin_id,$name,'$pers_nm[$m]')");
                      
                            $q34=q("select invest_id as lst_id from investments where fin_id=$fin_id order by invest_id desc limit 1");
                            
                            $rem_amt=0;
              q("select remain_bal as amts from amount_status where fin_id=$fin_id order by log_id desc limit 1");

                            for($n=0;$n<count($amts);$n++){
                                if(count($amts)==1){
                                    $rem_amt+=$amts;
                                }else{
                                    $rem_amt+=$amts[$n];
                                }
                             
                                
                            }
                           
                            $asal=$name;
                            $remain=$rem_amt+$asal;
                            $q23=q("INSERT INTO `amount_status` (`log_id`, `date_entry`, `invest_amt`, `interest`, `remain_bal`, `fin_id`, `cust_id`, `loan_type`,`my_date`,`invest_id`) VALUES (NULL, '$entry_date', '$asal', 0, $remain, $fin_id, '', '','$date','$lst_id');");
                        }
                       }
              }
              
              
              
              
              
              
            }else{

            }
                        $q=q("select finance_name as fn from finance_accounts where fin_id=$fin_id");

            
            ?>
 <?php 
            $q2=q("select invester as nm,invest_amount as am,invest_id as iid from investments where fin_id=$fin_id");
            
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
        <div class="container">
  <div class="ttl_main">
                Add Invest Person
                
            </div>
            
            <div class="person-holder col-lg-12">
                 <div class="col-lg-4">
                         S.No
                     </div>
               
                <div class="col-lg-4">
                    Person Name
                </div>
                <div class="col-lg-4">
                   Amount
                </div>
             
                
            </div>
           
                     
                       <form action="" id="form_inv" name="my_form" method="post">

            <div id="model_person">
                 <div class="each_pers_item col-lg-12" >
                     <div class="col-lg-4">
                         <?php
                           $tot_cost=0;
      q("select invest_amount as sami_inv,log_id as sid from saami_account where fin_id=$fin_id");
      if($sami_inv==NULL){
          $inv_saami=0;
      }else{
          $inv_saami=$sami_inv;
      }
      $tot_cost+=$inv_saami;

                         $m=0;
                         echo $m+1; ?>
                     </div>
                        <div class="col-lg-4">
                            <input type="text" readonly="" placeholder="Name"  value="Saami Account" class="pers_names col-lg-12"/>
                        </div>
                        <div class="col-lg-4">
                            <input type="text"  placeholder="Amount" name="saami_amount" value="<?php 
                            if($inv_saami==0){
                                $inv_saami="";
                            }
                            echo ($inv_saami); ?>" class="pers_amount col-lg-12" />
                        </div>
                   
                 </div>
                        
              <?php
                if($q2){
                  
                    for($n=0;$n<count($nm);$n++){
                        
                       $m++;
                        if(count($nm)==1){
                            $inv_nm=$nm;
                            $inv_amt=$am;
                            $invest_id=$iid;
                        }else{
                            $inv_nm=$nm[$n];
                            $inv_amt=$am[$n];
                             $invest_id=$iid[$n];
                        }
                         $tot_cost+=$inv_amt;
                        ?>
                
                 <div class="each_pers_item col-lg-12" >
                     <div class="col-lg-4">
                         <?php echo $n+1; ?>
                     </div>
                        <div class="col-lg-4">
                            <input type="text"  placeholder="Name" name="pers_nm[]" value="<?php echo $inv_nm; ?>"  class="pers_names col-lg-12"/>
                        </div>
                        <div class="col-lg-4">
                            <input type="text"  placeholder="Amount" name="per_amt[]" value="<?php echo convert_rup_format($inv_amt); ?>"  class="pers_amount col-lg-12" />
                        </div>
                     
                 </div>  
                            <?php
                    }
                    echo "<script>tot_cnt=".  count($nm).";</script>";
                }
                ?>
              
            </div>
            
            <div id="add_item_cont">
                
            </div>
              </form>
             <div class="add_btn_hold">
                <div class="ad_btn" onclick="add_person()">Add Invest Person</div>
                
            </div>
            <div class="tot-inv_cost_hold">
                <div class="tot_cost_hdr">
                    Total Investments
                </div>
                <div class="tot_cost">
                    Rs. <?php echo convert_rup_format($tot_cost); ?> /-
                    
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
                var pers_cont='<div class="each_pers_item col-lg-12" >\
                     <div class="col-lg-4">\
                         '+tot_cnt+'\
                     </div>\
                        <div class="col-lg-4">\
                            <input type="text"  name="pers_nm[]" placeholder="Name"  class="pers_names col-lg-12"/>\
                        </div>\
                        <div class="col-lg-4">\
                            <input type="text" oninput="put_this_val(this,this.value)" name="per_amt[]" placeholder="Amount" class="pers_amount col-lg-12" />\
                        </div>\
                 </div>';
                $('#add_item_cont').append(pers_cont);
            }
            
            function put_this_val(its,its_val){
               while(its_val.indexOf(",")>-1){
               its_val=its_val.replace(",","");
               
                }
            
                
               var rup_va=convert_rupee_format(its_val);
       
        $(its).val(rup_va);
                
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
                    num_val=$(this).val()
                    while(num_val.indexOf(",")>-1){
               num_val=num_val.replace(",","");
               
                }
                $(this).val(num_val);
                    if(num_val==="" || isNaN(num_val)){
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
            $('#form_inv').submit();

        }
    
    }
            
            
            }
            
              function convert_rupee_format(rup_str){
            var amt_len=rup_str+"";
                
                b=0;
                amt_conv="";
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
        
        </script>
    </body>
</html>