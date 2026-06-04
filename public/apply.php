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
    <title>Apply to Adopt | Help A Stray</title>
</head>
<body>

<h1>Apply to Adopt <?php echo htmlspecialchars($animal['name']); ?></h1>

<form action="submit-application.php" method="POST">
    <input type="hidden" name="animal_id" value="<?php echo $animal['animal_id']; ?>">

    <label>Full Name:</label><br>
    <input type="text" name="full_name" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <label>Phone:</label><br>
    <input type="text" name="phone"><br><br>

    <label>Address:</label><br>
    <textarea name="address" required></textarea><br><br>

    <label>Housing Type:</label><br>
    <input type="text" name="housing_type" placeholder="House, flat, rented, owned..." required><br><br>

    <label>Previous Pet Experience:</label><br>
    <textarea name="experience" required></textarea><br><br>

    <button type="submit">Submit Application</button>
</form>

<br>
<a href="animal-details.php?id=<?php echo $animal['animal_id']; ?>">Back to Animal Details</a>

</body>
</html>
