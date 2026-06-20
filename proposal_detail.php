<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];

$query = mysqli_query($conn, "SELECT * FROM program_proposals WHERE proposal_id='$id'");
$row = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Proposal Detail</title>
    <link rel="stylesheet" href="assets/css/style.css?v=3">
</head>

<body>

    <?php include 'includes/sidebar.php'; ?>

    <div class="main">

        <h1>Proposal Detail</h1>
        <p>View complete information about the submitted program proposal.</p>

        <br>

        <div class="card">

            <h2><?php echo $row['program_name']; ?></h2>
            <br>

            <p><b>Club Name:</b> <?php echo $row['club_name']; ?></p>
            <p><b>Date:</b> <?php echo $row['proposal_date']; ?></p>
            <p><b>Time:</b> <?php echo $row['proposal_time']; ?></p>
            <p><b>Location:</b> <?php echo $row['location']; ?></p>
            <p><b>Budget:</b> RM <?php echo $row['budget']; ?></p>

            <p>
                <b>Status:</b>
                <span class="badge badge-<?php echo strtolower($row['status']); ?>">
                    <?php echo $row['status']; ?>
                </span>
            </p>

            <br>

            <p><b>Objective:</b></p>
            <p><?php echo $row['objective']; ?></p>

            <br>

            <p><b>Description:</b></p>
            <p><?php echo $row['description']; ?></p>

            <br>

            <?php if ($_SESSION['role'] == 'Admin' && $row['status'] == 'Pending') { ?>

                <a href="approve_proposal.php?id=<?php echo $row['proposal_id']; ?>">
                    <button>Approve</button>
                </a>

                <a href="reject_proposal.php?id=<?php echo $row['proposal_id']; ?>">
                    <button style="background:red;">Reject</button>
                </a>

            <?php } ?>

        </div>

    </div>

</body>

</html>