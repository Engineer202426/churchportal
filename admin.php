<?php
session_start();

include 'config.php';

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== TRUE) {
  header("Location: ./login.php");
  exit;
}


$sql = "SELECT * FROM users";
$result = mysqli_query($link, $sql);

if (!$result) {
  die("Error: " . mysqli_error($link));
}

$username_err = $email_err = $password_err = "";
$first_name_err = $last_name_err = $middle_name_err = $address_err = $contact_number_err = $status_err = $birthday_err = "";

$username = $email = $password = "";
$first_name = $last_name = $middle_name = $address = $contact_number = $status = $birthday = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // Validate First Name
  $first_name = trim($_POST["first_name"]);
  if (empty($first_name)) {
    $first_name_err = "Please enter your First Name.";
  } elseif (!ctype_alpha($first_name)) {
    $first_name_err = "First Name can only contain letters.";
  }

  // Validate Last Name
  $last_name = trim($_POST["last_name"]);
  if (empty($last_name)) {
    $last_name_err = "Please enter your Last Name.";
  } elseif (!ctype_alpha($last_name)) {
    $last_name_err = "Last Name can only contain letters.";
  }

  // Validate Middle Name
  $middle_name = trim($_POST["middle_name"]);
  if (empty($middle_name)) {
    $middle_name_err = "Please enter your Middle Name.";
  } elseif (!ctype_alpha($middle_name)) {
    $middle_name_err = "Middle Name can only contain letters.";
  }

  // Validate Address
  $address = trim($_POST["address"]);
  if (empty($address)) {
    $address_err = "Please enter your Address.";
  }

  // Validate Contact Number
  $contact_number = trim($_POST["contact_number"]);
  if (empty($contact_number)) {
    $contact_number_err = "Please enter your Contact Number.";
  }

  // Validate Status
  $status = trim($_POST["status"]);
  if (empty($status)) {
    $status_err = "Please select a status.";
  }

  // Validate Birthday
  $birthday = trim($_POST["birthday"]);
  if (empty($birthday)) {
    $birthday_err = "Please enter your Birthday.";
  } elseif (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $birthday)) {
    $birthday_err = "Please enter a valid date in the format YYYY-MM-DD.";
  }

  // Validate username
  $username = trim($_POST["username"]);
  if (empty($username)) {
    $username_err = "Please enter a username.";
  } elseif (!ctype_alnum(str_replace(array("@", "-", "_"), "", $username))) {
    $username_err = "Username can only contain letters, numbers and symbols like '@', '_', or '-'.";
  } else {
    $sql = "SELECT id FROM users WHERE username = ?";

    if ($stmt = mysqli_prepare($link, $sql)) {
      mysqli_stmt_bind_param($stmt, "s", $param_username);

      $param_username = $username;

      if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_store_result($stmt);
        if (mysqli_stmt_num_rows($stmt) == 1) {
          $username_err = "This username is already registered.";
        }
      } else {
        echo "<script>alert('Oops! Something went wrong. Please try again later.');</script>";
      }

      mysqli_stmt_close($stmt);
    }
  }

  // Validate email
  $email = trim($_POST["email"]);
  if (empty($email)) {
    $email_err = "Please enter an email address";
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $email_err = "Please enter a valid email address.";
  } else {
    $sql = "SELECT id FROM users WHERE email = ?";

    if ($stmt = mysqli_prepare($link, $sql)) {
      mysqli_stmt_bind_param($stmt, "s", $param_email);
      $param_email = $email;
      if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_store_result($stmt);
        if (mysqli_stmt_num_rows($stmt) == 1) {
          $email_err = "This email is already registered.";
        }
      } else {
        echo "<script>alert('Oops! Something went wrong. Please try again later.');</script>";
      }
      mysqli_stmt_close($stmt);
    }
  }

  // Validate password
  $password = trim($_POST["password"]);
  if (empty($password)) {
    $password_err = "Please enter a password.";
  } elseif (strlen($password) < 8) {
    $password_err = "Password must contain at least 8 characters.";
  }

  if (empty($username_err) && empty($email_err) && empty($password_err) && empty($first_name_err) && empty($last_name_err) && empty($middle_name_err) && empty($address_err) && empty($contact_number_err) && empty($status_err) && empty($birthday_err)) {

    $sql = "INSERT INTO users (username, email, password, first_name, last_name, middle_name, address, contact_number, status, birthday, verified) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1)";


    if ($stmt = mysqli_prepare($link, $sql)) {
      mysqli_stmt_bind_param($stmt, "ssssssssss", $param_username, $param_email, $param_password, $param_first_name, $param_last_name, $param_middle_name, $param_address, $param_contact_number, $param_status, $param_birthday);

      $param_username = $username;
      $param_email = $email;
      $param_password = password_hash($password, PASSWORD_DEFAULT);
      $param_first_name = $first_name;
      $param_last_name = $last_name;
      $param_middle_name = $middle_name;
      $param_address = $address;
      $param_contact_number = $contact_number;
      $param_status = $status;
      $param_birthday = $birthday;

      if (mysqli_stmt_execute($stmt)) {
        header("Location: admin.php");
        exit();
      } else {
        echo "Oops! Something went wrong. Please try again later.";
      }

      mysqli_stmt_close($stmt);
    } else {
      echo "Oops! Something went wrong. Please try again later.";
    }
  }

  mysqli_close($link);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>All Users</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
  <link rel="shortcut icon" href="./img/favicon-16x16.png" type="image/x-icon">
