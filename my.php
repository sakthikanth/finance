<?php
  //require_once 'mysqli_connect.php';
   
   require_once './my_sqlc.php';
function q($q)
       {
    
    $main_q=$q;
    $q=  strtolower($q);
      global $dbc;
      
              $temp=$q;
              $temp=str_replace(" ", "", $temp);
              $temp=  strtolower($temp);
         $temp=".$temp";
              if(strpos($temp, "update")==1 || strpos($temp, "insert")==1 || strpos($temp, "delete")==1 || strpos($temp, "alter")==1 || strpos($temp, "create")==1)
              {
                  $rd2=  mysqli_query($dbc,$main_q);
                  if($rd2){
{


   $q_sel_fl=  mysqli_query($dbc,"select file_size as fss,log_id as fid from file_size_tbl");
$ins_chk=strpos($temp, "insert");
   if($q_sel_fl && !is_numeric($ins_chk) && !is_numeric(strpos($main_q, "Update file_size_tbl set mail_uploaded"))){
  if(mysqli_num_rows($q_sel_fl)==0){
      $file_cnt=1;
  }else{
      $row_file=  mysqli_fetch_array($q_sel_fl,MYSQLI_ASSOC);
      
      $file_cnt=  mysqli_num_rows($q_sel_fl);
      $old_size=$row_file['fss'];
      
  }  
  
  $file_name="./sql/backup_sql_file".($file_cnt).".sql";
           
   if(!is_file($file_name)){
  
                   $myfile = fopen($file_name, "w") or die("Unable to open file!");

   }
     
   $rrf=  fopen($file_name,"r+");
            $old_cont=  file_get_contents($file_name);
     $new_cont="$old_cont
             $main_q;";
     
        fwrite($rrf, $new_cont);

     $cur_date=$_SESSION['cur_date'];
     
 $rs= file_put_contents($file_name, $new_cont);
     $file_size=  filesize($file_name);
     
     
     if(mysqli_num_rows($q_sel_fl)==0){
         
      mysqli_query($dbc,"INSERT INTO `file_size_tbl` (`log_id`, `file_name`, `file_size`, `start_date`, `end_date`) VALUES (NULL, '$file_name', '$file_size', '$cur_date', '');");
            
     }else{
         $file_id=$row_file['fid'];
        $fs_in_kb=$file_size/1024;
        $fs_in_kb=  round($fs_in_kb);
        if($fs_in_kb>1000){
         
             $file_name="backup_sql_file".($file_cnt+1).".sql";
            mysqli_query($dbc,"INSERT INTO `file_size_tbl` (`log_id`, `file_name`, `file_size`, `start_date`, `end_date`) VALUES (NULL, '$file_name', '$file_size', '$cur_date', '');");
        
        }
        
        if(!strpos($main_q, "Update file_size_tbl set mail_uploaded=1")>-1){
                                   mysqli_query($dbc,"Update file_size_tbl set mail_uploaded=0 where log_id=$file_id");

        }

     }
     
     
  
   }else{
     
      
     
   }
     
   
    
}
  
                      return true;
                  }else{
                     
                      
	   $mysql_err=  mysqli_error($dbc);
	   
	          $err=  debug_backtrace();
	          $err_line=$err[0]['line'];
	          $err_file=$err[0]['file'];
	    echo  "<font color='black'>Error at <b>$err_file on line $err_line  </b>query --></font><font color='maroon'>$main_q</font> (<font color='red'> $mysql_err </font> )";
	         
	    return FALSE;
                      
                  }
                  
              }elseif(strpos($temp, "select")==1){
                      
    
     $qn=  str_replace("select ", "", $q);
    
     $qn=substr($qn,0,  strpos($qn, " from"));
     $qn="$qn,";
   
       $selc=  str_replace("`","", $qn);
       $qn=  str_replace("`","", $qn);
       $my_var=array();
       
      $my_nm=array();
       for($m=1;$m<=substr_count($selc, ',');$m++)
       {
              $my_nm[$m]=substr($qn,0,  strpos($qn, ","));

              $qn=substr($qn,strpos($qn, ",")+1, strlen($qn));
              if(strpos($my_nm[$m]," as ")>0)
              {
      $my_var[$m]=  str_replace(" as ", "~", $my_nm[$m]);
      $my_var[$m]=  str_replace(" ", "", $my_var[$m]);
     
    
      $my_var[$m]=substr($my_var[$m],strpos($my_var[$m],"~")+1,strlen($my_var[$m]));
              }else
              {
  $my_var[$m]=substr($my_nm[$m],0,  strlen($my_nm[$m]));  
  $my_var[$m]=  str_replace(" ","", $my_var[$m]);
              }
           
       }
      
       $rn=mysqli_query($dbc, $main_q);
     
       if($rn)
      {
         
              if(mysqli_num_rows($rn)>0)
              {       
 
               for($t=1;$t<=count($my_var);$t++)
             {
           
          $$my_var[$t]=array();
  
    
             }
            
          
    while($row=mysqli_fetch_array($rn,MYSQLI_ASSOC))
    {
           
           if(mysqli_num_rows($rn)>1)
           {
            
                  
              for($t=1;$t<=count($my_var);$t++)
             {
  
             ${$my_var[$t]}[]=$row[$my_var[$t]];
    }
            
     }else{
                  
             for($t=1;$t<=count($my_var);$t++)
             {
    $$my_var[$t]=$row[$my_var[$t]];
    
             }
       
             
           }
    }
    
  if(mysqli_num_rows($rn)>1)
  {
     for($t=1;$t<=count($my_var);$t++)
             {
     $GLOBALS[$my_var[$t]]= sel_mr($my_var,$$my_var[$t]);
    
              
             }   
             
             
             for($t=1;$t<=count($my_var);$t++)
             {
     return $$my_var[$t];
     
     
             }
  }
  if(mysqli_num_rows($rn)==1)
  {
         
              for($t=1;$t<=count($my_var);$t++)
             {
     $GLOBALS[$my_var[$t]]=$$my_var[$t];
    
             }
             for($t=1;$t<=count($my_var);$t++)
             {
     return $$my_var[$t];
    
             }
       
  }
           
          
            
              }else
              {
                  
       for($t=1;$t<=count($my_var);$t++)
             {
     $GLOBALS[$my_var[$t]]=NULL;
    
             }
            


             for($t=1;$t<=count($my_var);$t++)
             {
     return $my_var[$t];
     
     
             }
              
              }
             
      }else
      {
         
             for($t=1;$t<=count($my_var);$t++)
             {
     $my=  mysqli_error($dbc);
     if($t==1)
     {
            $err=  debug_backtrace();
            $err_line=$err[0]['line'];
            $err_file=$err[0]['file'];
      echo  "<font color='#ef0000'>Error at <b>$err_file on line $err_line  </b>query --></font><font color='maroon'>$q</font> (<font color='red'> $my </font> )";
           
     }
       $GLOBALS[$my_var[$t]]=  "<font color='#ef0000'>Error query --></font><font color='maroon'>$main_q</font> (<font color='red'> $my </font> )";
    
             }
            


             for($t=1;$t<=count($my_var);$t++)
             {
     for($p=0;$p<count($$my_var[$t]);$p++)
     {
            $a=$$my_var[$t];
            return $a;    
     }
     
     
             }
            
      }
              }
     
       
       }
     function sel_mr($a,$ab)
     {
            for($t=1;$t<=count($a);$t++)
            {
	  foreach ($ab as $my)
	  {
	      
	         ${$a[$t]}[]=$my;
	        
	  }
            }
            
            for($t=1;$t<=count($a);$t++)
            { 
	  return $$a[$t];
            }
           
            
     } 
    
?>