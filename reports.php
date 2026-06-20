<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['role'] != 'Admin') {
    header("Location: dashboard.php");
    exit();
}

$reports = mysqli_query($conn, "
SELECT 
events.event_name,
events.event_date,
events.location,
COUNT(registrations.registration_id) AS total_participants
FROM events
LEFT JOIN registrations ON events.event_id = registrations.event_id
GROUP BY events.event_id
ORDER BY events.event_id DESC
");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Reports</title>
    <link rel="stylesheet" href="assets/css/style.css?v=3">
</head>

<body>

    <?php include 'includes/sidebar.php'; ?>

    <div class="main">

        <h1>Reports</h1>
        <p>Summary of approved events and total registered participants.</p>

        <br>

        <div class="card">

            <h2>Event Report Summary</h2>
            <br>

            <table>
                <tr>
                    <th>No</th>
                    <th>Event Name</th>
                    <th>Date</th>
                    <th>Location</th>
                    <th>Total Participants</th>
                </tr>

                <?php
                $no = 1;

                if (mysqli_num_rows($reports) > 0) {
                    while ($row = mysqli_fetch_assoc($reports)) {
                        ?>

                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $row['event_name']; ?></td>
                            <td><?php echo $row['event_date']; ?></td>
                            <td><?php echo $row['location']; ?></td>
                            <td><?php echo $row['total_participants']; ?></td>
                        </tr>

                        <?php
                    }
                } else {
                    ?>

                    <tr>
                        <td colspan="5">No report data available.</td>
                    </tr>

                <?php } ?>

            </table>

        </div>

    </div>

</body>

</html>