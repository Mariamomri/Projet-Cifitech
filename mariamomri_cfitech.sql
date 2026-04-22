-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 22, 2026 at 09:16 AM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mariamomri_cfitech`
--

-- --------------------------------------------------------

--
-- Table structure for table `formations`
--

DROP TABLE IF EXISTS `formations`;
CREATE TABLE IF NOT EXISTS `formations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `intitule` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `nb_mois` int NOT NULL,
  `date_debut` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `formations`
--

INSERT INTO `formations` (`id`, `intitule`, `nb_mois`, `date_debut`) VALUES
(1, 'Web Dev', 12, '2026-01-05'),
(2, 'Technicien', 11, '2025-08-25'),
(3, 'Java Dev', 7, '2025-09-01');

-- --------------------------------------------------------

--
-- Table structure for table `participe`
--

DROP TABLE IF EXISTS `participe`;
CREATE TABLE IF NOT EXISTS `participe` (
  `id_stagiaire` int NOT NULL,
  `id_formation` int NOT NULL,
  PRIMARY KEY (`id_stagiaire`,`id_formation`),
  KEY `FK_participe_formation` (`id_formation`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `participe`
--

INSERT INTO `participe` (`id_stagiaire`, `id_formation`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 2),
(5, 2),
(6, 2),
(7, 3),
(8, 3),
(9, 3);

-- --------------------------------------------------------

--
-- Table structure for table `personnel`
--

DROP TABLE IF EXISTS `personnel`;
CREATE TABLE IF NOT EXISTS `personnel` (
  `id` int NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `mot_de_passe` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `nom` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `prenom` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pseudo` (`pseudo`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `personnel`
--

INSERT INTO `personnel` (`id`, `pseudo`, `mot_de_passe`, `nom`, `prenom`) VALUES
(1, 'doeking', 'cfitech', 'Dunia', 'Julien'),
(2, 'Mary', 'cfitech', 'Rossi', 'Myriam');

-- --------------------------------------------------------

--
-- Table structure for table `stagiaires`
--

DROP TABLE IF EXISTS `stagiaires`;
CREATE TABLE IF NOT EXISTS `stagiaires` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `prenom` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `date_naissance` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stagiaires`
--

INSERT INTO `stagiaires` (`id`, `nom`, `prenom`, `email`, `date_naissance`) VALUES
(1, 'Omri', 'Mariam', 'momri@cfitech.be', '1988-09-20'),
(2, 'Bianchi', 'Stefania', 'ste@cfitech.be', '1998-07-22'),
(3, 'Blu', 'Nisrin', 'nis@cfitech.be', '2001-03-15'),
(4, 'Tik', 'Said', 'said@cfitech.be', '2000-04-11'),
(5, 'Moreau', 'Thomas', 'tmoreau@cfitech.be', '1997-12-03'),
(6, 'Petit', 'Laura', 'lpetit@cfitech.be', '2002-05-27'),
(7, 'Bernard', 'Maxime', 'mbernard@cfitech.be', '1996-11-14'),
(8, 'Leroy', 'Emma', 'eleroy@cfitech.be', '2000-02-09'),
(9, 'Dubois', 'Lucas', 'ldubois@cfitech.be', '1998-08-30');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `participe`
--
ALTER TABLE `participe`
  ADD CONSTRAINT `FK_participe_formation` FOREIGN KEY (`id_formation`) REFERENCES `formations` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `FK_participe_stagiaire` FOREIGN KEY (`id_stagiaire`) REFERENCES `stagiaires` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
