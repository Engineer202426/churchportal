<?php

$userID = $_SESSION['id'];// Fetch events from database
$query = "SELECT * FROM events ORDER BY event_date DESC";
$result = mysqli_query($link, $query);

if (!$result) {
    die("Database query failed: " . mysqli_error($link));
}