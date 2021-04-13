-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 13 avr. 2021 à 12:03
-- Version du serveur :  10.4.16-MariaDB
-- Version de PHP : 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `twitterproject`
--

-- --------------------------------------------------------

--
-- Structure de la table `centre_interet`
--

CREATE TABLE `centre_interet` (
  `subject_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `subject` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `centre_interet`
--

INSERT INTO `centre_interet` (`subject_id`, `user_id`, `subject`) VALUES
(47, 122, 'coder'),
(48, 123, 'coder');

-- --------------------------------------------------------

--
-- Structure de la table `following`
--

CREATE TABLE `following` (
  `follower_id` int(11) NOT NULL,
  `following_id` int(11) NOT NULL,
  `follow_up` int(11) NOT NULL,
  `date_follow` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `following`
--

INSERT INTO `following` (`follower_id`, `following_id`, `follow_up`, `date_follow`) VALUES
(123, 122, 289, '2021-03-15 18:22:32'),
(123, 123, 291, '2021-03-15 18:26:28');

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

CREATE TABLE `message` (
  `message_text` text NOT NULL,
  `message_id` int(11) NOT NULL,
  `date_message` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_user_dest` int(11) NOT NULL,
  `id_user_exp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `message`
--

INSERT INTO `message` (`message_text`, `message_id`, `date_message`, `id_user_dest`, `id_user_exp`) VALUES
('kjv', 7, '2021-03-15 18:26:34', 123, 123);

-- --------------------------------------------------------

--
-- Structure de la table `notification`
--

CREATE TABLE `notification` (
  `user_id` int(11) NOT NULL,
  `notification_id` int(11) NOT NULL,
  `type_activitie` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `notification`
--

INSERT INTO `notification` (`user_id`, `notification_id`, `type_activitie`) VALUES
(122, 5, 'Vous avez été inscrit avec succès.BIENVENUE PARMI NOUS'),
(123, 6, 'Vous avez été inscrit avec succès.BIENVENUE PARMI NOUS'),
(123, 7, 'Vous avez un nouveau message de FaizHajar123.<a href=\"message.php?id_user=123\"> Voir le message</a>');

-- --------------------------------------------------------

--
-- Structure de la table `profile_image`
--

CREATE TABLE `profile_image` (
  `image_id` int(11) NOT NULL,
  `profile_default` varchar(100) NOT NULL,
  `profile_choisi` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `profile_image`
--

INSERT INTO `profile_image` (`image_id`, `profile_default`, `profile_choisi`, `user_id`) VALUES
(42, 'inconnu.jpg', '122.jpeg', 122),
(43, 'inconnu.jpg', '123.jpeg', 123);

-- --------------------------------------------------------

--
-- Structure de la table `profile_information`
--

CREATE TABLE `profile_information` (
  `user_id` int(11) NOT NULL,
  `profile_id` int(11) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `language` varchar(50) NOT NULL,
  `url` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `date_naissance` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `profile_information`
--

INSERT INTO `profile_information` (`user_id`, `profile_id`, `user_name`, `language`, `url`, `description`, `date_naissance`) VALUES
(122, 42, 'ASSMOUGUEAsmae122', 'englais', 'profil.php?user_name=ASSMOUGUEAsmae122', 'hello', '0000-00-00'),
(123, 43, 'FaizHajar123', 'englais', 'profil.php?user_name=FaizHajar123', 'etudiante', '0000-00-00');

-- --------------------------------------------------------

--
-- Structure de la table `reaction`
--

CREATE TABLE `reaction` (
  `tweet_user_id` int(11) NOT NULL,
  `tweet_id` int(11) NOT NULL,
  `reacteur_id` int(11) NOT NULL,
  `type_of_reaction` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `retweet`
--

CREATE TABLE `retweet` (
  `tweet_id` int(11) NOT NULL,
  `retweeter_id` int(11) NOT NULL,
  `tweet_user_id` int(11) NOT NULL,
  `date_retweet` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `tweet`
--

CREATE TABLE `tweet` (
  `id_tweet` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `text_tweet` text NOT NULL,
  `date_tweet` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(100) NOT NULL,
  `date_de_creation` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6),
  `tel` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`user_id`, `email`, `password`, `date_de_creation`, `tel`) VALUES
(122, 'asmae.assmougue@gmail.com', '7f6e088c29a19d5505df5828abc938c378cc0b2d', '2021-03-15 17:51:55.774020', NULL),
(123, 'hajar@gmail.com', '7f6e088c29a19d5505df5828abc938c378cc0b2d', '2021-03-15 18:21:52.384381', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `user_formation`
--

CREATE TABLE `user_formation` (
  `user_id` int(11) NOT NULL,
  `formation_id` int(11) NOT NULL,
  `type_etablissment` varchar(100) NOT NULL,
  `nom_etablissment` varchar(100) NOT NULL,
  `niveau` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `centre_interet`
--
ALTER TABLE `centre_interet`
  ADD PRIMARY KEY (`subject_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `following`
--
ALTER TABLE `following`
  ADD PRIMARY KEY (`follower_id`,`following_id`),
  ADD UNIQUE KEY `follow_up` (`follow_up`),
  ADD KEY `follower_id` (`follower_id`,`following_id`),
  ADD KEY `following_id` (`following_id`);

--
-- Index pour la table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`message_id`,`id_user_dest`,`id_user_exp`),
  ADD KEY `id_user_dest` (`id_user_dest`,`id_user_exp`),
  ADD KEY `id_user_exp` (`id_user_exp`);

