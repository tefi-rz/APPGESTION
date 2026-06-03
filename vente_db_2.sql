-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 27 mai 2026 à 11:00
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `vente_db`
CREATE DATABASE IF NOT EXISTS `vente_db`;   -- adino
USE `vente_db`;  

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'Henintsoa', 'Ntsoa', '2026-05-26 16:38:16'),
(2, 'Tefy', 'Tefy', '2026-05-26 16:41:53'),
(3, 'Nolan', 'Nolan', '2026-05-26 16:41:53');

-- --------------------------------------------------------

--
-- Structure de la table `vente`
--

DROP TABLE IF EXISTS `vente`;
CREATE TABLE IF NOT EXISTS `vente` (
  `numProduit` int NOT NULL AUTO_INCREMENT,
  `design` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  `quantite` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`numProduit`)
) ;

--
-- Déchargement des données de la table `vente`
--

INSERT INTO `vente` (`numProduit`, `design`, `prix`, `quantite`, `created_at`, `updated_at`) VALUES
(1, 'Clavier mécanique', 4500.00, 3, '2026-05-26 16:38:17', '2026-05-26 16:38:17'),
(2, 'Écran 24 pouces', 18000.00, 2, '2026-05-26 16:38:17', '2026-05-26 16:38:17'),
(3, 'Souris sans fil', 1200.00, 10, '2026-05-26 16:38:17', '2026-05-26 16:38:17'),
(4, 'Casque audio', 3500.00, 5, '2026-05-26 16:38:17', '2026-05-26 16:38:17'),
(5, 'Webcam HD', 2800.00, 4, '2026-05-26 16:38:17', '2026-05-26 16:38:17'),
(6, 'Ecouteur sans fil', 30000.00, 3, '2026-05-26 16:46:08', '2026-05-26 16:46:08'),
(7, 'OTG', 4000.00, 10, '2026-05-26 16:48:32', '2026-05-26 16:48:32'),
(8, 'Flash(32Go)', 40000.00, 7, '2026-05-26 16:48:32', '2026-05-26 16:48:32');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
