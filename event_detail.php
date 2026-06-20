<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];

$query = mysqli_query($conn, "SELECT * FROM events WHERE event_id='$id'");
$row = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Event Detail</title>
    <link rel="stylesheet" href="assets/css/style.css?v=3">
</head>

<body>

    <?php include 'includes/sidebar.php'; ?>

    <div class="main">

        <h1>Event Detail</h1>
        <p>View complete information about the selected event.</p>

        <br>

        <div class="card">

            <h2><?php echo $row['event_name']; ?></h2>

            <br>

            <p><b>Date:</b> <?php echo $row['event_date']; ?></p>

            <p><b>Time:</b> <?php echo $row['event_time']; ?></p>

            <p><b>Location:</b> <?php echo $row['location']; ?></p>

            <p><b>Budget:</b> RM <?php echo $row['budget']; ?></p>

            <p>
                <b>Status:</b>

                <span class="badge badge-<?php echo strtolower($row['status']); ?>">
                    <?php echo $row['status']; ?>
                </span>
            </p>

            <br>

            <p><b>Description:</b></p>

            <p><?php echo $row['description']; ?></p>

            <br>

            <?php if ($_SESSION['role'] == 'Student') { ?>

                <a href="register_event.php?id=<?php echo $row['event_id']; ?>">
                    <button>Register Event</button>
                </a>

            <?php } ?>

        </div>

    </div>

</body>

</html>