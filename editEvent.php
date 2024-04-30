<?php
ob_start();
// Include database connection file
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if event_id is set and not empty
    if (isset($_POST["event_id"]) && !empty($_POST["event_id"])) {
        $event_id = $_POST["event_id"];

        // Sanitize and validate input fields (you should perform more validation)
        $event_name = mysqli_real_escape_string($link, $_POST["event_name"]);
        $event_date = mysqli_real_escape_string($link, $_POST["event_date"]);
        $address = mysqli_real_escape_string($link, $_POST["address"]);
        $status = mysqli_real_escape_string($link, $_POST["status"]);

        // Update event details in the database
        $update_query = "UPDATE events SET event_name='$event_name', event_date='$event_date', address='$address', status='$status' WHERE event_id=$event_id";

        if (mysqli_query($link, $update_query)) {
            // Event details updated successfully
            header("Location: event.php"); // Redirect back to the events page or any other appropriate location
            exit;
        } else {
            echo "Error updating event: " . mysqli_error($link);
        }
    } else {
        echo "Invalid event ID.";
    }
}
ob_end_flush();
?>
