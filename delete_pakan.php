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
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM hewan WHERE id_pakan = ?");
        $stmt->execute([$id]);
        $count = $stmt->fetchColumn();
        
        if ($count > 0) {
            header("Location: pakan.php?msg=Pakan tidak bisa dihapus karena masih digunakan di hewan");
        } else {
            $stmt = $pdo->prepare("DELETE FROM pakan WHERE id = ?");
            $stmt->execute([$id]);
            header("Location: pakan.php?msg=Pakan berhasil dihapus");
        }
    } catch (PDOException $e) {
        header("Location: pakan.php?msg=Error: " . urlencode($e->getMessage()));
    }
} else {
    header("Location: pakan.php");
}
exit;
?>