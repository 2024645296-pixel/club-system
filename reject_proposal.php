<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];

mysqli_query($conn, "UPDATE program_proposals 
SET status='Rejected' 
WHERE proposal_id='$id'");

header("Location: proposals.php");
exit();
?>