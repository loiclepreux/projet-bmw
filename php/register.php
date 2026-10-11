<?php
require_once __DIR__ . '/securite.php'; // session protégée
require_once 'config.php';

// Inscription réservée aux admins connectés
if (empty($_SESSION['user'])) {
    header('Location: /index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: admin.php');
    exit;
}

if (empty($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    header('Location: admin.php');
    exit;
}

$nom      = trim($_POST['new-nom'] ?? '');
$password = $_POST['new-password'] ?? '';
$confirm  = $_POST['confirm-password'] ?? '';

if (empty($nom) || empty($password)) {
    header('Location: admin.php?erreur=champs');
    exit;
}

if ($password !== $confirm) {
    header('Location: admin.php?erreur=password');
    exit;
}

try {
    $check = $pdo->prepare("SELECT id FROM employes WHERE nom = ?");
    $check->execute([$nom]);

    if ($check->fetch()) {
        header('Location: admin.php?erreur=existe');
        exit;
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO employes (nom, password) VALUES (?, ?)");
    $stmt->execute([$nom, $hash]);

    header('Location: admin.php?inscription=ok');
} catch (PDOException $e) {
    header('Location: admin.php?erreur=bdd');
}
exit;
