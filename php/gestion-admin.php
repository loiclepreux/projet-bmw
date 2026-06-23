<?php
session_start();
require_once 'config.php';

if (empty($_SESSION['user'])) {
    http_response_code(403);
    exit('Non autorisé.');
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$isAjax = !empty($_POST['isAjax']);

function repondre(bool $success, string $message = '', bool $isAjax = false): void {
    if ($isAjax) {
        header('Content-Type: application/json');
        echo json_encode(['success' => $success, 'message' => $message]);
        exit;
    }
    header('Location: admin.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    repondre(false, 'Méthode non autorisée.', $isAjax);
}

if (empty($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    repondre(false, 'Token CSRF invalide.', $isAjax);
}

$action = $_GET['action'] ?? null;
$type   = $_GET['type']   ?? null;

if (!$action || !$type) {
    repondre(false, 'Requête incomplète.', $isAjax);
}

try {
    /* ---- AJOUT ---- */
    if ($action === 'ajout') {
        if ($type === 'vehicule') {
            $stmt = $pdo->prepare("INSERT INTO vehicules (marque, nom, image, options, fiche_technique) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([
                $_POST['marque'],
                $_POST['nom'],
                $_POST['image'],
                $_POST['options'] ?? '',
                $_POST['fiche_technique'],
            ]);
        } elseif ($type === 'employe') {
            $password = !empty($_POST['password'])
                ? password_hash($_POST['password'], PASSWORD_DEFAULT)
                : null;
            $stmt = $pdo->prepare("INSERT INTO employes (prenom, nom, fonction, concession, niveau, photo, password) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $_POST['prenom'],
                $_POST['nom'],
                $_POST['fonction'],
                $_POST['concession'],
                intval($_POST['niveau']),
                $_POST['photo'],
                $password,
            ]);
        } elseif ($type === 'evenement') {
            $stmt = $pdo->prepare("INSERT INTO evenement (titre, date, lieu, description, video) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([
                $_POST['titre'],
                $_POST['date'],
                $_POST['lieu'],
                $_POST['description'],
                $_POST['video'] ?? '',
            ]);
        }
    }

    /* ---- MODIFICATION ---- */
    elseif ($action === 'modif') {
        if ($type === 'vehicule') {
            $stmt = $pdo->prepare("UPDATE vehicules SET options = ?, fiche_technique = ? WHERE id = ?");
            $stmt->execute([$_POST['options'] ?? '', $_POST['fiche_technique'] ?? '', intval($_POST['id'])]);

        } elseif ($type === 'employe') {
            $champs_autorises = ['prenom', 'nom', 'fonction', 'concession', 'niveau', 'photo', 'password'];
            if (!in_array($_POST['champ'] ?? '', $champs_autorises)) {
                repondre(false, 'Champ non autorisé.', $isAjax);
            }
            $champ  = $_POST['champ'];
            $valeur = $_POST['valeur'];
            if ($champ === 'password') {
                if (empty($valeur)) {
                    repondre(false, 'Mot de passe vide.', $isAjax);
                }
                $valeur = password_hash($valeur, PASSWORD_DEFAULT);
            }
            $stmt = $pdo->prepare("UPDATE employes SET `$champ` = ? WHERE id = ?");
            $stmt->execute([$valeur, intval($_POST['id'])]);

        } elseif ($type === 'evenement') {
            $champs_autorises = ['titre', 'date', 'lieu', 'description', 'video'];
            if (!in_array($_POST['champ'] ?? '', $champs_autorises)) {
                repondre(false, 'Champ non autorisé.', $isAjax);
            }
            $champ = $_POST['champ'];
            $stmt  = $pdo->prepare("UPDATE evenement SET `$champ` = ? WHERE id = ?");
            $stmt->execute([$_POST['valeur'], intval($_POST['id'])]);
        }
    }

    /* ---- SUPPRESSION ---- */
    elseif ($action === 'suppr') {
        $tables = ['vehicule' => 'vehicules', 'employe' => 'employes', 'evenement' => 'evenement'];
        if (!isset($tables[$type])) {
            repondre(false, 'Type inconnu.', $isAjax);
        }
        $stmt = $pdo->prepare("DELETE FROM {$tables[$type]} WHERE id = ?");
        $stmt->execute([intval($_POST['id'])]);
    }

    repondre(true, '', $isAjax);

} catch (PDOException $e) {
    repondre(false, 'Erreur base de données.', $isAjax);
}
