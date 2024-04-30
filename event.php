<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== TRUE) {
  header("Location: ./login.php");
  exit;
}

// Include database connection file
include 'config.php';

// Fetch events from database
$query = "SELECT * FROM events ORDER BY event_date DESC";
$result = mysqli_query($link, $query);
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
  <?php include 'navbar.php'; ?>



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
              <button type="button" class="btn btn-primary btn-sm float-end" data-bs-toggle="modal"
                data-bs-target="#editEventModal<?= $row['event_id']; ?>">
                Edit
              </button>
              <button type="button" class="btn btn-danger btn-sm float-end me-2" data-bs-toggle="modal"
                data-bs-target="#deleteEventModal<?= $row['event_id']; ?>">
                Delete
              </button>

            </div>
          </div>
        </div>
        <!-- Edit Event Modal -->
        <div class="modal fade" id="editEventModal<?= $row['event_id']; ?>" tabindex="-1"
          aria-labelledby="editEventModalLabel<?= $row['event_id']; ?>" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="editEventModalLabel<?= $row['event_id']; ?>">Edit Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <!-- Form for editing the event -->
                <form id="editEventForm<?= $row['event_id']; ?>" method="post" action="editEvent.php">
                  <input type="hidden" name="event_id" value="<?= $row['event_id']; ?>">
                  <div class="mb-3">
                    <label for="editEventName<?= $row['event_id']; ?>" class="form-label">Event Name</label>
                    <input type="text" class="form-control" id="editEventName<?= $row['event_id']; ?>" name="event_name"
                      value="<?= htmlspecialchars($row['event_name']); ?>" required>
                  </div>
                  <div class="mb-3">
                    <label for="editEventDate<?= $row['event_id']; ?>" class="form-label">Event Date</label>
                    <input type="date" class="form-control" id="editEventDate<?= $row['event_id']; ?>" name="event_date"
                      value="<?= htmlspecialchars($row['event_date']); ?>" required>
                  </div>
                  <div class="mb-3">
                    <label for="editEventAddress<?= $row['event_id']; ?>" class="form-label">Address</label>
                    <input type="text" class="form-control" id="editEventAddress<?= $row['event_id']; ?>" name="address"
                      value="<?= htmlspecialchars($row['address']); ?>" required>
                  </div>
                  <div class="mb-3">
                    <label for="editEventStatus<?= $row['event_id']; ?>" class="form-label">Status</label>
                    <select class="form-select" id="editEventStatus<?= $row['event_id']; ?>" name="status" required>
                      <option value="Scheduled" <?= ($row['status'] == 'Scheduled') ? ' selected' : ''; ?>>Scheduled</option>
                      <option value="Completed" <?= ($row['status'] == 'Completed') ? ' selected' : ''; ?>>Completed</option>
                      <option value="Cancelled" <?= ($row['status'] == 'Cancelled') ? ' selected' : ''; ?>>Cancelled</option>
                    </select>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- Delete Event Modal -->
        <div class="modal fade" id="deleteEventModal<?= $row['event_id']; ?>" tabindex="-1"
          aria-labelledby="deleteEventModalLabel<?= $row['event_id']; ?>" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="deleteEventModalLabel<?= $row['event_id']; ?>">Delete Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <p>Are you sure you want to delete this event?</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="deleteEvent.php?event_id=<?= $row['event_id']; ?>" class="btn btn-danger">Delete</a>
              </div>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
      <div>
        <button type="button" class="btn btn-primary m-5" data-bs-toggle="modal" data-bs-target="#addEventModal">
          Add Event
        </button>


        <div class="modal fade" id="addEventModal" tabindex="-1" aria-labelledby="addEventModalLabel"
          aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="addEventModalLabel">Add New Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form id="addEventForm" method="post" action="addEvent.php">
                  <div class="mb-3">
                    <label for="eventName" class="form-label">Event Name</label>
                    <input type="text" class="form-control" id="eventName" name="event_name" required>
                  </div>
                  <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" class="form-control" id="address" name="address" required>
                  </div>
                  <div class="mb-3">
                    <label for="eventDate" class="form-label">Event Date</label>
                    <input type="date" class="form-control" id="eventDate" name="event_date" required>
                  </div>
                  <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status" required>
                      <option value="Scheduled">Scheduled</option>
                      <option value="Completed">Completed</option>
                      <option value="Cancelled">Cancelled</option>
                    </select>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Event</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>

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