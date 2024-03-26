-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : mar. 26 mars 2024 à 18:07
-- Version du serveur : 10.6.17-MariaDB
-- Version de PHP : 8.1.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `roia2134_lampdl`
--

-- --------------------------------------------------------

--
-- Structure de la table `phpboost_planning_cats`
--

CREATE TABLE `phpboost_planning_cats` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `rewrited_name` varchar(250) DEFAULT '',
  `c_order` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `special_authorizations` tinyint(1) NOT NULL DEFAULT 0,
  `auth` text DEFAULT NULL,
  `id_parent` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `phpboost_planning_cats`
--

INSERT INTO `phpboost_planning_cats` (`id`, `name`, `rewrited_name`, `c_order`, `special_authorizations`, `auth`, `id_parent`) VALUES
(1, 'Journée portes-ouvertes (extérieur ou indoor)', 'journee-portes-ouvertes-exterieur-ou-indoor', 7, 0, '', 0),
(2, 'Exposition, brocante, bourse d\'échange', 'exposition-brocante-bourse-d-echange', 4, 0, '', 0),
(4, 'Manifestation privée extérieure', 'manifestation-privee-exterieure', 8, 0, '', 0),
(6, 'Compétition Départementale', 'competition-departementale', 1, 0, '', 0),
(7, 'Compétition Fédérale', 'competition-federale', 2, 0, '', 0),
(8, 'Compétition Régionale', 'competition-regionale', 3, 0, '', 0),
(9, 'Journée annuelle des associations, Téléthon', 'journee-annuelle-des-associations-telethon', 5, 0, '', 0),
(10, 'Journée d\'initiation', 'journee-d-initiation', 6, 0, '', 0),
(11, 'Manifestation privée intérieure', 'manifestation-privee-interieure', 9, 0, '', 0),
(12, 'Spectacle aérien public extérieur (SAPA extérieur)', 'spectacle-aerien-public-exterieur-sapa-exterieur', 12, 0, '', 0),
(13, 'Spectacle aérien public intérieur (SAPA intérieur)', 'spectacle-aerien-public-interieur-sapa-interieur', 13, 0, '', 0),
(14, 'Stage d\'initiation ou de formation', 'stage-d-initiation-ou-de-formation', 15, 0, '', 0),
(15, 'Stage de juges', 'stage-de-juges', 16, 0, '', 0),
(16, 'Stage préparation passage QPDD ', 'stage-preparation-passage-qpdd', 17, 0, '', 0),
(17, 'Stage examinateur QPDD', 'stage-examinateur-qpdd', 14, 0, '', 0),
(18, 'Séance de passage ailes, rotors ou brevets', 'seance-de-passage-ailes-rotors-ou-brevets', 10, 0, '', 0),
(19, 'Séance de passage QPDD', 'seance-de-passage-qpdd', 11, 0, '', 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `phpboost_planning_cats`
--
ALTER TABLE `phpboost_planning_cats`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `phpboost_planning_cats`
--
ALTER TABLE `phpboost_planning_cats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