</head>

<body>
  <?php include 'navbar.php'; ?>

  <div class="container">
    <h1>All Users</h1>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
      + ADD
    </button>
    <table id="userTable" class="display">
      <thead>
        <tr>
          <th>ID</th>
          <th>Username</th>
          <th>Email</th>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Middle Name</th>
          <th>Address</th>
          <th>Contact Number</th>
          <th>Roles</th>
          <th>Status</th>
          <th>Registration Date</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if (mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row["id"] . "</td>";
            echo "<td>" . $row["username"] . "</td>";
            echo "<td>" . $row["email"] . "</td>";
            echo "<td>" . $row["first_name"] . "</td>";
            echo "<td>" . $row["last_name"] . "</td>";
            echo "<td>" . $row["middle_name"] . "</td>";
            echo "<td>" . $row["address"] . "</td>";
            echo "<td>" . $row["contact_number"] . "</td>";
            echo "<td>" . $row["status"] . "</td>";
            echo "<td>" . $row["stat"] . "</td>";
            echo "<td>" . $row["reg_date"] . "</td>";
            echo "<td>";
            echo "<button class='btn btn-dark deactivate-user mb-2' data-user-id='" . $row["id"] . "'>DEACTIVATE</button>";
            echo "<button class='btn btn-secondary suspend-user mb-2' data-user-id='" . $row["id"] . "'>SUSPEND</button>";
            echo "<button class='btn btn-success reactivate-user mb-2' data-user-id='" . $row["id"] . "'>REACTIVATE</button>";
            echo "<button class='btn btn-danger remove-user' data-user-id='" . $row["id"] . "'>Remove</button>";
            echo "</td>";
            echo "</tr>";
          }
        } else {
          echo "<tr><td colspan='10'>No users found</td></tr>";
        }

        ?>
      </tbody>
    </table>
  </div>
  <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addUserModalLabel">Add User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" novalidate>
            <div class="row mb-3">
              <!-- First Name -->
              <div class="col-md-6">
                <label for="first_name" class="form-label" style="color: #d9a401;">First Name</label>
                <input type="text" class="form-control" name="first_name" id="first_name" value="<?= $first_name; ?>"
                  style="outline-color: white;">
                <small class="text-danger" style="color: #d9a401;">
                  <?= $first_name_err; ?>
                </small>
              </div>

              <!-- Last Name -->
              <div class="col-md-6">
                <label for="last_name" class="form-label" style="color: #d9a401;">Last Name</label>
                <input type="text" class="form-control" name="last_name" id="last_name" value="<?= $last_name; ?>"
                  style="outline-color: white;">
                <small class="text-danger" style="color: #d9a401;">
                  <?= $last_name_err; ?>
                </small>
              </div>
            </div>

            <div class="row mb-3">
              <!-- Middle Name -->
              <div class="col-md-6">
                <label for="middle_name" class="form-label" style="color: #d9a401;">Middle Name</label>
                <input type="text" class="form-control" name="middle_name" id="middle_name" value="<?= $middle_name; ?>"
                  style="outline-color: white;">
                <small class="text-danger" style="color: #d9a401;">
                  <?= $middle_name_err; ?>
                </small>
              </div>

              <!-- Address -->
              <div class="col-md-6">
                <label for="address" class="form-label" style="color: #d9a401;">Address</label>
                <input type="text" class="form-control" name="address" id="address" value="<?= $address; ?>"
                  style="outline-color: white;">
                <small class="text-danger" style="color: #d9a401;">
                  <?= $address_err; ?>
                </small>
              </div>
            </div>

            <div class="row mb-3">
              <!-- Username -->
              <div class="col-md-6">
                <label for="username" class="form-label" style="color: #d9a401;">Username</label>
                <input type="text" class="form-control" name="username" id="username" value="<?= $username; ?>"
                  style="outline-color: white;">
                <small class="text-danger" style="color: #d9a401;">
                  <?= $username_err; ?>
                </small>
              </div>

              <!-- Password -->
              <div class="col-md-6">
                <label for="password" class="form-label" style="color: #d9a401;">Password</label>
                <input type="password" class="form-control" name="password" id="password" value="<?= $password; ?>"
                  style="outline-color: white;">
                <small class="text-danger" style="color: #d9a401;">
                  <?= $password_err; ?>
                </small>
              </div>
            </div>

            <!-- Show Password Checkbox -->
            <div class="form-check mb-3">
              <input class="form-check-input" type="checkbox" id="showPassword">
              <label class="form-check-label" for="showPassword">
                Show Password
              </label>
            </div>


            <div class="row mb-3">
              <!-- Email -->
              <div class="col-md-6">
                <label for="email" class="form-label" style="color: #d9a401;">Email Address</label>
                <input type="email" class="form-control" name="email" id="email" value="<?= $email; ?>"
                  style="outline-color: white;">
                <small class="text-danger" style="color: #d9a401;">
                  <?= $email_err; ?>
                </small>
              </div>

              <!-- Contact Number -->
              <div class="col-md-6">
                <label for="contact_number" class="form-label" style="color: #d9a401;">Contact Number</label>
                <input type="text" class="form-control" name="contact_number" id="contact_number"
                  value="<?= $contact_number; ?>" style="outline-color: white;">
                <small class="text-danger" style="color: #d9a401;">
                  <?= $contact_number_err; ?>
                </small>
              </div>
            </div>
            <!-- Birthday -->
            <div class="col-md-6">
              <label for="birthday" class="form-label" style="color: #d9a401;">Birthday</label>
              <input type="date" class="form-control" name="birthday" id="birthday" value="<?= $birthday; ?>"
                style="outline-color: white;">
              <small class="text-danger" style="color: #d9a401;">
                <?= $birthday_err; ?>
              </small>
            </div>
            <div class="mb-3">
              <label for="status" class="form-label" style="color: #d9a401;">Status</label>
              <select class="form-select" name="status" id="status">
                <option value="Admin">Admin</option>
                <option value="Member">Member</option>
                <option value="Guest">Guest</option>
              </select>
              <small class="text-danger" style="color: #d9a401;">
                <?= $status_err; ?>
              </small>
            </div>

            <div class="mb-3">
              <input type="submit" class="btn btn-primary form-control" name="submit" value="Sign Up">
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>
  <script>
    $(document).ready(function () {
      $('#userTable').DataTable();
    });
  </script>
