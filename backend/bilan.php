<?php
require_once 'db.php';
$conn = getConnexion();

// Stats globales
$sqlStats = "SELECT MAX(montant) AS maxMontant, MIN(montant) AS minMontant, SUM(montant) AS totalMontant FROM vente";
$resultStats = $conn->query($sqlStats);
$stats = $resultStats->fetch_assoc(); // 

// Montant par produit
$sqlProduits = "SELECT produit, SUM(montant) AS totalMontant FROM vente GROUP BY produit";
$resultProduits = $conn->query($sqlProduits);
$produits = $resultProduits->fetch_all(MYSQLI_ASSOC); 

header('Content-Type: application/json');
echo json_encode([
    "stats"    => $stats,
    "produits" => $produits
]);
