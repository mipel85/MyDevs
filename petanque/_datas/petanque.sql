-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 15 déc. 2023 à 12:36
-- Version du serveur : 10.4.22-MariaDB
-- Version de PHP : 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `petanque`
--

-- --------------------------------------------------------

--
-- Structure de la table `days`
--

CREATE TABLE `days` (
  `id` int(11) NOT NULL,
  `date` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `fields`
--

CREATE TABLE `fields` (
  `id` int(11) NOT NULL,
  `day_id` int(11) NOT NULL,
  `field_1` tinyint(1) NOT NULL,
  `field_2` tinyint(1) NOT NULL,
  `field_3` tinyint(1) NOT NULL,
  `field_4` tinyint(1) NOT NULL,
  `field_5` tinyint(1) NOT NULL,
  `field_6` tinyint(1) NOT NULL,
  `field_7` tinyint(1) NOT NULL,
  `field_8` tinyint(1) NOT NULL,
  `field_9` tinyint(1) NOT NULL,
  `field_10` tinyint(1) NOT NULL,
  `field_11` tinyint(1) NOT NULL,
  `field_12` tinyint(1) NOT NULL,
  `field_13` tinyint(1) NOT NULL,
  `field_14` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `matches`
--

CREATE TABLE `matches` (
  `id` int(11) NOT NULL,
  `day_id` int(11) NOT NULL,
  `round_id` int(11) NOT NULL,
  `team_1_id` int(11) NOT NULL,
  `team_1_score` int(11) DEFAULT NULL,
  `team_2_id` int(11) NOT NULL,
  `team_2_score` int(11) DEFAULT NULL,
  `field` int(11) NOT NULL,
  `score_status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `members`
--

CREATE TABLE `members` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `present` tinyint(1) DEFAULT NULL,
  `fav` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `members`
--

INSERT INTO `members` (`id`, `name`, `present`, `fav`) VALUES
(1, ' Alain.G', 1, 1),
(2, ' Alain.M', 1, 1),
(3, ' Annick.G', 1, 1),
(4, ' Christophe.B', 1, 0),
(5, ' Claudie.F', 1, 0),
(6, ' Daniel.E', 1, 0),
(7, ' Daniel.R', 1, 0),
(8, ' Daniel.T', 1, 0),
(9, ' Danielle.L', 1, 0),
(10, ' Dany.R', 1, 1),
(11, ' Denis.D', 0, 0),
(12, ' Denis.G', 0, 0),
(13, ' Dominique.B', 0, 0),
(14, ' Eric.E', 0, 0),
(15, ' Fernand.D', 0, 0),
(16, ' Fernando.L', 0, 0),
(17, ' Franck.H', 0, 0),
(18, ' Frederic.D', 0, 0),
(19, ' Francois.S', 0, 0),
(20, ' Gaetan.F', 0, 0),
(21, ' Gerard.F', 0, 0),
(22, ' Gerard.M', 0, 0),
(23, ' Ghislain.G', 0, 0),
(24, ' Guy.A', 0, 0),
(25, ' Jean-Claude.F', 0, 0),
(26, ' Gilbert.M', 0, 0),
(27, ' Jean-Jacques.B', 0, 0),
(28, ' Jean-Louis.D', 0, 0),
(29, ' Jean-Luc.C', 0, 0),
(30, ' Jean-Luc.L', 0, 0),
(31, ' Jean-Marcel.S', 0, 0),
(32, ' Jean-Paul.C', 0, 0),
(33, ' Jean-Pierre.L', 0, 0),
(34, ' Jean-Pierre.P', 0, 0),
(35, ' Laurent.S', 0, 0),
(36, ' Louis.R', 0, 0),
(37, ' Marcel .B', 0, 0),
(38, ' Marie.M', 0, 0),
(39, ' Mathieu.M', 0, 0),
(40, ' Michel.C', 0, 0),
(41, ' Michel.P', 0, 0),
(42, ' Michel.R', 0, 0),
(43, ' Nicky.M', 0, 0),
(44, ' Nicole.H', 0, 0),
(45, ' Noel.L', 0, 0),
(46, ' Pascal.L', 0, 0),
(47, ' Patrick.D', 0, 0),
(48, ' Patrick.L', 0, 0),
(49, ' Philippe.G', 0, 0),
(50, ' Philippe.R', 0, 0),
(51, ' Roland.C', 0, 0),
(52, ' Yannick.G', 0, 0),
(53, ' Claire.S', 0, 0),
(54, ' Marc.S', 0, 0),
(55, ' Sylvain.B', 0, 0),
(56, ' Mathieu.M', 0, 0),
(57, ' Gilles.T', 0, 0),
(58, ' Catherine.D', 0, 0),
(59, ' Jean-Louis.D', 0, 0),
(65, 'Babso', 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `rounds`
--

CREATE TABLE `rounds` (
  `id` int(11) NOT NULL,
  `day_id` int(11) NOT NULL,
  `i_order` int(11) NOT NULL,
  `players_number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `teams`
--

CREATE TABLE `teams` (
  `id` int(11) NOT NULL,
  `day_id` int(11) NOT NULL,
  `round_id` int(11) NOT NULL,
  `player_1_id` int(11) NOT NULL,
  `player_1_name` varchar(255) NOT NULL,
  `player_2_id` int(11) DEFAULT NULL,
  `player_2_name` varchar(255) DEFAULT NULL,
  `player_3_id` int(11) DEFAULT NULL,
  `player_3_name` char(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `days`
--
ALTER TABLE `days`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `fields`
--
ALTER TABLE `fields`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `matches`
--
ALTER TABLE `matches`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `rounds`
--
ALTER TABLE `rounds`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `days`
--
ALTER TABLE `days`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `fields`
--
ALTER TABLE `fields`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `matches`
--
ALTER TABLE `matches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `members`
--
ALTER TABLE `members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT pour la table `rounds`
--
ALTER TABLE `rounds`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `teams`
--
ALTER TABLE `teams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
