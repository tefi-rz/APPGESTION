<?php
require_once 'config/db.php';

$method = $_SERVER['REQUEST_METHOD'];
$data = json_decode(file_get_contents("php://input"), true);

// LIST all products
if ($method === 'GET') {
    try {
        $stmt = $pdo->query("
            SELECT numProduit, design, prix, quantite, 
            (prix * quantite) AS montant 
            FROM vente
        ");
        $ventes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(["success" => true, "data" => $ventes]);
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => "Erreur lors du listage"]);
    }
}

// UPDATE a product
elseif ($method === 'PUT') {
    if (!isset($data['numProduit'], $data['design'], $data['prix'], $data['quantite'])) {
        echo json_encode(["success" => false, "message" => "Modification échouée : données manquantes"]);
        exit();
    }
    try {
        $stmt = $pdo->prepare("
            UPDATE vente 
            SET design = ?, prix = ?, quantite = ? 
            WHERE numProduit = ?
        ");
        $stmt->execute([
            $data['design'],
            $data['prix'],
            $data['quantite'],
            $data['numProduit']
        ]);
        echo json_encode(["success" => true, "message" => "Modification réussie"]);
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => "Modification échouée"]);
    }
}

// DELETE a product
elseif ($method === 'DELETE') {
    if (!isset($data['numProduit'])) {
        echo json_encode(["success" => false, "message" => "Suppression échouée : ID manquant"]);
        exit();
    }
    try {
        $stmt = $pdo->prepare("DELETE FROM vente WHERE numProduit = ?");
        $stmt->execute([$data['numProduit']]);
        echo json_encode(["success" => true, "message" => "Suppression réussie"]);
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => "Suppression échouée"]);
    }
}

// Method not allowed
else {
    echo json_encode(["success" => false, "message" => "Méthode non autorisée"]);
}
?>