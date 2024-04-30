<?php
$userID = $_SESSION['id'];

$sql = "SELECT Birthday FROM users WHERE id = $userID";
$result = mysqli_query($link, $sql);

if ($result) {
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        
        $userBirthday = $row['Birthday'];
        
        $today = new DateTime();
        $birthday = new DateTime($userBirthday);
        $age = $today->diff($birthday)->y;

        if ($age >= 13 && $age <= 35) {
            $learningsLink = "learningsUser.php";
        } else {
            $learningsLink = "learningsAUser.php";
        }
    } else {
        $userBirthday = null;
        $learningsLink = "learningsUser.php";
    }
    
    mysqli_free_result($result);
} else {
 
    $userBirthday = null;
    $learningsLink = "learningsUser.php";
}

# Retrieve and display comments
$sql = "SELECT comments.comment_id, comments.user_id, comments.comment_text, comments.created_at, users.username, users.status
        FROM comments
        INNER JOIN users ON comments.user_id = users.id
        ORDER BY comments.comment_id DESC";

$result = $link->query($sql);
if ($result === false) {
    echo "Error fetching comments: " . $link->error;
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $comment_text = $_POST["comment_text"];
    $user_id = $_SESSION["id"]; 

    $sql = "INSERT INTO comments (user_id, comment_text) VALUES (?, ?)";
    $stmt = $link->prepare($sql);
    $stmt->bind_param("is", $user_id, $comment_text);
    $stmt->execute();
    $stmt->close();
    header("Location: ".$_SERVER['PHP_SELF']);
    exit;
}

#  comment deletion
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
    
  
    header("Location: ".$_SERVER['PHP_SELF']);
    exit;
}

$sql_comments = "SELECT comments.comment_id, comments.user_id, comments.comment_text, comments.created_at, users.username, users.status
        FROM comments
        INNER JOIN users ON comments.user_id = users.id
        ORDER BY comments.comment_id DESC";

$result_comments = $link->query($sql_comments);

if ($result_comments === false) {
    echo "Error fetching comments: " . $link->error;
    exit;
}

$query = "SELECT * FROM events ORDER BY event_date DESC";
$result = mysqli_query($link, $query);

if (!$result) {
    die("Database query failed: " . mysqli_error($link));
}
?>
