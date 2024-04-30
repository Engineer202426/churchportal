<?php
ob_start();
// Start a PHP session
session_start();

// Check if the user is logged in; if not, redirect to the login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== TRUE) {
  header("Location: ./login.php");
  exit;
}

$books = parse_ini_file("./book.ini", true);

// Calculate the total number of books available
$totalBooks = count($books);

// Number of books to display per page
$booksPerPage = 1;

// Calculate the total number of pages
$totalPages = ceil($totalBooks / $booksPerPage);

$currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;

$prevPage = ($currentPage > 1) ? ($currentPage - 1) : 1;
$nextPage = ($currentPage < $totalPages) ? ($currentPage + 1) : $totalPages;

// Determine the range of books to display on the current page
$startBook = ($currentPage - 1) * $booksPerPage;
$endBook = min($startBook + $booksPerPage - 1, $totalBooks - 1);

// Extract the books to display on the current page
$booksToDisplay = array_slice($books, $startBook, $booksPerPage, true);

// Check if the current page is valid
if (empty($booksToDisplay)) {
  // Redirect to the first page if the current page is invalid
  header("Location: ./learnings.php?page=1");
  exit;
}

// Extract the first book on the current page
$currentBookKey = key($booksToDisplay);
$currentBook = $booksToDisplay[$currentBookKey];
$title = $currentBook["Title"];
$author = $currentBook["Author"];
$contentFile = $currentBook["Content"];

// Function to load book details based on the current page
function loadBookDetails($currentPage) {
  // Load the book.ini file
  $books = parse_ini_file("./book.ini", true);
  $currentBook = $books["Book$currentPage"];
  $title = $currentBook["Title"];
  $author = $currentBook["Author"];
  $contentFile = $currentBook["Content"];
  return [
    'title' => $title,
    'author' => $author,
    'contentFile' => $contentFile
  ];
}

// Load book details for the current page
$bookDetails = loadBookDetails($currentPage);
$title = $bookDetails['title'];
$author = $bookDetails['author'];
$contentFile = $bookDetails['contentFile'];
ob_end_flush();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Book View</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <link rel="stylesheet" href="./css/main.css">
  <link rel="shortcut icon" href="./img/favicon-16x16.png" type="image/x-icon">
  <style>
    .book-page {
      background-image: url('img/book.jpg');
      background-size: cover;
      background-repeat: no-repeat;
      background-attachment: fixed;
      padding: 20px;
      margin: 20px 0;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      border-radius: 5px;
      max-width: 500px;
      font-size: 16px;
      line-height: 1.5;
      color: #000;
    }

    body {
      background-image: url('./img/b2.jpg');
      background-size: cover;
      background-repeat: no-repeat;
      background-attachment: fixed;
    }
  </style>
</head>

<body>
  <?php include 'navbaruser.php'; ?>

  <div class="container">
    <h1>Youth Learnings</h1>
    <div class="book-page">
      <h1 id="title"><?= $title; ?></h1>
      <h2 id="author"> <?= $author; ?></h2>
      <div id="content">
        <?php
        $contentFilePath = "./BOOKS/$contentFile";
        if (file_exists($contentFilePath)) {
          $content = file_get_contents($contentFilePath);
          echo "<p>$content</p>";
        } else {
          echo "<p>No content available for this book.</p>";
        }
        ?>
      </div>
    </div>
  </div>

  <div class="container">
    <ul class="pagination">
      <li class="page-item">
        <a class="page-link" href="?page=<?= $prevPage; ?>" aria-label="Previous">
          <span aria-hidden="true">&laquo;</span>
        </a>
      </li>
      <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <li class="page-item <?= ($i === $currentPage) ? 'active' : ''; ?>">
          <a class="page-link" href="?page=<?= $i; ?>">
            <?= $i; ?>
          </a>
        </li>
      <?php endfor; ?>
      <li class="page-item">
        <a class="page-link" href="?page=<?= $nextPage; ?>" aria-label="Next">
          <span aria-hidden="true">&raquo;</span>
        </a>
      </li>
    </ul>
  </div>

</body>

</html>

