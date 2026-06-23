<?php
require_once 'config.php';
$pdo = new PDO($dsn, $username, $password, $options);

// Ajouter véhicule
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'ajout_vehicule') {
    $stmt = $pdo->prepare("INSERT INTO vehicules (marque, nom, image, options, fiche_technique) VALUES (?, ?, ?, ?, ?)");
    $result = $stmt->execute([
        $_POST['marque'],
        $_POST['nom'],
        $_POST['image'],
        $_POST['options'],
        $_POST['fiche_technique']
    ]);
    echo json_encode(['success' => $result]);
    exit;
}

// Modifier véhicule
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'modifier_vehicule') {
    $stmt = $pdo->prepare("UPDATE vehicules SET options = ?, fiche_technique = ? WHERE id = ?");
    $result = $stmt->execute([
        $_POST['options'],
        $_POST['fiche_technique'],
        $_POST['id']
    ]);
    echo json_encode(['success' => $result]);
    exit;
}

// Supprimer véhicule
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'supprimer_vehicule') {
    $stmt = $pdo->prepare("DELETE FROM vehicules WHERE id = ?");
    $result = $stmt->execute([$_POST['id']]);
    echo json_encode(['success' => $result]);
    exit;
}

// AJOUT EMPLOYE
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'ajout_employe') {
    $stmt = $pdo->prepare("INSERT INTO employes (prenom, nom, fonction, concession, niveau, photo) VALUES (?, ?, ?, ?, ?, ?)");
    $result = $stmt->execute([
        $_POST['prenom'],
        $_POST['nom'],
        $_POST['fonction'],
        $_POST['concession'],
        $_POST['niveau'],
        $_POST['photo']
    ]);
    echo json_encode(['success' => $result]);
    exit;
}

// MODIFIER EMPLOYE
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'modifier_employe') {
    $champ = $_POST['champ'];
    $valeur = $_POST['valeur'];
    $id = intval($_POST['id']);
    
    // On sécurise le champ autorisé
    $champs_valides = ['prenom', 'nom', 'fonction', 'concession', 'niveau', 'photo'];
    if (!in_array($champ, $champs_valides)) {
        echo json_encode(['success' => false, 'error' => 'Champ invalide']);
        exit;
    }

    $sql = "UPDATE employes SET $champ = :valeur WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        ':valeur' => $valeur,
        ':id' => $id
    ]);
    echo json_encode(['success' => $result]);
    exit;
}

// SUPPRIMER EMPLOYE
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'supprimer_employe') {
    $stmt = $pdo->prepare("DELETE FROM employes WHERE id = ?");
    $result = $stmt->execute([$_POST['id']]);
    echo json_encode(['success' => $result]);
    exit;
}

// AJOUT EVENEMENT
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'ajout_evenement') {
    $stmt = $pdo->prepare("INSERT INTO evenements (titre, date, lieu, description) VALUES (?, ?, ?, ?)");
    $result = $stmt->execute([
        $_POST['titre'],
        $_POST['date'],
        $_POST['lieu'],
        $_POST['description']
    ]);
    echo json_encode(['success' => $result]);
    exit;
}

// MODIFIER EVENEMENT
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'modifier_evenement') {
    $champ = $_POST['champ'];
    $valeur = $_POST['valeur'];
    $id = intval($_POST['id']);

    $champs_valides = ['titre', 'date', 'lieu', 'description'];
    if (!in_array($champ, $champs_valides)) {
        echo json_encode(['success' => false, 'error' => 'Champ invalide']);
        exit;
    }

    $sql = "UPDATE evenements SET $champ = :valeur WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        ':valeur' => $valeur,
        ':id' => $id
    ]);
    echo json_encode(['success' => $result]);
    exit;
}

// SUPPRIMER EVENEMENT
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'supprimer_evenement') {
    $stmt = $pdo->prepare("DELETE FROM evenements WHERE id = ?");
    $result = $stmt->execute([$_POST['id']]);
    echo json_encode(['success' => $result]);
    exit;
}
?>