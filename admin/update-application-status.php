<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Invalid request.");
}

$application_id = $_POST['application_id'] ?? '';
$status = $_POST['status'] ?? '';

$allowed_statuses = ['Pending', 'Approved', 'Rejected'];

if (!is_numeric($application_id) || !in_array($status, $allowed_statuses)) {
    die("Invalid data submitted.");
}

$stmt = $pdo->prepare("UPDATE applications SET status = ? WHERE application_id = ?");
$stmt->execute([$status, $application_id]);

header("Location: view-application.php?id=" . $application_id);
exit;