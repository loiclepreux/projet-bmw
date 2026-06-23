<?php
session_start();
require_once 'config.php';

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /index.php');
    exit;
}

if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    header('Location: /index.php');
    exit;
}

if (isset($_SESSION['last_register']) && time() - $_SESSION['last_register'] < 10) {
    header('Location: /index.php?erreur=spam');
    exit;
}
$_SESSION['last_register'] = time();

$nom      = trim($_POST['new-nom'] ?? '');
$password = $_POST['new-password'] ?? '';
$confirm  = $_POST['confirm-password'] ?? '';

if (empty($nom) || empty($password)) {
    header('Location: /index.php?erreur=champs');
    exit;
}

if ($password !== $confirm) {
    header('Location: /index.php?erreur=password');
    exit;
}

try {
    $check = $pdo->prepare("SELECT id FROM employes WHERE nom = ?");
    $check->execute([$nom]);

    if ($check->fetch()) {
        header('Location: /index.php?erreur=existe');
        exit;
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO employes (nom, password) VALUES (?, ?)");
    $stmt->execute([$nom, $hash]);

    header('Location: /index.php?inscription=ok');
} catch (PDOException $e) {
    header('Location: /index.php?erreur=bdd');
}
exit;
