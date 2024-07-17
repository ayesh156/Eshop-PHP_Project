<?php
session_start();

require "connection.php";

if (isset($_SESSION["u"])) {

    $email = $_SESSION["u"]["email"];

    $total = 0;
    $subtotal = 0;
    $shipping = 0;

$txt = $_POST["t"];
if (isset($txt)) {

    $query = "SELECT * FROM `cart` INNER JOIN `product` ON cart.product_id=product.id  WHERE `title` LIKE '%" . $txt . "%'  ";

} else {
    $query = "SELECT * FROM `cart`";
}

if ("0" != ($_POST["page"])) {
    $pageno = $_POST["page"];
} else {
    $pageno = 1;
}

$cart_rs = Database::search($query);
$cart_num = $cart_rs->num_rows;

if ($cart_num == 0) {
?>
    <!-- Empty View start -->
    <div class="col-12">
        <div class="row">
            <div class="col-12 emptyCart"></div>
            <div class="col-12 text-center mb-2">
                <label class="form-label fs-1 fw-bold">
                    You have no items in your Cart yet.
                </label>
            </div>
            <div class="offset-lg-4 col-12 col-lg-4 d-grid mb-3">
                <a href="home.php" class="btn btn-outline-info fs-3 fw-bold">
                    Start Shopping
                </a>
            </div>
        </div>
    </div>
    <!-- Empty View end -->
<?php
} else {
?>
    <!-- Products start -->
    <div class="col-12 col-lg-9">
        <div class="row">

            <?php

            $results_per_page = 6;
            $number_of_pages = ceil($cart_num / $results_per_page);

            $page_results = ($pageno - 1) * $results_per_page;
            $selected_rs =  Database::search($query . " LIMIT " . $results_per_page . " OFFSET " . $page_results . "");

            $selected_num = $selected_rs->num_rows;

            for ($x = 0; $x < $selected_num; $x++) {
                $selected_data = $selected_rs->fetch_assoc();

                $product_rs = Database::search("SELECT * FROM `product` WHERE `id`='" . $selected_data["product_id"] . "' ");
                $product_data = $product_rs->fetch_assoc();

                $cart_rs2 = Database::search("SELECT * FROM `cart` WHERE `product_id`='" . $selected_data["product_id"] . "' ");
                $cart_data2 = $cart_rs2->fetch_assoc();

                $total = $total + ($product_data["price"] * $cart_data2["qty"]);

                $address_rs = Database::search("SELECT district.id as did FROM `user_has_address` INNER JOIN `city` ON user_has_address.city_id=city.id INNER JOIN `district` ON city.district_id=district.id WHERE `user_email`='" . $email . "' ");

                $address_data = $address_rs->fetch_assoc();

                $ship = 0;

                if ($address_data["did"] == 1) {
                    $ship = $product_data["delivery_fee_colombo"];
                    $shipping = $shipping + $ship;
                } else {
                    $ship = $product_data["delivery_fee_other"];
                    $shipping = $shipping + $ship;
                }

                $seller_rs = Database::search("SELECT * FROM `user` WHERE `email`='" . $product_data["user_email"] . "' ");
                $seller_data = $seller_rs->fetch_assoc();
                $seller = $seller_data["fname"] . " " . $seller_data["lname"];

            ?>

                <div class="card mb-3 mx-0 col-12">
                    <div class="row g-0">
                        <div class="col-md-12 mt-3 mb-3">
                            <div class="row">
                                <div class="col-12">
                                    <span class="fw-bold text-black-50 fs-5">Seller :</span>&nbsp;
                                    <span class="fw-bold text-black fs-5"><?php echo $seller ?></span>&nbsp;
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="col-md-4">
                            <span class="d-inline-block" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="<?php echo $product_data["description"] ?>" title="Product Details">
                                <?php
                                $img_rs = Database::search("SELECT * FROM `images` WHERE `product_id`='" . $product_data["id"] . "' ");
                                $img_data = $img_rs->fetch_assoc();
                                ?>
                                <img src="<?php echo $img_data["code"]; ?>" class="img-fluid rounded-start" style="max-width: 200px;">
                            </span>


                        </div>
                        <div class="col-md-5">
                            <div class="card-body">

                                <h3 class="card-title"><?php echo $product_data["title"]; ?></h3>
                                <?php
                                $clr_rs = Database::search("SELECT * FROM `colour` WHERE `id`='" . $product_data["colour_id"] . "' ");
                                $clr_data = $clr_rs->fetch_assoc();
                                ?>
                                <span class="fw-bold text-black-50">Colour : <?php echo $clr_data["name"]; ?></span> &nbsp; |
                                <?php
                                $condition_rs = Database::search("SELECT * FROM `condition` WHERE `id`='" . $product_data["condition_id"] . "' ");
                                $condition_data = $condition_rs->fetch_assoc();
                                ?>
                                &nbsp; <span class="fw-bold text-black-50">Condition : <?php echo $condition_data["name"]; ?></span>
                                <br>
                                <span class="fw-bold text-black-50 fs-5">Price :</span>&nbsp;
                                <span class="fw-bold text-black fs-5">Rs.<?php echo $product_data["price"]; ?>.00</span>
                                <br>
                                <span class="fw-bold text-black-50 fs-5">Quantity :</span>&nbsp;
                                <input type="number" class="mt-3 border border-2 border-secondary fs-4 fw-bold px-3 cardqtytext" value="<?php echo $cart_data2["qty"]; ?>" id="cq" onchange='cartQtyUpdate(<?php echo $product_data["id"]; ?>);' min="1">
                                <br><br>
                                <span class="fw-bold text-black-50 fs-5">Delivery Fee :</span>&nbsp;
                                <span class="fw-bold text-black fs-5">Rs.<?php echo $ship ?>.00</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card-body d-grid">
                                <button class="btn btn-outline-success mb-2">Buy Now</button>
                                <button class="btn btn-outline-danger mb-2" onclick='removeFromCart(<?php echo $selected_data["id"]; ?>);'>Remove</button>
                            </div>
                        </div>

                        <hr>

                        <div class="col-md-12 mt-3 mb-3">
                            <div class="row">
                                <div class="col-6 col-md-6">
                                    <span class="fw-bold fs-5 text-black-50">Requested Total <i class="bi bi-info-circle"></i></span>
                                </div>
                                <div class="col-6 col-md-6 text-end">
                                    <span class="fw-bold fs-5 text-black-50">Rs.<?php echo ($product_data["price"] * $selected_data["qty"]) + $ship ?>.00</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            <?php
            }

            ?>


        </div>
    </div>




    <!-- Products end -->

    <!-- Summery start -->
    <div class="col-12 col-lg-3">
        <div class="row">

            <div class="col-12">
                <label class="form-label fs-3 fw-bold">Summary</label>
            </div>

            <div class="col-12">
                <hr />
            </div>

            <div class="col-6 mb-3">
                <span class="fs-6 fw-bold">items (<?php echo $cart_num ?>)</span>
            </div>

            <div class="col-6 text-end mb-3">
                <span class="fs-6 fw-bold">Rs.<?php echo $total ?>.00</span>
            </div>

            <div class="col-6">
                <span class="fs-6 fw-bold">Shipping</span>
            </div>

            <div class="col-6 text-end">
                <span class="fs-6 fw-bold">Rs. <?php echo $shipping ?> .00</span>
            </div>

            <div class="col-12 mt-3">
                <hr />
            </div>

            <div class="col-6 mt-2">
                <span class="fs-4 fw-bold">Total</span>
            </div>

            <div class="col-6 mt-2 text-end">
                <span class="fs-4 fw-bold">Rs.<?php echo ($shipping + $total) ?>.00</span>
            </div>

            <div class="col-12 mt-3 mb-3 d-grid">
                <button class="btn btn-primary fs-5 fw-bold">CHECKOUT</button>
            </div>

        </div>
    </div>
    <!-- Summery end -->
<?php
}

?>

<div class="col-12 col-lg-9 text-center mb-3 mt-3">
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

<?php
                            } else {
                                echo ("Please Sign In or Register");
                            }
                                ?>