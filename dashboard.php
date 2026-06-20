<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];

$totalProposal = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM program_proposals"));
$pendingProposal = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM program_proposals WHERE status='Pending'"));
$approvedProposal = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM program_proposals WHERE status='Approved'"));
$rejectedProposal = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM program_proposals WHERE status='Rejected'"));

$totalEvents = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM events"));
$totalRegistrations = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM registrations"));
$totalUsers = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM users"));

$myProposal = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM program_proposals WHERE user_id='$user_id'"));
$myRegistration = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM registrations WHERE user_id='$user_id'"));
?>

<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="assets/css/style.css?v=20">
</head>

<body>

    <?php include 'includes/sidebar.php'; ?>

    <div class="main">

        <div class="topbar">
            <div></div>
            <div class="profile-box">
                <span class="notification">🔔</span>
                <span class="avatar"><?php echo strtoupper(substr($_SESSION['name'], 0, 2)); ?></span>
                <span><?php echo $_SESSION['name']; ?></span>
            </div>
        </div>

        <div class="welcome-section">
            <h1>Welcome back, <?php echo $_SESSION['name']; ?> 👋</h1>
            <p>Here's what's happening with your campus events today.</p>
        </div>

        <div class="dashboard-grid">

            <?php if ($role == 'Admin') { ?>

                <div class="glass-card">
                    <div class="circle blue">📄</div>
                    <div>
                        <h2><?php echo $totalProposal['total']; ?></h2>
                        <p>Total Proposals</p>
                    </div>
                </div>

                <div class="glass-card">
                    <div class="circle orange">⏳</div>
                    <div>
                        <h2><?php echo $pendingProposal['total']; ?></h2>
                        <p>Pending Proposals</p>
                    </div>
                </div>

                <div class="glass-card">
                    <div class="circle green">✅</div>
                    <div>
                        <h2><?php echo $approvedProposal['total']; ?></h2>
                        <p>Approved Proposals</p>
                    </div>
                </div>

                <div class="glass-card">
                    <div class="circle red">❌</div>
                    <div>
                        <h2><?php echo $rejectedProposal['total']; ?></h2>
                        <p>Rejected Proposals</p>
                    </div>
                </div>

                <div class="glass-card">
                    <div class="circle purple">🎉</div>
                    <div>
                        <h2><?php echo $totalEvents['total']; ?></h2>
                        <p>Total Events</p>
                    </div>
                </div>

                <div class="glass-card">
                    <div class="circle sky">📝</div>
                    <div>
                        <h2><?php echo $totalRegistrations['total']; ?></h2>
                        <p>Total Registrations</p>
                    </div>
                </div>

                <div class="glass-card">
                    <div class="circle teal">👥</div>
                    <div>
                        <h2><?php echo $totalUsers['total']; ?></h2>
                        <p>Total Users</p>
                    </div>
                </div>

            <?php } ?>

            <?php if ($role == 'Club Leader') { ?>

                <div class="glass-card">
                    <div class="circle blue">📄</div>
                    <div>
                        <h2><?php echo $myProposal['total']; ?></h2>
                        <p>My Proposals</p>
                    </div>
                </div>

                <div class="glass-card">
                    <div class="circle orange">⏳</div>
                    <div>
                        <h2><?php echo $pendingProposal['total']; ?></h2>
                        <p>Pending Proposals</p>
                    </div>
                </div>

                <div class="glass-card">
                    <div class="circle green">✅</div>
                    <div>
                        <h2><?php echo $approvedProposal['total']; ?></h2>
                        <p>Approved Proposals</p>
                    </div>
                </div>

                <div class="glass-card">
                    <div class="circle purple">🎉</div>
                    <div>
                        <h2><?php echo $totalEvents['total']; ?></h2>
                        <p>Available Events</p>
                    </div>
                </div>

            <?php } ?>

            <?php if ($role == 'Student') { ?>

                <div class="glass-card">
                    <div class="circle purple">🎉</div>
                    <div>
                        <h2><?php echo $totalEvents['total']; ?></h2>
                        <p>Available Events</p>
                    </div>
                </div>

                <div class="glass-card">
                    <div class="circle sky">📝</div>
                    <div>
                        <h2><?php echo $myRegistration['total']; ?></h2>
                        <p>My Registrations</p>
                    </div>
                </div>

            <?php } ?>

        </div>

        <div class="table-card">

            <div class="table-header">
                <h2>
                    <?php
                    if ($role == 'Admin')
                        echo "Recent Proposals";
                    if ($role == 'Club Leader')
                        echo "My Recent Proposals";
                    if ($role == 'Student')
                        echo "My Recent Registrations";
                    ?>
                </h2>
            </div>

            <?php if ($role == 'Student') { ?>

                <table>
                    <tr>
                        <th>Event</th>
                        <th>Date</th>
                        <th>Attendance</th>
                    </tr>

                    <?php
                    $recent = mysqli_query($conn, "
                SELECT registrations.*, events.event_name, events.event_date
                FROM registrations
                JOIN events ON registrations.event_id = events.event_id
                WHERE registrations.user_id='$user_id'
                ORDER BY registrations.registration_id DESC
                LIMIT 5
                ");

                    if (mysqli_num_rows($recent) > 0) {
                        while ($row = mysqli_fetch_assoc($recent)) {
                            ?>
                            <tr>
                                <td><?php echo $row['event_name']; ?></td>
                                <td><?php echo $row['event_date']; ?></td>
                                <td><?php echo $row['attendance_status']; ?></td>
                            </tr>
                        <?php }
                    } else { ?>
                        <tr>
                            <td colspan="3">No registration found.</td>
                        </tr>
                    <?php } ?>
                </table>

            <?php } else { ?>

                <table>
                    <tr>
                        <th>Program</th>
                        <th>Club</th>
                        <th>Status</th>
                    </tr>

                    <?php
                    if ($role == 'Admin') {
                        $recent = mysqli_query($conn, "SELECT * FROM program_proposals ORDER BY proposal_id DESC LIMIT 5");
                    } else {
                        $recent = mysqli_query($conn, "SELECT * FROM program_proposals WHERE user_id='$user_id' ORDER BY proposal_id DESC LIMIT 5");
                    }

                    if (mysqli_num_rows($recent) > 0) {
                        while ($row = mysqli_fetch_assoc($recent)) {
                            ?>
                            <tr>
                                <td><?php echo $row['program_name']; ?></td>
                                <td><?php echo $row['club_name']; ?></td>
                                <td>
                                    <span class="badge badge-<?php echo strtolower($row['status']); ?>">
                                        <?php echo $row['status']; ?>
                                    </span>
                                </td>
                            </tr>
                        <?php }
                    } else { ?>
                        <tr>
                            <td colspan="3">No proposal found.</td>
                        </tr>
                    <?php } ?>
                </table>

            <?php } ?>

        </div>

    </div>

</body>

</html>