<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Watchlist | eShop</title>
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

                $pageno;

            ?>


                <div class="col-12">
                    <div class="row">
                        <div class="col-12 border border-1 border-primary rounded mb-2">
                            <div class="row">

                                <div class="col-12">
                                    <label class="form-label fs-1 fw-bolder">Watchlist &hearts;</label>
                                </div>

                                <div class="col-12 col-lg-6">
                                    <hr />
                                </div>

                                <div class="col-12">
                                    <div class="row">
                                        <div class="offset-lg-2 col-12 col-lg-6 mb-3">
                                            <input type="text" class="form-control" id="watchlist_search_txt" placeholder="Search in Watchlist..." />
                                        </div>
                                        <div class="col-12 col-lg-2 mb-3 d-grid">
                                            <button class="btn btn-primary" onclick="watchlistSearch(0);">Search</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <hr />
                                </div>

                                <div class="col-11 col-lg-2 border-0 border-end border-1 border-primary">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                                            <li class="breadcrumb-item active" aria-current="page">Watchlist</li>
                                        </ol>
                                    </nav>
                                    <nav class="nav nav-pills flex-column">
                                        <a class="nav-link active" aria-current="page" href="#">My Watchlist</a>
                                        <a class="nav-link" href="#">My Cart</a>
                                        <a class="nav-link" href="recents.php">Recents</a>
                                    </nav>

                                </div>

                                <?php


                                $user = $_SESSION["u"]["email"];

                                $watch_rs = Database::search("SELECT * FROM `watchlist` WHERE `user_email`='" . $user . "'");
                                $watch_num = $watch_rs->num_rows;

                                if ($watch_num == 0) {

                                ?>

                                    <!-- empty view -->
                                    <div class="col-12 col-lg-9">
                                        <div class="row">
                                            <div class="col-12 emptyView"></div>
                                            <div class="col-12 text-center">
                                                <label class="form-label fs-1 fw-bold">You have no items in your Watchlist yet.</label>
                                            </div>
                                            <div class="offset-lg-4 col-12 col-lg-4 d-grid mb-3">
                                                <a href="home.php" class="btn btn-outline-warning fs-3 fw-bold">Start Shipping</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- empty view -->

                                <?php
                                } else {
                                ?>


                                    <!-- have Products -->
                                    <div class="col-12 col-lg-9">
                                        <div class="row" id="watchlistSearchResult">

                                            <?php


                                            if (isset($_GET["page"])) {
                                                $pageno = $_GET["page"];
                                            } else {
                                                $pageno = 1;
                                            }

                                            $results_per_page = 5;
                                            $number_of_pages = ceil($watch_num / $results_per_page);

                                            $page_results = ($pageno - 1) * $results_per_page;
                                            $selected_rs = Database::search("SELECT * FROM `watchlist` WHERE `user_email`='" . $user . "' LIMIT " . $results_per_page . " OFFSET " . $page_results . " ");

                                            $selected_num = $selected_rs->num_rows;

                                            for ($x = 0; $x < $selected_num; $x++) {
                                                $selected_data = $selected_rs->fetch_assoc();

                                            ?>

                                                <div class="card mb-3 mx-0 mx-lg-2 col-12">
                                                    <div class="row g-0">
                                                        <div class="col-md-4">
                                                            <?php

                                                            $img_rs = Database::search("SELECT * FROM `images` WHERE `product_id` = '" . $selected_data["product_id"] . "' ");
                                                            $img_data = $img_rs->fetch_assoc();

                                                            ?>
                                                            <img src="<?php echo $img_data["code"]; ?>" class="img-fluid rounded-start" />
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="card-body">
                                                                <?php

                                                                $product_rs = Database::search("SELECT * FROM `product` WHERE `id` = '" . $selected_data["product_id"] . "' ");
                                                                $product_data = $product_rs->fetch_assoc();

                                                                ?>
                                                                <h5 class="card-title fs-2 fw-bold"><?php echo $product_data["title"]; ?></h5>
                                                                <?php

                                                                $clr_rs = Database::search("SELECT * FROM `colour` WHERE `id` = '" . $product_data["colour_id"] . "' ");
                                                                $clr_data = $clr_rs->fetch_assoc();

                                                                ?>
                                                                <span class="fs-5 fw-bold text-black-50">Colour : <?php echo $clr_data["name"]; ?></span>
                                                                &nbsp;&nbsp; | &nbsp;&nbsp;

                                                                <?php

                                                                $condition_rs = Database::search("SELECT * FROM `condition` WHERE `id` = '" . $product_data["condition_id"] . "' ");
                                                                $condition_data = $condition_rs->fetch_assoc();

                                                                ?>

                                                                <span class="fs-5 fw-bold text-black-50">Condition : <?php echo $condition_data["name"]; ?></span><br />
                                                                <span class="fs-5 fw-bold text-black-50">Price : </span>&nbsp;&nbsp;
                                                                <span class="fs-5 fw-bold text-black"><?php echo $product_data["price"]; ?></span><br />
                                                                <span class="fs-5 fw-bold text-black-50">Quantity : </span>&nbsp;&nbsp;
                                                                <span class="fs-5 fw-bold text-black"><?php echo $product_data["qty"]; ?> Items Available</span><br />
                                                                <span class="fs-5 fw-bold text-black-50">Seller : </span><br />
                                                                <span class="fs-5 fw-bold text-black">Ayesh</span><br />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 mt-5">
                                                            <div class="card-body d-lg-grid">
                                                                <a href='<?php echo "singleProductView.php?id=" . $selected_data["product_id"]; ?>' class="btn btn-outline-success mb-2">Buy Now</a>
                                                                <button class="btn btn-outline-warning mb-2" onclick='addToCart(<?php echo $product_data["id"]; ?>);'>Add To Cart</button>
                                                                <a href="#" class="btn btn-outline-danger" onclick='removeFromWatchlist(<?php echo $selected_data["id"]; ?>);'>Remove</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            <?php
                                            }
                                            ?>
                                            <div class="offset-2 offset-lg-3 col-8 col-lg-6 text-center mb-3">
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
                                        </div>
                                    </div>
                                    <!-- have Products -->

                                <?php
                                }
                                ?>

                            </div>
                        </div>
                    </div>
                </div>

            <?php

            } else {
                echo ("Please Login first");
            }

            ?>

            <?php include "footer.php" ?>

        </div>
    </div>

    <script src="bootstrap.bundle.js"></script>
    <script src="script.js"></script>
</body>

</html>