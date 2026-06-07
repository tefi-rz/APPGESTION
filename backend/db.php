<?php
/**
 * db.php — Connexion centralisée à la base de données
 */

$host     = "localhost";
$user     = "root";
$password = "";
$dbname   = "vente_db";

function getConnexion() {
    static $conn = null;

    if ($conn === null) {
        $conn = new mysqli($host, $user, $password, $dbname);

        // Vérification de la connexion (corrigé)
        if ($conn->connect_errno) {
            die("Connexion échouée : " . $conn->connect_error);
        }

        // Support complet des accents (Écran 24", Clavier mécanique, etc.)
        $conn->set_charset("utf8mb4");
    }

    return $conn;
}