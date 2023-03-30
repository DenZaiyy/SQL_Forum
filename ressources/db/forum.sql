-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : db:3306
-- Généré le : jeu. 30 mars 2023 à 16:01
-- Version du serveur : 8.0.30
-- Version de PHP : 8.1.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `forum`
--

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE `category` (
  `id_category` int NOT NULL,
  `label` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id_category`, `label`) VALUES
(1, 'Gaming'),
(2, 'Development'),
(3, 'HTML'),
(4, 'CSS'),
(5, 'PHP');

-- --------------------------------------------------------

--
-- Structure de la table `like`
--

CREATE TABLE `like` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `topic_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

CREATE TABLE `message` (
  `id_message` int NOT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `topic_id` int NOT NULL,
  `user_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `message`
--

INSERT INTO `message` (`id_message`, `message`, `date`, `topic_id`, `user_id`) VALUES
(1, 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Maxime, sunt possimus sed molestias modi nam. Rem vero, in cumque dignissimos quis, laboriosam nulla assumenda error ipsa quam repellat eius eligendi?\r\n            Repudiandae, explicabo. Laudantium, reprehenderit similique quis, reiciendis doloremque possimus et aliquam inventore ducimus temporibus perferendis obcaecati at. Rerum ducimus vitae laborum modi pariatur at provident dicta, accusantium reiciendis error repellat!\r\n            Facilis id doloremque minus at commodi voluptatibus repellat ipsa ab possimus debitis ipsam dolore, eum maxime ea quisquam aliquid veniam harum nihil amet explicabo perspiciatis nemo quia? Dolorum, exercitationem minima?', '2023-03-22 19:38:11', 1, 1),
(2, 'jlgjgjdlkgjdlgkjlkgjlkdjlgdj', '2023-03-28 07:23:42', 2, 1),
(3, 'elzjrzlkjlkzjrlzkrjzlkjkljr', '2023-03-28 07:23:53', 3, 2),
(4, 'japepaeaoeiaopeiapoeiaepoaieap', '2023-03-28 07:24:04', 4, 1),
(5, 'epaepoaieapoeiaopeiapoeaiepa', '2023-03-28 07:24:14', 5, 1),
(6, 'jdqqpdioeiapoeiaopeiepoaieapoksjsjdqlskjdqlkdjq', '2023-03-28 07:24:29', 6, 2),
(7, 'A votre avis, que veux dire PDO?', '2023-03-28 07:24:40', 7, 2),
(8, 'ljslfjskfljslkfsjflsjflksjflsjfsfjslfjsljfslkjslfjslfslj', '2023-03-28 08:02:04', 1, 2),
(9, 'fjqsqsldjqldjqlkdjqkdjqlkq', '2023-03-28 08:26:09', 1, 2),
(10, 'DONNE NOUS LA TRADUCTION', '2023-03-28 08:55:56', 7, 2);

-- --------------------------------------------------------

--
-- Structure de la table `topic`
--

CREATE TABLE `topic` (
  `id_topic` int NOT NULL,
  `title` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `user_id` int NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `nbLike` int DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `category_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `topic`
--

INSERT INTO `topic` (`id_topic`, `title`, `user_id`, `date`, `nbLike`, `status`, `category_id`) VALUES
(1, 'Ceci est un topic de test 1', 1, '2023-03-22 14:39:01', NULL, 0, 2),
(2, 'Ceci est un topic de test 2', 2, '2023-03-23 08:36:33', NULL, 0, 1),
(3, 'Ceci est un topic de test 3', 1, '2023-03-23 10:02:35', NULL, 0, 2),
(4, 'Ceci est un topic de test 4', 1, '2023-03-23 10:02:43', NULL, 0, 1),
(5, 'Ceci est un topic de test 5', 1, '2023-03-23 10:02:51', NULL, 0, 1),
(6, 'Ceci est un topic de test 6', 1, '2023-03-23 10:02:58', NULL, 0, 2),
(7, 'What is PDO ?', 1, '2023-03-28 06:49:27', NULL, 0, 5);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id_user` int NOT NULL,
  `pseudo` varchar(100) NOT NULL,
  `mail` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` varchar(255) NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `avatar` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `role` json DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id_user`, `pseudo`, `mail`, `password`, `createdAt`, `avatar`, `role`) VALUES
(1, 'denZ', 'denz@example.com', 'test123', '2023-03-22 19:57:22', 'public/img/defaulta-user.png', NULL),
(2, 'test', 'test@test.com', 'testtesttest', '2023-03-28 06:48:42', NULL, NULL),
(4, 'denzaiyy', 'support@denzaiyy.fr', '$2y$10$MKXowrKGD.CjHbuJi9lpx.1wv78HYPu5FaesfuV0a41cimd7iQA8q', '2023-03-30 09:35:26', 'public/img/defaulta-user.png', '\"ROLE_USER\"');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id_category`);

--
-- Index pour la table `like`
--
ALTER TABLE `like`
  ADD PRIMARY KEY (`id`),
  ADD KEY `topic` (`topic_id`),
  ADD KEY `user` (`user_id`);

--
-- Index pour la table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id_message`),
  ADD KEY `Message_Topic_FK` (`topic_id`),
  ADD KEY `Message_User0_FK` (`user_id`);

--
-- Index pour la table `topic`
--
ALTER TABLE `topic`
  ADD PRIMARY KEY (`id_topic`),
  ADD KEY `Topic_User_FK` (`user_id`),
  ADD KEY `Topic_Category0_FK` (`category_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `category`
--
ALTER TABLE `category`
  MODIFY `id_category` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `like`
--
ALTER TABLE `like`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `message`
--
ALTER TABLE `message`
  MODIFY `id_message` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `topic`
--
ALTER TABLE `topic`
  MODIFY `id_topic` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `like`
--
ALTER TABLE `like`
  ADD CONSTRAINT `topic` FOREIGN KEY (`topic_id`) REFERENCES `topic` (`id_topic`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `Message_Topic_FK` FOREIGN KEY (`topic_id`) REFERENCES `topic` (`id_topic`),
  ADD CONSTRAINT `Message_User0_FK` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`);

--
-- Contraintes pour la table `topic`
--
ALTER TABLE `topic`
  ADD CONSTRAINT `Topic_Category0_FK` FOREIGN KEY (`category_id`) REFERENCES `category` (`id_category`),
  ADD CONSTRAINT `Topic_User_FK` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
