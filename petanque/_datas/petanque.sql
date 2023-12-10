-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 10 déc. 2023 à 07:52
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
-- Structure de la table `fights`
--

CREATE TABLE `fights` (
  `id` int(11) NOT NULL,
  `party_id` int(11) NOT NULL,
  `round_id` int(11) NOT NULL,
  `team_1_id` int(11) NOT NULL,
  `team_1_score` int(11) DEFAULT NULL,
  `team_2_id` int(11) NOT NULL,
  `team_2_score` int(11) DEFAULT NULL,
  `playground` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `parties`
--

CREATE TABLE `parties` (
  `id` int(11) NOT NULL,
  `date` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `players`
--

CREATE TABLE `players` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `present` tinyint(1) DEFAULT NULL,
  `fav` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `players`
--

INSERT INTO `players` (`id`, `name`, `present`, `fav`) VALUES
(1, ' Alain.G', 1, 1),
(2, ' Alain.M', 1, 1),
(3, ' Annick.G', 1, 1),
(4, ' Christophe.B', 1, 0),
(5, ' Claudie.F', 1, 0),
(6, ' Daniel.E', 1, 0),
(7, ' Daniel.R', 1, 0),
(8, ' Daniel.T', 1, 0),
(9, ' Danielle.L', 0, 0),
(10, ' Dany.R', 0, 1),
(11, ' Denis.D', 1, 0),
(12, ' Denis.G', 1, 0),
(13, ' Dominique.B', 1, 0),
(14, ' Eric.E', 1, 0),
(15, ' Fernand.D', 1, 0),
(16, ' Fernando.L', 1, 0),
(17, ' Franck.H', 1, 0),
(18, ' Frederic.D', 1, 0),
(19, ' Francois.S', 1, 0),
(20, ' Gaetan.F', 1, 0),
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
(59, ' Jean-Louis.D', 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `rounds`
--

CREATE TABLE `rounds` (
  `id` int(11) NOT NULL,
  `party_id` int(11) NOT NULL,
  `i_order` int(11) NOT NULL,
  `players_number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `teams`
--

CREATE TABLE `teams` (
  `id` int(11) NOT NULL,
  `party_id` int(11) NOT NULL,
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
-- Index pour la table `fights`
--
ALTER TABLE `fights`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `parties`
--
ALTER TABLE `parties`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `players`
--
ALTER TABLE `players`
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
-- AUTO_INCREMENT pour la table `fights`
--
ALTER TABLE `fights`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `parties`
--
ALTER TABLE `parties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `players`
--
ALTER TABLE `players`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

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
