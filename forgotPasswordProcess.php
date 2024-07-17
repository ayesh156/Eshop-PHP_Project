<?php

require "connection.php";

require "SMTP.php";
require "PHPMailer.php";
require "Exception.php";

use PHPMailer\PHPMailer\PHPMailer;

if(isset($_GET["e"])) {

    $email = $_GET["e"];

    if (empty($email)) {

        echo ("Please enter your email address");

    } else {
        $rs = Database::search("SELECT * FROM `user` WHERE `email`='".$email."'");
        $n = $rs -> num_rows;

        if($n == 1) {
            $code = uniqid();
            Database::iud("UPDATE `user` SET `varification_code`='".$code."' WHERE `email`='".$email."' ");

            $mail = new PHPMailer;
                $mail->IsSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'ayeshchathuranga531@gmail.com';
                $mail->Password = 'hqhutzzfbpovirng';
                $mail->SMTPSecure = 'ssl';
                $mail->Port = 465;
                $mail->setFrom('ayeshchathuranga531@gmail.com', 'Reset Password');
                $mail->addReplyTo('ayeshchathuranga531@gmail.com', 'Reset Password');
                $mail->addAddress($email);
                $mail->isHTML(true);
                $mail->Subject = 'eShop Forgot Password Verfication Code';
                $bodyContent = '<h1 style="color:green;">Your Verification code is '.$code.'</h1>';
                $mail->Body    = $bodyContent;

                if (!$mail->send()) {
                    echo "Varification code sending failed";
                } else {
                    echo "Success";
                }

        } else  {
            echo ("Invalid email address");
        }
    }


}


?>