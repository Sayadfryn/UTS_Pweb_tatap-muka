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
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM hewan WHERE id_obat = ?");
        $stmt->execute([$id]);
        $count = $stmt->fetchColumn();
        
        if ($count > 0) {
            header("Location: obat.php?msg=Obat tidak bisa dihapus karena masih digunakan");
        } else {
            $stmt = $pdo->prepare("DELETE FROM obat WHERE id = ?");
            $stmt->execute([$id]);
            header("Location: obat.php?msg=Obat berhasil dihapus");
        }
    } catch (PDOException $e) {
        header("Location: obat.php?msg=Error: " . urlencode($e->getMessage()));
    }
} else {
    header("Location: obat.php");
}
exit;
?>