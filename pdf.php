<?php
require 'pdfcrowd.php';

try
{   
    session_start();
    echo $_SESSION['fin_id'];
   $req_url=$_REQUEST['req_html'];
    
      $urls="http://harsankirubakar.esy.es/pdf_stl_pending.php";
echo $urls;
    
    // create an API client instance
    $client = new Pdfcrowd("sakthikanth", "f3fefeda03bf15f8d0f8da40de72455f");

    // convert a web page and store the generated PDF into a $pdf variable
    $pdf = $client->convertURI($urls);

    // set HTTP response headers
    header("Content-Type: application/pdf");
    header("Cache-Control: max-age=0");
    header("Accept-Ranges: none");
    
             $year=date('Y');
                $month=date('m');
                $day=date('d');
                $hr=date('g');
                $min=date('i');
                $noon=date('A');
                
                $date="$day-$month-$year  ( $hr:$min $noon ) ";
    header("Content-Disposition: attachment; filename=\"stl_pending$date.pdf\"");

    // send the generated PDF 
    echo $pdf;
}
catch(PdfcrowdException $why)
{
    echo "Pdfcrowd Error: " . $why;
}
?>