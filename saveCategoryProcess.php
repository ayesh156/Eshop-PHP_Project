<?php

require "connection.php";

if(isset($_POST["t"]) && isset($_POST["e"]) && isset($_POST["n"])){

    $vcode = $_POST["t"];
    $uemail = $_POST["e"];
    $cname = $_POST["n"];

    $admin_rs = Database::search("SELECT * FROM `admin` WHERE `email`='".$uemail."'");
    $admin_num = $admin_rs -> num_rows;

    if($admin_num > 0){
        $admin_data = $admin_rs -> fetch_assoc();
        if($admin_data["verification_code"] = $vcode){
            Database::iud("INSERT INTO `category` (`name`) VALUES ('".$cname."')");

            echo ("Success");
        } else {
            echo ("Invalid Verification Code");
        }
    } else {
        echo ("Invalid Email");
    }
}

?>