<?php
require_once '../config/db.php';

$search = trim($_GET['search'] ?? '');
$species = trim($_GET['species'] ?? '');
$status = trim($_GET['status'] ?? '');

$sql = "SELECT * FROM animals WHERE 1=1";
$params = [];

if (!empty($search)) {
    $sql .= " AND name LIKE ?";
    $params[] = "%$search%";
}

if (!empty($species)) {
    $sql .= " AND species = ?";
    $params[] = $species;
}

if (!empty($status)) {
    $sql .= " AND status = ?";
    $params[] = $status;
}

$sql .= " ORDER BY created_at DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);

$animals = $stmt->fetchAll(PDO::FETCH_ASSOC);

$pageTitle = "Available Animals | Help A Stray";
require_once '../includes/header.php';
?>

<h1>Available Animals</h1>

<form method="GET" class="card">
    <input
        type="text"
        name="search"
        placeholder="Search by name..."
        value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">

    <br><br>

    <select name="species">
        <option value="">All Species</option>
        <option value="Dog" <?php if (($_GET['species'] ?? '') === 'Dog') echo 'selected'; ?>>Dogs</option>
        <option value="Cat" <?php if (($_GET['species'] ?? '') === 'Cat') echo 'selected'; ?>>Cats</option>
    </select>

    <br><br>

    <select name="status">
        <option value="">All Statuses</option>
        <option value="Available" <?php if (($_GET['status'] ?? '') === 'Available') echo 'selected'; ?>>Available</option>
        <option value="Reserved" <?php if (($_GET['status'] ?? '') === 'Reserved') echo 'selected'; ?>>Reserved</option>
        <option value="Adopted" <?php if (($_GET['status'] ?? '') === 'Adopted') echo 'selected'; ?>>Adopted</option>
    </select>

    <br><br>

    <button type="submit">Search</button>
</form>

<div class="grid">
    <?php foreach ($animals as $animal): ?>
        <div class="card">
            <?php if (!empty($animal['image'])): ?>
    <img 
        src="uploads/<?php echo htmlspecialchars($animal['image']); ?>" 
        alt="<?php echo htmlspecialchars($animal['name']); ?>" 
        style="width:100%; height:180px; object-fit:cover; border-radius:8px;">
<?php endif; ?>
            <h2><?php echo htmlspecialchars($animal['name']); ?></h2>
            <p><strong>Species:</strong> <?php echo htmlspecialchars($animal['species']); ?></p>
            <p><strong>Breed:</strong> <?php echo htmlspecialchars($animal['breed']); ?></p>
            <p><strong>Age:</strong> <?php echo htmlspecialchars($animal['age']); ?> years</p>
            <p><strong>Status:</strong> <?php echo htmlspecialchars($animal['status']); ?></p>
            <p><?php echo htmlspecialchars($animal['description']); ?></p>
            <a class="btn" href="animal-details.php?id=<?php echo $animal['animal_id']; ?>">View Details</a>
        </div>
    <?php endforeach; ?>
</div>

<?php require_once '../includes/footer.php'; ?>