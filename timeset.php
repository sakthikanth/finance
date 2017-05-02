<?php


$dt = new DateTime('now', new DateTimezone('Asia/Kolkata'));
echo $dt->format('F j, Y, g:i a');

$date=$dt->format('d-m-Y');

$hr=$dt->format('g');
$min=$dt->format('i');
$noon=$dt->format('A');

echo "$hr $min $noon";


?>