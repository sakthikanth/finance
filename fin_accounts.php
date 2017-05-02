<?php
            session_start();
            
            if(empty($_SESSION['user_id'])) header("location:index.php");
                       // if(empty($_SESSION['fin_id'])) header("location:fin_accounts.php");

            
            require './my.php';
            
            if(isset($_REQUEST['fin_id'])){
                            $fin_id=$_REQUEST['fin_id'];
                            $_SESSION['fin_id']=$fin_id;

            }elseif(isset ($_SESSION['fin_id'])){
                                            $fin_id=$_SESSION['fin_id'];

              $q=q("select finance_name as fn from finance_accounts where fin_id=$fin_id");
            if($q){
                if($fn!=NULL){
                    $_SESSION['fin_id']=$fin_id;
                }else{
                    $_SESSION['fin_id']="";
                    unset($_SESSION['fin_id']);
                    header("location:index.php");
                }
            }
            }else{
                $fin_id=0;
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
        <script src="js/jquery.js" ></script>
        <script src="js/bootstrap.min.js"></script>
        <title>Velmurugan Finance</title>
        
       
    </head>
    <body>
        <script>
        
        
        </script>    
    <?php
  if(!empty($_SESSION['fin_id'])){
  include './header.php';    
  }else{
      
      ?> <style>
            .date_changer{
    position: absolute;
    background-color: rgba(0,0,0,0.7);
    z-index: 222;
    margin: 0px;
    margin-left: 0px;
    margin-top: -30px;
    
}
        </style><nav class="navbar navbar-default titlebar_nav" role="navigation">
            <a href="home.php"><img class="navbar-header" src="icons_imgs/header_logo.jpg" /></a>

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
                 
              <li>
                    <a href="#" onclick="$('.date_changer').slideToggle()"><?php echo $_SESSION['cur_date']; ?></a>
                </li>
                <li>
                                              <a href="./logout.php"><img src="./icons_imgs/power.png" width="25" height="25" title="Logout" /></a>

                     
                 </li>
                </ul>

        </div>

                     
    </nav>
 
           <div class="col-lg-12 date_changer" style="text-align: center;display: none">
                         <div class="inp_disc"><h2 style="color: white;text-align: center">Set Date</h2> </div>
                                  <div class="">
                                      <div style="display: inline-block;">
                                       <select name="day_loan" id="l_day">
                                          <option value=""> Day</option>
                                          <?php for($n=1;$n<=31;$n++){
                                              
                                              if($cur_ses_day==$n){
                                                  $sel="selected";
                                              }else{
                                                  $sel="";
                                              }
                                              
                                              ?><option  <?php echo $sel; ?> value="<?php echo $n; ?>"><?php  echo $n;?></option><?php     
                                          } ?>
                                          
                                      </select>
                                      </div>
                                          
                                      <div  style="display: inline-block">
                                              <select name="day_month" id="l_mnth">
                                          <option value="">Month</option>
                                          <?php for($n=1;$n<=12;$n++){
                                                 if($cur_ses_mnth==$n){
                                                  $sel="selected";
                                              }else{
                                                  $sel="";
                                              }
                                              
                                          ?><option  <?php echo $sel; ?> value="<?php echo $n; ?>"><?php  echo $n;?></option><?php     
                                          } ?>
                                          
                                      </select>
                                      
                                      </div>
                                      <div  style="display: inline-block">
                                          <select name="day_year" id="l_year">
                                            <option value="">Year</option>
                                          <?php for($n=2013;$n<=2016;$n++){
                                                 if($cur_ses_year==$n){
                                                  $sel="selected";
                                              }else{
                                                  $sel="";
                                              }
                                              
                                          ?><option  <?php echo $sel; ?> value="<?php echo $n; ?>"><?php  echo $n;?></option><?php     
                                          } ?>
                                          
                                      </select>
                                      
                                      </div>
                                      <button class="set_date_val" onclick="set_date()">Set</button>
                                  
                                  
                                          </div>
                            </div>  
 <?php
  }
   ?>
        <div class="">
        
              <div class="container">
               
                <div class="fin_acc_ttl">
                    Financing Accounts
                </div>
                <?php
               
                    
                $q=q("select fin_id as fid,finance_name from finance_accounts");
               
                
                ?>
                <div class="fin_item_container">
                            <?php
                            
                             if($q){
                                 
                                 if(count($fid)==0){
                                     ?><h2 style="text-align: center;color:crimson">No Accounts</h2><?php
                                 }
                    for($n=0;$n<count($fid);$n++){
                        
                        if(count($fid)==1){
                            $f_ids=$fid;
                            $fnames=$finance_name;
                        }else{
                            $f_ids=$fid[$n];
                            $fnames=$finance_name[$n];
                        }
                        
                        ?><a href="home.php?fin_id=<?php echo $f_ids; ?>"><div class="finance_item">
                                <div class="finance_innder">

                                    <div class="finance_text">
                                       <?php echo ucfirst($fnames); ?>
                                    </div>
                                </div>

                        </div></a>
                            
                            <?php
                    }
                }
                            ?>
                                        
                            

                </div>
                
                <div class="add_acnt_holder">
                    <div class="add_acnt_btn" onclick="add_fin_account()">+ Add Account</div>
                    
                </div>

            </div>
       
            <div class="black_screen" style="display: none">
                <div class="cb_holder col-lg-12" onclick="$('.black_screen').fadeToggle()">
                    <div class="close_btn">X</div>
                </div>
            <div class="admin_promt_screen" id="admin_cont">
                <table class="table">
                   
                    <thead>
                    <th colspan="2">
                        Admin Password
                    </th>
                    </thead>
                    <tbody>
                        <tr>
                           <td>
                               <div> Username </div>
                        </td>
                        <td>
                            <input type="text" id="admin_uname" class="admin_chck_inp" placeholder="Admin User Name" />
                        </td>
                         
                        </tr>
                        <tr>
                            <td>
                                <div> Password </div>
                            </td>
                            <td>
                                <input type="password" id="admin_upass" class="admin_chck_inp" placeholder="Enter Password" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <button class="col-lg-12" onclick="check_admin();">Submit</button>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: center" colspan="2">
                                <span style="text-align: center !important" id="check_res"></span>
                            </td>
                        </tr>
                    </tbody>
             
                </table>
            </div>
            
            <div class="admin_promt_screen" style="display: none" id="user_reg_cont">
                <table class="table">
                   
                    <thead>
                    <th colspan="2">
                        Create Finance Account
                    </th>
                    </thead>
                    <tbody>
                        <tr>
                           <td>
                               <div> Finance Name </div>
                        </td>
                        <td>
                            <input type="text" id="user_uname" class="user_chck_inp" placeholder="Finance Name" />
                        </td>
                         
                        </tr>
                      
                        <tr>
                            <td colspan="2">
                                <button class="col-lg-12" onclick="reg_user();">Submit</button>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: center" colspan="2">
                                <span style="text-align: center !important" id="user_check_res"></span>
                            </td>
                        </tr>
                    </tbody>
             
                </table>
            </div>
        </div>
        
         
            
      
            
        </div>
        <script type="text/javascript">
        
        function add_fin_account(){
         
        $('.black_screen').show(); 
          $('#admin_uname').focus();
          $('#admin_cont').fadeIn();
          $('#user_reg_cont').fadeOut();
           $('#user_check_res').html('');
$('.admin_promt_screen *').css('width','0px').animate({width: "+=130px"},250,function (){
  $('.admin_promt_screen *').removeAttr('style');
});

 $('#user_uname').val('');
                  
            $('#admin_uname').val('');
            $('#admin_upass').val('');
              $('#user_check_res').html('');
        }
        
        function check_admin(){
                                $('#check_res').html('<small style="color:crimson;text-align:center" >Processing Please Wait...</small>');

            
            var au=$('#admin_uname').val();
            var ap=$('#admin_upass').val();
            
            var prvnt="~!@#$%^&*()_+`-={}[];':\"<>,./?\\";
            
            for(n=0;n<prvnt.length;n++){
                
                    prev_wrd=prvnt[n];
                    
                if(au.indexOf(prev_wrd)){
                
                }
            
            }
          var urls="check_admin.php";
          var fmdt=new FormData();
          fmdt.append('uname',au);
          fmdt.append('upass',ap);
            $.ajax({
                url: urls,  
                dataType: 'text',  
                cache: false,
                contentType: false,
                processData: false,
                data: fmdt,                         
                type: 'post',
                success: function(psr){
                    if(psr==='n'){
                   
                    $('#check_res').html('<small style="color:crimson;text-align:center" >Wrong Password</small>');
                        
                    }
                    if(psr==='s'){
                   
                    $('#check_res').html('<small style="color:green;text-align:center" >Success</small>');
                          
$('#admin_cont *').animate({width: "-=130px"},250,function (){
  $('#admin_cont').fadeOut();
  
});
$('#user_reg_cont').fadeIn();
  $('#user_reg_cont *').fadeIn().css('width','0px').animate({width: "+=120px"},250,function (){
  $('#user_reg_cont *').removeAttr('style');
});

                    }
                }
	    
     });
            
            
        }
        
        $(document).ready(function(){
            
                $('.admin_chck_inp').keyup(function(e){
                    var key=e.which || e.keyCode;
                    if(key===13){
                        check_admin();
                    }
                });
                $('.user_chck_inp').keyup(function(e){
                    var key=e.which || e.keyCode;
                    if(key===13){
                        reg_user()();
                    }
                });
    
            });
            
            
            function reg_user(){
                                                $('#user_check_res').html('<small style="color:crimson;text-align:center" >Processing Please Wait...</small>');

                   var uu=$('#user_uname').val();
                  
                   
           
            
            var block=0;
            if(uu==="" ){
                block=1;
            }
          
            
            var prvnt="~!$^&*+`{};'\",./?\\";
            
            
            for(n=0;n<prvnt.length;n++){
                
                    prev_wrd=prvnt[n];
                    
                if(uu.indexOf(prev_wrd)>-1){
                block=3;
                }
            
            }
          
            if(block===3){
                alert("Invalid Characters for user name");
            }
            if(block===1){
                alert("Can't be Empty Details");
            }
            
            if(block===0){
                
          var urls="add_fin.php";
          var fmdt=new FormData();
          fmdt.append('fname',uu);
          
            $.ajax({
                url: urls,  
                dataType: 'text',  
                cache: false,
                contentType: false,
                processData: false,
                data: fmdt,                         
                type: 'post',
                success: function(psr){
                   
                    if(psr==='n'){
                   
                    $('#user_check_res').html('<small style="color:crimson;text-align:center" >Try Again</small>');
                        
                    }
                    if(psr==='s'){
                   
                    $('#user_check_res').html('<small style="color:green;text-align:center" >Success</small>');
                       window.location.href='fin_accounts.php';

                    }
                    if(psr==='ae'){
                   
                    $('#user_check_res').html('<small style="color:crimson;text-align:center" >User Already Exists</small>');
                       

                    }
                    if(psr==='em'){
                   alert("Success");
                    $('#user_check_res').html('<h2 style="color:crimson;text-align:center" >Empty Details</h2>');
                       

                    }
                    if(psr==='es'){
                   
                 
                    $('#user_check_res').html('<small style="color:crimson;text-align:center" >Empty Session</small>');
                       

                    }
                     $('.black_screen').fadeOut(1000); 
                }
	    
     });
            
                
            }
                
            }
        </script>
        
                    
                  
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
     $('#srch_inp').blur(function (){
    
    $('#srch_contt_holder').slideUp();
    });
    
   
    
    });
      function set_date(){
            
            
          
            var l_day=$('#l_day').val();
            var l_mnth=$('#l_mnth').val();
            var l_year=$('#l_year').val();
            
            var urls='set_date.php';
            
            if(l_mnth<=9){
            l_mnth="0"+l_mnth;
            }
            if(l_day<=9){
            l_day="0"+l_day;
            }
            
            
            if(l_day==="" || l_mnth==="" || l_year===""){
            
                alert('Select valid date');
            }else{
            var fmdt=new FormData();
            
            var dates=l_year+'-'+l_mnth+"-"+l_day;
            
            var s_date=l_day+"-"+l_mnth+'-'+l_year;
            
            fmdt.append('s_date',s_date);
            fmdt.append('date',dates);
            
            
             $.ajax({
                url: urls,  
                dataType: 'text',  
                cache: false,
                contentType: false,
                processData: false,
                data: fmdt,                         
                type: 'post',
                success: function(psr){
                    alert(psr);
                    window.location.href='';
                }
	    
     });

            
            
        }
            
        }
</script>    

    </body>
   
</html>

