<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard | Help A Stray</title>
</head>
<body>

<h1>Admin Dashboard</h1>

<p>Welcome, <?php echo htmlspecialchars($_SESSION['admin_username']); ?>.</p>

<ul>
    <li><a href="applications.php">View Adoption Applications</a></li>
    <li><a href="../public/animals.php">View Public Animal Page</a></li>
    <li><a href="logout.php">Logout</a></li>
</ul>

</body>
</html>
