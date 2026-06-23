<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /php/modele.php');
    exit;
}

$nom       = trim($_POST['nom'] ?? '');
$email     = trim($_POST['email'] ?? '');
$telephone = trim($_POST['tel'] ?? '');
$modele    = trim($_POST['modele'] ?? '');
$couleur   = trim($_POST['couleur'] ?? '');
$options   = trim($_POST['options'] ?? '');
$date      = trim($_POST['date'] ?? '');

if (empty($nom) || empty($email) || empty($modele) || empty($date)) {
    header('Location: /php/modele.php?erreur=champs');
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: /php/modele.php?erreur=email');
    exit;
}

try {
    $stmt = $pdo->prepare("INSERT INTO reservations (nom, email, telephone, modele, couleur, options, date_reservation) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$nom, $email, $telephone, $modele, $couleur, $options, $date]);
    header('Location: /php/modele.php?reservation=ok');
} catch (PDOException $e) {
    header('Location: /php/modele.php?erreur=bdd');
}
exit;
