<?php
$current_page = basename($_SERVER['PHP_SELF']);
$role = $_SESSION['role'];
?>

<div class="sidebar">

    <div class="logo">Campus<span>Event</span></div>

    <p class="sidebar-subtitle">Student Club Management</p>

    <div class="menu">

        <a href="dashboard.php">Dashboard</a>

        <?php if ($role == 'Admin') { ?>
            <a href="manage_proposals.php">Manage Proposals</a>
            <a href="events.php">Club Events</a>
            <a href="registrations.php">Registrations</a>
            <a href="reports.php">Reports</a>
            <a href="users.php">Users</a>
        <?php } ?>

        <?php if ($role == 'Club Leader') { ?>
            <a href="submit_proposal.php">Submit Proposal</a>
            <a href="my_proposals.php">My Proposals</a>
            <a href="events.php">Club Events</a>
        <?php } ?>

        <?php if ($role == 'Student') { ?>
            <a href="events.php">Club Events</a>
            <a href="my_registrations.php">My Registrations</a>
        <?php } ?>

        <a href="logout.php">Logout</a>

    </div>

</div>