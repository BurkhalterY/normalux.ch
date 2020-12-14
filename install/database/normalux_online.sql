-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : lun. 14 déc. 2020 à 13:19
-- Version du serveur :  10.4.11-MariaDB
-- Version de PHP : 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `normalux`
--

-- --------------------------------------------------------

--
-- Structure de la table `online_themes`
--

CREATE TABLE `online_themes` (
  `id` int(11) NOT NULL,
  `theme` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `in_validation` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `online_themes_words`
--

CREATE TABLE `online_themes_words` (
  `id` int(11) NOT NULL,
  `fk_theme` int(11) NOT NULL,
  `fk_word` int(11) NOT NULL,
  `in_validation` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `online_words`
--

CREATE TABLE `online_words` (
  `id` int(11) NOT NULL,
  `word` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `in_validation` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `online_themes`
--
ALTER TABLE `online_themes`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `online_themes_words`
--
ALTER TABLE `online_themes_words`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_theme` (`fk_theme`),
  ADD KEY `fk_word` (`fk_word`);

--
-- Index pour la table `online_words`
--
ALTER TABLE `online_words`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `online_themes`
--
ALTER TABLE `online_themes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `online_themes_words`
--
ALTER TABLE `online_themes_words`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `online_words`
--
ALTER TABLE `online_words`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
