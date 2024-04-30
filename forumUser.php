<?php
session_start();


if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== TRUE) {
    header("Location: ./login.php");
    exit;
}


include 'config.php';


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $comment_text = $_POST["comment_text"];
    $user_id = $_SESSION["id"];

    $sql = "INSERT INTO comments (user_id, comment_text) VALUES (?, ?)";
    $stmt = $link->prepare($sql);
    $stmt->bind_param("is", $user_id, $comment_text);
    $stmt->execute();
    $stmt->close();


    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

if (isset($_GET["delete_comment_id"])) {
    $comment_id = $_GET["delete_comment_id"];

    $sql = "SELECT user_id FROM comments WHERE comment_id = ?";
    $stmt = $link->prepare($sql);
    $stmt->bind_param("i", $comment_id);
    $stmt->execute();
    $stmt->bind_result($comment_user_id);
    $stmt->fetch();
    $stmt->close();

    if ($_SESSION["status"] === "Admin" || $_SESSION["id"] === $comment_user_id) {

        $sql = "DELETE FROM comments WHERE comment_id = ?";
        $stmt = $link->prepare($sql);
        $stmt->bind_param("i", $comment_id);
        $stmt->execute();
        $stmt->close();
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
include 'configs.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <style>
        .comment {
            background-color: #f8f9fa;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 10px;
        }

        .comment p {
            margin: 0;
        }

        .btn-delete {
            margin-top: 10px;
        }

        .comment-form {
            margin-top: 30px;
            margin-bottom: 30px;
        }

        .video-container {
            position: relative;
            padding-bottom: 56.25%;
            height: 0;
            overflow: hidden;
            margin-top: 30px;
        }

        .video-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
    </style>
</head>

<body>
    <?php include 'navbaruser.php'; ?>

    <div class="container mt-4">
        <div class="row">

            <div class="col-md-8">
                <form method="POST" action="" class="comment-form">
                    <div class="mb-3">
                        <textarea name="comment_text" class="form-control" rows="3" placeholder="Add a comment..."
                            required></textarea>
                    </div>
                    <input type="submit" class="btn btn-primary" value="Post Comment">
                </form>


                <?php
                if ($result_comments->num_rows > 0) {
                    while ($row = $result_comments->fetch_assoc()) {
                        echo "<div class='comment'>";
                        echo "<p><strong>" . htmlspecialchars($row['username']) . "</strong>: " . htmlspecialchars($row['comment_text']) . "</p>";

                        if ($_SESSION["status"] === "Admin" || $_SESSION["id"] === $row['user_id']) {
                            echo "<a href='?delete_comment_id={$row['comment_id']}' class='btn btn-danger btn-delete'>Delete</a>";
                        }
                        echo "</div>";
                    }
                }
                ?>
            </div>


            <div class="col-md-4">
                <div class="video-container">

                    <iframe src="./components/w.mp4" frameborder="0" allowfullscreen></iframe>
                </div>

                <div class="video-text mt-5">
                    <p>Developed By:Khate</p>

                </div>
            </div>
        </div>
    </div>

    </div>

    <div class="container2">
        <a style="float: right; margin: 20px;" href="aboutus.php" class="btn btn-primary">About Us</a>
    </div>
</body>

</html>

<?php
$link->close();
?>

<style>
    .comment {
        background-color: #f8f9fa;
        border-radius: 5px;
        padding: 15px;
        margin-bottom: 10px;
    }

    .comment p {
        margin: 0;
    }

    .btn-delete {
        margin-top: 10px;
    }

    .comment-form {
        margin-top: 30px;
        margin-bottom: 30px;
    }

    .video-text {

        margin-top: 40px;
        font-size: 18px;
        color: #555;
        font-weight: bold;
        font-family: Arial, sans-serif;
    }
</style>