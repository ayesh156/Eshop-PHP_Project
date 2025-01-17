<?php

require "connection.php";

if (isset($_POST["f"]) && isset($_POST["t"])) {

    $from = $_POST["f"];
    $to = $_POST["t"];

    $query = "SELECT * FROM `invoice`";
    
    if ("0" != ($_POST["page"])) {
        $pageno = $_POST["page"];
    } else {
        $pageno = 1;
    }
    
    $invoice_rs = Database::search($query);
    $invoice_num = $invoice_rs->num_rows;
    
    $results_per_page = 8;
    $number_of_pages = ceil($invoice_num / $results_per_page);
    
    $page_results = ($pageno - 1) * $results_per_page;
    $selected_rs =  Database::search($query . " LIMIT " . $results_per_page . " OFFSET " . $page_results . "");
    
    $selected_num = $selected_rs->num_rows;
    
    for ($x = 0; $x < $selected_num; $x++) {
        $selected_data = $selected_rs->fetch_assoc();

        $sold_date = $selected_data["date"];
        $date = explode(" ", $sold_date);

        $d = $date[0];
        $t = $date[1];

        if (!empty($from) && empty($to)) {
            if ($from <= $d) {
?>
                <div class="row">

                    <div class="col-1 bg-secondary text-end pt-2 pb-2 mt-1 mb-1">
                        <label class="fs-5 fw-bold text-white">0<?php echo $selected_data["id"] ?></label>
                    </div>

                    <?php
                    $product_rs = Database::search("SELECT * FROM `product` WHERE `id`='" .  $selected_data["product_id"] . "' ");
                    $product_data = $product_rs->fetch_assoc();

                    $user_rs = Database::search("SELECT * FROM `user` WHERE `email`='" .  $selected_data["user_email"] . "' ");
                    $user_data = $user_rs->fetch_assoc();
                    ?>

                    <div class="col-3 bg-body text-end pt-2 pb-2 mt-1 mb-1">
                        <label class="form-label fs-5 fw-bold text-black"><?php echo $product_data["title"]; ?></label>
                    </div>

                    <div class="col-3 bg-secondary text-end pt-2 pb-2 mt-1 mb-1">
                        <label class="fs-5 fw-bold text-white"><?php echo $user_data["fname"] . " " . $user_data["lname"]; ?></label>
                    </div>

                    <div class="col-2 bg-body text-end pt-2 pb-2 mt-1 mb-1">
                        <label class="form-label fs-5 fw-bold text-black">Rs. <?php echo  $selected_data["total"]; ?>.00</label>
                    </div>

                    <div class="col-1 bg-secondary text-end pt-2 pb-2 mt-1 mb-1">
                        <label class="fs-5 fw-bold text-white"><?php echo  $selected_data["qty"]; ?></label>
                    </div>

                    <div class="col-2 bg-white d-grid">
                        <?php
                        if ($selected_data["status"] == 0) {
                        ?>
                            <button class="btn btn-success fw-bold mt-1 mb-1" onclick="changeStatus('<?php echo $selected_data['id']; ?>')" id="btn<?php echo $selected_data["id"]; ?>">Confirm Order</button>
                        <?php
                        } else if ($selected_data["status"] == 1) {
                        ?>
                            <button class="btn btn-warning fw-bold mt-1 mb-1" onclick="changeStatus('<?php echo $selected_data['id']; ?>')" id="btn<?php echo $selected_data["id"]; ?>">Packing</button>
                        <?php
                        } else if ($selected_data["status"] == 2) {
                        ?>
                            <button class="btn btn-info fw-bold mt-1 mb-1" onclick="changeStatus('<?php echo $selected_data['id']; ?>')" id="btn<?php echo $selected_data["id"]; ?>">Dispatch</button>
                        <?php
                        } else if ($selected_data["status"] == 3) {
                        ?>
                            <button class="btn btn-primary fw-bold mt-1 mb-1" onclick="changeStatus('<?php echo $selected_data['id']; ?>')" id="btn<?php echo $selected_data["id"]; ?>">Shipping</button>
                        <?php
                        } else if ($selected_data["status"] == 4) {
                        ?>
                            <button class="btn btn-danger fw-bold mt-1 mb-1 disabled" onclick="changeStatus('<?php echo $selected_data['id']; ?>')" id="btn<?php echo $selected_data["id"]; ?>">Delivered</button>
                        <?php
                        }

                        ?>

                    </div>

                </div>
            <?php
            }
        } else if (empty($from) && !empty($to)) {
            if ($to >= $d) {
            ?>
                <div class="row">

                    <div class="col-1 bg-secondary text-end pt-2 pb-2 mt-1 mb-1">
                        <label class="fs-5 fw-bold text-white">0<?php echo $selected_data["id"] ?></label>
                    </div>

                    <?php
                    $product_rs = Database::search("SELECT * FROM `product` WHERE `id`='" .  $selected_data["product_id"] . "' ");
                    $product_data = $product_rs->fetch_assoc();

                    $user_rs = Database::search("SELECT * FROM `user` WHERE `email`='" .  $selected_data["user_email"] . "' ");
                    $user_data = $user_rs->fetch_assoc();
                    ?>

                    <div class="col-3 bg-body text-end pt-2 pb-2 mt-1 mb-1">
                        <label class="form-label fs-5 fw-bold text-black"><?php echo $product_data["title"]; ?></label>
                    </div>

                    <div class="col-3 bg-secondary text-end pt-2 pb-2 mt-1 mb-1">
                        <label class="fs-5 fw-bold text-white"><?php echo $user_data["fname"] . " " . $user_data["lname"]; ?></label>
                    </div>

                    <div class="col-2 bg-body text-end pt-2 pb-2 mt-1 mb-1">
                        <label class="form-label fs-5 fw-bold text-black">Rs. <?php echo  $selected_data["total"]; ?>.00</label>
                    </div>

                    <div class="col-1 bg-secondary text-end pt-2 pb-2 mt-1 mb-1">
                        <label class="fs-5 fw-bold text-white"><?php echo  $selected_data["qty"]; ?></label>
                    </div>

                    <div class="col-2 bg-white d-grid">
                        <?php
                        if ($selected_data["status"] == 0) {
                        ?>
                            <button class="btn btn-success fw-bold mt-1 mb-1" onclick="changeStatus('<?php echo $selected_data['id']; ?>')" id="btn<?php echo $selected_data["id"]; ?>">Confirm Order</button>
                        <?php
                        } else if ($selected_data["status"] == 1) {
                        ?>
                            <button class="btn btn-warning fw-bold mt-1 mb-1" onclick="changeStatus('<?php echo $selected_data['id']; ?>')" id="btn<?php echo $selected_data["id"]; ?>">Packing</button>
                        <?php
                        } else if ($selected_data["status"] == 2) {
                        ?>
                            <button class="btn btn-info fw-bold mt-1 mb-1" onclick="changeStatus('<?php echo $selected_data['id']; ?>')" id="btn<?php echo $selected_data["id"]; ?>">Dispatch</button>
                        <?php
                        } else if ($selected_data["status"] == 3) {
                        ?>
                            <button class="btn btn-primary fw-bold mt-1 mb-1" onclick="changeStatus('<?php echo $selected_data['id']; ?>')" id="btn<?php echo $selected_data["id"]; ?>">Shipping</button>
                        <?php
                        } else if ($selected_data["status"] == 4) {
                        ?>
                            <button class="btn btn-danger fw-bold mt-1 mb-1 disabled" onclick="changeStatus('<?php echo $selected_data['id']; ?>')" id="btn<?php echo $selected_data["id"]; ?>">Delivered</button>
                        <?php
                        }

                        ?>

                    </div>

                </div>
            <?php
            }
        } else if (!empty($from) && !empty($to)) {
            if ($from <= $d && $to >= $d) {
            ?>
                <div class="row">

                    <div class="col-1 bg-secondary text-end pt-2 pb-2 mt-1 mb-1">
                        <label class="fs-5 fw-bold text-white">0<?php echo $selected_data["id"] ?></label>
                    </div>

                    <?php
                    $product_rs = Database::search("SELECT * FROM `product` WHERE `id`='" .  $selected_data["product_id"] . "' ");
                    $product_data = $product_rs->fetch_assoc();

                    $user_rs = Database::search("SELECT * FROM `user` WHERE `email`='" .  $selected_data["user_email"] . "' ");
                    $user_data = $user_rs->fetch_assoc();
                    ?>

                    <div class="col-3 bg-body text-end pt-2 pb-2 mt-1 mb-1">
                        <label class="form-label fs-5 fw-bold text-black"><?php echo $product_data["title"]; ?></label>
                    </div>

                    <div class="col-3 bg-secondary text-end pt-2 pb-2 mt-1 mb-1">
                        <label class="fs-5 fw-bold text-white"><?php echo $user_data["fname"] . " " . $user_data["lname"]; ?></label>
                    </div>

                    <div class="col-2 bg-body text-end pt-2 pb-2 mt-1 mb-1">
                        <label class="form-label fs-5 fw-bold text-black">Rs. <?php echo  $selected_data["total"]; ?>.00</label>
                    </div>

                    <div class="col-1 bg-secondary text-end pt-2 pb-2 mt-1 mb-1">
                        <label class="fs-5 fw-bold text-white"><?php echo  $selected_data["qty"]; ?></label>
                    </div>

                    <div class="col-2 bg-white d-grid">
                        <?php
                        if ($selected_data["status"] == 0) {
                        ?>
                            <button class="btn btn-success fw-bold mt-1 mb-1" onclick="changeStatus('<?php echo $selected_data['id']; ?>')" id="btn<?php echo $selected_data["id"]; ?>">Confirm Order</button>
                        <?php
                        } else if ($selected_data["status"] == 1) {
                        ?>
                            <button class="btn btn-warning fw-bold mt-1 mb-1" onclick="changeStatus('<?php echo $selected_data['id']; ?>')" id="btn<?php echo $selected_data["id"]; ?>">Packing</button>
                        <?php
                        } else if ($selected_data["status"] == 2) {
                        ?>
                            <button class="btn btn-info fw-bold mt-1 mb-1" onclick="changeStatus('<?php echo $selected_data['id']; ?>')" id="btn<?php echo $selected_data["id"]; ?>">Dispatch</button>
                        <?php
                        } else if ($selected_data["status"] == 3) {
                        ?>
                            <button class="btn btn-primary fw-bold mt-1 mb-1" onclick="changeStatus('<?php echo $selected_data['id']; ?>')" id="btn<?php echo $selected_data["id"]; ?>">Shipping</button>
                        <?php
                        } else if ($selected_data["status"] == 4) {
                        ?>
                            <button class="btn btn-danger fw-bold mt-1 mb-1 disabled" onclick="changeStatus('<?php echo $selected_data['id']; ?>')" id="btn<?php echo $selected_data["id"]; ?>">Delivered</button>
                        <?php
                        }

                        ?>

                    </div>

                </div>
<?php
            }
        }
    }
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