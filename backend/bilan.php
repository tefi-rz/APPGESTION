<?php
/**
 * bilan.php — Statistiques agrégées de la table Vente
 * GET → { success, total, min, max, moyenne, nb_produits, produits[] }
 */

require_once 'db.php';

if (empty($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Non authentifié']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
    exit;
}

$conn = getConnexion();   // ← Connexion MySQLi

try {
    // Statistiques globales
    $result = $conn->query(
        'SELECT
            COUNT(*)                          AS nb_produits,
            COALESCE(SUM(prix * quantite), 0) AS total,
            COALESCE(MIN(prix * quantite), 0) AS min_montant,
            COALESCE(MAX(prix * quantite), 0) AS max_montant,
            COALESCE(AVG(prix * quantite), 0) AS moyenne
         FROM vente'
    );

    $stats = $result ? $result->fetch_assoc() : null;

    // Détail par produit pour les graphiques
    $result = $conn->query(
        'SELECT 
            numProduit,
            design,
            prix,
            quantite,
            (prix * quantite) AS montant
         FROM vente
         ORDER BY montant DESC'
    );

    $produits = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $produits[] = [
                'numProduit' => (int)    $row['numProduit'],
                'design'     =>          $row['design'],
                'prix'       => (float)  $row['prix'],
                'quantite'   => (int)    $row['quantite'],
                'montant'    => (float)  $row['montant'],
            ];
        }
    }

    echo json_encode([
        'success'     => true,
        'total'       => (float) ($stats['total'] ?? 0),
        'min'         => (float) ($stats['min_montant'] ?? 0),
        'max'         => (float) ($stats['max_montant'] ?? 0),
        'moyenne'     => (float) ($stats['moyenne'] ?? 0),
        'nb_produits' => (int)   ($stats['nb_produits'] ?? 0),
        'produits'    => $produits
    ], JSON_UNESCAPED_UNICODE);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false, 
        'message' => 'Erreur serveur : ' . $e->getMessage()
    ]);
}