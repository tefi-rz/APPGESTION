<?php
require_once 'config/db.php';

// Only accept POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["success" => false, "message" => "Méthode non autorisée"]);
    exit();
}

// Get request body
$data = json_decode(file_get_contents("php://input"), true);

// Check required fields
if (!isset($data['username'], $data['password'])) {
    echo json_encode(["success" => false, "message" => "Champs manquants"]);
    exit();
}

$username = trim($data['username']);
$password = $data['password'];

// Find user by username
try {
    $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if user exists and password matches
    if (!$user || $user['password'] !== $password) {
        echo json_encode(["success" => false, "message" => "Identifiants incorrects"]);
        exit();
    }

    // Login successful
    echo json_encode([
        "success" => true,
        "message" => "Connexion réussie",
        "user" => [
            "id" => $user['id'],
            "username" => $user['username']
        ]
    ]);

} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "Erreur serveur"]);
}
?>