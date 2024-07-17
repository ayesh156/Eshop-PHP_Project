<?php

session_start();

require "connection.php";

if (isset($_SESSION["a"])) {

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Home | Admin</title>
        <link rel="stylesheet" href="bootstrap.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css" />
        <link rel="stylesheet" href="style.css" />

        <link rel="icon" href="resource/logo.svg" />
    </head>

    <body style="background-color: #74EBD5;background-image: linear-gradient(90deg, #74EBD5 0%, #9FACE6 100%);">

        <div class="container-fluid">
            <div class="row">

                <div class="col-12 col-lg-2">
                    <div class="row">
                        <div class="col-12 align-items-start bg-dark">
                            <div class="row g-1 text-center">

                                <div class="col-12 mt-5">
                                    <h4 class="text-white"><?php echo $_SESSION["a"]["fname"] . " " . $_SESSION["a"]["lname"]; ?></h4>
                                    <hr class="border border-1 border-white" />
                                </div>

                                <div class="nav flex-column nav-pills me-3 mt-3" role="tablist" aria-orientation="vertical">
                                    <nav class="nav flex-column">
                                        <a class="nav-link active" aria-current="page" href="#">Dashboard</a>
                                        <a class="nav-link" href="manageUsers.php">Manage Users</a>
                                        <a class="nav-link" href="manageProduct.php">Manage Products</a>
                                    </nav>
                                </div>

                                <div class="col-12 mt-4">
                                    <hr class="border border-1 border-white" />
                                    <h4 class="text-white fw-bold" onclick="window.location = 'sellingHistory.php';" style="cursor: pointer;">Selling History</h4>
                                    <hr class="border border-1 border-white" />
                                </div>
                                <div class="col-12 mt-3 d-grid">
                                    <label class="form-label fs-6 fw-bold text-white">From Date</label>
                                    <input type="date" class="form-control" id="from" />
                                    <label class="form-label fs-6 fw-bold text-white mt-2">To Date</label>
                                    <input type="date" class="form-control" id="to" />
                                    <button class="btn btn-primary mt-2" onclick="findSellings(0);">Search</button>
                                    <hr class="border border-1 border-white" />
                                    <label class="form-label fs-6 fw-bold text-white">Daily Sellings</label>
                                    <hr class="border border-1 border-white" />
                                    <hr class="border border-1 border-white" />
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-10">
                    <div class="row">

                        <div class="text-white fw-bold mb-1 mt-3">
                            <h2 class="fw-bold">Dashboard</h2>
                        </div>
                        <div class="col-12">
                            <hr />
                        </div>
                        <div class="col-12">
                            <div class="row g-1">

                                <div class="col-6 col-lg-4 px-1">
                                    <div class="row g-1">
                                        <div class="col-12 bg-primary text-white text-center rounded" style="height: 100px;">
                                            <br />
                                            <span class="fs-4 fw-bold">Daily Earnings</span>
                                            <br />
                                            <?php

                                            $today = date("Y-m-d");
                                            $thismonth = date("m");
                                            $thisyear = date("Y");

                                            $a = "0";
                                            $b = "0";
                                            $c = "0";
                                            $e = "0";
                                            $f = "0";

                                            $invoice_rs = Database::search("SELECT * FROM `invoice`");
                                            $invoice_num = $invoice_rs->num_rows;

                                            for ($x = 0; $x < $invoice_num; $x++) {
                                                $invoice_data = $invoice_rs->fetch_assoc();

                                                $f = $f + $invoice_data["qty"]; // total qty

                                                $d = $invoice_data["date"];
                                                $splitDate = explode(" ", $d); // separate date from time
                                                $pdate = $splitDate[0]; // Sold date

                                                if ($pdate == $today) {
                                                    $a = $a + $invoice_data["total"];
                                                    $c = $c + $invoice_data["qty"];
                                                }

                                                $splitMonth = explode("-", $pdate); // separate date as year,month & date
                                                $pyear = $splitMonth[0]; // year
                                                $pmonth = $splitMonth[1]; // month

                                                if ($pyear == $thisyear) {
                                                    if ($pmonth == $thismonth) {
                                                        $b = $b + $invoice_data["total"];
                                                        $e = $e + $invoice_data["qty"];
                                                    }
                                                }
                                            }

                                            ?>
                                            <span class="fs-5">Rs. <?php echo $a; ?> .00</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-lg-4 px-1">
                                    <div class="row g-1">
                                        <div class="col-12 bg-white text-black text-center rounded" style="height: 100px;">
                                            <br />
                                            <span class="fs-4 fw-bold">Monthly Earnings</span>
                                            <br />
                                            <span class="fs-5">Rs. <?php echo $b; ?> .00</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-lg-4 px-1">
                                    <div class="row g-1">
                                        <div class="col-12 bg-black text-white text-center rounded" style="height: 100px;">
                                            <br />
                                            <span class="fs-4 fw-bold">Daily Selling</span>
                                            <br />
                                            <span class="fs-5"><?php echo $c; ?> Items</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-lg-4 px-1">
                                    <div class="row g-1">
                                        <div class="col-12 bg-secondary text-white text-center rounded" style="height: 100px;">
                                            <br />
                                            <span class="fs-4 fw-bold">Monthly Selling</span>
                                            <br />
                                            <span class="fs-5"><?php echo $e; ?> Items</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-lg-4 px-1">
                                    <div class="row g-1">
                                        <div class="col-12 bg-success text-white text-center rounded" style="height: 100px;">
                                            <br />
                                            <span class="fs-4 fw-bold">Total Selling</span>
                                            <br />
                                            <span class="fs-5"><?php echo $f; ?> Items</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-lg-4 px-1">
                                    <div class="row g-1">
                                        <div class="col-12 bg-danger text-white text-center rounded" style="height: 100px;">
                                            <br />
                                            <span class="fs-4 fw-bold">Total Engagements</span>
                                            <br />
                                            <?php
                                            $user_rs = Database::search("SELECT * FROM `user`");
                                            $user_num = $user_rs->num_rows;
                                            ?>
                                            <span class="fs-5"><?php echo $user_num; ?> Members</span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-12">
                            <hr />
                        </div>

                        <div class="col-12 bg-dark">
                            <div class="row">
                                <div class="col-12 col-lg-2 text-center my-3">

                                    <label class="form-label fs-4 fw-bold text-white">Total Active Time</label>
                                </div>
                                <div class="col-12 col-lg-10 text-center my-3">
                                    <label class="form-label fs-4 fw-bold text-warning" id="time">

                                        <script>
                                            setInterval(function() {
                                                var r = new XMLHttpRequest();

                                                r.onreadystatechange = function() {
                                                    if (r.readyState == 4) {
                                                        var t = r.responseText;

                                                        document.getElementById("time").innerHTML = t;

                                                    }
                                                }

                                                r.open("GET", "TotalActiveTime.php", true);
                                                r.send();
                                            }, 1000);
                                        </script>

                                    </label>
                                </div>
                            </div>
                        </div>

                        <div id="viewArea">
                            <div class="row">
                                <div class="offset-1 col-10  col-lg-4 my-3 rounded bg-body">
                                    <div class="row g-1">
                                        <div class="col-12 text-center">
                                            <label class="form-label fs-4 fw-bold">Mostly Sold Item</label>
                                        </div>
                                        <?php

                                        $freq_rs = Database::search("SELECT `product_id`,COUNT(`product_id`) AS `value_occurence` FROM `invoice` WHERE `date` LIKE '%" . $today . "%' GROUP BY `product_id` ORDER BY `value_occurence` DESC LIMIT 1");


                                        $freq_num = $freq_rs->num_rows;
                                        if ($freq_num > 0) {
                                            $freq_data = $freq_rs->fetch_assoc();

                                            $product_rs = Database::search("SELECT * FROM `product` WHERE `id`='" . $freq_data["product_id"] . "' ");
                                            $product_data = $product_rs->fetch_assoc();

                                            $image_rs = Database::search("SELECT * FROM `images` WHERE `product_id`='" . $freq_data["product_id"] . "' ");
                                            $image_data = $image_rs->fetch_assoc();

                                            $qty_rs = Database::search("SELECT SUM(`qty`) AS `qty_total` FROM `invoice` WHERE `product_id`='" . $freq_data["product_id"] . "'AND `date` LIKE '%" . $today . "%' ");
                                            $qty_data = $qty_rs->fetch_assoc();

                                        ?>

                                            <div class="col-12 text-center shadow">
                                                <img src="<?php echo $image_data["code"]; ?>" class="img-fluid rounded-top" style="height: 250px;" />
                                            </div>
                                            <div class="col-12 text-center">
                                                <span class="fs-5 fw-bold"><?php echo $product_data["title"]; ?></span><br />
                                                <span class="fs-6"><?php echo $qty_data["qty_total"]; ?> Items</span><br />
                                                <span class="fs-6">Rs. <?php echo $qty_data["qty_total"] * $product_data["price"]; ?>.00</span>
                                            </div>

                                        <?php

                                        } else {

                                        ?>

                                            <div class="col-12 text-center shadow">
                                                <img src="resource/empty.svg" class="img-fluid rounded-top" style="height: 250px;" />
                                            </div>
                                            <div class="col-12 text-center">
                                                <span class="fs-5 fw-bold">----------</span><br />
                                                <span class="fs-6">-- Items</span><br />
                                                <span class="fs-6">Rs. -----.00</span>
                                            </div>

                                        <?php

                                        }

                                        ?>
                                        <div class="col-12 mt-3 mb-3">
                                            <div class="first-place"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="offset-1 col-10 col-lg-4 my-3 rounded bg-body">
                                    <div class="row g-1">
                                        <div class="col-12 text-center">
                                            <label class="form-label fs-4 fw-bold">Mostly Famouse Seller</label>
                                        </div>
                                        <?php

                                        if ($freq_num > 0) {

                                            $profile_rs = Database::search("SELECT * FROM `profile_image` WHERE `user_email`='" . $product_data["user_email"] . "'");
                                            $profile_data = $profile_rs->fetch_assoc();

                                            $user_rs1 = Database::search("SELECT * FROM `user` WHERE `email`='" . $product_data["user_email"] . "'");
                                            $user_data1 = $user_rs1->fetch_assoc();

                                        ?>

                                            <div class="col-12 text-center shadow">
                                                <img src="<?php echo $profile_data["path"]; ?>" class="img-fluid rounded-top" style="height: 250px;" />
                                            </div>
                                            <div class="col-12 text-center">
                                                <span class="fs-5 fw-bold"><?php echo $user_data1["fname"]; ?></span><br />
                                                <span class="fs-6"><?php echo $user_data1["email"]; ?></span><br />
                                                <span class="fs-6"><?php echo $user_data1["mobile"]; ?></span>
                                            </div>

                                        <?php

                                        } else {

                                        ?>

                                            <div class="col-12 text-center shadow">
                                                <img src="resource/new_user.svg" class="img-fluid rounded-top" style="height: 250px;" />
                                            </div>
                                            <div class="col-12 text-center">
                                                <span class="fs-5 fw-bold">--------------</span><br />
                                                <span class="fs-6">--------------</span><br />
                                                <span class="fs-6">---------</span>
                                            </div>

                                        <?php

                                        }



                                        ?>

                                        <div class="col-12 mt-3 mb-3">
                                            <div class="first-place"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <?php include "footer.php" ?>

            </div>
        </div>

        <script src="bootstrap.bundle.js"></script>
        <script src="script.js"></script>
    </body>

    </html>

<?php

} else {
    echo ("You are Not a valid user");
}

?>