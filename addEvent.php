<?php
ob_start();
session_start();


include 'config.php';

require './php/src/PHPMailer.php';
require './php/src/SMTP.php';
require './php/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: ./login.php");
    exit;
}

if (!isset($_SESSION['id'])) {
    echo "User ID is not set. Please login again.";
    exit;
}

$user_id = $_SESSION['id'];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $event_name = mysqli_real_escape_string($link, $_POST['event_name']);
    $address = mysqli_real_escape_string($link, $_POST['address']);
    $event_date = mysqli_real_escape_string($link, $_POST['event_date']);
    $status = mysqli_real_escape_string($link, $_POST['status']);

    $sql = "INSERT INTO events (event_name, address, event_date, status, user_id) VALUES (?, ?, ?, ?, ?)";

    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "ssssi", $event_name, $address, $event_date, $status, $user_id);
        if (mysqli_stmt_execute($stmt)) {
            sendEmailNotification($event_name, $address, $event_date, $status);
            header("Location: event.php");
            exit();
        } else {
            echo "Error: " . mysqli_stmt_error($stmt);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing statement: " . mysqli_error($link);
    }

    mysqli_close($link);
} else {
    header("Location: event.php");
    exit();
}

function sendEmailNotification($event_name, $address, $event_date, $status)
{
    global $link;
    $user_emails_query = "SELECT email FROM users";
    $user_emails_result = mysqli_query($link, $user_emails_query);

    if ($user_emails_result) {
     
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPAuth = true;
        $mail->Username = 'resurreccionkhaythetricia27@gmail.com';
        $mail->Password = 'rehw gsdp qxmi ikbx';
        $mail->SMTPSecure = 'tls';



        $subject = 'New Event Added';

        $greetingMessage = "We are excited to invite you to our upcoming event: " . $event_name . ".\n"
            . "Join us on " . $event_date . " at " . $address . " for an unforgettable experience.\n"
            . "Your presence will make this event truly special.\n\n"
            . "See you there!";
        while ($row = mysqli_fetch_assoc($user_emails_result)) {
            $email = $row['email'];

            $first_name = $row['first_name']; 
            $fullMessage = "Hello " . $first_name . "!\n\n" . $greetingMessage;
         
            $mail->setFrom('resurreccionkhaythetricia27@gmail.com', 'noreply@gmail.com'); 
            $mail->addAddress($email);
            $mail->isHTML(false);
            $mail->Subject = $subject;
            $mail->Body = $fullMessage; 

          
            if ($mail->send()) {
               
            } else {
            
            }
        }

        mysqli_free_result($user_emails_result);
    }
}
ob_end_flush();
?>