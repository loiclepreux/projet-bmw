<?php
// ✅ Démarrage de la session (obligatoire pour utiliser $_SESSION).
session_start();

// ✅ Inclusion du fichier de configuration de la base de données.
require_once 'config.php';

// ✅ Génération du token CSRF s'il n'existe pas encore.
if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// ✅ Vérifie que le formulaire a été envoyé via méthode POST.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // 🔒 Vérifie la validité du token CSRF.
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Erreur CSRF : formulaire invalide.");
        }

// ⏱ Anti spam/robot : limite les soumissions rapides.       
if (isset($_SESSION['last_register']) && time() - $_SESSION['last_register'] < 10) {
        die("Merci d'attendre quelques secondes avant de soumettre à nouveau.");
        }
        $_SESSION['last_register'] = time(); // Enregistre le moment de soumission.

        // 🔎 Récupération des champs du formulaire.
        $nom = trim($_POST['nom'] ?? '');
        $prenom = trim($_POST['prenom'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $fonction = intval($_POST['fonction'] ?? 0);
        $photo = $_FILES['photo'];
        $concession = trim($_POST['concession'] ?? '');
        $filename = '';

if ($photo['error'] === 0) {
        $allowedTypes = ['image/jpeg', 'image/png'];
        $mimeType = mime_content_type($photo['tmp_name']);
        $maxSize = 2 * 1024 * 1024; // 2 Mo

        if (in_array($mimeType, $allowedTypes) && $photo['size'] <= $maxSize) {
                $extension = pathinfo($photo['name'], PATHINFO_EXTENSION);
                $filename = uniqid('photo_', true) . '.' . $extension;
                move_uploaded_file($photo['tmp_name'], '../php/photo/' . $filename);
        } else {
                die("Image invalide ou trop volumineuse.");
        }
}

if (!empty($nom) && !empty($email) && !empty($password)) {
        try {

        // 🔍 Vérifie si pseudo ou email existe déjà.   
        $check = $pdo->prepare("SELECT * FROM utilisateurs WHERE nom = :nom OR email = :email");
        $check->execute([':nom' => $nom, ':email' => $email]);

        if ($check->fetch()) {
                echo "Un compte avec ce pseudo ou cet email existe déjà.";
        } else {

                // 🔐 Hachage du mot de passe.
                $hash = password_hash($password, PASSWORD_DEFAULT);

                // 💾 Insertion en base de donnée.
                $stmt = $pdo->prepare("INSERT INTO utilisateurs (nom, email, password, photo) VALUES (?, ?, ?, ?, NOW())");
                $stmt->execute([$nom, $email, $hash, $filename,]);

                 // ✅ Message et redirection
                $_SESSION['message'] = "Inscription réussie ! Vous pouvez maintenant vous connecter.";
                header('Location: ../php/bmw.php');
                exit();
        }
        } catch (PDOException $e) {
        echo "Erreur BDD : " . $e->getMessage();
        }
} else {
        echo "Tous les champs obligatoires doivent être remplis.";
}
}
?>