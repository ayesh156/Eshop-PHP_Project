<?php
$today = date("Y-m-d");
$start_date = new DateTime("2022-09-27 00:00:00");

$tdate = new DateTime();
$tz = new DateTimeZone("Asia/Colombo");
$tdate->setTimezone($tz);

$end_date = new DateTime($tdate->format("Y-m-d H:i:s"));

$difference = $end_date->diff($start_date);

echo $difference->format('%Y') . " Years " . $difference->format('%m') . " Months " . $difference->format('%d') . " Days " . $difference->format('%H') . " Hours " . $difference->format('%i') . " Minutes " . $difference->format('%s') . " Seconds"; 

?>