--
-- Index pour la table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`notification_id`,`user_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `user_id_2` (`user_id`);

--
-- Index pour la table `profile_image`
--
ALTER TABLE `profile_image`
  ADD PRIMARY KEY (`image_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `profile_information`
--
ALTER TABLE `profile_information`
  ADD PRIMARY KEY (`profile_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `reaction`
--
ALTER TABLE `reaction`
  ADD PRIMARY KEY (`tweet_user_id`,`tweet_id`,`reacteur_id`),
  ADD KEY `tweet_id` (`tweet_id`,`reacteur_id`),
  ADD KEY `tweet_user_id` (`tweet_user_id`),
  ADD KEY `reacteur_id` (`reacteur_id`);

--
-- Index pour la table `retweet`
--
ALTER TABLE `retweet`
  ADD PRIMARY KEY (`tweet_id`,`retweeter_id`,`tweet_user_id`),
  ADD KEY `tweet_id` (`tweet_id`,`retweeter_id`,`tweet_user_id`),
  ADD KEY `retweet_ibfk_2` (`retweeter_id`),
  ADD KEY `tweet_user_id` (`tweet_user_id`);

--
-- Index pour la table `tweet`
--
ALTER TABLE `tweet`
  ADD PRIMARY KEY (`id_tweet`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- Index pour la table `user_formation`
--
ALTER TABLE `user_formation`
  ADD PRIMARY KEY (`formation_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `centre_interet`
--
ALTER TABLE `centre_interet`
  MODIFY `subject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT pour la table `following`
--
ALTER TABLE `following`
  MODIFY `follow_up` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=292;

--
-- AUTO_INCREMENT pour la table `message`
--
ALTER TABLE `message`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `notification`
--
ALTER TABLE `notification`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `profile_image`
--
ALTER TABLE `profile_image`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT pour la table `profile_information`
--
ALTER TABLE `profile_information`
  MODIFY `profile_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT pour la table `tweet`
--
ALTER TABLE `tweet`
  MODIFY `id_tweet` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;

--
-- AUTO_INCREMENT pour la table `user_formation`
--
ALTER TABLE `user_formation`
  MODIFY `formation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `centre_interet`
--
ALTER TABLE `centre_interet`
  ADD CONSTRAINT `centre_interet_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `following`
--
ALTER TABLE `following`
  ADD CONSTRAINT `following_ibfk_1` FOREIGN KEY (`follower_id`) REFERENCES `user` (`user_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `following_ibfk_2` FOREIGN KEY (`following_id`) REFERENCES `user` (`user_id`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`id_user_exp`) REFERENCES `user` (`user_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `message_ibfk_2` FOREIGN KEY (`id_user_dest`) REFERENCES `user` (`user_id`);

--
-- Contraintes pour la table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `notification_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Contraintes pour la table `profile_image`
--
ALTER TABLE `profile_image`
  ADD CONSTRAINT `profile_image_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `profile_information`
--
ALTER TABLE `profile_information`
  ADD CONSTRAINT `profile_information_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `reaction`
--
ALTER TABLE `reaction`
  ADD CONSTRAINT `reaction_ibfk_1` FOREIGN KEY (`tweet_id`) REFERENCES `tweet` (`id_tweet`) ON UPDATE CASCADE,
  ADD CONSTRAINT `reaction_ibfk_2` FOREIGN KEY (`tweet_user_id`) REFERENCES `tweet` (`user_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `reaction_ibfk_3` FOREIGN KEY (`reacteur_id`) REFERENCES `user` (`user_id`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `retweet`
--
ALTER TABLE `retweet`
  ADD CONSTRAINT `retweet_ibfk_1` FOREIGN KEY (`tweet_id`) REFERENCES `tweet` (`id_tweet`) ON UPDATE CASCADE,
  ADD CONSTRAINT `retweet_ibfk_2` FOREIGN KEY (`retweeter_id`) REFERENCES `user` (`user_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `retweet_ibfk_3` FOREIGN KEY (`tweet_user_id`) REFERENCES `tweet` (`user_id`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `tweet`
--
ALTER TABLE `tweet`
  ADD CONSTRAINT `tweet_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `user_formation`
--
ALTER TABLE `user_formation`
  ADD CONSTRAINT `user_formation_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
