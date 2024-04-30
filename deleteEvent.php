<?php
ob_start();
// Include database connection file
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["event_id"])) {
    // Get the event ID from the URL
    $event_id = $_GET["event_id"];

    // Delete the event from the database
    $delete_query = "DELETE FROM events WHERE event_id = $event_id";

    if (mysqli_query($link, $delete_query)) {
        // Event deleted successfully
        header("Location: event.php"); // Redirect back to the events page or any other appropriate location
        exit;
    } else {
        echo "Error deleting event: " . mysqli_error($link);
    }
} else {
    echo "Invalid request.";
}
ob_end_flush();
?>
