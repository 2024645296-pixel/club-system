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

$user_id = $_SESSION['user_id'];

$proposals = mysqli_query($conn, "
SELECT * FROM program_proposals
WHERE user_id='$user_id'
ORDER BY proposal_id DESC
");
?>

<!DOCTYPE html>
<html>

<head>
    <title>My Proposals</title>
    <link rel="stylesheet" href="assets/css/style.css?v=3">
</head>

<body>

    <?php include 'includes/sidebar.php'; ?>

    <div class="main">

        <h1>My Proposals</h1>
        <p>View the status of program proposals submitted by your club.</p>

        <br>

        <div class="card">

            <table>
                <tr>
                    <th>No</th>
                    <th>Program Name</th>
                    <th>Club</th>
                    <th>Date</th>
                    <th>Budget</th>
                    <th>Status</th>
                    <th>View</th>
                </tr>

                <?php
                $no = 1;

                if (mysqli_num_rows($proposals) > 0) {
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
                                <a href="proposal_detail.php?id=<?php echo $row['proposal_id']; ?>">View</a>
                            </td>
                        </tr>

                        <?php
                    }
                } else {
                    ?>

                    <tr>
                        <td colspan="7">No proposal submitted yet.</td>
                    </tr>

                <?php } ?>

            </table>

        </div>

    </div>

</body>

</html>