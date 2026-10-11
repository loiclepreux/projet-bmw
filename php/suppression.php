<?php
require_once __DIR__ . '/securite.php'; // session protégée
require_once 'config.php';

header('Content-Type: application/json');

if (empty($_SESSION['user'])) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Non autorisé.']);
    exit;
}

if (empty($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Token CSRF invalide.']);
    exit;
}

if (!isset($_POST['id'], $_POST['type'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Données manquantes.']);
    exit;
}

$id   = intval($_POST['id']);
$type = $_POST['type'];

$tables = [
    'custom'      => 'customisations',
    'reservation' => 'reservations',
    'essai'       => 'essais',
    'projet'      => 'projets',
];

if (!isset($tables[$type])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Type inconnu.']);
    exit;
}

try {
    $stmt = $pdo->prepare("DELETE FROM {$tables[$type]} WHERE id = ?");
    $stmt->execute([$id]);
    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Erreur base de données.']);
}
