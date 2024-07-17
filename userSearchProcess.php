<?php

require "connection.php";
session_start();

$txt = $_POST["t"];
$user = $_SESSION["a"]["email"];

if (isset($txt)) {

    $query = "SELECT * FROM `user` WHERE `fname` LIKE '%" . $txt . "%' OR `lname` LIKE '%" . $txt . "%'  ";
} else {
    $query = "SELECT * FROM `user`";
}

if ("0" != ($_POST["page"])) {
    $pageno = $_POST["page"];
} else {
    $pageno = 1;
}

$user_rs = Database::search($query);
$user_num = $user_rs->num_rows;

$results_per_page = 20;
$number_of_pages = ceil($user_num / $results_per_page);

$page_results = ($pageno - 1) * $results_per_page;
$selected_rs =  Database::search($query . " LIMIT " . $results_per_page . " OFFSET " . $page_results . "");

$selected_num = $selected_rs->num_rows;

for ($x = 0; $x < $selected_num; $x++) {
    $selected_data = $selected_rs->fetch_assoc();

?>

    <div class="col-12 mt-1 mb-1">
        <div class="row">
            <div class="col-2 col-lg-1 bg-primary py-2 text-end">
                <span class="fs-4 fw-bold text-dark">0<?php echo $x + 1; ?></span>
            </div>
            <div class="col-2 d-none d-lg-block bg-light py-2" onclick="viewMsgModal('<?php echo $selected_data['email']; ?>');">
                <?php

                $img_rs = Database::search("SELECT * FROM `profile_image` WHERE `user_email`='" . $selected_data["email"] . "'");
                $img_num = $img_rs->num_rows;

                if ($img_num == 1) {
                    $img_data = $img_rs->fetch_assoc();
                ?>
                    <img src="<?php echo $img_data["path"]; ?>" style="height: 40px;margin-left: 80px;" />
                <?php
                } else {
                ?>
                    <img src="resource/new_user.svg" style="height: 40px;margin-left: 80px;" />
                <?php
                }


                ?>

            </div>
            <div class="col-4 col-lg-2 bg-primary py-2">
                <span class="fs-4 fw-bold text-dark"><?php echo $selected_data["fname"] . " " . $selected_data["lname"]; ?></span>
            </div>
            <div class="col-4 col-lg-2 d-lg-block bg-light py-2">
                <span class="fs-4 fw-bold"><?php echo $selected_data["email"]; ?></span>
            </div>
            <div class="col-2 d-none d-lg-block bg-primary py-2">
                <span class="fs-4 fw-bold text-white"><?php echo $selected_data["mobile"]; ?></span>
            </div>
            <div class="col-2 d-none d-lg-block bg-light py-2">
                <span class="fs-4 fw-bold"><?php echo $selected_data["joined_date"]; ?></span>
            </div>
            <div class="col-2 col-lg-1 bg-white py-2 d-grid">
                <?php

                if ($selected_data["status"] == 1) {
                ?>
                    <button class="btn btn-danger" id="ub<?php echo $selected_data["email"]; ?>" onclick="blockUser('<?php echo $selected_data['email']; ?>');">Block</button>
                <?php
                } else {
                ?>
                    <button class="btn btn-success" id="ub<?php echo $selected_data["email"]; ?>" onclick="blockUser('<?php echo $selected_data['email']; ?>');">Unblock</button>
                <?php
                }

                ?>
            </div>
        </div>
    </div>

    <!-- msg modal start -->

    <div class="modal" tabindex="-1" id="userMsgModal<?php echo $selected_data["email"]; ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo $selected_data["fname"] . " " . $selected_data["lname"]; ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="msg_box" style="height: 300px;overflow-y: scroll;">

                    <?php

                    $msg_rs = Database::search("SELECT * FROM `chat` WHERE `from`='" . $selected_data["email"] . "' OR `to`= '" . $selected_data["email"] . "' ");
                    $msg_num = $msg_rs->num_rows;
                    
                    for ($y = 0; $y < $msg_num; $y++) {
                        $msg_data = $msg_rs->fetch_assoc();
                        if ($msg_data["from"] == $selected_data["email"] && $msg_data["to"] == $user) {

                    ?>

                            <!-- received start -->

                            <div class="col-12 mt-2">
                                <div class="row">
                                    <div class="col-8 rounded bg-success">
                                        <div class="row">
                                            <div class="col-12 pt-2">
                                                <span class="text-white fw-bold fs-4"><?php echo $msg_data["content"]; ?></span>
                                            </div>
                                            <div class="col-12 text-end pb-2">
                                                <span class="text-white fs-6"><?php echo $msg_data["date_time"]; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- received end -->

                        <?php
                        }

                        if ($msg_data["to"] == $selected_data["email"] && $msg_data["from"] == $user) {

                        ?>


                            <!-- sent start -->

                            <div class="col-12 mt-2">
                                <div class="row">
                                    <div class="offset-4 col-8 rounded bg-primary">
                                        <div class="row">
                                            <div class="col-12 pt-2">
                                                <span class="text-white fw-bold fs-4"><?php echo $msg_data["content"]; ?></span>
                                            </div>
                                            <div class="col-12 text-end pb-2">
                                                <span class="text-white fs-6"><?php echo $msg_data["date_time"]; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- sent end -->

                    <?php
                        }
                    }
                    ?>


                </div>
                <div class="modal-footer">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-9">
                                <input type="text" class="form-control" id="msgtxt" />
                            </div>
                            <div class="col-3 d-grid">
                                <button type="button" class="btn btn-primary" onclick="sendAdminMsg('<?php echo $selected_data['email']; ?>');">Send</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- msg modal end -->

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