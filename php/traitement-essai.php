<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /php/modele.php');
    exit;
}

$nom       = trim($_POST['nom-essai'] ?? '');
$email     = trim($_POST['email-essai'] ?? '');
$telephone = trim($_POST['tel-essai'] ?? '');
$modele    = trim($_POST['modele-essai'] ?? '');
$date      = trim($_POST['date-essai'] ?? '');
$heure     = trim($_POST['heure-essai'] ?? '');

if (empty($nom) || empty($email) || empty($modele) || empty($date) || empty($heure)) {
    header('Location: /php/modele.php?erreur=champs');
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: /php/modele.php?erreur=email');
    exit;
}

try {
    $stmt = $pdo->prepare("INSERT INTO essais (nom, email, telephone, modele, date_essai, heure_essai) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$nom, $email, $telephone, $modele, $date, $heure]);
    header('Location: /php/modele.php?essai=ok');
} catch (PDOException $e) {
    header('Location: /php/modele.php?erreur=bdd');
}
exit;
