-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  sam. 14 déc. 2019 à 13:10
-- Version du serveur :  10.4.10-MariaDB
-- Version de PHP :  7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `parfumerie`
--

-- --------------------------------------------------------

--
-- Structure de la table `parfums`
--

CREATE TABLE `parfums` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `stamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `image` varchar(255) DEFAULT NULL,
  `prix` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `parfums`
--

INSERT INTO `parfums` (`id`, `nom`, `description`, `stamp`, `image`, `prix`) VALUES
(1, 'ROYAL OUD SPRAY', 'Oriental Oud est un produit excquis élaboré à partir du plus fin des oud du Cambodge et allié à un mélange de rose et de quelques notes de musc.', '2019-12-11 08:45:07', 'RoyalOud.jpg', 50),
(2, 'ARABIAN KNIGHT SILVER', 'Un parfum boisé et discret à la fois, idéal pour laisser un agréable sillage pendant les jours d\'été.', '2019-12-11 08:45:07', 'ArabianKnight.jpg', 70),
(3, 'AWTAR', 'Fleur d\'oranger, baies rouges, pomme, tendre jasmin, gardenia  Flacon 50ml.', '2019-12-11 08:45:07', 'Awtar.png', 35),
(4, 'MAJESTIC SPECIAL OUD', 'Arabian Oud, artisan du luxe depuis plus de 35 ans vous présente Majestic Special Oud, un parfum signature avec des senteurs authentiques.', '2019-12-11 08:45:07', 'Majestic.png', 112);

-- --------------------------------------------------------

--
-- Structure de la table `sexe`
--

CREATE TABLE `sexe` (
  `id` int(11) NOT NULL,
  `id_sexe` tinyint(1) NOT NULL,
  `sexe` varchar(10) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `sexe`
--

INSERT INTO `sexe` (`id`, `id_sexe`, `sexe`) VALUES
(1, 0, 'Homme'),
(2, 1, 'Femme');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `pseudo` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `type_id` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `pseudo`, `password`, `role`, `type_id`) VALUES
(1, 'Mohamed', 'a', 'Admin', 0),
(2, 'Jeremy', 'azert', 'User', 0),
(10, 'Lisa', 'pass', 'User', 1),
(12, 'test', 'test', 'User', 0),
(14, 'Lise', 'test', 'User', 1),
(19, 'Test', 'test', 'User', 0);

--
-- Déclencheurs `users`
--
DELIMITER $$
CREATE TRIGGER `before_insert_role` BEFORE INSERT ON `users` FOR EACH ROW BEGIN
    IF NEW.role != 'Admin'
    AND NEW.role != 'User'
      THEN
        SET NEW.role = 'Guest';
    END IF;
END
$$
DELIMITER ;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `parfums`
--
ALTER TABLE `parfums`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `sexe`
--
ALTER TABLE `sexe`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_sexe` (`id_sexe`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type_id` (`type_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `parfums`
--
ALTER TABLE `parfums`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `sexe`
--
ALTER TABLE `sexe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `sexe` (`id_sexe`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
