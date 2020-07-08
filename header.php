<?php  $cur_ses_date=$_SESSION['show_date']; ?>


<nav class="navbar navbar-default titlebar_nav" role="navigation">
   
    <div class="navbar-header title_text_div" >
       
                <button type="button" class="navbar-toggle" data-toggle="collapse"
                data-target="#example-navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                </button>
        <a href="home.php"> <img  src="icons/header_logo.jpg"  class="navbar-header"/></a>
            <a class="navbar-brand" href="home.php">Velmurugan Finance</a>
        </div>
        <div class="collapse navbar-collapse" id="example-navbar-collapse">
                <ul class="nav navbar-nav">

                   
                  

                <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        Customers<b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="stl_customers.php">STL</a></li>
                            <li><a href="hp_customers.php">HP</a></li>
                        </ul>
                </li>
                <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        Pendings<b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="stl_pendings.php">STL Pending</a></li>
                            <li><a href="hp_pendings.php">HP Pending</a></li>
                        </ul>
                </li>
                <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        GL<b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="money_expense.php?exp_type=o">Office</a></li>
                        <li><a href="money_expense.php?exp_type=s">Salary</a></li>
                        <li><a href="money_expense.php?exp_type=rr">Room Rent</a></li>
                      
                        <li><a href="money_expense.php?exp_type=ad">Advance</a></li>
                         <li><a href="money_expense.php?exp_type=bnk">Bank</a></li>
                         <li><a href="money_expense.php?exp_type=otr">Others</a></li>
                        </ul>
                </li>
                <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        Create Account<b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="divider"></li>
                        <li><a href="create_stl_account.php">Create STL Account</a></li>
                         <li class="divider"></li>
                        <li><a href="create_hp_account.php">Create HP Account</a></li>
                         <li class="divider"></li>
                       
                        </ul>
                </li>
                <li>
                    <a href="#" onclick="$('.date_changer').slideToggle()"><?php echo $_SESSION['cur_date']; ?></a>
                </li>
                <li ><a href="fin_accounts.php"><b><?php
            if($q){
                
                echo ucfirst($fn);
            }
            ?></b></a></li>
                
                <li>
                    <input  type="text" class="input-lg titlebar_input" placeholder="Search" oninput="srch_this()" id="srch_inp" /><button onclick="srch_this()" class="">Search</button>

                     <div>
                        <div id="srch_contt_holder" style="display: none" class="srch_cont">
                         
                     </div>
                    
                 </div>
                 </li>
                 
                 <li>
                                              <a href="./logout.php"><img src="./icons/power.png" width="25" height="25" title="Logout" /></a>

                     
                 </li>
                </ul>

        </div>
    
    <?php
    
    
   
    
     $cur_ses_day=  substr($cur_ses_date, strpos($cur_ses_date, "-")+4,  2);
                    $cur_ses_mnth=substr($cur_ses_date, strpos($cur_ses_date, "-")+1,  2);
                    $cur_ses_year=  substr($cur_ses_date, 0,4);
                   
                     $_SESSION['cur_day']=$cur_ses_day;
                $_SESSION['cur_month']=$cur_ses_mnth;
                $_SESSION['cur_year']=$cur_ses_year;
                
                  $year= $_SESSION['cur_year'];
                $month= $_SESSION['cur_month'];
                $day=$_SESSION['cur_day'];
                
                    $cur_ses_day=$cur_ses_day-1+1;
                    $cur_ses_mnth=$cur_ses_mnth-1+1;
                    $cur_ses_year=$cur_ses_year-1+1;
                   
                
                if($day<=9){
                    $cday="0".$day;
                }
                if($month<=9){
                    $cmnth="0".$month;
                }
                
                $_SESSION['show_date']="$year-$month-$day";
                $_SESSION['cur_date']="$day-$month-$year";
                    
    ?>
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
                                          <?php for($n=2013;$n<=2030;$n++){
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
                    
             
    </nav>

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
 