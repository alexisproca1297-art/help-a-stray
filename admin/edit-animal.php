<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid animal ID.");
}

$animal_id = $_GET['id'];
$success = "";
$error = "";

$stmt = $pdo->prepare("SELECT * FROM animals WHERE animal_id = ?");
$stmt->execute([$animal_id]);
$animal = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$animal) {
    die("Animal not found.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $species = trim($_POST['species'] ?? '');
    $breed = trim($_POST['breed'] ?? '');
    $age = trim($_POST['age'] ?? '');
    $gender = $_POST['gender'] ?? '';
    $description = trim($_POST['description'] ?? '');
    $image = $animal['image'];

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
        $updateStmt = $pdo->prepare("
            UPDATE animals
            SET name = ?, species = ?, breed = ?, age = ?, gender = ?, description = ?, image = ?, status = ?
            WHERE animal_id = ?
        ");

        $updateStmt->execute([
            $name,
            $species,
            $breed,
            $age,
            $gender,
            $description,
            $image,
            $status,
            $animal_id
        ]);

        $success = "Animal updated successfully.";

        $stmt = $pdo->prepare("SELECT * FROM animals WHERE animal_id = ?");
        $stmt->execute([$animal_id]);
        $animal = $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
$pageTitle = "Edit Animal | Help A Stray";
require_once '../includes/header.php';
?>

<h1>Edit Animal</h1>

<div class="card">
    <a class="btn" href="manage-animals.php">Back to Manage Animals</a>
    <a class="btn" href="dashboard.php">Dashboard</a>
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
    <input
        type="text"
        name="name"
        value="<?php echo htmlspecialchars($animal['name']); ?>"
        required>

    <br><br>

    <label>Species:</label>
    <input
        type="text"
        name="species"
        value="<?php echo htmlspecialchars($animal['species']); ?>"
        required>

    <br><br>

    <label>Breed:</label>
    <input
        type="text"
        name="breed"
        value="<?php echo htmlspecialchars($animal['breed']); ?>">

    <br><br>

    <label>Age:</label>
    <input
        type="number"
        name="age"
        min="0"
        value="<?php echo htmlspecialchars($animal['age']); ?>">

    <br><br>

    <label>Gender:</label>
    <select name="gender" required>
        <option value="Male" <?php if ($animal['gender'] === 'Male') echo 'selected'; ?>>
            Male
        </option>

        <option value="Female" <?php if ($animal['gender'] === 'Female') echo 'selected'; ?>>
            Female
        </option>
    </select>

    <br><br>

    <label>Description:</label>

    <textarea name="description" required><?php
        echo htmlspecialchars($animal['description']);
    ?></textarea>

    <br><br>

    <h3>Animal Image</h3>

<?php if (!empty($animal['image'])): ?>
    <p>Current Image:</p>

    <img
        src="../public/uploads/<?php echo htmlspecialchars($animal['image']); ?>"
        alt="<?php echo htmlspecialchars($animal['name']); ?>"
        style="
            width:220px;
            border-radius:10px;
            margin-bottom:15px;
            display:block;
        ">
<?php endif; ?>

<label>Upload New Image:</label>

<input
    type="file"
    name="image"
    accept="image/jpeg,image/png,image/gif,image/webp">

    <br><br>

    <label>Status:</label>

    <select name="status">

        <option value="Available"
            <?php if ($animal['status'] === 'Available') echo 'selected'; ?>>
            Available
        </option>

        <option value="Reserved"
            <?php if ($animal['status'] === 'Reserved') echo 'selected'; ?>>
            Reserved
        </option>

        <option value="Adopted"
            <?php if ($animal['status'] === 'Adopted') echo 'selected'; ?>>
            Adopted
        </option>

    </select>

    <br><br>

    <button type="submit">Update Animal</button>

</form>

</div>

<?php require_once '../includes/footer.php'; ?>