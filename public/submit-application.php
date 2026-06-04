<?php
require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Invalid request.");
}

$animal_id = $_POST['animal_id'] ?? '';
$full_name = trim($_POST['full_name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$address = trim($_POST['address'] ?? '');
$housing_type = trim($_POST['housing_type'] ?? '');
$experience = trim($_POST['experience'] ?? '');

if (
    empty($animal_id) ||
    empty($full_name) ||
    empty($email) ||
    empty($address) ||
    empty($housing_type) ||
    empty($experience)
) {
    die("Please complete all required fields.");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Please enter a valid email address.");
}

$stmt = $pdo->prepare("
    INSERT INTO applications 
    (animal_id, full_name, email, phone, address, housing_type, experience)
    VALUES (?, ?, ?, ?, ?, ?, ?)
");

$stmt->execute([
    $animal_id,
    $full_name,
    $email,
    $phone,
    $address,
    $housing_type,
    $experience
]);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Application Submitted | Help A Stray</title>
</head>
<body>

<h1>Application Submitted</h1>

<p>Thank you. Your adoption application has been submitted successfully.</p>

<a href="animals.php">Back to Available Animals</a>

</body>
</html>