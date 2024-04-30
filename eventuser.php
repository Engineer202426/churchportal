<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== TRUE) {
    header("Location: ./login.php");
    exit;
}


include 'config.php';
    

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Schedule</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/main.css">
    <link rel="shortcut icon" href="./img/favicon-16x16.png" type="image/x-icon">


</head>

<body>
    <?php include 'navbaruser.php'; ?>



    <div class="container mt-4">
        <h2 class="text-center mb-4">Event Scheduled Board</h2>
        <div class="row">
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">
                                <?= htmlspecialchars($row['event_name']); ?>
                            </h5>
                            <h6 class="card-subtitle mb-2 text-muted">
                                <?= htmlspecialchars($row['event_date']); ?>
                            </h6>
                            <p class="card-text">
                                <?= htmlspecialchars($row['address']); ?>
                            </p>
                        </div>
                        <div class="card-footer">
                            <small class="text-muted">Status:
                                <?= htmlspecialchars($row['status']); ?>
                            </small>

                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
            <div>

                <script
                    src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
<style>
    .card {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .card:hover {
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    .card-title {
        color: #0056b3;
        /* Example color */
    }
</style>