</body>
<script>
  const passwordInput = document.getElementById('password');
  const showPasswordCheckbox = document.getElementById('showPassword');
  showPasswordCheckbox.addEventListener('change', function () {
    if (passwordInput.type === 'password') {
      passwordInput.type = 'text';
    } else {
      passwordInput.type = 'password';
    }
  });



  $(document).ready(function () {
  $('#userTable').DataTable();

  $('.remove-user').click(function () {
    var userId = $(this).data('user-id');

    if (confirm("Are you sure you want to remove this user?")) {
      $.ajax({
        type: 'POST',
        url: 'remove_user.php',
        data: { userId: userId },
        success: function(response) {
    console.log('AJAX request successful', response);
    location.reload();
  },
        error: function(xhr, status, error) {
    console.error('AJAX request failed', status, error);
  }
});
console.log('After AJAX request');
    }
  });
});

$(document).ready(function () {
  $('#userTable').DataTable();

  $('.deactivate-user').click(function () {
    var userId = $(this).data('user-id');

    if (confirm("Are you sure you want to Deactivate this user?")) {
      $.ajax({
        type: 'POST',
        url: 'deactivate_user.php',
        data: { userId: userId },
        success: function(response) {
    console.log('AJAX request successful', response);
    location.reload();
  },
        error: function(xhr, status, error) {
    console.error('AJAX request failed', status, error);
  }
});
console.log('After AJAX request');
    }
  });
});

$(document).ready(function () {
  $('#userTable').DataTable();
$('.reactivate-user').click(function () {
    var userId = $(this).data('user-id');

    if (confirm("Are you sure you want to Reactivate this user?")) {
      $.ajax({
        type: 'POST',
        url: 'reactivate_user.php',
        data: { userId: userId },
        success: function(response) {
          console.log('AJAX request successful', response);
          location.reload();
        },
        error: function(xhr, status, error) {
          console.error('AJAX request failed', status, error);
        }
      });
    }
  });});

$(document).ready(function () {
  $('#userTable').DataTable();

  $('.suspend-user').click(function () {
    var userId = $(this).data('user-id');

    if (confirm("Are you sure you want to Suspend this user?")) {
      $.ajax({
        type: 'POST',
        url: 'suspend_user.php',
        data: { userId: userId },
        success: function(response) {
    console.log('AJAX request successful', response);
    location.reload();
  },
        error: function(xhr, status, error) {
    console.error('AJAX request failed', status, error);
  }
});
console.log('After AJAX request');
    }
  });
});

</script>

</html>
<style>
  .container{
    margin-left: -5px;;
  }
</style>