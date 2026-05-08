-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 08 mai 2026 à 21:13
-- Version du serveur : 8.4.7
-- Version de PHP : 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `lrr_suiviestage`
--
CREATE DATABASE IF NOT EXISTS `lrr_suiviestage` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `lrr_suiviestage`;

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20260507070612', '2026-05-08 10:10:21', 258),
('DoctrineMigrations\\Version20260508091000', '2026-05-08 14:15:06', 91),
('DoctrineMigrations\\Version20260508092000', '2026-05-08 14:21:01', 83),
('DoctrineMigrations\\Version20260508103000', '2026-05-08 15:32:38', 75),
('DoctrineMigrations\\Version20260508104000', '2026-05-08 15:46:41', 31),
('DoctrineMigrations\\Version20260508105000', '2026-05-08 16:57:01', 40),
('DoctrineMigrations\\Version20260508106000', '2026-05-08 17:14:53', 368),
('DoctrineMigrations\\Version20260508107000', '2026-05-08 17:14:54', 13),
('DoctrineMigrations\\Version20260508108000', '2026-05-08 17:25:58', 1205),
('DoctrineMigrations\\Version20260508109000', '2026-05-08 17:35:35', 304),
('DoctrineMigrations\\Version20260508185819', '2026-05-08 18:58:35', 451);

-- --------------------------------------------------------

--
-- Structure de la table `eleve`
--

DROP TABLE IF EXISTS `eleve`;
CREATE TABLE IF NOT EXISTS `eleve` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom_eleve` varchar(150) NOT NULL,
  `prenom_eleve` varchar(150) NOT NULL,
  `option_eleve_id` int DEFAULT NULL,
  `promotion_eleve_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_ECA105F72A1BB616` (`option_eleve_id`),
  KEY `IDX_ECA105F7CC3863F6` (`promotion_eleve_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `eleve`
--

