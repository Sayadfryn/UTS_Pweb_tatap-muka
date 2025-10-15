<?php
session_start();
include 'config.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}
$id = $_GET['id'] ?? 0;

if ($id > 0) {
    try {
        $stmt = $pdo->prepare("DELETE FROM hewan WHERE id = ?");
        $stmt->execute([$id]);
        header("Location: dashboard.php?msg=Hewan berhasil dihapus");
    } catch (PDOException $e) {
        header("Location: dashboard.php?msg=Error: " . urlencode($e->getMessage()));
    }
} else {
    header("Location: dashboard.php");
}
exit;
?>