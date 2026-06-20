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

$search = "";

if (isset($_GET['search'])) {
    $search = $_GET['search'];

    $proposals = mysqli_query($conn, "
    SELECT * FROM program_proposals
    WHERE program_name LIKE '%$search%'
    OR club_name LIKE '%$search%'
    OR status LIKE '%$search%'
    ORDER BY proposal_id DESC
    ");
} else {
    $proposals = mysqli_query($conn, "SELECT * FROM program_proposals ORDER BY proposal_id DESC");
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Manage Proposals</title>
    <link rel="stylesheet" href="assets/css/style.css?v=3">
</head>

<body>

    <?php include 'includes/sidebar.php'; ?>

    <div class="main">

        <h1>Manage Proposals</h1>
        <p>Review, approve or reject program proposals submitted by club leaders.</p>

        <br>

        <div class="card">

            <h2>All Program Proposals</h2>
            <br>

            <form method="GET">
                <input type="text" name="search" placeholder="Search proposal, club or status..."
                    value="<?php echo $search; ?>">
                <button type="submit">Search</button>
                <a href="manage_proposals.php">
                    <button type="button">Reset</button>
                </a>
            </form>

            <br>

            <table>
                <tr>
                    <th>No</th>
                    <th>Program Name</th>
                    <th>Club</th>
                    <th>Date</th>
                    <th>Budget</th>
                    <th>Status</th>
                    <th>Action</th>
                    <th>View</th>
                </tr>

                <?php
                $no = 1;
                while ($row = mysqli_fetch_assoc($proposals)) {
                    ?>

                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $row['program_name']; ?></td>
                        <td><?php echo $row['club_name']; ?></td>
                        <td><?php echo $row['proposal_date']; ?></td>
                        <td>RM <?php echo $row['budget']; ?></td>

                        <td>
                            <span class="badge badge-<?php echo strtolower($row['status']); ?>">
                                <?php echo $row['status']; ?>
                            </span>
                        </td>

                        <td>
                            <?php if ($row['status'] == 'Pending') { ?>
                                <a href="approve_proposal.php?id=<?php echo $row['proposal_id']; ?>">Approve</a>
                                |
                                <a href="reject_proposal.php?id=<?php echo $row['proposal_id']; ?>">Reject</a>
                            <?php } else { ?>
                                Completed
                            <?php } ?>
                        </td>

                        <td>
                            <a href="proposal_detail.php?id=<?php echo $row['proposal_id']; ?>">View</a>
                        </td>
                    </tr>

                <?php } ?>

            </table>

        </div>

    </div>

</body>

</html>