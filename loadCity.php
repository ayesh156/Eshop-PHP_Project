<?php

require "connection.php";

if (isset($_GET["d"])) {
    $district_id = $_GET["d"];

    $city_rs = Database::search("SELECT * FROM `city` WHERE `district_id` = '" . $district_id . "' ");
    $city_num = $city_rs->num_rows;

    if ($city_num > 0) {
?>
        <option value="0">Select Province</option>
        <?php

        for ($x = 0; $x < $city_num; $x++) {
            $city_data = $city_rs->fetch_assoc();

        ?>

            <option value="<?php echo $city_data["id"]; ?>" <?php if (!empty($address_data["city_id"])) {
                                                                if ($city_data["id"] == $address_data["city_id"]) {
                                                            ?>selected<?php
                                                                    }
                                                                } ?>><?php echo $city_data["city_name"]; ?></option>

        <?php

        }
    } else {
        ?>
        <option value="0">Select Province</option>
        <?php

        $city_rs = Database::search("SELECT * FROM `city`");
        $city_num = $city_rs->num_rows;
        for ($x = 0; $x < $city_num; $x++) {
            $city_data = $city_rs->fetch_assoc();
        ?>

            <option value="<?php echo $city_data["id"]; ?>" <?php if (!empty($address_data["city_id"])) {
                                                                if ($city_data["id"] == $address_data["city_id"]) {
                                                            ?>selected<?php
                                                                    }
                                                                } ?>><?php echo $city_data["city_name"]; ?></option>

<?php
        }
    }
}

?>