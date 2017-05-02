<?php
require 'pdfcrowd.php';

try
{   
    session_start();
    echo $_SESSION['fin_id'];
   $req_url=$_REQUEST['req_url'];
    
      $urls="http://harsankirubakar.esy.es/$req_url.html";
      
      if($req_url=="stl_pdf_html"){
          $fname="STL Pending";
      }elseif($req_url=="tally_pdf_html"){
          $fname="Tally ";
      }else{
          $fname="HP Pending ";
      }

    
    // create an API client instance
    $client = new Pdfcrowd("sakthikanth", "f3fefeda03bf15f8d0f8da40de72455f");

    // convert a web page and store the generated PDF into a $pdf variable
    $pdf = $client->convertURI($urls);

    // set HTTP response headers
    header("Content-Type: application/pdf");
    header("Cache-Control: max-age=0");
    header("Accept-Ranges: none");
    
    $dt = new DateTime('now', new DateTimezone('Asia/Kolkata'));
              $year=$dt->format('Y');
                $month=$dt->format('m');
                $day=$dt->format('d');
                $hr=$dt->format('g');
                $min=$dt->format('i');
                $noon=$dt->format('A');
                
            
                
                $date="$day-$month-$year  ( $hr:$min $noon )";
    header("Content-Disposition: attachment; filename=\"$fname $date.pdf\"");

    // send the generated PDF 
    echo $pdf;
}
catch(PdfcrowdException $why)
{
    echo "Pdfcrowd Error: " . $why;
}
?>