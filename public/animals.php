<?php
require_once '../config/db.php';

$stmt = $pdo->query("SELECT * FROM animals ORDER BY created_at DESC");
$animals = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Available Animals | Help A Stray</title>
</head>
<body>

<h1>Available Animals</h1>

<?php foreach ($animals as $animal): ?>
    <div>
        <h2><?php echo htmlspecialchars($animal['name']); ?></h2>
        <p><strong>Species:</strong> <?php echo htmlspecialchars($animal['species']); ?></p>
        <p><strong>Breed:</strong> <?php echo htmlspecialchars($animal['breed']); ?></p>
        <p><strong>Age:</strong> <?php echo htmlspecialchars($animal['age']); ?> years</p>
        <p><strong>Status:</strong> <?php echo htmlspecialchars($animal['status']); ?></p>
        <p><?php echo htmlspecialchars($animal['description']); ?></p>
        <a href="animal-details.php?id=<?php echo $animal['animal_id']; ?>">View Details</a>
    </div>
    <hr>
<?php endforeach; ?>

</body>
</html>
