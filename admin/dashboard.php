<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$totalAnimals = $pdo->query("SELECT COUNT(*) FROM animals")->fetchColumn();
$availableAnimals = $pdo->query("SELECT COUNT(*) FROM animals WHERE status = 'Available'")->fetchColumn();
$reservedAnimals = $pdo->query("SELECT COUNT(*) FROM animals WHERE status = 'Reserved'")->fetchColumn();
$adoptedAnimals = $pdo->query("SELECT COUNT(*) FROM animals WHERE status = 'Adopted'")->fetchColumn();

$totalApplications = $pdo->query("SELECT COUNT(*) FROM applications")->fetchColumn();
$pendingApplications = $pdo->query("SELECT COUNT(*) FROM applications WHERE status = 'Pending'")->fetchColumn();
$approvedApplications = $pdo->query("SELECT COUNT(*) FROM applications WHERE status = 'Approved'")->fetchColumn();
$rejectedApplications = $pdo->query("SELECT COUNT(*) FROM applications WHERE status = 'Rejected'")->fetchColumn();
$recentStmt = $pdo->query("
    SELECT 
        applications.application_id,
        applications.full_name,
        applications.status,
        applications.application_date,
        animals.name AS animal_name
    FROM applications
    INNER JOIN animals ON applications.animal_id = animals.animal_id
    ORDER BY applications.application_date DESC
    LIMIT 5
");

$recentApplications = $recentStmt->fetchAll(PDO::FETCH_ASSOC);

$pageTitle = "Admin Dashboard | Help A Stray";
require_once '../includes/header.php';
?>

<h1>Admin Dashboard</h1>

<p>Welcome, <?php echo htmlspecialchars($_SESSION['admin_username']); ?>.</p>

<h2>System Overview</h2>

<div class="grid">

    <div class="card">
        <h2><?php echo $totalAnimals; ?></h2>
        <p>Total Animals</p>
    </div>

    <div class="card">
        <h2><?php echo $availableAnimals; ?></h2>
        <p>Available Animals</p>
    </div>

    <div class="card">
        <h2><?php echo $reservedAnimals; ?></h2>
        <p>Reserved Animals</p>
    </div>

    <div class="card">
        <h2><?php echo $adoptedAnimals; ?></h2>
        <p>Adopted Animals</p>
    </div>

    <div class="card">
        <h2><?php echo $totalApplications; ?></h2>
        <p>Total Applications</p>
    </div>

    <div class="card">
        <h2><?php echo $pendingApplications; ?></h2>
        <p>Pending Applications</p>
    </div>

    <div class="card">
        <h2><?php echo $approvedApplications; ?></h2>
        <p>Approved Applications</p>
    </div>

    <div class="card">
        <h2><?php echo $rejectedApplications; ?></h2>
        <p>Rejected Applications</p>
    </div>

</div>

<h2>Recent Applications</h2>

<?php if (count($recentApplications) === 0): ?>
    <div class="card">
        <p>No recent applications found.</p>
    </div>
<?php else: ?>
    <table>
        <tr>
            <th>Applicant</th>
            <th>Animal</th>
            <th>Status</th>
            <th>Date</th>
            <th>Action</th>
        </tr>

        <?php foreach ($recentApplications as $application): ?>
            <tr>
                <td><?php echo htmlspecialchars($application['full_name']); ?></td>
                <td><?php echo htmlspecialchars($application['animal_name']); ?></td>
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

<h2>Admin Actions</h2>

<ul>
    <li><a href="manage-animals.php">Manage Animals</a></li>
    <li><a href="add-animal.php">Add Animal</a></li>
    <li><a href="applications.php">View Adoption Applications</a></li>
    <li><a href="../public/animals.php">View Public Animal Page</a></li>
    <li><a href="logout.php">Logout</a></li>
</ul>

<?php require_once '../includes/footer.php'; ?>