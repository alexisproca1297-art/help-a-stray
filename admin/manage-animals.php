<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$stmt = $pdo->query("SELECT * FROM animals ORDER BY created_at DESC");
$animals = $stmt->fetchAll(PDO::FETCH_ASSOC);
$pageTitle = "Manage Animals | Help A Stray";
require_once '../includes/header.php';
?>

<h1>Manage Animals</h1>

<div class="card">
    <a class="btn" href="dashboard.php">Back to Dashboard</a>
    <a class="btn" href="add-animal.php">Add New Animal</a>
</div>

<?php if (count($animals) === 0): ?>
    <div class="card">
        <p>No animals have been added yet.</p>
    </div>
<?php else: ?>

<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Species</th>
        <th>Breed</th>
        <th>Age</th>
        <th>Gender</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>

    <?php foreach ($animals as $animal): ?>
        <tr>
            <td><?php echo $animal['animal_id']; ?></td>
            <td><?php echo htmlspecialchars($animal['name']); ?></td>
            <td><?php echo htmlspecialchars($animal['species']); ?></td>
            <td><?php echo htmlspecialchars($animal['breed']); ?></td>
            <td><?php echo htmlspecialchars($animal['age']); ?></td>
            <td><?php echo htmlspecialchars($animal['gender']); ?></td>
            <td><?php echo htmlspecialchars($animal['status']); ?></td>
            <td>
                <a href="edit-animal.php?id=<?php echo $animal['animal_id']; ?>">Edit</a>
                |
                <a href="delete-animal.php?id=<?php echo $animal['animal_id']; ?>" 
                   onclick="return confirm('Are you sure you want to delete this animal?');">
                   Delete
                </a>
            </td>
        </tr>
    <?php endforeach; ?>

</table>

<?php endif; ?>

<?php require_once '../includes/footer.php'; ?>