<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['role'] != 'Club Leader') {
    header("Location: dashboard.php");
    exit();
}

if (isset($_POST['submit'])) {
    $user_id = $_SESSION['user_id'];
    $program_name = $_POST['program_name'];
    $club_name = $_POST['club_name'];
    $objective = $_POST['objective'];
    $description = $_POST['description'];
    $proposal_date = $_POST['proposal_date'];
    $proposal_time = $_POST['proposal_time'];
    $location = $_POST['location'];
    $budget = $_POST['budget'];

    $insert = mysqli_query($conn, "INSERT INTO program_proposals
    (user_id, program_name, club_name, objective, description, proposal_date, proposal_time, location, budget)
    VALUES
    ('$user_id', '$program_name', '$club_name', '$objective', '$description', '$proposal_date', '$proposal_time', '$location', '$budget')");

    if ($insert) {
        $success = "Proposal submitted successfully! Please wait for admin approval.";
    } else {
        $error = "Failed to submit proposal.";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Submit Proposal</title>
    <link rel="stylesheet" href="assets/css/style.css?v=3">
</head>

<body>

    <?php include 'includes/sidebar.php'; ?>

    <div class="main">

        <h1>Submit Program Proposal</h1>
        <p>Fill in the program details and submit your proposal for admin approval.</p>

        <br>

        <div class="card">

            <?php if (isset($success)) { ?>
                <p style="color:green; font-weight:bold;"><?php echo $success; ?></p>
                <br>
                <a href="my_proposals.php">
                    <button type="button">View My Proposals</button>
                </a>
                <br><br>
            <?php } ?>

            <?php if (isset($error)) { ?>
                <p style="color:red; font-weight:bold;"><?php echo $error; ?></p>
                <br>
            <?php } ?>

            <form method="POST">

                <label>Program Name</label>
                <input type="text" name="program_name" placeholder="Example: Leadership Camp 2026" required>

                <label>Club Name</label>
                <input type="text" name="club_name" placeholder="Example: IT Club" required>

                <label>Objective</label>
                <textarea name="objective" placeholder="State the main objective of the program" required></textarea>

                <label>Description</label>
                <textarea name="description" placeholder="Explain the program activities and target participants"
                    required></textarea>

                <label>Date</label>
                <input type="date" name="proposal_date" required>

                <label>Time</label>
                <input type="time" name="proposal_time" required>

                <label>Location</label>
                <input type="text" name="location" placeholder="Example: Dewan Kuliah Pusat" required>

                <label>Budget RM</label>
                <input type="number" step="0.01" name="budget" placeholder="Example: 500" required>

                <button type="submit" name="submit">Submit Proposal</button>

            </form>

        </div>

    </div>

</body>

</html>