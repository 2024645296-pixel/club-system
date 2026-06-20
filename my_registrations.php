<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['role'] != 'Student') {
    header("Location: dashboard.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$registrations = mysqli_query($conn, "
SELECT registrations.*, events.event_name, events.event_date, events.location
FROM registrations
JOIN events ON registrations.event_id = events.event_id
WHERE registrations.user_id='$user_id'
ORDER BY registrations.registration_id DESC
");
?>

<!DOCTYPE html>
<html>

<head>
    <title>My Registrations</title>
    <link rel="stylesheet" href="assets/css/style.css?v=3">
</head>

<body>

    <?php include 'includes/sidebar.php'; ?>

    <div class="main">

        <h1>My Registrations</h1>
        <p>View the events that you have registered for.</p>

        <br>

        <div class="card">

            <table>
                <tr>
                    <th>No</th>
                    <th>Event Name</th>
                    <th>Date</th>
                    <th>Location</th>
                    <th>Payment</th>
                    <th>Attendance</th>
                </tr>

                <?php
                $no = 1;

                if (mysqli_num_rows($registrations) > 0) {
                    while ($row = mysqli_fetch_assoc($registrations)) {
                        ?>

                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $row['event_name']; ?></td>
                            <td><?php echo $row['event_date']; ?></td>
                            <td><?php echo $row['location']; ?></td>
                            <td><?php echo $row['payment_status']; ?></td>
                            <td><?php echo $row['attendance_status']; ?></td>
                        </tr>

                        <?php
                    }
                } else {
                    ?>

                    <tr>
                        <td colspan="6">You have not registered for any event yet.</td>
                    </tr>

                <?php } ?>

            </table>

        </div>

    </div>

</body>

</html>