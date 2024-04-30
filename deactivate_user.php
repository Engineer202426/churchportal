<?php
ob_start();
session_start();

// Include the configuration file
include 'config.php';
require './php/src/PHPMailer.php';
require './php/src/SMTP.php';
require './php/src/Exception.php'; // Include PHPMailer autoload

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the user is logged in
    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== TRUE) {
        die("Access denied. Please log in.");
    }

    // Validate and sanitize the userId
    $userId = filter_input(INPUT_POST, 'userId', FILTER_SANITIZE_NUMBER_INT);

    if (!empty($userId)) {
        // Update user status to "Deactivated"
        $sql_deactivate_user = "UPDATE users SET stat = 'Deactivated' WHERE id = ?";
        if ($stmt_deactivate_user = mysqli_prepare($link, $sql_deactivate_user)) {
            mysqli_stmt_bind_param($stmt_deactivate_user, "i", $userId);

            if (mysqli_stmt_execute($stmt_deactivate_user)) {
                // Retrieve user email for notification
                $sql_get_email = "SELECT email FROM users WHERE id = ?";
                if ($stmt_get_email = mysqli_prepare($link, $sql_get_email)) {
                    mysqli_stmt_bind_param($stmt_get_email, "i", $userId);
                    mysqli_stmt_execute($stmt_get_email);
                    mysqli_stmt_bind_result($stmt_get_email, $email);
                    mysqli_stmt_fetch($stmt_get_email);
                    mysqli_stmt_close($stmt_get_email);

                    // Send notification email
                    $mail = new PHPMailer(true);
                    try {
                        //Server settings
                        $mail->isSMTP();
                        $mail->Host       = 'smtp.gmail.com'; // Gmail SMTP server
                        $mail->SMTPAuth   = true;
                        $mail->Username   = 'resurreccionkhaythetricia27@gmail.com'; // Your Gmail username
                        $mail->Password   = 'rehw gsdp qxmi ikbx'; // Your Gmail password
                        $mail->SMTPSecure = 'tls';
                        $mail->Port       = 587; // TCP port to connect to Gmail SMTP

                        //Recipients
                        $mail->setFrom('resurreccionkhaythetricia27@gmail.com', 'SDA Admin');
                        $mail->addAddress($email);  // Add a recipient

                        // Content
                        $mail->isHTML(true);
                        $mail->Subject = 'Account Deactivation Notification';
                        $mail->Body    = "Dear User,

                        We regret to inform you that your account has been temporarily suspended for a period of one month due to prolonged inactivity. Maintaining an engaged and active user base is vital to the vibrancy of our community, and we encourage all members to participate regularly.
                        During this suspension period, your account will be deactivated, and you will be unable to access forum features. We encourage you to reach out to us at resurreccionkhaythetricia27@gmail.com if you have any concerns or wish to reactivate your account.
                        We value your participation in our community and look forward to welcoming you back upon your return.
                        Thank you for your understanding.
                        Sincerely,

                         Administration Team";

                        $mail->send();
                        echo 'Notification email has been sent';
                    } catch (Exception $e) {
                        echo "Notification email could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    }
                } else {
                    echo "Error preparing statement to retrieve user email: " . mysqli_error($link);
                }
            } else {
                echo "Error deactivating user: " . mysqli_error($link);
            }
            mysqli_stmt_close($stmt_deactivate_user);
        } else {
            echo "Error preparing statement to deactivate user: " . mysqli_error($link);
        }
    } else {
        echo "Invalid userId.";
    }
    // Close the database connection
    mysqli_close($link);
} else {
    echo "Invalid request.";
}
ob_end_flush();
?>
