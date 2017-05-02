<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$tar_file=$_REQUEST['tar_file'];
  $file_name="./$tar_file.html";
           
   if(!is_file($file_name)){
  
                   $myfile = fopen($file_name, "w") or die("Unable to open file!");

   }
   $file_cont=$_REQUEST['html_cont'];
   
  $r= file_put_contents($file_name, $file_cont);
  if($r){
      echo "success";
  }else{
      echo "Failure";
  }
    