INSERT INTO `eleve` (`id`, `nom_eleve`, `prenom_eleve`, `option_eleve_id`, `promotion_eleve_id`) VALUES
(1, 'jean', 'jacque', 1, 1),
(2, 'Galilea', 'Iban', 1, 1),
(5, 'Tutur', 'Tutur', 1, 1),
(9, 'Baptiste', 'Bertrand', 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `eleve_utilisateur`
--

DROP TABLE IF EXISTS `eleve_utilisateur`;
CREATE TABLE IF NOT EXISTS `eleve_utilisateur` (
  `eleve_id` int NOT NULL,
  `utilisateur_id` int NOT NULL,
  PRIMARY KEY (`eleve_id`,`utilisateur_id`),
  KEY `IDX_987B6984A6CC7B2` (`eleve_id`),
  KEY `IDX_987B6984FB88E14F` (`utilisateur_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `entreprise`
--

DROP TABLE IF EXISTS `entreprise`;
CREATE TABLE IF NOT EXISTS `entreprise` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom_entreprise` varchar(200) NOT NULL,
  `adresse_entreprise` varchar(200) NOT NULL,
  `cpentreprise` int NOT NULL,
  `ville_entreprise` varchar(200) NOT NULL,
  `tuteur_entreprise` varchar(150) NOT NULL,
  `telephone_entreprise` varchar(20) NOT NULL,
  `mail_entreprise` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `entreprise`
--

INSERT INTO `entreprise` (`id`, `nom_entreprise`, `adresse_entreprise`, `cpentreprise`, `ville_entreprise`, `tuteur_entreprise`, `telephone_entreprise`, `mail_entreprise`) VALUES
(1, 'Longmire', '48 Rue du Désespoire', 76100, 'Rouen', 'M. Erdogan', '06 58 64 22 18', 'contact@longmire-studio.fr'),
(3, 'Maison', '501 rue sainte-framboise', 27864, 'Bonbons', 'Mr. Fraise', '06 14 13 10 52', 'fraise@framboise.com');

-- --------------------------------------------------------

--
-- Structure de la table `historique_eleve`
--

DROP TABLE IF EXISTS `historique_eleve`;
CREATE TABLE IF NOT EXISTS `historique_eleve` (
  `id` int NOT NULL AUTO_INCREMENT,
  `eleve_id` int DEFAULT NULL,
  `utilisateur_id` int DEFAULT NULL,
  `date_modification` datetime NOT NULL,
  `type_action` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `champ_modifie` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ancienne_valeur` longtext COLLATE utf8mb4_unicode_ci,
  `nouvelle_valeur` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `IDX_A221DF84A6CC7B2` (`eleve_id`),
  KEY `IDX_A221DF84FB88E14F` (`utilisateur_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `historique_eleve`
--

INSERT INTO `historique_eleve` (`id`, `eleve_id`, `utilisateur_id`, `date_modification`, `type_action`, `champ_modifie`, `ancienne_valeur`, `nouvelle_valeur`) VALUES
(5, 5, 10, '2026-05-08 20:18:18', 'modifié', 'optionEleve', 'SISR', 'SLAM');

-- --------------------------------------------------------

--
-- Structure de la table `historique_entreprise`
--

DROP TABLE IF EXISTS `historique_entreprise`;
CREATE TABLE IF NOT EXISTS `historique_entreprise` (
  `id` int NOT NULL AUTO_INCREMENT,
  `entreprise_id` int DEFAULT NULL,
  `utilisateur_id` int DEFAULT NULL,
  `date_modification` datetime NOT NULL,
  `type_action` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `champ_modifie` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ancienne_valeur` longtext COLLATE utf8mb4_unicode_ci,
  `nouvelle_valeur` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `IDX_754D4089A4AEAFEA` (`entreprise_id`),
  KEY `IDX_754D4089FB88E14F` (`utilisateur_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `historique_entreprise`
--

INSERT INTO `historique_entreprise` (`id`, `entreprise_id`, `utilisateur_id`, `date_modification`, `type_action`, `champ_modifie`, `ancienne_valeur`, `nouvelle_valeur`) VALUES
(3, NULL, 10, '2026-05-08 20:19:33', 'modifié', 'telephoneEntreprise', '05 84 94 25', '05 84 94 25 52');

-- --------------------------------------------------------

--
-- Structure de la table `historique_stage`
--

DROP TABLE IF EXISTS `historique_stage`;
CREATE TABLE IF NOT EXISTS `historique_stage` (
  `id` int NOT NULL AUTO_INCREMENT,
  `stage_id` int DEFAULT NULL,
  `utilisateur_id` int DEFAULT NULL,
  `date_modification` datetime NOT NULL,
  `type_action` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `champ_modifie` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ancienne_valeur` longtext COLLATE utf8mb4_unicode_ci,
  `nouvelle_valeur` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `IDX_8CFC491A2298D193` (`stage_id`),
  KEY `IDX_8CFC491AFB88E14F` (`utilisateur_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `historique_stage`
--

INSERT INTO `historique_stage` (`id`, `stage_id`, `utilisateur_id`, `date_modification`, `type_action`, `champ_modifie`, `ancienne_valeur`, `nouvelle_valeur`) VALUES
(2, 8, 11, '2026-05-08 20:15:18', 'modifié', 'commentaire', NULL, 'Remerciement OK'),
(3, 8, 11, '2026-05-08 20:15:28', 'modifié', 'commentaire', 'Remerciement OK', 'Remerciement OK\r\nAttestation NOK'),
(4, 8, 11, '2026-05-08 20:15:45', 'modifié', 'commentaire', 'Remerciement OK\r\nAttestation NOK', 'Remerciement OK / Attestation NOK'),
(7, 7, 10, '2026-05-08 20:27:35', 'modifié', 'dateFinStage', '2026-05-15 00:00:00', '2026-05-21 00:00:00'),
(8, 7, 10, '2026-05-08 20:27:35', 'modifié', 'profVisite', 'Tutur Tutur', NULL),
(10, 13, 10, '2026-05-08 20:36:49', 'créé', NULL, NULL, 'Élève: jacque jean | Entreprise: Longmire | Début: 04/05/2026 | Fin: 07/05/2026 | Référent: ge ge | Visite: Legros Ayleric | Description: test');

-- --------------------------------------------------------

--
-- Structure de la table `historique_utilisateur`
--

DROP TABLE IF EXISTS `historique_utilisateur`;
CREATE TABLE IF NOT EXISTS `historique_utilisateur` (
  `id` int NOT NULL AUTO_INCREMENT,
  `utilisateur_id` int DEFAULT NULL,
  `date_modification` datetime NOT NULL,
  `type_action` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `champ_modifie` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ancienne_valeur` longtext COLLATE utf8mb4_unicode_ci,
  `nouvelle_valeur` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `IDX_C4B26DD5FB88E14F` (`utilisateur_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `historique_utilisateur`
--

INSERT INTO `historique_utilisateur` (`id`, `utilisateur_id`, `date_modification`, `type_action`, `champ_modifie`, `ancienne_valeur`, `nouvelle_valeur`) VALUES
(9, 10, '2026-05-08 20:17:46', 'modifié', 'emailUtilisateur', 'aymeric.legros@gmail.com', 'aymeric.legros@gmail.fr');

-- --------------------------------------------------------

--
-- Structure de la table `option`
--

DROP TABLE IF EXISTS `option`;
CREATE TABLE IF NOT EXISTS `option` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom_option` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `option`
--

INSERT INTO `option` (`id`, `nom_option`) VALUES
(1, 'SLAM'),
(2, 'SISR');

-- --------------------------------------------------------

--
-- Structure de la table `promotion`
--

DROP TABLE IF EXISTS `promotion`;
CREATE TABLE IF NOT EXISTS `promotion` (
  `id` int NOT NULL AUTO_INCREMENT,
  `classe_promotion` varchar(100) NOT NULL,
  `annee_promotion` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `promotion`
--

INSERT INTO `promotion` (`id`, `classe_promotion`, `annee_promotion`) VALUES
(1, '2SIO', '2024/2026');

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom_role` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `role`
--

INSERT INTO `role` (`id`, `nom_role`) VALUES
(1, 'ADMIN'),
(2, 'PROF');

-- --------------------------------------------------------

--
-- Structure de la table `stage`
--

DROP TABLE IF EXISTS `stage`;
CREATE TABLE IF NOT EXISTS `stage` (
  `id` int NOT NULL AUTO_INCREMENT,
  `descriptif_stage` varchar(255) DEFAULT NULL,
  `date_debut_stage` date DEFAULT NULL,
  `date_fin_stage` date DEFAULT NULL,
  `entreprise_stage_id` int NOT NULL,
  `eleve_stage_id` int DEFAULT NULL,
  `prof_referent` varchar(150) DEFAULT NULL,
  `prof_visite` varchar(150) DEFAULT NULL,
  `commentaire` longtext,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_C27C9369367537E7` (`eleve_stage_id`),
  KEY `IDX_C27C93697048D716` (`entreprise_stage_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `stage`
--

INSERT INTO `stage` (`id`, `descriptif_stage`, `date_debut_stage`, `date_fin_stage`, `entreprise_stage_id`, `eleve_stage_id`, `prof_referent`, `prof_visite`, `commentaire`) VALUES
(7, 'Couou', '2026-05-11', '2026-05-21', 3, 2, 'ge ge', NULL, NULL),
(8, 'vsddd', '2026-05-06', '2026-05-14', 3, 5, 'ge ge', 'ge ge', 'Remerciement OK / Attestation NOK'),
(9, 'Réalisation d\'un site internet', '2026-05-06', '2026-05-07', 1, 9, 'ge ge', 'Legros Ayleric', NULL),
(13, 'test', '2026-05-04', '2026-05-07', 1, 1, 'ge ge', 'Legros Ayleric', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom_utilisateur` varchar(150) NOT NULL,
  `prenom_utilisateur` varchar(100) NOT NULL,
  `mdp_utilisateur` varchar(255) NOT NULL,
  `email_utilisateur` varchar(200) NOT NULL,
  `role_utilisateur_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_1D1C63B39201D279` (`role_utilisateur_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `nom_utilisateur`, `prenom_utilisateur`, `mdp_utilisateur`, `email_utilisateur`, `role_utilisateur_id`) VALUES
(10, 'test', 'test', '$2y$13$1V3fWumG6MljC4W0i19lGuUD.5VDclSNoqiwOhf/5FYlqUgH/f9yO', 'te@gmail.com', 1),
(11, 'ge', 'ge', '$2y$13$qUgAkX7RapZljYQLulifj.wznhvuqHxcc9DAfBEJwKCaOtXEsECg.', 'ge@gmail.com', 2),
(15, 'Ayleric', 'Legros', '$2y$13$mhJ/hrwz341SJuCoX8G4tO4S621OkIvEENqeAbIe2eqrHjt.WLzHi', 'aymeric.legros@gmail.fr', 2);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `eleve`
--
ALTER TABLE `eleve`
  ADD CONSTRAINT `FK_ECA105F72A1BB616` FOREIGN KEY (`option_eleve_id`) REFERENCES `option` (`id`),
  ADD CONSTRAINT `FK_ECA105F7CC3863F6` FOREIGN KEY (`promotion_eleve_id`) REFERENCES `promotion` (`id`);

--
-- Contraintes pour la table `eleve_utilisateur`
--
ALTER TABLE `eleve_utilisateur`
  ADD CONSTRAINT `FK_ELEVE_UTILISATEUR_ELEVE` FOREIGN KEY (`eleve_id`) REFERENCES `eleve` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_ELEVE_UTILISATEUR_UTILISATEUR` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateur` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `historique_eleve`
--
ALTER TABLE `historique_eleve`
  ADD CONSTRAINT `FK_HIST_ELEVE_ELEVE` FOREIGN KEY (`eleve_id`) REFERENCES `eleve` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `FK_HIST_ELEVE_UTILISATEUR` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateur` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `historique_entreprise`
--
ALTER TABLE `historique_entreprise`
  ADD CONSTRAINT `FK_HE_ENTREPRISE` FOREIGN KEY (`entreprise_id`) REFERENCES `entreprise` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `FK_HE_UTILISATEUR` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateur` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `historique_stage`
--
ALTER TABLE `historique_stage`
  ADD CONSTRAINT `FK_HS_STAGE` FOREIGN KEY (`stage_id`) REFERENCES `stage` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `FK_HS_UTILISATEUR` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateur` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `historique_utilisateur`
--
ALTER TABLE `historique_utilisateur`
  ADD CONSTRAINT `FK_HU_UTILISATEUR` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateur` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `stage`
--
ALTER TABLE `stage`
  ADD CONSTRAINT `FK_C27C9369367537E7` FOREIGN KEY (`eleve_stage_id`) REFERENCES `eleve` (`id`),
  ADD CONSTRAINT `FK_C27C93697048D716` FOREIGN KEY (`entreprise_stage_id`) REFERENCES `entreprise` (`id`);

--
-- Contraintes pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD CONSTRAINT `FK_1D1C63B39201D279` FOREIGN KEY (`role_utilisateur_id`) REFERENCES `role` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
