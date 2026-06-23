<?php
// ✅ Démarre la session pour utiliser $_SESSION.
session_start();

// ✅ Connexion à la base de données.
require_once 'config.php';

// Stocke les messages d'erreur à afficher à l'utilisateur.
$erreur = '';

// 🔒 Génère un token CSRF s'il n'existe pas encore (protège contre les attaques cross-site).
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// ✅ Vérifie si le formulaire a été soumis.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // ✅ Vérification du token CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Erreur CSRF : formulaire invalide.");
    }

    // ✅ Récupération des données du formulaire.
    $nom = trim($_POST['nom'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!empty($nom) && !empty($password)) {
        try {
            // 🔍 Requête pour récupérer l’utilisateur par pseudo.
            $stmt = $pdo->prepare("SELECT * FROM employes WHERE nom = :nom");
            $stmt->execute([':nom' => $nom]);
            $user = $stmt->fetch();

            // 🔑 Vérifie que le mot de passe correspond au hash en base.
            if ($user && password_verify($password, $user['password'])) {
                // ✅ Connexion réussie
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'nom' => $user['nom'],
                    
                ];

                $_SESSION['id'] = $user['id']; // Stockage simplifié.

                $_SESSION['login_attempts'] = 0; // 🔄 Reset des tentatives après succès.

                if ($_POST['rapel'] == 'on') {
                    // ✅ Si la case "Se souvenir de moi" est cochée, on crée un cookie.
                    setcookie('remember_me', $user['nom'], time() + (86400 * 365), "/"); // 1 an de validité.
                }

                header('Location:admin.php'); // ✅ Redirection.
                exit();
                
            } else {
                $_SESSION['login_attempts']++;
                $_SESSION['last_attempt_time'] = time();
                $erreur = "Identifiants incorrects.";

                header('Location:bmw.php'); // ✅ Redirection.
                exit();
            }
        } catch (PDOException $e) {
            $erreur = "Erreur de connexion à la base.";
        }
    } else {
        $erreur = "Tous les champs sont obligatoires.";
    }
}
?>