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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($animal['name']); ?> | Help A Stray</title>
</head>
<body>

<h1><?php echo htmlspecialchars($animal['name']); ?></h1>

<p><strong>Species:</strong> <?php echo htmlspecialchars($animal['species']); ?></p>
<p><strong>Breed:</strong> <?php echo htmlspecialchars($animal['breed']); ?></p>
<p><strong>Age:</strong> <?php echo htmlspecialchars($animal['age']); ?> years</p>
<p><strong>Gender:</strong> <?php echo htmlspecialchars($animal['gender']); ?></p>
<p><strong>Status:</strong> <?php echo htmlspecialchars($animal['status']); ?></p>

<p><?php echo htmlspecialchars($animal['description']); ?></p>

<?php if ($animal['status'] === 'Available'): ?>
    <a href="apply.php?id=<?php echo $animal['animal_id']; ?>">Apply to Adopt</a>
<?php else: ?>
    <p>This animal is currently not available for adoption.</p>
<?php endif; ?>

<br><br>
<a href="animals.php">Back to Animals</a>

</body>
</html>