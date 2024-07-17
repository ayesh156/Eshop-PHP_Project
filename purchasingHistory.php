<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Purchasing History | eShop</title>
    <link rel="stylesheet" href="bootstrap.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="style.css" />

    <link rel="icon" href="resource/logo.svg" />
</head>

<body>

    <div class="container-fluid">
        <div class="row">
            <?php include "header.php";


            if (isset($_SESSION["u"])) {
                $umail = $_SESSION["u"]["email"];

                $invoice_rs = Database::search("SELECT * FROM `invoice` WHERE `user_email`='" . $umail . "' ");
                $invoice_num = $invoice_rs->num_rows;

            ?>

                <div class="col-12 text-center mb-3">
                    <span class="fs-1 text-primary fw-bold">Purchasing History</span>
                </div>

                <?php
                if ($invoice_num == 0) {
                ?>
                    <div class="col-12 bg-body text-center" style="height: 450px;">
                        <span class="fs-1 fw-bolder text-black-50 d-block" style="margin-top: 200px;">
                            You have not purchased any product yet...
                        </span>
                    </div>
                <?php
                } else {
                ?>
                    <div class="col-12">
                        <div class="row">

                            <div class="col-12 d-none d-lg-block">
                                <div class="row">
                                    <div class="col-1 bg-light">
                                        <label for="" class="form-label fw-bold">#</label>
                                    </div>
                                    <div class="col-3 bg-light">
                                        <label for="" class="form-label fw-bold">Order Details</label>
                                    </div>
                                    <div class="col-1 bg-light text-end">
                                        <label for="" class="form-label fw-bold">Quantity</label>
                                    </div>
                                    <div class="col-2 bg-light text-end">
                                        <label for="" class="form-label fw-bold">Amount</label>
                                    </div>
                                    <div class="col-2 bg-light text-end">
                                        <label for="" class="form-label fw-bold">Purchased Date & Time</label>
                                    </div>
                                    <div class="col-3 bg-light"></div>
                                    <div class="col-12">
                                        <hr />
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <?php
                    $query = "SELECT * FROM `invoice` WHERE `user_email`='" . $umail . "' ";
                    $pageno = 0;

                    if (isset($_GET["page"])) {
                        $pageno = $_GET["page"];
                    } else {
                        $pageno = 1;
                    }

                    $invoice_rs2 = Database::search($query);
                    $invoice_num2 = $invoice_rs2->num_rows;

                    $results_per_page = 6;
                    $number_of_pages = ceil($invoice_num2 / $results_per_page);

                    $page_results = ($pageno - 1) * $results_per_page;
                    $selected_rs =  Database::search($query . " LIMIT " . $results_per_page . " OFFSET " . $page_results . "");

                    $selected_num = $selected_rs->num_rows;

                    for ($x = 0; $x < $selected_num; $x++) {
                        $selected_data = $selected_rs->fetch_assoc();
                        $pid = $selected_data["product_id"]
                    ?>

                        <div class="col-12">
                            <div class="row">

                                <div class="col-12 col-lg-1 bg-info text-center text-lg-start">
                                    <label class="form-label text-white fs-6 py-5"><?php echo $selected_data["order_id"]; ?></label>
                                </div>
                                <div class="col-12 col-lg-3">
                                    <div class="card mx-0 mx-lg-3 my-3" style="max-width: 540px;">
                                        <div class="row g-0">
                                            <div class="col-md-4">
                                                <?php
                                                $image_rs = Database::search("SELECT * FROM `images` WHERE `product_id`='" . $selected_data["product_id"] . "' ");
                                                $image_data = $image_rs->fetch_assoc();

                                                ?>

                                                <img src="<?php echo $image_data["code"]; ?>" class="img-fluid rounded-start" />
                                            </div>
                                            <div class="col-md-8">
                                                <div class="card-body">
                                                    <?php
                                                    $product_rs = Database::search("SELECT * FROM `product` WHERE `id`='" . $selected_data["product_id"] . "' ");
                                                    $product_data = $product_rs->fetch_assoc();

                                                    ?>
                                                    <h5 class="card-title"><?php echo $product_data["title"]; ?></h5>
                                                    <?php
                                                    $seller_rs = Database::search("SELECT * FROM `user` WHERE `email`='" . $product_data["user_email"] . "' ");
                                                    $seller_data = $seller_rs->fetch_assoc();

                                                    ?>
                                                    <p class="card-text"><b>Seller : </b><?php echo $seller_data["fname"] . " " . $seller_data["lname"]; ?></p>
                                                    <p class="card-text"><b>Price : </b>Rs. <?php echo $product_data["price"]; ?> .00</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-1 text-center text-lg-end">
                                    <label class="form-label fs-4 py-5">0<?php echo $selected_data["qty"]; ?></label>
                                </div>
                                <div class="col-12 col-lg-2 bg-info text-center text-lg-end">

                                    <?php
                                    $city_rs = Database::search("SELECT * FROM `city` INNER JOIN `user_has_address` ON city.id=user_has_address.city_id WHERE `user_email`='" . $umail . "' ");
                                    $city_data = $city_rs->fetch_assoc();

                                    $delivery = 0;
                                    if ($city_data["district_id"] == 4) {
                                        $delivery = $product_data["delivery_fee_colombo"];
                                    } else {
                                        $delivery = $product_data["delivery_fee_other"];
                                    }
                                    $t = $selected_data["total"];
                                    $s = $t - $delivery;
                                    ?>

                                    <label class="form-label text-white fs-5 py-5">Rs. <?php echo $s; ?> .00</label>
                                </div>
                                <div class="col-12 col-lg-2 text-center text-lg-end">
                                    <label class="form-label fs-5 py-5"><?php echo $selected_data["date"]; ?></label>
                                </div>
                                <div class="col-12 col-lg-3">
                                    <div class="row">
                                        <div class="col-6 d-grid">
                                            <button class="btn btn-secondary border border-1 fs-5 rounded mt-5 border-primary" onclick="addFeedback(<?php echo $pid; ?>);">
                                                <i class="bi bi-info-circle-fill"></i> Feedback
                                            </button>
                                        </div>
                                        <div class="col-6 d-grid">
                                            <button class="btn btn-danger fs-5 rounded mt-5">
                                                <i class="bi bi-trash3-fill"></i> Delete
                                            </button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-12">
                            <hr />
                        </div>

                        <!-- model start -->

                        <div class="modal" tabindex="-1" id="feedbackModel<?php echo $pid; ?>">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Add New Feedback</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-3">
                                                            <label class="form-label fw-bold">Type</label>
                                                        </div>
                                                        <div class="col-3">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="type<?php echo $x; ?>" id="type1<?php echo $pid; ?>">
                                                                <label class="form-check-label text-success fw-bold" for="type1">
                                                                    Positive
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-3">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="type<?php echo $x; ?>" id="type2<?php echo $pid; ?>" checked>
                                                                <label class="form-check-label text-warning fw-bold" for="type2">
                                                                    Neutral
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-3">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="type<?php echo $x; ?>" id="type3<?php echo $pid; ?>">
                                                                <label class="form-check-label text-danger fw-bold" for="type3">
                                                                    Negative
                                                                </label>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-3">
                                                            <label class="form-label fw-bold" readonly>User's email</label>
                                                        </div>
                                                        <div class="col-9">
                                                            <input type="text" class="form-control" value="<?php echo $umail; ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 mt-2">
                                                    <div class="row">
                                                        <div class="col-3">
                                                            <label class="form-label fw-bold">Feedback</label>
                                                        </div>
                                                        <div class="col-9">
                                                            <textarea cols="50" rows="8" class="form-control" id="feed<?php echo $pid; ?>"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary" onclick="saveFeedback(<?php echo $pid; ?>);">Save changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- model end -->


                    <?php
                    }
                    ?>

                    <div class="offset-2 offset-lg-3 col-8 col-lg-6 text-center mb-3 mt-3">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination pagination-lg justify-content-center">
                                <li class="page-item">
                                    <a class="page-link" href="<?php if ($pageno <= 1) {
                                                                    echo "#";
                                                                } else {
                                                                    echo "?page=" . ($pageno - 1);
                                                                } ?>" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <?php

                                for ($x = 1; $x <= $number_of_pages; $x++) {
                                    if ($x == $pageno) {
                                ?>

                                        <li class="page-item active">
                                            <a class="page-link" href="<?php echo "?page=" . ($x); ?>"><?php echo $x; ?></a>
                                        </li>

                                    <?php
                                    } else {
                                    ?>

                                        <li class="page-item">
                                            <a class="page-link" href="<?php echo "?page=" . ($x); ?>"><?php echo $x; ?></a>
                                        </li>

                                <?php
                                    }
                                }

                                ?>

                                <li class="page-item">
                                    <a class="page-link" href="<?php if ($pageno >= $number_of_pages) {
                                                                    echo "#";
                                                                } else {
                                                                    echo "?page=" . ($pageno + 1);
                                                                } ?>" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>



                    <div class="col-12 mb-3">
                        <div class="row">
                            <div class="offset-lg-10 col-12 col-lg-2 d-grid mb-3">
                                <button class="btn btn-danger"><i class="bi bi-trash3-fill"></i> Delete All Records</button>
                            </div>
                        </div>
                    </div>


                <?php
                }
                ?>



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