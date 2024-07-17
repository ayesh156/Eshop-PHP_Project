<?php

session_start();
require "connection.php";

$msg_txt = $_POST["t"];
$receiver = $_POST["r"];

$d = new DateTime();
$tz = new DateTimeZone("Asia/Colombo");
$d -> setTimezone($tz);
$date = $d -> format("Y-m-d H:i:s");

$sender;

if(isset($_SESSION["u"])){

    $sender = $_SESSION["u"]["email"];

}else if(isset($_SESSION["a"])){

    $sender = $_SESSION["a"]["email"];

}
 
Database::iud("INSERT INTO `chat` (`content`,`date_time`,`status`,`from`,`to`) VALUES ('".$msg_txt."','".$date."','0','".$sender."','".$receiver."')");

echo "success";


?>