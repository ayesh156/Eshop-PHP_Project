<?php

session_start();
require "connection.php";

if (isset($_SESSION["u"])) {

    $o_id = $_POST["o"];
    $mail = $_POST["m"];
    $amount = $_POST["a"];
    $ids = $_POST["ids"];
    $q = $_POST["q"];

    $qty_array = json_decode($q);
    $id_array = json_decode($ids);

    $i_count = count($id_array);

    for ($x = 0; $x < $i_count; $x++) {

        $single_id = $id_array[$x];

        $product_rs = Database::search("SELECT * FROM `product` WHERE `id`='" . $single_id . "' ");
        $product_data = $product_rs->fetch_assoc();

        $p_id = $product_data["id"];
        $curr_qty = $product_data["qty"];
        $qty = $qty_array[$x];
        $new_qty = $curr_qty - $qty;
        $price = $product_data["price"];

        $address_rs = Database::search("SELECT * FROM `user_has_address` WHERE `user_email`='" . $mail . "' ");
        $address_data = $address_rs->fetch_assoc();

        $city_rs = Database::search("SELECT * FROM `city` WHERE `id`='" . $address_data["city_id"] . "'");
        $city_data = $city_rs->fetch_assoc();

        $delivery = 0;
        if ($city_data["district_id"] == 4) {
            $delivery = $product_data["delivery_fee_colombo"];
        } else {
            $delivery = $product_data["delivery_fee_other"];
        }
        $amount = $price + $delivery;

        Database::iud("UPDATE `product` SET `qty`='" . $new_qty . "' WHERE `id`='" . $p_id . "' ");

        $d = new DateTime();
        $tz = new DateTimeZone("Asia/Colombo");
        $d->setTimezone($tz);
        $date = $d->format("Y-m-d H:i:s");

        Database::iud("INSERT INTO `invoice` (`order_id`,`date`,`total`,`qty`,`status`,`product_id`,`user_email`) VALUES ('" . $o_id . "','" . $date . "','" . $amount . "','" .  $qty . "','0','" . $p_id . "','" . $mail . "')");
    }

    echo ("1");
}
