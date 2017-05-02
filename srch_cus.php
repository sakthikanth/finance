<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

session_start();
if(empty($_SESSION['user_id'])) header("location:index.php");
  require './my.php';
         $srch_val=  mysqli_real_escape_string($dbc,$_REQUEST['srch_vals']);
      
        
        if(is_numeric($srch_val)){
            $srch_key="mob_no regexp '$srch_val' ";
        }elseif(is_numeric(strpos($srch_val, ":")) && strpos($srch_val, ":")==0){
            $srch_key="stl_id regexp '".substr($srch_val,1)."' ";
        }else{
            $srch_key="name regexp '$srch_val' or nick_name regexp '$srch_val' ";
        }
        
      
        if(strlen($srch_val)>0){
            
        q("select name as s_name,stl_id as sid,nick_name as snm,fin_id as s_fid from customers_stl where $srch_key ");
        if(is_numeric($srch_val)){
            $srch_key="mob_no regexp '$srch_val' ";
        }elseif(is_numeric(strpos($srch_val, ":")) && strpos($srch_val, ":")==0){
            $srch_key="hp_id regexp '".substr($srch_val,1)."' ";
        }else{
            $srch_key="name regexp '$srch_val' or nick_name regexp '$srch_val' ";
        }
        
        q("select name as h_name,hp_id as hid,nick_name as hnm,fin_id as h_fid from customers_hp where $srch_key");
        
        $tot_cnt=0;
        
        $pers_arr=array();
        for($n=0;$n<count($sid);$n++){
            $tot_cnt++;
            if(count($s_name)==1){
                $name=ucfirst($s_name);
                $stl_id=$sid;
                $nick_name=$snm;
                $fin_ids=$s_fid;
                
               
               
            }else{
                 $name=ucfirst($s_name[$n]);
                $stl_id=$sid[$n];
                $nick_name=$snm[$n];
                 $fin_ids=$s_fid[$n];
                 
                 
                
            }
            q("select finance_name as fname from finance_accounts where fin_id=$fin_ids");
            if($tot_cnt>10){
                break;
            }
             $pers_arr[]=array('name'=>$name,'id'=>$stl_id,'nm'=>$nick_name,'type'=>'stl','fin_id'=>$fin_ids,'fname'=>$fname);
            ?>
                                <?php
            
            
        }
          for($n=0;$n<count($hid);$n++){
              $tot_cnt++;
            if(count($h_name)==1){
                $name=  ucfirst($h_name);
                $stl_id=$hid;
                $nick_name=$hnm;
                $fin_ids=$h_fid;
                
            }else{
                 $name=ucfirst($h_name[$n]);
                $stl_id=$hid[$n];
                $nick_name=$hnm[$n];
                $fin_ids=$h_fid[$n];
               
                
            }
            q("select finance_name as fname from finance_accounts where fin_id=$fin_ids");
          
            if($tot_cnt>10){
                break;
            }
            
             $pers_arr[]=array('name'=>$name,'id'=>$stl_id,'nm'=>$nick_name,'type'=>'hp','fin_id'=>$fin_ids,'fname'=>$fname);
            
        }
        
       
        
        if($tot_cnt>0){
        $stl_arr=array('tot_cont'=>$pers_arr);
        echo json_encode($stl_arr);
            
        }else{
            echo "No user found";
        }
             
        }else{
            echo "no";
        }
       