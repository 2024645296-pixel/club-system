<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$role = $_SESSION['role'];

$search = "";

if (isset($_GET['search'])) {
    $search = $_GET['search'];

    $events = mysqli_query($conn, "
    SELECT * FROM events
    WHERE event_name LIKE '%$search%'
    OR location LIKE '%$search%'
    OR status LIKE '%$search%'
    ORDER BY event_id DESC
    ");
} else {
    $events = mysqli_query($conn, "SELECT * FROM events ORDER BY event_id DESC");
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Events</title>
    <link rel="stylesheet" href="assets/css/style.css?v=3">
</head>

<body>

    <?php include 'includes/sidebar.php'; ?>

    <div class="main">

        <h1>Club Events</h1>
        <p>View approved club events and register for available programs.</p>

        <br>

        <div class="card">

            <h2>Event List</h2>
            <br>

            <form method="GET">
                <input type="text" name="search" placeholder="Search event, location or status..."
                    value="<?php echo $search; ?>">
                <button type="submit">Search</button>
                <a href="events.php">
                    <button type="button">Reset</button>
                </a>
            </form>

            <br>

            <table>

                <tr>
                    <th>No</th>
                    <th>Event Name</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Location</th>
                    <th>Budget</th>
                    <th>Status</th>

                    <?php if ($role == 'Student') { ?>
                        <th>Action</th>
                    <?php } ?>

                    <th>View</th>
                </tr>

                <?php
                $no = 1;

                if (mysqli_num_rows($events) > 0) {
                    while ($row = mysqli_fetch_assoc($events)) {
                        ?>

                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $row['event_name']; ?></td>
                            <td><?php echo $row['event_date']; ?></td>
                            <td><?php echo $row['event_time']; ?></td>
                            <td><?php echo $row['location']; ?></td>
                            <td>RM <?php echo $row['budget']; ?></td>

                            <td>
                                <span class="badge badge-<?php echo strtolower($row['status']); ?>">
                                    <?php echo $row['status']; ?>
                                </span>
                            </td>

                            <?php if ($role == 'Student') { ?>
                                <td>
                                    <a href="register_event.php?id=<?php echo $row['event_id']; ?>">Register</a>
                                </td>
                            <?php } ?>

                            <td>
                                <a href="event_detail.php?id=<?php echo $row['event_id']; ?>">View</a>
                            </td>
                        </tr>

                        <?php
                    }
                } else {
                    ?>

                    <tr>
                        <td colspan="9">No event found.</td>
                    </tr>

                <?php } ?>

            </table>

        </div>

    </div>

</body>

</html>