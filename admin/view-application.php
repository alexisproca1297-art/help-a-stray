<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid application ID.");
}

$application_id = $_GET['id'];

$stmt = $pdo->prepare("
    SELECT 
        applications.*, 
        animals.name AS animal_name,
        animals.species,
        animals.breed
    FROM applications
    INNER JOIN animals ON applications.animal_id = animals.animal_id
    WHERE applications.application_id = ?
");

$stmt->execute([$application_id]);
$application = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$application) {
    die("Application not found.");
}
$pageTitle = "View Application | Help A Stray";
require_once '../includes/header.php';
?>

<h1>Adoption Application Details</h1>

<div class="card">
    <h2>Animal Information</h2>

    <p><strong>Animal:</strong> <?php echo htmlspecialchars($application['animal_name']); ?></p>
    <p><strong>Species:</strong> <?php echo htmlspecialchars($application['species']); ?></p>
    <p><strong>Breed:</strong> <?php echo htmlspecialchars($application['breed']); ?></p>
</div>

<div class="card">
    <h2>Applicant Information</h2>

    <p><strong>Applicant Name:</strong> <?php echo htmlspecialchars($application['full_name']); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($application['email']); ?></p>
    <p><strong>Phone:</strong> <?php echo htmlspecialchars($application['phone']); ?></p>
    <p><strong>Address:</strong> <?php echo nl2br(htmlspecialchars($application['address'])); ?></p>
    <p><strong>Housing Type:</strong> <?php echo htmlspecialchars($application['housing_type']); ?></p>

    <p><strong>Previous Pet Experience:</strong></p>
    <p><?php echo nl2br(htmlspecialchars($application['experience'])); ?></p>
</div>

<div class="card">
    <h2>Application Status</h2>

<p>
    <strong>Current Status:</strong>
    <span class="badge badge-<?php echo strtolower($application['status']); ?>">
        <?php echo htmlspecialchars($application['status']); ?>
    </span>
</p>    <p><strong>Submitted:</strong> <?php echo htmlspecialchars($application['application_date']); ?></p>

    <form action="update-application-status.php" method="POST">
        <input type="hidden" name="application_id" value="<?php echo $application['application_id']; ?>">

        <label>Update Status:</label>
        <select name="status" required>
            <option value="Pending" <?php if ($application['status'] === 'Pending') echo 'selected'; ?>>Pending</option>
            <option value="Approved" <?php if ($application['status'] === 'Approved') echo 'selected'; ?>>Approved</option>
            <option value="Rejected" <?php if ($application['status'] === 'Rejected') echo 'selected'; ?>>Rejected</option>
        </select>

        <br><br>

        <button type="submit">Update Status</button>
    </form>
</div>

<a class="btn" href="applications.php">Back to Applications</a>

<?php require_once '../includes/footer.php'; ?>