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

$registrations = mysqli_query($conn, "
SELECT registrations.*, events.event_name
FROM registrations
JOIN events ON registrations.event_id = events.event_id
ORDER BY registrations.registration_id DESC
");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Registrations</title>
    <link rel="stylesheet" href="assets/css/style.css?v=3">
</head>

<body>

    <?php include 'includes/sidebar.php'; ?>

    <div class="main">

        <h1>Event Registrations</h1>
        <p>View all participants registered for club events.</p>

        <br>

        <div class="card">

            <h2>Participant List</h2>
            <br>

            <table>
                <tr>
                    <th>No</th>
                    <th>Event Name</th>
                    <th>Full Name</th>
                    <th>Matric No</th>
                    <th>Email</th>
                    <th>Phone</th>
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
                            <td><?php echo $row['full_name']; ?></td>
                            <td><?php echo $row['matric_no']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['phone']; ?></td>
                            <td><?php echo $row['payment_status']; ?></td>
                            <td><?php echo $row['attendance_status']; ?></td>
                        </tr>

                        <?php
                    }
                } else {
                    ?>

                    <tr>
                        <td colspan="8">No registration record found.</td>
                    </tr>

                <?php } ?>

            </table>

        </div>

    </div>

</body>

</html>