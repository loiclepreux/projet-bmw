<?php
require_once __DIR__ . '/securite.php'; // session protégée
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

// ── Brute-force protection ────────────────────────────────────
$maxAttempts = 5;
$lockoutTime = 900; // 15 minutes

$attempts    = $_SESSION['login_attempts']    ?? 0;
$lastAttempt = $_SESSION['last_attempt_time'] ?? 0;

if ((time() - $lastAttempt) >= $lockoutTime) {
    $_SESSION['login_attempts'] = 0;
    $attempts = 0;
}

if ($attempts >= $maxAttempts) {
    $wait = ceil(($lockoutTime - (time() - $lastAttempt)) / 60);
    header("Location: /index.php?erreur=bloque&attente={$wait}");
    exit;
}

// Même blocage par adresse IP (un robot peut jeter son cookie, pas son adresse)
if (limite_attente() > 0) {
    $wait = ceil(limite_attente() / 60);
    header("Location: /index.php?erreur=bloque&attente={$wait}");
    exit;
}

// ── Authentification ──────────────────────────────────────────
$nom      = trim($_POST['nom'] ?? '');
$password = $_POST['password'] ?? '';

if (empty($nom) || empty($password)) {
    header('Location: /index.php?erreur=champs');
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT * FROM employes WHERE nom = ?");
    $stmt->execute([$nom]);
    $user = $stmt->fetch();

    if ($user && !empty($user['password']) && password_verify($password, $user['password'])) {
        session_regenerate_id(true);
        limite_reset();
        $_SESSION['user']            = ['id' => $user['id'], 'nom' => $user['nom']];
        $_SESSION['login_attempts']  = 0;
        $_SESSION['last_activity']   = time();
        header('Location: admin.php');
    } else {
        limite_echec();
        $_SESSION['login_attempts']    = $attempts + 1;
        $_SESSION['last_attempt_time'] = time();
        header('Location: /index.php?erreur=identifiants');
    }
} catch (PDOException $e) {
    header('Location: /index.php?erreur=bdd');
}
exit;
