<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /index.php');
    exit;
}

if (empty($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    header('Location: /index.php');
    exit;
}

$email       = trim($_POST['mail'] ?? '');
$explication = trim($_POST['explication'] ?? '');

if (empty($email) || empty($explication)) {
    header('Location: /index.php?erreur=champs');
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: /index.php?erreur=email');
    exit;
}

try {
    $stmt = $pdo->prepare("INSERT INTO projets (email, explication) VALUES (?, ?)");
    $stmt->execute([$email, $explication]);
    header('Location: /index.php?projet=ok');
} catch (PDOException $e) {
    header('Location: /index.php?erreur=bdd');
}
exit;
