
        function add_fin_account(){
         
        $('.black_screen').show(); 
          $('#admin_uname').focus();
          $('#admin_cont').fadeIn();
          $('#user_reg_cont').fadeOut();
$('.admin_promt_screen *').css('width','0px').animate({width: "+=130px"},250,function (){
  $('.admin_promt_screen *').removeAttr('style');
});

 $('#user_uname').val('');
                  
            $('#user_pass1').val('');
            $('#user_pass2').val('');
            $('#admin_uname').val('');
            $('#admin_upass').val('');
            $('#user_check_res').html('');
             $('#check_res').html('');
        }
        
        function check_admin(){
            
            var au=$('#admin_uname').val();
            var ap=$('#admin_upass').val();
            
            var prvnt="~!@#$%^&*_`-={};':\"<>,./?\\";
            
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
                       window.location.href='users.php';

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
            
            function delt_user(its_id){
            
            var urls='delt_user.php';
            var fmdt=new FormData();
            
            fmdt.append('ids',its_id);
             $.ajax({
                url: urls,  
                dataType: 'text',  
                cache: false,
                contentType: false,
                processData: false,
                data: fmdt,                         
                type: 'post',
                success: function(psr){
                 
                if(psr==='s'){
                    window.location.href='users.php';
                }else{
             alert('Try Again');       
            }
        }
	    
     });
            }
            