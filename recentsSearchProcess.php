<?php

require "connection.php";

$txt = $_POST["t"];

if (isset($txt)) {
    $query = "SELECT * FROM `recent` INNER JOIN `product` ON recent.product_id=product.id  WHERE `title` LIKE '%" . $txt . "%'  ";
} else {
    $query = "SELECT * FROM `recent`";
}

if ("0" != ($_POST["page"])) {
    $pageno = $_POST["page"];
} else {
    $pageno = 1;
}

$recent_rs = Database::search($query);
$recent_num = $recent_rs->num_rows;

$results_per_page = 5;
$number_of_pages = ceil($recent_num / $results_per_page);

$page_results = ($pageno - 1) * $results_per_page;
$selected_rs = Database::search($query . " LIMIT " . $results_per_page . " OFFSET " . $page_results . "");

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
                    <h5 class="card-title fs-2 fw-bold"><?php echo $selected_data["title"]; ?></h5>
                    <?php

                    $clr_rs = Database::search("SELECT * FROM `colour` WHERE `id` = '" . $selected_data["colour_id"] . "' ");
                    $clr_data = $clr_rs->fetch_assoc();

                    ?>
                    <span class="fs-5 fw-bold text-black-50">Colour : <?php echo $clr_data["name"]; ?></span>
                    &nbsp;&nbsp; | &nbsp;&nbsp;

                    <?php

                    $condition_rs = Database::search("SELECT * FROM `condition` WHERE `id` = '" . $selected_data["condition_id"] . "' ");
                    $condition_data = $condition_rs->fetch_assoc();

                    ?>

                    <span class="fs-5 fw-bold text-black-50">Condition : <?php echo $condition_data["name"]; ?></span><br />
                    <span class="fs-5 fw-bold text-black-50">Price : </span>&nbsp;&nbsp;
                    <span class="fs-5 fw-bold text-black"><?php echo $selected_data["price"]; ?></span><br />
                    <span class="fs-5 fw-bold text-black-50">Quantity : </span>&nbsp;&nbsp;
                    <span class="fs-5 fw-bold text-black"><?php echo $selected_data["qty"]; ?> Items Available</span><br />
                    <span class="fs-5 fw-bold text-black-50">Seller : </span><br />
                    <span class="fs-5 fw-bold text-black">Ayesh</span><br />
                </div>
            </div>
            <div class="col-md-3 mt-5">
                <div class="card-body d-lg-grid">
                    <a href='<?php echo "singleProductView.php?id=" . $selected_data["product_id"]; ?>' class="btn btn-outline-success mb-2">Buy Now</a>
                    <button class="btn btn-outline-warning mb-2" onclick='addToCart(<?php echo $selected_data["id"]; ?>);'>Add To Cart</button>
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