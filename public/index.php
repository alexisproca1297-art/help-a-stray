<?php
require_once '../config/db.php';

$totalAnimals = $pdo->query("SELECT COUNT(*) FROM animals")->fetchColumn();
$availableAnimals = $pdo->query("SELECT COUNT(*) FROM animals WHERE status = 'Available'")->fetchColumn();
$totalApplications = $pdo->query("SELECT COUNT(*) FROM applications")->fetchColumn();

$stmt = $pdo->query("SELECT * FROM animals WHERE status = 'Available' ORDER BY created_at DESC LIMIT 3");
$featuredAnimals = $stmt->fetchAll(PDO::FETCH_ASSOC);

$pageTitle = "Home | Help A Stray";
require_once '../includes/header.php';
?>

<section class="card">
    <h1>Help A Stray</h1>
    <p>
        Help A Stray is a web-based animal rescue and adoption management system designed
        to support rescue centres in managing animal profiles and adoption applications.
    </p>

    <a class="btn" href="animals.php">View Animals Available for Adoption</a>
</section>

<section class="grid">
    <div class="card">
        <h2><?php echo $totalAnimals; ?></h2>
        <p>Total Animals</p>
    </div>

    <div class="card">
        <h2><?php echo $availableAnimals; ?></h2>
        <p>Available for Adoption</p>
    </div>

    <div class="card">
        <h2><?php echo $totalApplications; ?></h2>
        <p>Adoption Applications</p>
    </div>
</section>

<h2>Featured Animals</h2>

<div class="grid">
    <?php foreach ($featuredAnimals as $animal): ?>
        <div class="card">

            <?php if (!empty($animal['image'])): ?>
                <img
                    class="animal-image"
                    src="uploads/<?php echo htmlspecialchars($animal['image']); ?>"
                    alt="<?php echo htmlspecialchars($animal['name']); ?>">
            <?php endif; ?>

            <h3><?php echo htmlspecialchars($animal['name']); ?></h3>

            <p><strong>Species:</strong> <?php echo htmlspecialchars($animal['species']); ?></p>
            <p><strong>Breed:</strong> <?php echo htmlspecialchars($animal['breed']); ?></p>
            <p><?php echo htmlspecialchars($animal['description']); ?></p>

            <a class="btn" href="animal-details.php?id=<?php echo $animal['animal_id']; ?>">
                View Details
            </a>

        </div>
    <?php endforeach; ?>
</div>

<section class="card">
    <h2>About the Project</h2>
    <p>
        This prototype demonstrates how HTML, CSS, PHP and MySQL can be used to create
        a practical adoption management system. It includes public adoption features and
        an administrator area for managing animal records and applications.
    </p>
</section>

<?php require_once '../includes/footer.php'; ?>