<?php

require "connection.php";

if (isset($_GET["p"])) {
    $province_id = $_GET["p"];

    $district_rs = Database::search("SELECT * FROM `district` WHERE `province_id` = '" . $province_id . "' ");
    $district_num = $district_rs->num_rows;

    if ($district_num > 0) {
?>
        <option value="0">Select District</option>
        <?php

        for ($x = 0; $x < $district_num; $x++) {
            $district_data = $district_rs->fetch_assoc();

        ?>

            <option value="<?php echo $district_data["id"]; ?>" <?php if (!empty($address_data["district_id"])) {
                                                                    if ($district_data["id"] == $address_data["district_id"]) {
                                                                ?>selected<?php
                                                                        }
                                                                    } ?>><?php echo $district_data["district_name"]; ?></option>

        <?php

        }
    } else {
        ?>
        <option value="0">Select District</option>
        <?php

        $district_rs = Database::search("SELECT * FROM `district`");

        $district_num = $district_rs->num_rows;
        for ($x = 0; $x < $district_num; $x++) {
            $district_data = $district_rs->fetch_assoc();
        ?>

            <option value="<?php echo $district_data["id"]; ?>" <?php if (!empty($address_data["district_id"])) {
                                                                    if ($district_data["id"] == $address_data["district_id"]) {
                                                                ?>selected<?php
                                                                                                                    }
                                                                                                                } ?>><?php echo $district_data["district_name"]; ?></option>

<?php
        }
    }
}

?>