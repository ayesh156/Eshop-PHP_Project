<?php

require "connection.php";

if (isset($_GET["c"])) {
    $category_id = $_GET["c"];

    $brands_rs = Database::search("SELECT * FROM `brand` WHERE `category_id` = '" . $category_id . "' ");
    $brands_num = $brands_rs->num_rows;

    if ($brands_num > 0) {
        ?>
            <option value="0">Select Brand</option>
        <?php

        for ($x = 0; $x < $brands_num; $x++) {
            $brand_data = $brands_rs->fetch_assoc();

?>

            <option value="<?php echo $brand_data["id"];  ?>"><?php echo $brand_data["name"]; ?></option>

        <?php

        }
    } else {
        ?>

        <option value="0">Select Brand</option>

        <?php

        $brand_rs = Database::search("SELECT * FROM `brand`");
        $brand_num = $brand_rs->num_rows;

        for ($x = 0; $x < $brand_num; $x++) {
            $brand_data = $brand_rs->fetch_assoc();
        ?>
            <option value="<?php echo $brand_data["id"];  ?>"><?php echo $brand_data["name"];  ?></option>
<?php
        }
    }
}

?>