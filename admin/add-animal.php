<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$success = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $species = trim($_POST['species'] ?? '');
    $breed = trim($_POST['breed'] ?? '');
    $age = trim($_POST['age'] ?? '');
    $gender = $_POST['gender'] ?? '';
    $description = trim($_POST['description'] ?? '');
    $image = "";

if (!empty($_FILES['image']['name'])) {
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    $fileType = $_FILES['image']['type'];

    if (!in_array($fileType, $allowedTypes)) {
        $error = "Only JPG, PNG, GIF and WEBP images are allowed.";
    } else {
        $uploadDir = '../public/uploads/';
        $fileName = time() . '_' . basename($_FILES['image']['name']);
        $targetPath = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
            $image = $fileName;
        } else {
            $error = "Image upload failed.";
        }
    }
}
    $status = $_POST['status'] ?? 'Available';

    if (empty($name) || empty($species) || empty($gender) || empty($description)) {
        $error = "Please complete all required fields.";
    } elseif (!empty($age) && !is_numeric($age)) {
        $error = "Age must be a number.";
    } else {
        $stmt = $pdo->prepare("
            INSERT INTO animals 
            (name, species, breed, age, gender, description, image, status)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->execute([
            $name,
            $species,
            $breed,
            $age,
            $gender,
            $description,
            $image,
            $status
        ]);

        $success = "Animal added successfully.";
    }
}
$pageTitle = "Add Animal | Help A Stray";
require_once '../includes/header.php';
?>

<h1>Add Animal</h1>

<div class="card">
    <a class="btn" href="dashboard.php">Back to Dashboard</a>
    <a class="btn" href="manage-animals.php">Manage Animals</a>
</div>

<?php if ($success): ?>
    <div class="card success">
        <?php echo htmlspecialchars($success); ?>
    </div>
<?php endif; ?>

<?php if ($error): ?>
    <div class="card error">
        <?php echo htmlspecialchars($error); ?>
    </div>
<?php endif; ?>

<div class="card">
    <form method="POST" enctype="multipart/form-data">
        <label>Name:</label>
        <input type="text" name="name" required>

        <br><br>

        <label>Species:</label>
        <input type="text" name="species" required>

        <br><br>

        <label>Breed:</label>
        <input type="text" name="breed">

        <br><br>

        <label>Age:</label>
        <input type="number" name="age" min="0">

        <br><br>

        <label>Gender:</label>
        <select name="gender" required>
            <option value="">Select gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select>

        <br><br>

        <label>Description:</label>
        <textarea name="description" required></textarea>

        <br><br>

        <label>Image filename:</label>
        <input type="file" name="image" accept="image/*">

        <br><br>

        <label>Status:</label>
        <select name="status">
            <option value="Available">Available</option>
            <option value="Reserved">Reserved</option>
            <option value="Adopted">Adopted</option>
        </select>

        <br><br>

        <button type="submit">Add Animal</button>
    </form>
</div>

<?php require_once '../includes/footer.php'; ?>