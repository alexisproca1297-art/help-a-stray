<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$stmt = $pdo->query("
    SELECT 
        applications.*, 
        animals.name AS animal_name,
        animals.species
    FROM applications
    INNER JOIN animals ON applications.animal_id = animals.animal_id
    ORDER BY applications.application_date DESC
");

$applications = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Adoption Applications | Help A Stray</title>
</head>
<body>

<h1>Adoption Applications</h1>

<a href="dashboard.php">Back to Dashboard</a>
<br><br>

<?php if (count($applications) === 0): ?>
    <p>No adoption applications have been submitted yet.</p>
<?php else: ?>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Animal</th>
        <th>Applicant</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Status</th>
        <th>Date</th>
        <th>Action</th>
    </tr>

    <?php foreach ($applications as $application): ?>
        <tr>
            <td><?php echo $application['application_id']; ?></td>
            <td>
                <?php echo htmlspecialchars($application['animal_name']); ?>
                (<?php echo htmlspecialchars($application['species']); ?>)
            </td>
            <td><?php echo htmlspecialchars($application['full_name']); ?></td>
            <td><?php echo htmlspecialchars($application['email']); ?></td>
            <td><?php echo htmlspecialchars($application['phone']); ?></td>
            <td><?php echo htmlspecialchars($application['status']); ?></td>
            <td><?php echo htmlspecialchars($application['application_date']); ?></td>
            <td>
                <a href="view-application.php?id=<?php echo $application['application_id']; ?>">
                    View
                </a>
            </td>
        </tr>
    <?php endforeach; ?>

</table>

<?php endif; ?>

</body>
</html>
