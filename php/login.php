<?php
session_start();
require_once 'config.php';

if (!empty($_SESSION['user'])) {
    header('Location: admin.php');
    exit;
}

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

$nom      = trim($_POST['nom'] ?? '');
$password = $_POST['password'] ?? '';

if (empty($nom) || empty($password)) {
    header('Location: /index.php');
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT * FROM employes WHERE nom = :nom");
    $stmt->execute([':nom' => $nom]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        session_regenerate_id(true);
        $_SESSION['user'] = ['id' => $user['id'], 'nom' => $user['nom']];
        $_SESSION['login_attempts'] = 0;

        if (($_POST['rapel'] ?? '') === 'on') {
            setcookie('remember_me', $user['nom'], time() + 86400 * 365, '/');
        }

        header('Location: admin.php');
    } else {
        $_SESSION['login_attempts'] = ($_SESSION['login_attempts'] ?? 0) + 1;
        header('Location: /index.php?erreur=1');
    }
} catch (PDOException $e) {
    header('Location: /index.php?erreur=1');
}
exit;
