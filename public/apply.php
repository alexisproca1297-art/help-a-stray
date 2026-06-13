<?php
require_once '../config/db.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid animal ID.");
}

$animal_id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM animals WHERE animal_id = ?");
$stmt->execute([$animal_id]);
$animal = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$animal) {
    die("Animal not found.");
}
$pageTitle = "Apply to Adopt | Help A Stray";
require_once '../includes/header.php';
?>

<h1>Apply to Adopt <?php echo htmlspecialchars($animal['name']); ?></h1>

<div class="card">
    <h2>Animal Selected</h2>

    <?php if (!empty($animal['image'])): ?>
                <img
                    class="animal-image"
                    src="uploads/<?php echo htmlspecialchars($animal['image']); ?>"
                    alt="<?php echo htmlspecialchars($animal['name']); ?>">
            <?php endif; ?>

    <p><strong>Name:</strong> <?php echo htmlspecialchars($animal['name']); ?></p>
    <p><strong>Species:</strong> <?php echo htmlspecialchars($animal['species']); ?></p>
    <p><strong>Breed:</strong> <?php echo htmlspecialchars($animal['breed']); ?></p>
</div>

<div class="card">
    <h2>Adoption Application Form</h2>

    <form action="submit-application.php" method="POST">
        <input type="hidden" name="animal_id" value="<?php echo $animal['animal_id']; ?>">

        <label>Full Name:</label>
        <input type="text" name="full_name" required>

        <br><br>

        <label>Email:</label>
        <input type="email" name="email" required>

        <br><br>

        <label>Phone:</label>
        <input type="text" name="phone">

        <br><br>

        <label>Address:</label>
        <textarea name="address" required></textarea>

        <br><br>

        <label>Housing Type:</label>
        <input
            type="text"
            name="housing_type"
            placeholder="House, flat, rented, owned..."
            required>

        <br><br>

        <label>Previous Pet Experience:</label>
        <textarea name="experience" required></textarea>

        <br><br>

        <button type="submit">Submit Application</button>
    </form>
</div>

<a class="btn" href="animal-details.php?id=<?php echo $animal['animal_id']; ?>">
    Back to Animal Details
</a>

<?php require_once '../includes/footer.php'; ?>
