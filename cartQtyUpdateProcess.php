<?php

session_start();
require "connection.php";

if(isset($_SESSION["u"])){
    if(isset($_GET["id"])){

        $email = $_SESSION["u"]["email"];
        $pid = $_GET["id"];
        $qty = $_GET["qty"];

        $product_rs = Database::search("SELECT * FROM `product` WHERE `id`='".$pid."' ");
        $product_data = $product_rs -> fetch_assoc();
        $product_qty = $product_data["qty"];

        if($product_qty >= $qty){

            Database::iud("UPDATE `cart` SET `qty`='".$qty."' WHERE `product_id`='".$pid."' ");
            echo ("Updated");

        }else {
            echo ("Maximum quantity has achieved");
            
        }
        

    }else {
        echo ("Something went wrong.");
    }
    
}else {
    echo ("Please Login or Register");
}

?>