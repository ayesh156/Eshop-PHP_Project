<?php

require "connection.php";

if(isset($_GET["id"])) {

    $cid = $_GET["id"];

    $cart_rs = Database::search("SELECT * FROM `cart` WHERE `id`='".$cid."'");
    $cart_num = $cart_rs -> num_rows;
    $cart_data = $cart_rs -> fetch_assoc();

    $user = $cart_data["user_email"];
    $product = $cart_data["product_id"];

    if($cart_num == 0){
        echo ("Something went wrong. Please try again later.");
    }else {

        Database::iud("INSERT INTO `recent` (`product_id`,`user_email`) VALUES ('".$product."','".$user."') ");

        Database::iud("DELETE FROM `cart` WHERE `id`='".$cid."' ");

        echo("Success");

    }

}else {
    echo ("Please select a product");
}