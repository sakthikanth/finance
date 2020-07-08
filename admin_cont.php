<?php
session_start();
if(empty($_SESSION['user_id'])) header("location:index.php");
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
        <link rel="stylesheet" href="css/homepage.css" />
        <script src="js/jquery.js" ></script>
        <title>Velmurugan Finance</title>
    </head>
    <body>
        
        <div class="">
                    <div class="title_bar">
                       <div class="title_text_cont">
                           Velmurugan Finance
                       </div>
                       <div class="seacr_container">
                           <input type="text" placeholder="Search" /><button >Search</button>
                       </div>
                       <div class="logout_btn">
                           <button>Logout</button>
                       </div>
                   </div>
            <div class="container">
                
                <div class="fin_acc_ttl">
                    Financing Accounts
                </div>
                <?php
                    include './my.php';
                $q=q("select fin_id,finance_name from finance_accounts");
               
                
                ?>
                <div class="fin_item_container">
                            <?php
                            
                             if($q){
                    for($n=0;$n<count($fin_id);$n++){
                        ?>        <a href="home.php?fin_id=<?php echo $fin_id[$n]; ?>"><div class="finance_item">
                                <div class="finance innder">

                                    <div class="finance_text">
                                       <?php echo $finance_name[$n] ?>
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
        </div>
        <div class="black_screen" style="display: none">
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
                        Create User
                    </th>
                    </thead>
                    <tbody>
                        <tr>
                           <td>
                               <div> Username </div>
                        </td>
                        <td>
                            <input type="text" id="user_uname" class="user_chck_inp" placeholder="User Name" />
                        </td>
                         
                        </tr>
                        <tr>
                            <td>
                                <div> Password </div>
                            </td>
                            <td>
                                <input type="password" id="user_pass1" class="user_chck_inp" placeholder="Enter Password" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div> Confirm Password </div>
                            </td>
                            <td>
                                <input type="password" id="user_pass2" class="user_chck_inp" placeholder="Enter Password" />
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
      
    
        <script type="text/javascript">
        
        function add_fin_account(){
         
        $('.black_screen').show(); 
          $('#admin_uname').focus();
          $('#admin_cont').fadeIn();
$('.admin_promt_screen *').css('width','0px').animate({width: "+=130px"},250,function (){
  $('.admin_promt_screen *').removeAttr('style');
});

 $('#user_uname').val('');
                  
            $('#user_pass1').val('');
            $('#user_pass2').val('');
            $('#admin_uname').val('');
            $('#admin_upass').val('');
        }
        
        function check_admin(){
            
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
                   var uu=$('#user_uname').val();
                   uu=uu.trim();
                   
            var up1=$('#user_pass1').val();
            var up2=$('#user_pass2').val();
            
            var block=0;
            if(uu==="" || up1==="" || up2===""){
                block=1;
            }
            if(up1===up2  ){
            
            }else{
                block=2;
            }
            
            var prvnt="~!@#$%^&*()_+`-={}[]; ':\"<>,./?\\";
            
            for(n=0;n<prvnt.length;n++){
                
                    prev_wrd=prvnt[n];
                    
                if(uu.indexOf(prev_wrd)>-1){
                block=3;
                }
            
            }
            if(block===2){
                alert("Password not matched");
            }
            if(block===3){
                alert("Invalid Characters for user name");
            }
            if(block===1){
                alert("Can't be Empty Details");
            }
            
            if(block===0){
                
          var urls="reg_user.php";
          var fmdt=new FormData();
          fmdt.append('uname',uu);
          fmdt.append('upass',up1);
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
    </body>
   
</html>
