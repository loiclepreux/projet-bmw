<?php
session_start();
require_once 'config.php';

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$pdo = new PDO($dsn, $username, $password, $options);

$action = $_GET['action'] ?? null;
$type = $_GET['type'] ?? null;

if (!$action || !$type) {
    die("Requête incomplète.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Erreur CSRF : requête non autorisée.");
    }
}
/* ---------------- AJOUT ---------------- */
if ($action === "ajout") {

    // AJOUT VEHICULE
    if ($type === "vehicule") {
        $stmt = $pdo->prepare("INSERT INTO vehicules (marque, nom, image, options, fiche_technique) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([
            
            htmlspecialchars($_POST['marque']),
            htmlspecialchars($_POST['nom']),
            htmlspecialchars($_POST['image']),
            htmlspecialchars($_POST['options']),
            htmlspecialchars($_POST['fiche_technique'])
        ]);
    }

    // AJOUT EMPLOYE
    if ($type === "employe") {
        $stmt = $pdo->prepare("INSERT INTO employes (prenom, nom, fonction, concession, niveau, photo) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            htmlspecialchars($_POST['prenom']),
            htmlspecialchars($_POST['nom']),
            htmlspecialchars($_POST['fonction']),
            htmlspecialchars($_POST['concession']),
            intval($_POST['niveau']),
            htmlspecialchars($_POST['photo'])
        ]);
    }

    // AJOUT EVENEMENT
    if ($type === "evenement") {
        $stmt = $pdo->prepare("INSERT INTO evenement (titre, date, lieu, description) VALUES (?, ?, ?, ?)");
        $stmt->execute([
            htmlspecialchars($_POST['titre']),
            htmlspecialchars($_POST['date']),
            htmlspecialchars($_POST['lieu']),
            htmlspecialchars($_POST['description'])
        ]);
    }
}

/* ---------------- MODIFICATION ---------------- */
if ($action === "modif") {

    // MODIF VEHICULE
    if ($type === "vehicule") {
        $stmt = $pdo->prepare("UPDATE vehicules SET options = ?, fiche_technique = ? WHERE id = ?");
        $stmt->execute([
            htmlspecialchars($_POST['options']),
            htmlspecialchars($_POST['fiche_technique']),
            intval($_POST['id'])
        ]);
    }

    // MODIF EMPLOYE
    if ($type === "employe") {
        $champs_autorises = ['prenom', 'nom', 'fonction', 'concession', 'niveau', 'photo'];
        if (!in_array($_POST['champ'], $champs_autorises)) {
            die("Champ non autorisé.");
        }
        $champ = $_POST['champ'];
        $stmt = $pdo->prepare("UPDATE employes SET $champ = ? WHERE id = ?");
        $stmt->execute([
            htmlspecialchars($_POST['valeur']),
            intval($_POST['id'])
        ]);
    }

    // MODIF EVENEMENT
    if ($type === "evenement") {
        $champs_autorises = ['titre', 'date', 'lieu', 'description'];
        if (!in_array($_POST['champ'], $champs_autorises)) {
            die("Champ non autorisé.");
        }
        $champ = $_POST['champ'];
        $stmt = $pdo->prepare("UPDATE evenement SET $champ = ? WHERE id = ?");
        $stmt->execute([
            htmlspecialchars($_POST['valeur']),
            intval($_POST['id'])
        ]);
    }
}

/* ---------------- SUPPRESSION ---------------- */
if ($action === "suppr") {

    if ($type === "vehicule") {
        $stmt = $pdo->prepare("DELETE FROM vehicules WHERE id = ?");
        $stmt->execute([intval($_POST['id'])]);
    }

    if ($type === "employe") {
        $stmt = $pdo->prepare("DELETE FROM employes WHERE id = ?");
        $stmt->execute([intval($_POST['id'])]);
    }

    if ($type === "evenement") {
        $stmt = $pdo->prepare("DELETE FROM evenement WHERE id = ?");
        $stmt->execute([intval($_POST['id'])]);
    }
}

/* ---------------- REDIRECTION ---------------- */
header("Location: admin.php");
exit;
?>