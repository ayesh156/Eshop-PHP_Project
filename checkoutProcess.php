<?php

session_start();
require "connection.php";

if (isset($_SESSION["u"])) {

    $ids = $_GET["ids"];
    $ship_fee = $_GET["ship_fee"];
    $qty = $_GET["qty"];
    $umail = $_SESSION["u"]["email"];

    $ids_array = json_decode($ids);
    $qty_array = json_decode($qty);
    $ids_count = count($ids_array);

    $array;
    $price_array;
    $order_id = uniqid();

    $title2 = "";

    for ($y = 0; $y < $ids_count; $y++) {

        $qty2 = $qty_array[$y];
        $product_rs = Database::search("SELECT * FROM `product` WHERE `id`='" . $ids_array[$y] . "' ");
        $product_data = $product_rs->fetch_assoc();
        $title = $product_data["title"];
        $price_array[$y] = $product_data["price"]*intval($qty2);

        $title2 = $title2 . $title . ",";
    }

    $items = rtrim($title2, ",");
    $total_price = array_sum($price_array);

    $city_rs = Database::search("SELECT * FROM `user_has_address` WHERE `user_email`='" . $umail . "'");
    $city_num = $city_rs->num_rows;

    if ($city_num == 1) {

        $city_data = $city_rs->fetch_assoc();

        $city_id = $city_data["city_id"];
        $address = $city_data["line1"] . ", " . $city_data["line2"];

        $district_rs = Database::search("SELECT * FROM `city` WHERE `id`='" . $city_id . "'");
        $district_data = $district_rs->fetch_assoc();

        $amount = $total_price + $ship_fee;

        $fname = $_SESSION["u"]["fname"];
        $lname = $_SESSION["u"]["lname"];
        $mobile = $_SESSION["u"]["mobile"];
        $city = $district_data["city_name"];

        $merchant_secret = "MjgwNzA5MTUxMjMwMzcyMzQ2ODQzMTE2NzkxNjg1MjQzNjc5MDQyMQ==";
        $currency = "LKR";
        $merchant_id = 1221178;

        $hash = strtoupper(
            md5(
                $merchant_id .
                    $order_id .
                    number_format($amount, 2, '.', '') .
                    $currency .
                    strtoupper(md5($merchant_secret))
            )
        );

        $array["id"] = $order_id;
        $array["item"] = $items;
        $array["amount"] = $amount;
        $array["fname"] = $fname;
        $array["lname"] = $lname;
        $array["mobile"] = $mobile;
        $array["address"] = $address;
        $array["city"] = $city;
        $array["mail"] = $umail;
        $array["hash"] = $hash;

        echo json_encode($array);
    } else {
        echo ("2");
    }
} else {
    echo ("1");
}

?>