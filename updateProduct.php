<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product | eShop</title>
    <link rel="stylesheet" href="bootstrap.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="style.css" />
    <link rel="icon" href="resource/logo.svg" />
</head>

<body>

    <div class="container-fluid">
        <div class="row gy-3">
            <?php

            include "header.php";

            if (isset($_SESSION["u"])) {

                if (isset($_SESSION["p"])) {

                    $product = $_SESSION["p"];

            ?>

                    <div class="col-12">
                        <div class="row">

                            <div class="col-12 text-center">
                                <h2 class="h2 text-success fw-bold">Update My Product</h2>
                            </div>

                            <div class="col-12">
                                <div class="row">

                                    <div class="col-12 col-lg-4">
                                        <div class="row">

                                            <div class="col-12">
                                                <label class="form-label fw-bold" style="font-size: 20px;">Select Product Category</label>
                                            </div>

                                            <div class="col-12">
                                                <select class="form-select text-center bg-light border-0 border-bottom" disabled>
                                                    <?php

                                                    $category_rs = Database::search("SELECT * FROM `category` WHERE `id`='" . $product["category_id"] . "' ");
                                                    $category_data = $category_rs->fetch_assoc();

                                                    ?>

                                                    <option><?php echo $category_data["name"]; ?></option>

                                                </select>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-12 col-lg-4">
                                        <div class="row">

                                            <div class="col-12">
                                                <label class="form-label fw-bold" style="font-size: 20px;">Select Product Brand</label>
                                            </div>

                                            <div class="col-12">
                                                <select class="form-select text-center bg-light border-0 border-bottom" disabled>
                                                    <?php

                                                    $brand_rs = Database::search("SELECT * FROM  `brand_has_model` INNER JOIN `brand` ON brand_has_model.brand_id= brand.id WHERE `brand_has_model`.`id`='" . $product["brand_has_model_id"] . "' ");
                                                    $brand_data = $brand_rs->fetch_assoc();

                                                    ?>

                                                    <option><?php echo $brand_data["name"]; ?></option>

                                                </select>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-12 col-lg-4">
                                        <div class="row">

                                            <div class="col-12">
                                                <label class="form-label fw-bold" style="font-size: 20px;">Select Product Model</label>
                                            </div>

                                            <div class="col-12">
                                                <select class="form-select text-center bg-light border-0 border-bottom" disabled>
                                                    <?php

                                                    $model_rs = Database::search("SELECT * FROM  `brand_has_model` INNER JOIN `model` ON brand_has_model.model_id= model.id WHERE `brand_has_model`.`id`='" . $product["brand_has_model_id"] . "' ");
                                                    $model_data = $model_rs->fetch_assoc();

                                                    ?>

                                                    <option><?php echo $model_data["name"]; ?></option>

                                                </select>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <hr class="border-success" style="border-width: 3px;" />
                                    </div>

                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-12">
                                                <label class="form-label fw-bold" style="font-size: 20px;">
                                                    Add a Title to your Product
                                                </label>
                                            </div>
                                            <div class="col-12 col-lg-8 offset-0 offset-lg-2">
                                                <input type="text" class="form-control" id="t" value="<?php echo $product["title"]; ?>" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <hr class="border-success" style="border-width: 3px;" />
                                    </div>

                                    <div class="col-12">
                                        <div class="row">

                                            <div class="col-12 col-lg-4 border-end">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label class="form-label fw-bold" style="font-size: 20px;">Select Product Condition</label>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-check form-check-inline mx-5">
                                                            <input class="form-check-input" type="radio" name="c" id="b" <?php if ($product["condition_id"] == '1') { ?> checked <?php } ?> disabled>
                                                            <label class="form-check-label fw-bold" for="b">
                                                                Brandnew
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="c" id="u" <?php if ($product["condition_id"] == '2') { ?> checked <?php } ?> disabled>
                                                            <label class="form-check-label fw-bold" for="u">
                                                                Used
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12 col-lg-4 border-end">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label class="form-label fw-bold" style="font-size: 20px;">Select Product Colour</label>
                                                    </div>
                                                    <div class="col-12">

                                                        <select class="form-select" disabled>
                                                            <?php

                                                            $clr_rs = Database::search("SELECT * FROM `colour` WHERE `id`='" . $product["colour_id"] . "'");
                                                            $clr_data = $clr_rs->fetch_assoc();

                                                            ?>

                                                            <option><?php echo $clr_data["name"]; ?></option>

                                                        </select>


                                                    </div>
                                                    <div class="col-12">
                                                        <div class="input-group mt-2 mb-2">
                                                            <input type="text" class="form-control" placeholder="Add new Colour" disabled />
                                                            <button class="btn btn-outline-primary" type="button" disabled>+ Add</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12 col-lg-4">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label class="form-label fw-bold" style="font-size: 20px;">Add Product Quantity</label>
                                                    </div>
                                                    <div class="col-12">
                                                        <input type="number" class="form-control" min="0" id="q" value="<?php echo $product["qty"]; ?>" />
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>


                                    <div class="col-12">
                                        <hr class="border-success" style="border-width: 3px;" />
                                    </div>

                                    <div class="col-12">
                                        <div class="row">

                                            <div class="col-6 border-end border-success">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label class="form-label fw-bold" style="font-size: 20px;">Cost Per Item</label>
                                                    </div>
                                                    <div class="offset-0 offset-lg-2 col-12 col-lg-8">
                                                        <div class="input-group mb-2 mt-2">
                                                            <span class="input-group-text">Rs.</span>
                                                            <input type="text" class="form-control" disabled value="<?php echo $product["price"]; ?>" />
                                                            <span class="input-group-text">.00</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label class="form-label fw-bold" style="font-size: 20px;">Approved Payment Methods</label>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="row">
                                                            <div class="offset-1 offset-lg-2 col-2 pm pm1"></div>
                                                            <div class="col-2 pm pm2"></div>
                                                            <div class="col-2 pm pm3"></div>
                                                            <div class="col-2 pm pm4"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <hr class="border-success" style="border-width: 3px;" />
                                    </div>

                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-12">
                                                <label class="form-label fw-bold" style="font-size: 20px;">Delivery Costs</label>
                                            </div>
                                            <div class="col-12 col-lg-6 border-end border-success">
                                                <div class="row">
                                                    <div class="col-12 offset-lg-1 col-lg-3">
                                                        <label class="form-label">Delivery Cost Within Colombo</label>
                                                    </div>
                                                    <div class="col-12 col-lg-8">
                                                        <div class="input-group mb-2 mt-2">
                                                            <span class="input-group-text">Rs.</span>
                                                            <input type="text" class="form-control" id="dwc" value="<?php echo $product["delivery_fee_colombo"]; ?>" />
                                                            <span class="input-group-text">.00</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-6">
                                                <div class="row">
                                                    <div class="col-12 offset-lg-1 col-lg-3">
                                                        <label class="form-label">Delivery Cost out of Colombo</label>
                                                    </div>
                                                    <div class="col-12 col-lg-8">
                                                        <div class="input-group mb-2 mt-2">
                                                            <span class="input-group-text">Rs.</span>
                                                            <input type="text" class="form-control" id="doc" value="<?php echo $product["delivery_fee_other"]; ?>" />
                                                            <span class="input-group-text">.00</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <hr class="border-success" style="border-width: 3px;" />
                                    </div>

                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-12">
                                                <label class="form-label fw-bold" style="font-size: 20px;">Products Description</label>
                                            </div>
                                            <div class="col-12">
                                                <textarea cols="30" rows="15" class="form-control" id="d" ><?php echo $product["description"]; ?></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <hr class="border-success" style="border-width: 3px;" />
                                    </div>

                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-12">
                                                <label class="form-label fw-bold" style="font-size: 20px;">Add product Image</label>
                                            </div>
                                            <div class="offset-lg-3 col-12 col-lg-6">
                                                <div class="row">
                                                    <?php

                                                    $img = array();
                                                    $img[0] = "resource/addproductimg.svg";
                                                    $img[1] = "resource/addproductimg.svg";
                                                    $img[2] = "resource/addproductimg.svg";

                                                    $image_rs = Database::search("SELECT * FROM `images` WHERE `product_id`='" . $product["id"] . "' ");
                                                    $image_num = $image_rs->num_rows;

                                                    for ($x = 0; $x < $image_num; $x++) {
                                                        $image_data = $image_rs->fetch_assoc();
                                                        $img[$x] = $image_data["code"];
                                                    }

                                                    ?>

                                                    <div class="col-4 border border-primary rounded">
                                                        <img src="<?php echo $img [0]; ?>" class="img-fluid" style="width: 250px;" id="i0" />
                                                    </div>
                                                    <div class="col-4 border border-primary rounded">
                                                        <img src="<?php echo $img [1]; ?>" class="img-fluid" style="width: 250px;" id="i1" />
                                                    </div>
                                                    <div class="col-4 border border-primary rounded">
                                                        <img src="<?php echo $img [2]; ?>" class="img-fluid" style="width: 250px;" id="i2" />
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="offset-lg-3 col-12 col-lg-6 d-grid mt-3">
                                                <input type="file" class="d-none" id="imageuploader" multiple />
                                                <label for="imageuploader" class="col-12 btn btn-primary" onclick="changeProductImage();">Upload Images</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <hr class="border-success" style="border-width: 3px;" />
                                    </div>

                                    <div class="offset-lg-4 col-12 col-lg-4 d-grid mt-3 mb-3">
                                        <button class="btn btn-dark" onclick="updateProduct();" >Update Product</button>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>

            <?php

                } else {
                    header("Location:myProducts.php");
                }
            } else {
                header("Location:home.php");
            }

            ?>

            <?php include "footer.php"; ?>
        </div>
    </div>

    <script src="bootstrap.bundle.js"></script>
    <script src="script.js"></script>
</body>

</html>