<?php

session_start();
if(empty($_SESSION['user_id'])) header("location:index.php");
  require './my.php';
  if(isset($_REQUEST['all_srch_vals'])){
              $srch_val=  mysqli_real_escape_string($dbc,$_REQUEST['all_srch_vals']);

  }else{
      header("location:home.php");
  }
     
      
        
        if(is_numeric($srch_val)){
            $srch_key="mob_no regexp '$srch_val' ";
        }elseif(is_numeric(strpos($srch_val, ":")) && strpos($srch_val, ":")==0){
            $srch_key="stl_id regexp '".substr($srch_val,1)."' ";
        }else{
            $srch_key="name regexp '$srch_val' or nick_name regexp '$srch_val' ";
        }
        
        
        if(isset($_REQUEST['all_srch_vals'])){
            
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
    </head>
    <body>
  <?php
  
  if(isset($_SESSION['fin_id'])){
      $fin_id=$_SESSION['fin_id'];
        $q=q("select finance_name as fn from finance_accounts where fin_id=$fin_id");
            if($q){
                if($fn!=NULL){
                    $_SESSION['fin_id']=$fin_id;
                }else{
                    header("location:index.php");
                }
            }
                
  include './header.php';  
  }else{
      ?><nav class="navbar navbar-default titlebar_nav" role="navigation">
        <div class="navbar-header title_text_div col-lg-3">
                <button type="button" class="navbar-toggle" data-toggle="collapse"
                data-target="#example-navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                </button>
            <a class="navbar-brand" href="home.php">Velmurugan Finance</a>
        </div>
        <div class="collapse navbar-collapse col-lg-6" id="example-navbar-collapse">
                <ul class="nav navbar-nav">


               
                
                    <li>
                    <input  type="text" class="input-lg titlebar_input" placeholder="Search" oninput="srch_this()" id="srch_inp" /><button onclick="srch_this()" class="">Search</button>

                    <div class="col-lg-6">
                        <div id="srch_contt_holder" style="display: none" class="srch_cont">
                         
                     </div>
                    
                 </div>
                 </li>
                 
               <li style="">
                         
                         <a href="./logout.php"><img src="./icons/power.png" width="25" height="25" title="Logout" /></a>
                     </li>
                </ul>

        </div>

                     
                     
             
    </nav><?php
  }
  
 ?>
        <div class="container">
            <div class="PG_ttl">
                Search list of "<?php echo $srch_val;  ?>" from All Finances
            </div>
            <div class="PG_content_holder">
                <div class="PG_ch_inner">
                    <?php
                    
                     if(strlen($srch_val)>0){
            
        q("select name as s_name,stl_id as sid,nick_name as snm,loan_amount,mob_no,fin_id as sfid from customers_stl where $srch_key ");
        if(is_numeric($srch_val)){
            $srch_key="mob_no regexp '$srch_val' ";
        }elseif(is_numeric(strpos($srch_val, ":")) && strpos($srch_val, ":")==0){
            $srch_key="hp_id regexp '".substr($srch_val,1)."' ";
        }else{
            $srch_key="name regexp '$srch_val' or nick_name regexp '$srch_val' ";
        }
        
        
        $tot_cnt=0;
        
        $pers_arr=array();
        for($n=0;$n<count($sid);$n++){
            $tot_cnt++;
            if(count($s_name)==1){
                $name[]=ucfirst($s_name);
                $_id[]=$sid;
                $nick_name[]=$snm;
                $type[]='stl';
                $loan_amt[]=$loan_amount;
                $mob_nos[]=$mob_no;
                $fin_ids[]=$sfid;
               
            }else{
                 $name[]=ucfirst($s_name[$n]);
                $_id[]=$sid[$n];
                $nick_name[]=$snm[$n];
                $type[]='stl';
                 $loan_amt[]=$loan_amount[$n];
                $mob_nos[]=$mob_no[$n];
                $fin_ids[]=$sfid[$n];
            }
            
          
           
            ?>
                                <?php
            
            
        }
         q("select name as h_name,hp_id as hid,nick_name as hnm,loan_amount,mob_no,fin_id as hfid from customers_hp where $srch_key ");
       
          for($n=0;$n<count($hid);$n++){
              $tot_cnt++;
            if(count($h_name)==1){
                $name[]=  ucfirst($h_name);
                $_id[]=$hid;
                $nick_name[]=$hnm;
                $type[]='hp';
                $loan_amt[]=$loan_amount;
                $mob_nos[]=$mob_no;
                $fin_ids[]=$hfid;
              
            }else{
                 $name[]=ucfirst($h_name[$n]);
                $_id[]=$hid[$n];
                $nick_name[]=$hnm[$n];
                $type[]='hp';
                $loan_amt[]=$loan_amount[$n];
                $mob_nos[]=$mob_no[$n];
                $fin_ids[]=$hfid[$n];
            }
            
            
           
            
        }
        
       
        
       
             
        }else{
           
        }
                    ?>
                    <table class="table table-striped table-responsive">
                        <thead>

                        <th>
                            S.no
                        </th>   
                        <th>
                            Name
                        </th>
                        <th>
                            Nick Name
                        </th>
                        <th>
                            Mobile No
                        </th>
                        <th>
                            Account
                        </th>
                        <th>
                            Loan Amount
                        </th>
                        <th>
                            Finance
                        </th>
                        <th>
                            View User
                        </th>
                        </thead>
                        <tbody>
                            <?php
                            
                            $c=0;
                            for($n=0;$n<count($_id);$n++){
                                $c++;
                                ?>
                            <tr>
                                <td>
                                    <?php echo  $n+1; ?>
                                </td>
                                <td>
                                    <?php echo $name[$n]; ?>
                                </td>
                                <td>
                                    <?php echo $nick_name[$n]; ?>
                                </td>
                                <td>
                                    <?php echo $mob_nos[$n]; ?>
                                </td>
                                <td>
                                    <?php if($type[$n]=='stl'){
                                        echo "STL No. ".$_id[$n];
                                        $href="view_stl_user.php?stl_id=".$_id[$n]."&fin_id=".$fin_ids[$n];
                                    }  else {
                                         echo "HP No. ".$_id[$n];
                                          $href="view_hp_user.php?hp_id=".$_id[$n]."&fin_id=".$fin_ids[$n];
                                    }   ?>
                                </td>
                                <td>
                                    Rs. <?php echo convert_rup_format($loan_amt[$n]) ?> /-
                                </td>
                                <td>
                                    <?php
                                    q("select finance_name as fname from finance_accounts where fin_id=$fin_ids[$n]");
                                    echo $fname;
                                    ?>
                                </td>
                                <td>
                                     <a href="<?php echo $href; ?>"> <button>
                                        View
                                    </button>
                                    </a>
                                </td>
                            </tr>
                                    <?php
                            }
                            ?>
                        </tbody>
                      
                    </table>
                   
                    
                </div>
                
            </div>
            
        </div>
       <script>
    max_cnt=0;
    function srch_this(){
         var srch_val=$('#srch_inp').val();
         if(srch_val.length===0){
                     $('#srch_contt_holder').slideUp();

         }else{
             $('#srch_contt_holder').html("Searching ...").slideDown();
       
        var fmdt=new FormData();
        fmdt.append('srch_vals',srch_val);
        var urls="srch_cus.php";
        
        $.ajax({
                url: urls,  
                dataType: 'text',  
                cache: false,
                contentType: false,
                processData: false,
                data: fmdt,                         
                type: 'post',
                success: function(psr){
     
      if(psr==="No user found"){
           $('#srch_contt_holder').html("<div class='each_person'>No user Found</div>");
      }else{
            obj = JSON.parse(psr);
    i=0;
    $('#srch_contt_holder').html('');
var key, count = -1;
for(key in obj.tot_cont) {
  if(obj.tot_cont.hasOwnProperty(key)) {
    count++;
    
    var name=obj.tot_cont[count].name;
    var id=obj.tot_cont[count].id;
    var nick_name=obj.tot_cont[count].nm;
    var ac_type=obj.tot_cont[count].type;
    var fin_id=obj.tot_cont[count].fin_id;
    var fnames=obj.tot_cont[count].fname;
    if(ac_type==="stl"){
        tp="<font color='maroon'><small>STL No. "+id+"</small></font>";
        href='view_stl_user.php?stl_id='+id+"&fin_id="+fin_id;
    }else{
        tp="<font color='maroon'><small>HP No.  "+id+"</small></font>";
         href='view_hp_user.php?hp_id='+id+"&fin_id="+fin_id;
    }
    var pers="<div onclick=\"goto_page('"+href+"')\" onmouseover=\"hover_this('"+count+"')\" id='item_no"+count+"' class='each_person'>"+tp+" "+name+"  <small>( "+nick_name+" )</small> <sup style='color:grey'>"+fnames+"</sup></div>";
     $('#srch_contt_holder').append(pers);
  }
}

if(count>5){
count++;
var pers="<div onclick=\"goto_page('search_all.php?all_srch_vals="+srch_val+"')\" id='item_no"+count+"' class='each_person' style='text-align:center'><font color='crimson'>Show All</font></div>";
     $('#srch_contt_holder').append(pers);
}



max_cnt=count;
      }
  

                }
	    
     }); 
         }
       

    }
    
    function goto_page(its){
    
        window.location.href=its;
    }
    
    function hover_this(i_n){
   
    dwn=i_n;
    
    
     $('.each_person').css("background-color","transparent");
               $('#item_no'+dwn).css("background-color","lightgrey");
               
    }
    
    dwn=0;
    $(document).ready(function (){
    
    $('.titlebar_input').keyup(function(e){
    
    var key=e.which || e.keyCode;
    
    if(key===40){
     dwn++;
      if(dwn>max_cnt){
         dwn=0;
        }
 }
    
        if(key===38){
            dwn--;
            
            if(dwn<0){
                dwn=max_cnt;
                
            }
        }
        
        if(key===13){
             $('#item_no'+dwn).click();
        }
        
        $('.each_person').css("background-color","transparent");
               $('#item_no'+dwn).css("background-color","lightgrey");

    });
    
    
    });
    
</script>    
 
    </body>
</html>
                <?php
        }
        
       
       