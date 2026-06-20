<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];

mysqli_query($conn, "UPDATE program_proposals 
SET status='Approved' 
WHERE proposal_id='$id'");

$proposal = mysqli_query($conn, "SELECT * FROM program_proposals WHERE proposal_id='$id'");
$row = mysqli_fetch_assoc($proposal);

$check = mysqli_query($conn, "SELECT * FROM events WHERE proposal_id='$id'");

if (mysqli_num_rows($check) == 0) {
    mysqli_query($conn, "INSERT INTO events
    (proposal_id, event_name, event_date, event_time, location, description, budget)
    VALUES
    (
    '$id',
    '" . $row['program_name'] . "',
    '" . $row['proposal_date'] . "',
    '" . $row['proposal_time'] . "',
    '" . $row['location'] . "',
    '" . $row['description'] . "',
    '" . $row['budget'] . "'
    )");
}

header("Location: proposals.php");
exit();
?>