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

              
            }else{
                  header("location:fin_accounts.php");
            }
            
            $q=q("select finance_name as fn from finance_accounts where fin_id=$fin_id");
            if($q){
                if($fn!=NULL){
                    $_SESSION['fin_id']=$fin_id;
                }else{
                    header("location:index.php");
                }
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
  <?php
  if(!empty($_SESSION['fin_id'])){
  include './header.php';    
  }
   ?>
        <div class="container">
        
              <div class="container">
              <table class="table table-striped">
                    <thead>
                    <th>
                        S.no
                    </th>
                    <th>
                        User name
                    </th>
                    </thead>
                    <tbody>
                        <?php
                        q("select user_name as unm ,users_id from users");
                        for($n=0;$n<count($unm);$n++){
                            if(count($unm)==1){
                                $uname=$unm;
                                $uid=$users_id;
                            }else{
                                $uname=$unm[$n];
                                $uid=$users_id[$n]; 
                            }
                            ?>
                        <tr>
                            <td>
                                <?php echo $n+1; ?>
                            </td>
                            <td>
                                <?php echo $uname; ?>
                            </td>
                            <td>
<!--                                <button onclick="delt_user(<?php echo $uid ?>);">
                                    Delete
                                </button>-->
                            </td>
                        </tr><?php
                        }
                        ?>
                       
                    </tbody>
                </table>
                <div class="add_acnt_holder">
                    <div class="add_acnt_btn" onclick="add_fin_account()">+ Add Users</div>
                    
                </div>
                
               

            </div>
       
            <div class="black_screen" style="display: none">
                <div class="cb_holder col-lg-12" onclick="$('.black_screen').fadeToggle()">
                    <div class="close_btn">X</div>
                </div>
            <div >
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
        </div>
        
         
            
      
            
        </div>
        
        
                    
             <script src="js/home.js"></script>       
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

