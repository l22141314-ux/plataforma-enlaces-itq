<?php
// admin/eliminar.php
session_start();
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header('Location: index.php');
    exit;
}

require_once '../config/db.php';

$id = (int)($_GET['id'] ?? 0);
if ($id === 0) {
    header('Location: dashboard.php');
    exit;
}

// Verificar que existe
$stmt = $pdo->prepare("SELECT id FROM enlaces WHERE id = ?");
$stmt->execute([$id]);
if (!$stmt->fetch()) {
    header('Location: dashboard.php');
    exit;
}

// Eliminar
$stmt = $pdo->prepare("DELETE FROM enlaces WHERE id = ?");
$stmt->execute([$id]);

header('Location: dashboard.php');
exit;
?>