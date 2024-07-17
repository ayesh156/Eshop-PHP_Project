<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Invoice | eShop</title>
    <link rel="stylesheet" href="bootstrap.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="style.css" />

    <link rel="icon" href="resource/logo.svg" />
</head>

<body class="mt-2" style="background-color: #f7f7ff;">

    <div class="container-fluid">
        <div class="row">

            <?php include "header.php";

            if (isset($_SESSION["u"])) {
                $umail = $_SESSION["u"]["email"];
                $ids = $_GET["id"];
                $oid = $_GET["oid"];

                $id_array = json_decode($ids);
                $i_count = count($id_array);

            ?>

                <div class="col-12">
                    <hr />
                </div>

                <div class="col-12 btn-toolbar justify-content-end">
                    <button class="btn btn-dark me-2" onclick="printInvoice();"><i class="bi bi-printer-fill"></i> print</button>
                    <button class="btn btn-danger me-2"><i class="bi bi-filetype-pdf"></i> Export as PDF</button>
                </div>

                <div class="col-12" id="page">
                    <div class="row">

                        <div class="col-6">
                            <div class="ms-5 invoiceHeaderImage"></div>
                        </div>

                        <div class="col-6">
                            <div class="row">
                                <div class="col-12 text-primary text-decoration-underline text-end">
                                    <h2>eShop</h2>
                                </div>
                                <div class="col-12 fw-bold text-end">
                                    <span>Maradana, Colombo 10, Sri Lanka</span><br />
                                    <span>+94 112 785694</span><br />
                                    <span>eshop@gmail.com</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <hr class="border border-1 border-primary" />
                        </div>

                        <div class="col-12 mb-4">
                            <div class="row">
                                <div class="col-6">
                                    <h5 class="fw-bold">INVOICE TO :</h5>
                                    <?php
                                    $address_rs = Database::search("SELECT * FROM `user_has_address` WHERE `user_email`='" . $umail . "' ");
                                    $address_data = $address_rs->fetch_assoc();
                                    ?>
                                    <h2><?php echo $_SESSION["u"]["fname"] . " " . $_SESSION["u"]["lname"]; ?></h2>
                                    <span><?php echo $address_data["line1"] . " " . $address_data["line2"]; ?></span><br />
                                    <span><?php echo $umail; ?></span>
                                </div>
                                <?php
                                $invoice_rs = Database::search("SELECT * FROM `invoice` WHERE `order_id`='" . $oid . "'");
                                $invoice_data = $invoice_rs->fetch_assoc();

                                ?>
                                <div class="col-6 text-end mt-4">
                                    <h1 class="text-primary">INVOICE 0<?php echo $invoice_data["id"]; ?></h1>
                                    <span class="fw-bold">Date & Time of Invoice : </span><br />
                                    <span><?php echo $invoice_data["date"]; ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <table class="table">
                                <thead>
                                    <tr class="border border-1 border-secondary">
                                        <th>#</th>
                                        <th>Order ID & Product</th>
                                        <th class="text-end">Unit Price</th>
                                        <th class="text-end">Quantity</th>
                                        <th class="text-end">Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $tdelivery = 0;
                                    $total = 0;

                                    $invoice_rs2 = Database::search("SELECT * FROM `invoice` WHERE `order_id`='" . $oid . "' ");
                                    for ($x = 0; $x < $i_count; $x++) {
                                        $singleId = $id_array[$x];
                                        $invoice_data2 = $invoice_rs2->fetch_assoc();

                                        $product_rs = Database::search("SELECT * FROM `product` WHERE `id`='" . $singleId . "'");
                                        $product_data = $product_rs->fetch_assoc();

                                        $price = $product_data["price"];

                                    ?>
                                        <tr style="height: 72px;">
                                            <td class="bg-primary text-white fs-3">0<?php echo ($invoice_data["id"] + $x); ?></td>
                                            <td>
                                                <span class="fw-bold text-primary text-decoration-underline p-2"><?php echo $oid; ?></span><br />

                                                <span class="fw-bold text-primary fs-4 p-2"><?php echo $product_data["title"]; ?></span>
                                            </td>
                                            <td class="fw-bold fs-6 text-end pt-4 bg-secondary text-white">Rs. <?php echo $price; ?>. 00</td>
                                            <td class="fw-bold fs-6 text-end pt-4">0<?php echo $invoice_data2["qty"]; ?></td>
                                            <td class="fw-bold fs-6 text-end pt-4 bg-secondary text-white">Rs. <?php echo ($price * $invoice_data2["qty"]); ?>. 00</td>
                                        </tr>
                                    <?php

                                        $qty_total = $price * $invoice_data2["qty"];

                                        $city_rs = Database::search("SELECT * FROM `city` WHERE `id`='" . $address_data["city_id"] . "'");
                                        $city_data = $city_rs->fetch_assoc();

                                        $delivery = 0;
                                        if ($city_data["district_id"] == 4) {
                                            $delivery = $product_data["delivery_fee_colombo"];
                                        } else {
                                            $delivery = $product_data["delivery_fee_other"];
                                        }
                                        $tdelivery = (int)$tdelivery + (int)$delivery;

                                        $total = (int)$total + (int)$qty_total;
                                        
                                    }


                                    ?>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="border-0"></td>
                                        <td class="fs-5 text-end fw-bold">SUBTOTAL</td>
                                        <td class="text-end">Rs. <?php echo $total; ?> .00</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="border-0"></td>
                                        <td class="fs-5 text-end fw-bold border-primary">Delivery Fee</td>
                                        <td class="text-end border-primary">Rs. <?php echo $tdelivery; ?> .00</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="border-0"></td>
                                        <td class="fs-5 text-end fw-bold border-primary text-primary">GRAND TOTAL</td>
                                        <td class="text-end border-primary text-primary">Rs. <?php echo $total+$tdelivery; ?> .00</td>
                                    </tr>
                                </tfoot>

                            </table>
                        </div>

                        <div class="col-4 text-center" style="margin-top: -100px;">
                            <span class="fs-1 fw-bold text-success">Thank You !</span>
                        </div>

                        <div class="col-12 border-start border-5 border-primary mt-3 mb-3 rounded" style="background-color: #e7f2ff;">
                            <div class="row">
                                <div class="col-12 mt-3 mb-3">
                                    <label class="form-label fw-bold fs-5">NOTICE : </label><br />
                                    <label class="form-label fs-6">Purchased items can return before 7 days of Delivery.</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <hr class="border border-1 border-primary" />
                        </div>

                        <div class="col-12 text-center mb-3">
                            <label class="form-label fs-5 text-black-50 fw-bold">
                                Invoice was created on a computer and is valid without the Signature and Seal.
                            </label>
                        </div>

                    </div>
                </div>

            <?php
            }
            ?>

            <?php include "footer.php" ?>

        </div>
    </div>

    <script src="bootstrap.bundle.js"></script>
    <script src="script.js"></script>
</body>

</html>