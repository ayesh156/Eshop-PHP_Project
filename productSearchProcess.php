<?php
session_start();
require "connection.php";
$txt = $_POST["t"];
if (isset($txt)) {

    $query = "SELECT * FROM `product` WHERE `title` LIKE '%" . $txt . "%'  ";
} else {
    $query = "SELECT * FROM `product`";
}

if ("0" != ($_POST["page"])) {
    $pageno = $_POST["page"];
} else {
    $pageno = 1;
}

$product_rs = Database::search($query);
$product_num = $product_rs->num_rows;

$results_per_page = 6;
$number_of_pages = ceil($product_num / $results_per_page);

$page_results = ($pageno - 1) * $results_per_page;
$selected_rs =  Database::search($query . " LIMIT " . $results_per_page . " OFFSET " . $page_results . "");

$selected_num = $selected_rs->num_rows;

for ($x = 0; $x < $selected_num; $x++) {
    $selected_data = $selected_rs->fetch_assoc();

?>

    <div class="col-12 mt-1 mb-1">
        <div class="row">
            <div class="col-2 col-lg-1 bg-primary py-2 text-end">
                <span class="fs-4 fw-bold text-white">0<?php echo $x + 1; ?></span>
            </div>
            <div class="col-2 d-none d-lg-block bg-light py-2" onclick="viewProductModal('<?php echo $selected_data['id']; ?>');" style="cursor: pointer;">

                <?php

                $img_rs = Database::search("SELECT * FROM `images` WHERE `product_id`='" . $selected_data["id"] . "' ");
                $img_num = $img_rs->num_rows;
                $imgArray = array();

                if ($img_num >= 0) {

                    for ($y = 0; $y < $img_num; $y++) {
                        $img_data = $img_rs->fetch_assoc();
                        $imgArray[$y] = $img_data["code"];
                    }
                ?>
                    <img src="<?php echo $imgArray[0] ?>" style="height: 40px;margin-left: 80px;" />
                <?php

                } else {
                ?>
                    <img src="resource/empty.svg" style="height: 40px;margin-left: 80px;" />
                <?php
                }

                ?>
                
            </div>
            <div class="col-4 col-lg-2 bg-primary py-2">
                <span class="fs-4 fw-bold text-white"><?php echo $selected_data["title"]; ?></span>
            </div>
            <div class="col-4 col-lg-2 d-lg-block bg-light py-2">
                <span class="fs-4 fw-bold">Rs. <?php echo $selected_data["price"]; ?>.00</span>
            </div>
            <div class="col-2 d-none d-lg-block bg-primary py-2">
                <span class="fs-4 fw-bold text-white"><?php echo $selected_data["qty"]; ?></span>
            </div>
            <div class="col-2 d-none d-lg-block bg-light py-2">
                <span class="fs-4 fw-bold"><?php echo $selected_data["datetime_added"]; ?></span>
            </div>
            <div class="col-2 col-lg-1 bg-white py-2 d-grid">
                <?php

                if ($selected_data["status_id"] == 1) {
                ?>
                    <button class="btn btn-danger" id="pb<?php echo $selected_data["id"]; ?>" onclick="blockProduct('<?php echo $selected_data['id']; ?>');">Deactive</button>
                <?php
                } else {
                ?>
                    <button class="btn btn-success" id="pb<?php echo $selected_data["id"]; ?>" onclick="blockProduct('<?php echo $selected_data['id']; ?>');">Active</button>

                <?php
                }

                ?>
            </div>
        </div>
    </div>

    <!-- Modal 01 start -->

    <div class="modal" tabindex="-1" id="viewProductModal<?php echo $selected_data["id"]; ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold text-success"><?php echo $selected_data["title"]; ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="offset-3 col-6">
                        <?php
                        $img_rs2 = Database::search("SELECT * FROM `images` WHERE `product_id`='" . $selected_data["id"] . "' ");
                        $img_num2 = $img_rs2->num_rows;
                        $imgArray2 = array();
                        if ($img_num >= 0) {

                            for ($y = 0; $y < $img_num; $y++) {
                                $img_data2 = $img_rs2->fetch_assoc();
                                $imgArray2[$y] = $img_data2["code"];
                            }
                        ?>
                            <img src="<?php echo $imgArray2[0] ?>" class="img-fluid" style="height: 150px;" />
                        <?php

                        } else {
                        ?>
                            <img src="resource/empty.svg" class="img-fluid" style="height: 150px;" />
                        <?php
                        }
                        ?>
                    </div>
                    <div class="col-12">
                        <span class="fs-5 fw-bold">Price :</span>&nbsp;
                        <span class="fs-5">Rs. <?php echo $selected_data["price"]; ?>.00</span><br />
                        <span class="fs-5 fw-bold">Quantity :</span>&nbsp;
                        <span class="fs-5"><?php echo $selected_data["qty"]; ?> Products left</span><br />
                        <span class="fs-5 fw-bold">Seller :</span>&nbsp;
                        <span class="fs-5"><?php echo $_SESSION["a"]["fname"]; ?></span><br />
                        <span class="fs-5 fw-bold">Description :</span>&nbsp;
                        <span class="fs-5"><?php echo $selected_data["description"]; ?></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal 01 end -->

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