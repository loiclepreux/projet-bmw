<?php
session_start();
require_once 'config.php';

if (!isset($_POST['id']) || !isset($_POST['type'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Données manquantes']);
    exit;
}

$id = intval($_POST['id']);
$type = $_POST['type'];

try {
    $pdo = new PDO($dsn, $username, $password, $options);

    switch ($type) {
        case 'custom':
            $stmt = $pdo->prepare("DELETE FROM customisations WHERE id = ?");
            break;
        case 'reservation':
            $stmt = $pdo->prepare("DELETE FROM reservations WHERE id = ?");
            break;
        case 'essai':
            $stmt = $pdo->prepare("DELETE FROM essais WHERE id = ?");
            break;
        case 'projet':
            $stmt = $pdo->prepare("DELETE FROM projets WHERE id = ?");
            break;
        default:
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Type de suppression inconnu']);
            exit;
    }

    $stmt->execute([$id]);

    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}