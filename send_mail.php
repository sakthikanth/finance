<?php
session_start();
{
    require './my.php';
                 include './backup.php';
                 
                function send_mail_attch($to,$file_nm){
                    
    $cur_date=$_SESSION['cur_date'];
      $dt = new DateTime('now', new DateTimezone('Asia/Kolkata'));
                $hr=$dt->format('g');
                $min=$dt->format('i');
                $noon=$dt->format('A');
                
                $date_time=$cur_date."   $hr:$min $noon";
                                 
    $from_email         = 'noreply@harsankirubakar.esy.es'; //from mail, it is mandatory with some hosts
    $recipient_email    = $to; //recipient email (most cases it is your personal email)
   
    //Capture POST data from HTML form and Sanitize them,
    $sender_name    = "sakthikanth"; //sender name
    $reply_to_email = ""; //sender email used in "reply-to" header
    $subject        = "Sql Backup"; //get subject from HTML form
    $message        = "File at $date_time"; //message
   
    /* //don't forget to validate empty fields
    if(strlen($sender_name)<1){
        die('Name is too short or empty!');
    }
    */
   
    //Get uploaded file data

   
    //read from the uploaded file & base64_encode content for the mail
    $file_name=$file_nm;
    $handle = fopen($file_name, "r");
    $file_size=  filesize($file_name);
    $content = fread($handle, $file_size);
    fclose($handle);
    $encoded_content = chunk_split(base64_encode($content));

        $boundary = md5("sanwebe");
        //header
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "From:".$from_email."\r\n";
        $headers .= "Reply-To: ".$reply_to_email."" . "\r\n";
        $headers .= "Content-Type: multipart/mixed; boundary = $boundary\r\n\r\n";
       
        //plain text
        $body = "--$boundary\r\n";
        $body .= "Content-Type: text/plain; charset=ISO-8859-1\r\n";
        $body .= "Content-Transfer-Encoding: base64\r\n\r\n";
        $body .= chunk_split(base64_encode($message));
       $file_type=  filetype($file_name);
        //attachment
        $body .= "--$boundary\r\n";
        $body .="Content-Type: $file_type; name=".$file_name."\r\n";
        $body .="Content-Disposition: attachment; filename=".$file_name."\r\n";
        $body .="Content-Transfer-Encoding: base64\r\n";
        $body .="X-Attachment-Id: ".rand(1000,99999)."\r\n\r\n";
        $body .= $encoded_content;
   
    $sentMail = @mail($recipient_email, $subject, $body, $headers);
    if($sentMail) //output success or failure messages
    {      
        return TRUE;
    }else{
        return FALSE;
    }

                }
                
                
                q("select file_name as fname,log_id as lid from file_size_tbl where mail_uploaded=0");
                
                for($n=0;$n<count($fname);$n++){
                
                  if(count($fname)==1){
                      
                      $fl_nm=$fname;
                      $log_id=$lid;
                  }else{
                      $fl_nm=$fname[$n];
                      $log_id=$lid;

                      }
                      $to="sakthikanthj@gmail.com";
                             
                      $fl_nm=  substr($fl_nm, 2,  strlen($fl_nm));
                  
                     if(send_mail_attch($to, $fl_nm)){
                        echo "Datas Sent to mail"; 
                        q("Update file_size_tbl set mail_uploaded=1 where log_id=$log_id");
                     }else{
                         echo "Sorry Mail Not Sent";
                     }
                      
                }
                if(count($fname)==0){
                    echo "Already Sent to Mail";
                }
   
}