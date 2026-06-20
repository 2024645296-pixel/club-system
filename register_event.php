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

$event_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

$event = mysqli_query($conn, "SELECT * FROM events WHERE event_id='$event_id'");
$event_data = mysqli_fetch_assoc($event);

$check = mysqli_query($conn, "
SELECT * FROM registrations 
WHERE event_id='$event_id' 
AND user_id='$user_id'
");

$already_registered = mysqli_num_rows($check) > 0;

if (isset($_POST['register']) && !$already_registered) {
    $full_name = $_POST['full_name'];
    $matric_no = $_POST['matric_no'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $insert = mysqli_query($conn, "INSERT INTO registrations
    (event_id, user_id, full_name, matric_no, email, phone)
    VALUES
    ('$event_id', '$user_id', '$full_name', '$matric_no', '$email', '$phone')");

    if ($insert) {
        $success = "Registration successful!";
        $already_registered = true;
    } else {
        $error = "Registration failed.";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Register Event</title>
    <link rel="stylesheet" href="assets/css/style.css?v=3">
</head>

<body>

    <?php include 'includes/sidebar.php'; ?>

    <div class="main">

        <h1>Event Registration</h1>
        <p>Complete your registration details for this event.</p>

        <br>

        <div class="card">

            <h2><?php echo $event_data['event_name']; ?></h2>
            <br>

            <p><b>Date:</b> <?php echo $event_data['event_date']; ?></p>
            <p><b>Time:</b> <?php echo $event_data['event_time']; ?></p>
            <p><b>Location:</b> <?php echo $event_data['location']; ?></p>

            <br>

            <?php if (isset($success)) { ?>
                <p style="color:green; font-weight:bold;"><?php echo $success; ?></p>
                <br>
            <?php } ?>

            <?php if (isset($error)) { ?>
                <p style="color:red; font-weight:bold;"><?php echo $error; ?></p>
                <br>
            <?php } ?>

            <?php if ($already_registered) { ?>

                <p style="color:#1e40af; font-weight:bold;">
                    You have already registered for this event.
                </p>

                <br>

                <a href="my_registrations.php">
                    <button type="button">View My Registrations</button>
                </a>

            <?php } else { ?>

                <form method="POST">

                    <label>Full Name</label>
                    <input type="text" name="full_name" required>

                    <label>Matric No</label>
                    <input type="text" name="matric_no" required>

                    <label>Email</label>
                    <input type="email" name="email" required>

                    <label>Phone</label>
                    <input type="text" name="phone" required>

                    <button type="submit" name="register">Submit Registration</button>

                </form>

            <?php } ?>

        </div>

    </div>

</body>

</html>