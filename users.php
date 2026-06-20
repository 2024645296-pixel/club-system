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

    $users = mysqli_query($conn, "
    SELECT * FROM users
    WHERE name LIKE '%$search%'
    OR matric_no LIKE '%$search%'
    OR email LIKE '%$search%'
    OR role LIKE '%$search%'
    ORDER BY user_id DESC
    ");
} else {
    $users = mysqli_query($conn, "SELECT * FROM users ORDER BY user_id DESC");
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Users</title>
    <link rel="stylesheet" href="assets/css/style.css?v=3">
</head>

<body>

    <?php include 'includes/sidebar.php'; ?>

    <div class="main">

        <h1>Users</h1>
        <p>View all registered users and their roles in the system.</p>

        <br>

        <div class="card">

            <h2>User List</h2>
            <br>

            <form method="GET">
                <input type="text" name="search" placeholder="Search name, matric no, email or role..."
                    value="<?php echo $search; ?>">
                <button type="submit">Search</button>
                <a href="users.php">
                    <button type="button">Reset</button>
                </a>
            </form>

            <br>

            <table>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Matric No</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Role</th>
                    <th>Faculty</th>
                </tr>

                <?php
                $no = 1;

                if (mysqli_num_rows($users) > 0) {
                    while ($row = mysqli_fetch_assoc($users)) {
                        ?>

                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['matric_no']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['phone']; ?></td>
                            <td><?php echo $row['role']; ?></td>
                            <td><?php echo $row['faculty']; ?></td>
                        </tr>

                        <?php
                    }
                } else {
                    ?>

                    <tr>
                        <td colspan="7">No user found.</td>
                    </tr>

                <?php } ?>

            </table>

        </div>

    </div>

</body>

</html>