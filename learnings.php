<?php
ob_start();
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

// Function to add a new book
function addBook($title, $author) {
  // Load the existing book.ini file
  $books = parse_ini_file("./book.ini", true);
  
  // Determine the next available book number
  $bookNumber = count($books) + 1;
  
  // Generate the new content file name automatically
  $newContentFile = "book" . $bookNumber . ".txt";

  // Create a new book entry in the book.ini file
  $books["Book$bookNumber"] = [
    'Title' => $title,
    'Author' => $author,
    'Content' => $newContentFile
  ];
  
  // Save the updated book.ini file
  $updatedIni = '';
  foreach ($books as $bookName => $bookData) {
    $updatedIni .= "[$bookName]\n";
    foreach ($bookData as $key => $value) {
      $updatedIni .= "$key = \"$value\"\n";
    }
    $updatedIni .= "\n";
  }
  
  file_put_contents("./book.ini", $updatedIni);
  
  // Create the corresponding .txt file for the content
  $contentFilePath = "./BOOKS/$newContentFile";
  $contentText = "This is the content of the book: $title by $author";
  file_put_contents($contentFilePath, $contentText);
  
  // Redirect to the newly added book page
  header("Location: ./learnings.php?page=$bookNumber");
  exit;
}


// Function to remove the current book
function removeBook() {
  // Load the existing book.ini file
  $books = parse_ini_file("./book.ini", true);

  // Find the last book key
  $lastBookKey = "Book" . count($books);

  // Remove the last book from the array
  unset($books[$lastBookKey]);

  // Save the updated book.ini file
  $updatedIni = '';
  foreach ($books as $bookName => $bookData) {
    $updatedIni .= "[$bookName]\n";
    foreach ($bookData as $key => $value) {
      $updatedIni .= "$key = \"$value\"\n";
    }
    $updatedIni .= "\n";
  }

  file_put_contents("./book.ini", $updatedIni);

  // Redirect to the last page in the pagination
  $lastPage = ceil((count($books) - 1) / $GLOBALS['booksPerPage']);
  header("Location: ./learnings.php?page=" . max(1, $lastPage));
  exit;
}

// Check if a book has been added or removed using a POST request
if (isset($_POST['action'])) {
  if ($_POST['action'] === 'add') {
    $newTitle = $_POST['newTitle'];
    $newAuthor = $_POST['newAuthor'];
    $newContentFile = $_POST['newContentFile'];
    addBook($newTitle, $newAuthor, $newContentFile);
  } elseif ($_POST['action'] === 'remove') {
    removeBook($currentPage);
  }
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
  <?php include 'navbar.php'; ?>

  <div class="container">
    <h1>Youth Learnings</h1>
    <button id="addButton" class="btn btn-success">Add Book</button>
    <button id="removeButton" class="btn btn-danger" <?php echo ($totalBooks <= 1) ? 'disabled' : ''; ?>>Remove Book</button>
    <button id="editButton" class="btn btn-primary">Edit</button>
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

  <script>
  function toggleEditMode() {
  var titleElement = document.getElementById('title');
  var authorElement = document.getElementById('author');
  var contentElement = document.getElementById('content');

  // Toggle the contentEditable attribute to enable/disable editing
  titleElement.contentEditable = !titleElement.isContentEditable;
  authorElement.contentEditable = !authorElement.isContentEditable;
  contentElement.contentEditable = !contentElement.isContentEditable;

  var editButton = document.getElementById('editButton');
  if (titleElement.isContentEditable) {
    editButton.textContent = 'Save';
  } else {
    editButton.textContent = 'Edit';

    // Save the edited content
    saveEditedContent();
  }
}

function saveEditedContent() {
  var editedTitle = document.getElementById('title').innerText;
  var editedAuthor = document.getElementById('author').innerText;
  var editedContent = document.getElementById('content').innerText;

  var xhr = new XMLHttpRequest();
  xhr.open("POST", "save_edit.php?page=<?php echo $currentPage; ?>", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4) {
      if (xhr.status === 200) {
        alert("Content saved successfully!");
      } else {
        alert("Error saving content. Please try again later.");
        console.error(xhr.responseText); // Log the response for debugging
      }
    }
  };
  xhr.send(
    "editedTitle=" + encodeURIComponent(editedTitle) +
    "&editedAuthor=" + encodeURIComponent(editedAuthor) +
    "&editedContent=" + encodeURIComponent(editedContent)
  );
}

    document.getElementById('editButton').addEventListener('click', toggleEditMode);

    // Add click event listener to the "Edit" button
    document.getElementById('editButton').addEventListener('click', toggleEditMode);

    document.getElementById('addButton').addEventListener('click', function () {
  var newTitle = prompt("Enter the title of the new book:");
  var newAuthor = prompt("Enter the author of the new book:");
  
  // Check that the user entered both title and author
  if (newTitle && newAuthor) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "learnings.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        location.reload(); // Refresh the page after adding the book
      }
    };
    xhr.send("action=add&newTitle=" + encodeURIComponent(newTitle) + "&newAuthor=" + encodeURIComponent(newAuthor));
  } else {
    // Handle the case where the user did not enter title or author
    alert("You must enter both a title and an author for the new book.");
  }
});
    document.getElementById('removeButton').addEventListener('click', function () {
      // Confirm with the user before removing the current book
      var confirmation = confirm("Are you sure you want to remove the current book?");
      if (confirmation) {
        // Send a POST request to remove the current book
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "learnings.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
          if (xhr.readyState === 4 && xhr.status === 200) {
            location.reload(); // Refresh the page after removing the book
          }
        };
        xhr.send("action=remove");
      }
    });

    document.getElementById('editButton').addEventListener('click', toggleEditMode);
  </script>
</body>

</html>

