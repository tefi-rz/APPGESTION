<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Répondre au preflight CORS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once 'config/db.php';

// Vérifier que c'est bien une requête POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["success" => false, "message" => "Méthode non autorisée"]);
    exit();
}

// Récupérer les données envoyées
$data = json_decode(file_get_contents("php://input"), true);

// Vérifier que les champs sont présents
if (!isset($data['design'], $data['prix'], $data['quantite'])) {
    echo json_encode(["success" => false, "message" => "Données manquantes"]);
    exit();
}

// Valider les types
$design = trim($data['design']);
$prix = filter_var($data['prix'], FILTER_VALIDATE_FLOAT);
$quantite = filter_var($data['quantite'], FILTER_VALIDATE_INT);

if (empty($design)) {
    echo json_encode(["success" => false, "message" => "Le nom du produit est vide"]);
    exit();
}

if ($prix === false || $prix < 0) {
    echo json_encode(["success" => false, "message" => "Prix invalide"]);
    exit();
}

if ($quantite === false || $quantite < 0) {
    echo json_encode(["success" => false, "message" => "Quantité invalide"]);
    exit();
}

// Insérer dans la base de données
try {
    $stmt = $pdo->prepare("
        INSERT INTO vente (design, prix, quantite) 
        VALUES (?, ?, ?)
    ");
    $stmt->execute([$design, $prix, $quantite]);

    echo json_encode([
        "success" => true, 
        "message" => "Produit ajouté avec succès",
        "id" => $pdo->lastInsertId()
    ]);

} catch (PDOException $e) {
    echo json_encode([
        "success" => false, 
        "message" => "Erreur lors de l'ajout : " . $e->getMessage()
    ]);
}
?>