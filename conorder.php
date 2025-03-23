<?php
include "conn.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'vendor/autoload.php';

if (isset($_GET['id'])) {
    $order_id = $_GET['id'];

    // Assuming your order table has a column named user_id that references the user's ID
    $sql = "SELECT username FROM takeorder WHERE id=$order_id";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);

        if ($row) {
            $username = $row['username'];

            // Now fetch the user details using the username
            $sql_user = "SELECT * FROM userlogin WHERE username='$username'";
            $record = mysqli_query($conn, $sql_user);

            if ($record) {
                $n = mysqli_fetch_assoc($record);

                if ($n) {
                    $name = $n['username'];
                    $email = $n['email'];

                    // Check if email is valid
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        echo "Error: Invalid email address";
                        exit;
                    }

                    $mail = new PHPMailer(TRUE);

                    try {
                        $mail->SMTPDebug = SMTP::DEBUG_SERVER; // Enable verbose debug output
                        $mail->setFrom('binishadhikari2019@gmail.com', 'System');
                        $mail->addAddress($email, 'Customer');
                        $mail->Subject = 'Order Completed';
                        $mail->Body = 'Dear ' . $name . ', Your order has been completed. You will be receiving it soon.';

                        // SMTP configuration
                        $mail->isSMTP();
                        $mail->Host = 'smtp.elasticemail.com';
                        $mail->SMTPAuth = TRUE;
                        $mail->SMTPSecure = 'tls';
                        $mail->Username = 'binishadhikari2019@gmail.com';
                        $mail->Password = '8CE2C6C5B9C2DB2ACE59D0F62720AA0EE260';
                        $mail->Port = 2525;

                        // Finally send the mail
                        if ($mail->send()) {
                            header("Location: http://localhost/canteen-management-system-cms/vieworder.php?success=1");
                            exit;
                        } else {
                            echo "Error: " . $mail->ErrorInfo;
                        }
                    } catch (Exception $e) {
                        echo "Error: " . $e->getMessage();
                    }
                } else {
                    echo "Error: No user found with the provided username";
                }
            } else {
                echo "Error: Database query failed";
            }
        } else {
            echo "Error: No order found with the provided ID";
        }
    } else {
        echo "Error: Database query failed";
    }
} else {
    echo "Error: Order ID parameter is not set";
}
?>
