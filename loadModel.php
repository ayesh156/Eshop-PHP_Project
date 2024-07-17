<?php

require "connection.php";

if(isset($_GET["b"])){
    $brand_id = $_GET["b"];

    $model_rs = Database::search("SELECT * FROM `brand_has_model` INNER JOIN `model` ON brand_has_model.model_id=model.id WHERE `brand_id`='".$brand_id."' ");
    $model_num = $model_rs -> num_rows;

    if($model_num > 0) {
        ?>
            <option value="0">Select Model</option>
        <?php

        for($x = 0;$x < $model_num;$x++){
            $model_data = $model_rs -> fetch_assoc();

            ?>
                <option value="<?php echo $model_data["id"]; ?>"><?php echo $model_data["name"]; ?></option>
            <?php
        }
    } else {

        ?>
        
        <option value="0">Select Model</option>
        
        <?php

        $model_rs = Database::search("SELECT * FROM `model`");
        $model_num = $model_rs->num_rows;

        for ($x = 0; $x < $model_num; $x++) {
            $model_data = $model_rs->fetch_assoc();
        ?>
            <option value="<?php echo $model_data["id"]; ?>"><?php echo $model_data["name"]; ?></option>
        <?php
        }
    }

}

?>