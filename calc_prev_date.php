<?php 
  function calc_prev_date($cnt,$dates){
            
      
         $day= substr($dates, strpos($dates, "-")+4,  2);
                       $month=substr($dates, strpos($dates, "-")+1,  2);
                    $year=  substr($dates, 0,4);
                    
                    $day=$day-1+1;
                    $month=$month-1+1;
                    $year=$year-1+1;
                    
                  
                  
                    
                 $diff_cnt=0;
              
                 
                if($cnt>$day){
                     
                     $diff_cnt=$day;
                     
                 }
                 if($day>=$cnt){
                   
                    $diff_cnt=$day-$cnt;
                    $cnt=0;
                 }
                 while ($diff_cnt<$cnt || $diff_cnt==0){
                
                      $month-=1;
                 
               switch ($month){
                   case 1:
                       $month_days=31;
                       break;
                   case 2:
                       if(($year%4)==0){
                        $month_days=29;   
                       }else{
                         $month_days=28;
  
                       }
                       break;
                   case 3:
                       $month_days=31;
                       break;
                   case 4:
                       $month_days=30;
                       break;
                   case 5:
                       $month_days=31;
                       break;
                   case 6:
                       $month_days=30;
                       break;
                   case 7:
                       $month_days=31;
                       break;
                   case 8:
                       $month_days=31;
                       break;
                   case 9:
                       $month_days=30;
                       break;
                   case 10:
                       $month_days=31;
                       break;
                   case 11:
                       $month_days=30;
                       break;
                   case 12:
                       $month_days=31;
                       break;
                   
                   
                       
               }
               
                $diff_cnt+=$month_days;
                        
                if($month<=0){
                    $year-=1;
                    $month=12;
                }
                 }
              
                 $mean=$diff_cnt-$cnt;
                 if($mean==0){
                     $day=1;
                 }else{
                     $day=$mean;
                 }
                 
                 if($day<=9){
                     $day="0".$day;
                 }
                 if($month<=9){
                     $month="0".$month;
                 }
                 if($year<=9){
                     $year="0".$year;
                 }
                 
                 return "$year-$month-$day";
                 
             }
             
             
            
            