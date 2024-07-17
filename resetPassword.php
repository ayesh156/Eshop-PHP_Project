<?php

require "connection.php";

$email = $_POST["e"];
$np = $_POST["n"];
$rnp = $_POST["r"];
$vcode = $_POST["v"];

if(empty($np)) {
    echo ("Please insert a New Password");
} else if(strlen($np) < 5 || strlen($np) > 20) {
    echo ("Password must be between 5 - 20 characters");
} else if (empty($rnp)) {
    echo ("Please Re-type your New Password");
} else if ($np != $rnp) {
    echo ("Password does not matched");
} else if (empty($vcode)) {
    echo ("Please enter your Varification Code");
} else {

    $rs = Database::search("SELECT * FROM `user` WHERE `email`='".$email."' AND `varification_code`='".$vcode."'");
    $n = $rs -> num_rows;

    if($n == 1) {

        Database::iud("UPDATE `user` SET `password`='".$np."' WHERE `email`='".$email."' ");
        echo ("Success");

    } else {
        echo ("Invalid Varification Code");
    }


}


?>