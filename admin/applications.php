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
$pageTitle = "Adoption Applications | Help A Stray";
require_once '../includes/header.php';
?>

<h1>Adoption Applications</h1>

<div class="card">
    <a class="btn" href="dashboard.php">Back to Dashboard</a>
</div>

<?php if (count($applications) === 0): ?>
    <div class="card">
        <p>No adoption applications have been submitted yet.</p>
    </div>
<?php else: ?>

<table>
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
<td>
    <span class="badge badge-<?php echo strtolower($application['status']); ?>">
        <?php echo htmlspecialchars($application['status']); ?>
    </span>
</td>            <td><?php echo htmlspecialchars($application['application_date']); ?></td>
            <td>
                <a href="view-application.php?id=<?php echo $application['application_id']; ?>">
                    View
                </a>
            </td>
        </tr>
    <?php endforeach; ?>

</table>

<?php endif; ?>

<?php require_once '../includes/footer.php'; ?>
