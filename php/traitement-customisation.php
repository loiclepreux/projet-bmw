<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /php/personnalisation.php');
    exit;
}

$nom       = trim($_POST['nom'] ?? '');
$email     = trim($_POST['email'] ?? '');
$telephone = trim($_POST['telephone'] ?? '');
$modele    = trim($_POST['modele'] ?? '');

if (empty($nom) || empty($email) || empty($modele)) {
    header('Location: /php/personnalisation.php?erreur=champs');
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: /php/personnalisation.php?erreur=email');
    exit;
}

$elements = isset($_POST['elements']) ? implode(', ', array_map('trim', $_POST['elements'])) : '';

try {
    $stmt = $pdo->prepare("INSERT INTO customisations
        (nom, email, telephone, modele, couleur, jantes, sellerie,
         stage1, stage2, kit, elements, finition, motif,
         sellerie_extreme, volant, neons, diffuseur)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->execute([
        $nom,
        $email,
        $telephone,
        $modele,
        $_POST['couleur']          ?? '',
        $_POST['jantes']           ?? '',
        $_POST['sellerie']         ?? '',
        $_POST['stage1']           ?? '',
        $_POST['stage2']           ?? '',
        $_POST['kit']              ?? '',
        $elements,
        $_POST['finition']         ?? '',
        $_POST['motif']            ?? '',
        $_POST['sellerie-extreme'] ?? '',
        $_POST['volant']           ?? '',
        isset($_POST['neons'])     ? 'oui' : 'non',
        isset($_POST['diffuseur']) ? 'oui' : 'non',
    ]);

    header('Location: /php/personnalisation.php?envoi=ok');
} catch (PDOException $e) {
    header('Location: /php/personnalisation.php?erreur=bdd');
}
exit;
