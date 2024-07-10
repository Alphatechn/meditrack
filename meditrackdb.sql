-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 10 juil. 2024 à 02:17
-- Version du serveur : 8.3.0
-- Version de PHP : 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `bdmeditrack`
--
CREATE DATABASE IF NOT EXISTS `bdmeditrack` DEFAULT CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci;
USE `bdmeditrack`;

-- --------------------------------------------------------

--
-- Structure de la table `antecedents`
--

DROP TABLE IF EXISTS `antecedents`;
CREATE TABLE IF NOT EXISTS `antecedents` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `medi` varchar(190) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `chiru` varchar(190) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `gyneco` varchar(190) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `immu` varchar(190) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `aller` varchar(190) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `autres` varchar(190) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `is_delete` tinyint NOT NULL DEFAULT '0',
  `id_pat` bigint NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_pat` (`id_pat`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `antecedents`
--

INSERT INTO `antecedents` (`id`, `medi`, `chiru`, `gyneco`, `immu`, `aller`, `autres`, `is_delete`, `id_pat`, `created_at`, `updated_at`) VALUES
(1, 'Hypertension artérielle', 'Cholécystectomie', NULL, 'Allergie au latex avérée', NULL, NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'wewew', 'ewewe', NULL, 'ewwww', 'ewewe', NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'ras', 'ras', NULL, 'ras', 'ras', 'ras', 0, 5, '2024-07-08 13:25:18', '2024-07-08 13:25:18');

-- --------------------------------------------------------

--
-- Structure de la table `appartenir`
--

DROP TABLE IF EXISTS `appartenir`;
CREATE TABLE IF NOT EXISTS `appartenir` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `id_ser` bigint UNSIGNED NOT NULL,
  `id_per` bigint UNSIGNED NOT NULL,
  `status` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `appartenir_id_ser_foreign` (`id_ser`),
  KEY `appartenir_id_per_foreign` (`id_per`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `appartenir`
--

INSERT INTO `appartenir` (`id`, `date_debut`, `date_fin`, `id_ser`, `id_per`, `status`, `created_at`, `updated_at`) VALUES
(1, '0000-00-00', '0000-00-00', 8, 1, 0, '2024-04-14 06:11:28', '2024-04-14 06:11:28');

-- --------------------------------------------------------

--
-- Structure de la table `caisse`
--

DROP TABLE IF EXISTS `caisse`;
CREATE TABLE IF NOT EXISTS `caisse` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `motif` varchar(191) COLLATE utf8mb4_general_ci NOT NULL,
  `prix` float NOT NULL,
  `verser` float NOT NULL,
  `reste` float NOT NULL,
  `lettre` varchar(191) COLLATE utf8mb4_general_ci NOT NULL,
  `etat_caisse` varchar(191) COLLATE utf8mb4_general_ci NOT NULL,
  `numero_recu` varchar(191) COLLATE utf8mb4_general_ci NOT NULL,
  `id_pers` bigint UNSIGNED NOT NULL,
  `id_pat` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `caisse_id_pers_foreign` (`id_pers`),
  KEY `caisse_id_pat_foreign` (`id_pat`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `caisse`
--

INSERT INTO `caisse` (`id`, `motif`, `prix`, `verser`, `reste`, `lettre`, `etat_caisse`, `numero_recu`, `id_pers`, `id_pat`, `created_at`, `updated_at`) VALUES
(1, 'Consultation', 2500, 2500, 0, 'DEUX MILLE CINQ CENT  FCFA', 'Payé', '00001', 1, 1, '2024-06-29 14:11:28', '2024-06-29 14:11:28'),
(2, 'frais labo', 20000, 20000, 0, 'VINGT MILLE  FCFA', 'Payé', '00002', 1, 1, '2024-06-29 14:37:58', '2024-06-29 14:37:58'),
(3, 'Consultation', 10000, 10000, 0, 'DIX MILLE  FCFA', 'Payé', '00003', 1, 1, '2024-07-07 11:45:55', '2024-07-07 11:45:55'),
(4, 'frais labo', 15000, 15000, 0, 'QUINZE MILLE  FCFA', 'Payé', '00004', 1, 1, '2024-07-07 11:52:13', '2024-07-07 11:52:13'),
(5, 'frais labo', 10000, 10000, 0, 'DIX MILLE  FCFA', 'Payé', '00005', 1, 1, '2024-07-07 18:12:39', '2024-07-08 04:42:30'),
(6, 'wew', 2500, 2500, 0, 'DEUX MILLE CINQ CENT  FCFA', 'Payé', '00006', 1, 5, '2024-07-09 13:33:43', '2024-07-09 13:33:43'),
(7, 'wew', 2500, 2500, 0, 'DEUX MILLE CINQ CENT  FCFA', 'Payé', '00007', 1, 5, '2024-07-09 13:33:52', '2024-07-09 13:33:52'),
(8, 'echo', 2500, 2500, 0, 'DEUX MILLE CINQ CENT  FCFA', 'Payé', '00008', 1, 1, '2024-07-09 13:50:01', '2024-07-09 13:50:01'),
(9, 'Consultation', 5000, 5000, 0, 'CINQ MILLE  FCFA', 'Payé', '00009', 1, 5, '2024-07-09 14:54:46', '2024-07-09 14:54:46'),
(10, 'Consultation', 5000, 5000, 0, 'CINQ MILLE  FCFA', 'Payé', '00010', 1, 5, '2024-07-09 14:56:18', '2024-07-09 14:56:18'),
(11, 'cons', 5000, 5000, 0, 'CINQ MILLE  FCFA', 'Payé', '00011', 1, 5, '2024-07-09 15:03:20', '2024-07-09 15:03:20'),
(12, 'cons', 5000, 5000, 0, 'CINQ MILLE  FCFA', 'Payé', '00012', 1, 5, '2024-07-09 15:05:19', '2024-07-09 15:05:19');

-- --------------------------------------------------------

--
-- Structure de la table `caisse_mvts`
--

DROP TABLE IF EXISTS `caisse_mvts`;
CREATE TABLE IF NOT EXISTS `caisse_mvts` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `libelle` varchar(191) COLLATE utf8mb4_general_ci NOT NULL,
  `montant` float NOT NULL,
  `num_recu` varchar(191) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `caisse_mvts`
--

INSERT INTO `caisse_mvts` (`id`, `libelle`, `montant`, `num_recu`, `created_at`, `updated_at`) VALUES
(3, 'CONSULTATION', 2500, '00001', '2024-06-29 14:11:28', '2024-06-29 14:11:28'),
(4, 'WIDAL', 15000, '00002', '2024-06-29 14:37:58', '2024-06-29 14:37:58'),
(5, 'TFS', 5000, '00002', '2024-06-29 14:37:58', '2024-06-29 14:37:58'),
(6, 'ELCTROPHORESE', 10000, '00003', '2024-07-07 11:45:55', '2024-07-07 11:45:55'),
(7, 'WIDAL', 15000, '00004', '2024-07-07 11:52:13', '2024-07-07 11:52:13'),
(8, 'ELCTROPHORESE', 10000, '00005', '2024-07-07 18:12:39', '2024-07-07 18:12:39'),
(9, 'ECHO', 2500, '00006', '2024-07-09 13:33:43', '2024-07-09 13:33:43'),
(10, 'ECHO', 2500, '00007', '2024-07-09 13:33:52', '2024-07-09 13:33:52'),
(11, 'ECHO', 2500, '00008', '2024-07-09 13:50:01', '2024-07-09 13:50:01'),
(12, 'CONSULTATION', 5000, '00009', '2024-07-09 14:54:46', '2024-07-09 14:54:46'),
(13, 'CONSULTATION', 5000, '00010', '2024-07-09 14:56:18', '2024-07-09 14:56:18'),
(14, 'CONSULTATION', 5000, '00011', '2024-07-09 15:03:20', '2024-07-09 15:03:20'),
(15, 'CONSULTATION', 5000, '00012', '2024-07-09 15:05:19', '2024-07-09 15:05:19');

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `libelle` varchar(191) COLLATE utf8mb4_general_ci NOT NULL,
  `status` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `libelle`, `status`, `created_at`, `updated_at`) VALUES
(1, 'sirop', 0, '2024-06-29 15:45:05', '2024-06-29 15:45:05'),
(2, 'comprime', 0, '2024-06-29 15:45:13', '2024-06-29 15:45:13');

-- --------------------------------------------------------

--
-- Structure de la table `consultation`
--

DROP TABLE IF EXISTS `consultation`;
CREATE TABLE IF NOT EXISTS `consultation` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `temperature` float NOT NULL,
  `poids` float NOT NULL,
  `taille` float NOT NULL,
  `type_cons` varchar(191) COLLATE utf8mb4_general_ci NOT NULL,
  `symptome` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `diagnostique` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `exam_recom` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `id_pat` bigint UNSIGNED NOT NULL,
  `id_pers` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `consultation_id_pat_foreign` (`id_pat`),
  KEY `consultation_id_pers_foreign` (`id_pers`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `consultation`
--

INSERT INTO `consultation` (`id`, `temperature`, `poids`, `taille`, `type_cons`, `symptome`, `diagnostique`, `exam_recom`, `status`, `id_pat`, `id_pers`, `created_at`, `updated_at`) VALUES
(2, 39, 75, 1.75, 'Generale', 'Vu en Consultation ce jour pour: fièvre et céphalées', 'Début de la symptomatologie il y a 3 jours avec fièvre à 39°C, céphalées intenses et asthénie,\r\nPas de frissons, de nausées, de vomissements, ni de diarrhée,\r\nLe patient est revenu d\'un séjour de douala il y a 10 jours,\r\nPas de signes de déshydratation,\r\nExamen physique sans particularité, notamment absence de taches rosées abdominales, de hépato-splénomégalie ou de gurgling iléal.\r\nSuspicion de fièvre typhoïde ou de paludisme devant le contexte épidémiologique', 'Hémoculture pour isoler Salmonella typhi,\r\nSérologie : test de Widal,\r\nFrottis sanguin et goutte épaisse,\r\nTest de diagnostic rapide du paludisme,', 0, 1, 1, '2024-06-29 14:34:30', '2024-06-29 17:57:14'),
(3, 18, 20, 1.75, 'Generale', 'popopopop', 'poopppooo', 'asasasas', 0, 1, 1, '2024-07-07 11:47:45', '2024-07-07 11:47:45'),
(4, 18, 20, 1.75, 'Generale', 'srdtfyghij', 'sdtfugih', 'echo', 0, 1, 1, '2024-07-09 12:25:14', '2024-07-09 12:25:14');

-- --------------------------------------------------------

--
-- Structure de la table `element`
--

DROP TABLE IF EXISTS `element`;
CREATE TABLE IF NOT EXISTS `element` (
  `id` int NOT NULL AUTO_INCREMENT,
  `libelle` text NOT NULL,
  `montant` float NOT NULL,
  `status` int NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `element`
--

INSERT INTO `element` (`id`, `libelle`, `montant`, `status`, `created_at`, `updated_at`) VALUES
(1, 'CONSULTATION', 5000, 0, '2024-07-09 10:36:36', '2024-07-09 10:52:05');

-- --------------------------------------------------------

--
-- Structure de la table `examen`
--

DROP TABLE IF EXISTS `examen`;
CREATE TABLE IF NOT EXISTS `examen` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `libelle` varchar(191) COLLATE utf8mb4_general_ci NOT NULL,
  `prix_examen` float NOT NULL,
  `status` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `examen`
--

INSERT INTO `examen` (`id`, `libelle`, `prix_examen`, `status`, `created_at`, `updated_at`) VALUES
(1, 'ELCTROPHORESE', 10000, 0, '2024-06-29 13:20:34', '2024-06-29 13:20:34'),
(2, 'TFS', 5000, 0, '2024-06-29 13:42:53', '2024-06-29 13:59:17'),
(3, 'WIDAL', 15000, 0, '2024-06-29 13:59:41', '2024-06-29 13:59:41'),
(4, 'ECHO', 2500, 0, '2024-06-29 14:10:56', '2024-07-07 13:34:25'),
(5, 'Goutte Epaisse', 2000, 0, '2024-06-29 19:10:52', '2024-06-29 19:10:52'),
(6, 'Text Paludisme', 1500, 0, '2024-06-29 19:11:59', '2024-06-29 19:11:59'),
(7, 'Hémoculture', 5000, 0, '2024-06-29 19:12:20', '2024-06-29 19:12:20');

-- --------------------------------------------------------

--
-- Structure de la table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_general_ci NOT NULL,
  `connection` text COLLATE utf8mb4_general_ci NOT NULL,
  `queue` text COLLATE utf8mb4_general_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_general_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_general_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `medicament`
--

DROP TABLE IF EXISTS `medicament`;
CREATE TABLE IF NOT EXISTS `medicament` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_cat` bigint UNSIGNED NOT NULL,
  `libelle` varchar(191) COLLATE utf8mb4_general_ci NOT NULL,
  `prix` float DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `medicament_id_cat_foreign` (`id_cat`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `medicament`
--

INSERT INTO `medicament` (`id`, `id_cat`, `libelle`, `prix`, `created_at`, `updated_at`) VALUES
(1, 2, 'METRO', 100, '2024-06-29 15:47:20', '2024-06-29 15:47:20'),
(2, 2, 'PARA', 500, '2024-06-29 15:47:32', '2024-06-29 15:47:32'),
(3, 1, 'Ciprofloxacine 500 mg', 1000, '2024-06-29 19:41:08', '2024-07-07 16:40:09'),
(4, 2, 'Arthémether-Luméfantrine ', NULL, '2024-06-29 19:41:24', '2024-06-29 19:41:24'),
(5, 2, 'Levothyrox®50 mcg', NULL, '2024-06-29 19:41:56', '2024-06-29 19:41:56');

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_general_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(2, '2024_04_02_173230_create_resultats_table', 1),
(3, '2024_04_02_173619_create_services_table', 1),
(4, '2024_04_02_174316_create_examens_table', 1),
(5, '2024_04_02_174453_create_soins_table', 1),
(6, '2024_04_02_174640_create_cathegories_table', 1),
(7, '2024_04_02_174720_create_type_users_table', 1),
(8, '2024_04_02_180717_create_user_table', 1),
(9, '2024_04_02_180718_create_password_reset_tokens_table', 1),
(10, '2024_04_02_180719_create_failed_jobs_table', 1),
(11, '2024_04_02_180752_create_medicaments_table', 1),
(12, '2024_04_02_180819_create_patients_table', 1),
(13, '2024_04_02_180836_create_personnels_table', 1),
(14, '2024_04_02_180855_create_consultations_table', 1),
(15, '2024_04_02_181210_create_caisses_table', 1),
(16, '2024_04_02_181231_create_rendez_vouses_table', 1),
(17, '2024_04_02_181252_create_transferts_table', 1),
(18, '2024_04_02_181306_create_appartenirs_table', 1),
(19, '2024_04_02_181341_create_prescrires_table', 1),
(20, '2024_04_02_181412_create_result_p_s_table', 1),
(21, '2024_06_28_042632_create_prive_table', 1),
(22, '2024_06_28_042924_create_caisse_mvts_table', 1);

-- --------------------------------------------------------

--
-- Structure de la table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(191) COLLATE utf8mb4_general_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `patient`
--

DROP TABLE IF EXISTS `patient`;
CREATE TABLE IF NOT EXISTS `patient` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` varchar(191) COLLATE utf8mb4_general_ci NOT NULL,
  `date_naissance` date NOT NULL,
  `lieu` varchar(191) COLLATE utf8mb4_general_ci NOT NULL,
  `contact_urgent` int NOT NULL,
  `profession` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `grp_san` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nom_p` varchar(191) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nom_m` varchar(191) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_user` bigint UNSIGNED NOT NULL,
  `is_delete` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `patient_id_user_foreign` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `patient`
--

INSERT INTO `patient` (`id`, `code`, `date_naissance`, `lieu`, `contact_urgent`, `profession`, `grp_san`, `nom_p`, `nom_m`, `id_user`, `is_delete`, `created_at`, `updated_at`) VALUES
(1, '24-PAT-101', '2009-06-29', 'Mbouda', 651138433, 'Eleve', '0+', 'FOMEKONG Francois', 'FOFOU Beatrice', 2, 0, '2024-06-29 12:38:16', '2024-06-29 12:38:16'),
(5, '24-PAT-102', '2002-07-01', 'Bafoussam', 698371369, 'Ing surface', 'O+', 'PAGANG', 'NONO', 5, 0, '2024-07-08 13:25:18', '2024-07-08 13:25:18');

-- --------------------------------------------------------

--
-- Structure de la table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) COLLATE utf8mb4_general_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_general_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_general_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_general_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB AUTO_INCREMENT=103 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `personnel`
--

DROP TABLE IF EXISTS `personnel`;
CREATE TABLE IF NOT EXISTS `personnel` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `date_embauche` date NOT NULL,
  `matricule` varchar(191) COLLATE utf8mb4_general_ci NOT NULL,
  `id_user` bigint UNSIGNED NOT NULL,
  `is_delete` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `personnel_id_user_foreign` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `personnel`
--

INSERT INTO `personnel` (`id`, `date_embauche`, `matricule`, `id_user`, `is_delete`, `created_at`, `updated_at`) VALUES
(1, '2020-04-17', '24-FMN-101', 1, 0, '2024-04-14 06:11:28', '2024-04-14 06:11:28');

-- --------------------------------------------------------

--
-- Structure de la table `prescrire`
--

DROP TABLE IF EXISTS `prescrire`;
CREATE TABLE IF NOT EXISTS `prescrire` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `dose` varchar(191) COLLATE utf8mb4_general_ci NOT NULL,
  `prise` varchar(191) COLLATE utf8mb4_general_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `medicament` varchar(191) COLLATE utf8mb4_general_ci NOT NULL,
  `id_consul` bigint UNSIGNED NOT NULL,
  `id_pat` bigint UNSIGNED NOT NULL,
  `id_pers` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `prescrire_id_consul_foreign` (`id_consul`),
  KEY `prescrire_id_pers_foreign` (`id_pers`),
  KEY `prescrire_id_pat_foreign` (`id_pat`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `prescrire`
--

INSERT INTO `prescrire` (`id`, `dose`, `prise`, `status`, `medicament`, `id_consul`, `id_pat`, `id_pers`, `created_at`, `updated_at`) VALUES
(1, 'eerr', 'reree', 0, 'PARA', 2, 1, 1, '2024-06-29 15:59:17', '2024-06-29 15:59:17'),
(2, 'gfgg', 'gff', 0, 'METRO', 2, 1, 1, '2024-06-29 15:59:17', '2024-06-29 15:59:17'),
(3, '2 semaines', '1 comprimé par jour', 0, 'Levothyrox® 50 mcg', 2, 1, 1, '2024-06-29 19:44:52', '2024-06-29 19:44:52'),
(4, 'puis 4 comprimés à 8h, 24h, 36h, 48h et 60h', '4 comprimés à la 1ère prise', 0, 'Arthémether', 2, 1, 1, '2024-06-29 19:44:52', '2024-06-29 19:44:52'),
(5, '2 fois par jour', '10 jours', 0, 'Ciprofloxacine 500 mg', 2, 1, 1, '2024-06-29 19:44:52', '2024-06-29 19:44:52');

-- --------------------------------------------------------

--
-- Structure de la table `prive`
--

DROP TABLE IF EXISTS `prive`;
CREATE TABLE IF NOT EXISTS `prive` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_user` int NOT NULL,
  `pass` varchar(191) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `prive`
--

INSERT INTO `prive` (`id`, `id_user`, `pass`, `created_at`, `updated_at`) VALUES
(1, 2, 'nqPVY#@0', '2024-06-29 12:38:16', '2024-06-29 12:38:16'),
(2, 5, 'R$gmr%0l', '2024-07-08 13:25:18', '2024-07-08 13:25:18');

-- --------------------------------------------------------

--
-- Structure de la table `rendez_vous`
--

DROP TABLE IF EXISTS `rendez_vous`;
CREATE TABLE IF NOT EXISTS `rendez_vous` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `date_r` date NOT NULL,
  `time_r` time DEFAULT NULL,
  `motif_r` varchar(191) COLLATE utf8mb4_general_ci NOT NULL,
  `notes` varchar(191) COLLATE utf8mb4_general_ci NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_general_ci NOT NULL,
  `id_cons` bigint DEFAULT NULL,
  `is_delete` tinyint(1) NOT NULL DEFAULT '0',
  `id_pat` bigint UNSIGNED NOT NULL,
  `id_pers` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rendez_vous_id_pat_foreign` (`id_pat`),
  KEY `rendez_vous_id_pers_foreign` (`id_pers`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `rendez_vous`
--

INSERT INTO `rendez_vous` (`id`, `date_r`, `time_r`, `motif_r`, `notes`, `status`, `id_cons`, `is_delete`, `id_pat`, `id_pers`, `created_at`, `updated_at`) VALUES
(1, '2024-07-29', '15:00:00', 'Suivi', 'ssuivis du traitement', 'Réalisé', 2, 0, 1, 1, '2024-06-29 15:59:10', '2024-07-05 03:55:05'),
(2, '2024-07-15', '12:10:00', 'Consultation', 'J\'ai mal aux yeux', 'Reporté', NULL, 0, 1, 1, '2024-07-05 19:27:07', '2024-07-06 12:03:07');

-- --------------------------------------------------------

--
-- Structure de la table `resultat`
--

DROP TABLE IF EXISTS `resultat`;
CREATE TABLE IF NOT EXISTS `resultat` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `etat_result` varchar(191) COLLATE utf8mb4_general_ci NOT NULL,
  `status` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `resultp`
--

DROP TABLE IF EXISTS `resultp`;
CREATE TABLE IF NOT EXISTS `resultp` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_pat` bigint UNSIGNED NOT NULL,
  `id_pers` bigint UNSIGNED NOT NULL,
  `id_cons` bigint UNSIGNED NOT NULL,
  `exam` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `result_text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `result_image` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `resultp_id_cons_foreign` (`id_cons`),
  KEY `resultp_id_pat_foreign` (`id_pat`),
  KEY `resultp_id_pers_foreign` (`id_pers`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `resultp`
--

INSERT INTO `resultp` (`id`, `id_pat`, `id_pers`, `id_cons`, `exam`, `result_text`, `result_image`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 2, 'WIDAL', 'Résultat positif : Les titres d\'anticorps anti-O (somatiques) et anti-H (flagellaires) de Salmonella typhi sont élevés, par exemple anti-O ≥ 1/160 et anti-H ≥ 1/320, indiquant une infection récente ou en cours.', NULL, '2024-06-29 14:58:05', '2024-06-29 19:15:17'),
(2, 1, 1, 2, 'TFS', 'TSH (Thyréostimuline) : 4,2 mUI/L (Valeurs de référence : 0,4 - 4,0 mUI/L)\nT4 libre : 12,5 pmol/L (Valeurs de référence : 10,0 - 25,0 pmol/L)\nT3 libre : 3,8 pmol/L (Valeurs de référence : 3,1 - 6,8 pmol/L)', NULL, '2024-06-29 14:58:05', '2024-06-29 14:58:05'),
(3, 1, 1, 2, 'Hémoculture', 'Résultat positif : La culture bactérienne a permis d\'isoler Salmonella typhi. Le nombre de colonies bactériennes peut être comptabilisé (par exemple, 10^3 UFC/mL) pour évaluer la concentration de l\'infection.', NULL, '2024-06-29 19:15:17', '2024-06-29 19:15:17'),
(4, 1, 1, 2, 'Goutte Epaisse', 'Résultat positif : Le frottis sanguin ou la goutte épaisse ont permis d\'identifier des formes asexuées (trophozoïtes, schizontes) et/ou sexuées (gamétocytes) des parasites du paludisme, avec une parasitémie évaluée à X parasites/µL de sang.', NULL, '2024-06-29 19:15:17', '2024-06-29 19:15:17'),
(5, 1, 1, 2, 'Text Paludisme', 'Résultat positif : Le test a détecté la présence d\'antigènes spécifiques aux parasites du paludisme, tels que la protéine HRP2 (pour Plasmodium falciparum) ou pLDH (pour les autres espèces de Plasmodium).', NULL, '2024-06-29 19:15:17', '2024-06-29 19:15:17'),
(6, 1, 1, 3, 'WIDAL', 'positif', NULL, '2024-07-07 11:53:55', '2024-07-07 11:53:55');

-- --------------------------------------------------------

--
-- Structure de la table `service`
--

DROP TABLE IF EXISTS `service`;
CREATE TABLE IF NOT EXISTS `service` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `libelle` varchar(191) COLLATE utf8mb4_general_ci NOT NULL,
  `status` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `service`
--

INSERT INTO `service` (`id`, `libelle`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Accueil', 0, '2024-04-14 12:38:18', '2024-07-07 17:09:58'),
(2, 'Consultation', 1, '2024-04-14 12:38:18', '2024-04-14 12:38:18'),
(3, 'Medecine', 0, '2024-04-14 12:38:18', '2024-04-14 12:38:18'),
(4, 'Laboratoire', 0, '2024-04-14 12:38:18', '2024-04-14 12:38:18'),
(5, 'Chirurgie', 0, '2024-04-14 12:38:18', '2024-04-14 12:38:18'),
(6, 'Maternite', 0, '2024-04-14 12:38:18', '2024-04-14 12:38:18'),
(7, 'ORL', 0, '2024-04-14 12:38:18', '2024-04-14 12:38:18'),
(8, 'Administration', 0, '2024-07-07 11:54:40', '2024-07-07 11:54:47');

-- --------------------------------------------------------

--
-- Structure de la table `soin`
--

DROP TABLE IF EXISTS `soin`;
CREATE TABLE IF NOT EXISTS `soin` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `libelle` varchar(191) COLLATE utf8mb4_general_ci NOT NULL,
  `cout` decimal(8,2) NOT NULL,
  `traitement` varchar(191) COLLATE utf8mb4_general_ci NOT NULL,
  `status` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `transfert`
--

DROP TABLE IF EXISTS `transfert`;
CREATE TABLE IF NOT EXISTS `transfert` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `date_envoi` date NOT NULL,
  `date_recu` date DEFAULT NULL,
  `etat_transf` varchar(191) COLLATE utf8mb4_general_ci NOT NULL,
  `motif` varchar(191) COLLATE utf8mb4_general_ci NOT NULL,
  `id_pat` bigint UNSIGNED NOT NULL,
  `id_pers` bigint UNSIGNED NOT NULL,
  `id_pers_r` int DEFAULT NULL,
  `id_cons` tinyint(1) DEFAULT NULL,
  `etat_caisse` tinyint(1) NOT NULL DEFAULT '0',
  `num_caisse` varchar(8) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `id_ser` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transfert_id_pat_foreign` (`id_pat`),
  KEY `transfert_id_pers_foreign` (`id_pers`),
  KEY `transfert_id_ser_foreign` (`id_ser`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `transfert`
--

INSERT INTO `transfert` (`id`, `date_envoi`, `date_recu`, `etat_transf`, `motif`, `id_pat`, `id_pers`, `id_pers_r`, `id_cons`, `etat_caisse`, `num_caisse`, `status`, `id_ser`, `created_at`, `updated_at`) VALUES
(1, '2024-06-29', '2024-06-29', 'Reçu', 'Maux de tete et autres', 1, 1, NULL, NULL, 1, NULL, 0, 1, '2024-06-29 13:07:39', '2024-06-29 14:34:30'),
(2, '2024-06-29', '2024-06-29', 'Reçu', 'Hémoculture pour isoler Salmonella typhi,\r\nSérologie : test de Widal,\r\nFrottis sanguin et goutte épaisse,\r\nTest de diagnostic rapide du paludisme,', 1, 1, 1, 2, 1, NULL, 0, 4, '2024-06-29 14:34:30', '2024-06-29 17:57:14'),
(3, '2024-07-07', '2024-07-07', 'Reçu', 'tete', 1, 1, 1, NULL, 1, NULL, 0, 2, '2024-07-07 11:42:45', '2024-07-07 11:47:45'),
(4, '2024-07-07', '2024-07-07', 'Reçu', 'asasasas', 1, 1, 1, 3, 1, NULL, 0, 4, '2024-07-07 11:47:45', '2024-07-07 11:53:55'),
(5, '2024-07-07', '2024-07-09', 'Reçu', 'electrophorese', 1, 1, 1, NULL, 1, '00005', 0, 4, '2024-07-07 17:51:46', '2024-07-09 12:25:14'),
(6, '2024-07-09', NULL, 'Envoyé', 'nez qui coule', 5, 1, NULL, NULL, 1, '00007', 0, 7, '2024-07-09 12:00:45', '2024-07-09 13:33:52'),
(7, '2024-07-09', NULL, 'Envoyé', 'echo', 1, 1, NULL, 4, 1, '00008', 0, 4, '2024-07-09 12:25:14', '2024-07-09 13:50:01'),
(8, '2024-07-09', NULL, 'Envoyé', 'TETE', 5, 1, NULL, NULL, 1, '00009', 0, 3, '2024-07-09 14:53:50', '2024-07-09 14:54:46'),
(9, '2024-07-09', NULL, 'Envoyé', 'TETETTT', 5, 1, NULL, NULL, 1, '00010', 0, 3, '2024-07-09 14:55:49', '2024-07-09 14:56:18'),
(10, '2024-07-09', NULL, 'Envoyé', 'ert', 5, 1, NULL, NULL, 1, '00011', 0, 3, '2024-07-09 15:02:30', '2024-07-09 15:03:20'),
(11, '2024-07-09', NULL, 'Envoyé', 'wwr', 5, 1, NULL, NULL, 1, '00012', 0, 3, '2024-07-09 15:04:48', '2024-07-09 15:05:19');

-- --------------------------------------------------------

--
-- Structure de la table `type_users`
--

DROP TABLE IF EXISTS `type_users`;
CREATE TABLE IF NOT EXISTS `type_users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `libelle` varchar(191) COLLATE utf8mb4_general_ci NOT NULL,
  `role` varchar(191) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `type_users`
--

INSERT INTO `type_users` (`id`, `libelle`, `role`, `created_at`, `updated_at`) VALUES
(1, 'Admin', '1011111001111101', '2024-04-06 20:32:56', '2024-04-06 20:37:14'),
(2, 'Directeur', '0100000110000011', '2024-04-06 20:38:58', '2024-04-06 20:38:58'),
(3, 'Médecin', '1100000000000011', '2024-04-06 20:59:25', '2024-04-06 20:59:25'),
(4, 'Infirmier', '0011111111111100', '2024-04-14 05:01:48', '2024-04-14 05:05:35'),
(5, 'Laborantin', '0011100000011100', '2024-04-15 08:46:03', '2024-04-15 08:46:03'),
(6, 'Patient', '1111100000011111', '2024-04-15 08:46:49', '2024-04-15 08:46:49'),
(7, 'Secretaire M', '1110101111101011', '2024-04-15 08:46:49', '2024-04-15 08:46:49'),
(8, 'Caissier(ère)', '0100111110111011', '2024-04-14 07:11:28', '2024-04-06 21:37:14');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(191) COLLATE utf8mb4_general_ci NOT NULL,
  `prenom` varchar(191) COLLATE utf8mb4_general_ci NOT NULL,
  `telephone` int NOT NULL,
  `adresse` varchar(191) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_general_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `sit_mat` varchar(191) COLLATE utf8mb4_general_ci NOT NULL,
  `sexe` varchar(191) COLLATE utf8mb4_general_ci NOT NULL,
  `profil` varchar(191) COLLATE utf8mb4_general_ci NOT NULL,
  `is_delete` tinyint(1) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_type_user` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_id_type_user_foreign` (`id_type_user`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `nom`, `prenom`, `telephone`, `adresse`, `email`, `email_verified_at`, `password`, `status`, `sit_mat`, `sexe`, `profil`, `is_delete`, `remember_token`, `id_type_user`, `created_at`, `updated_at`) VALUES
(1, 'FOMEKONG TATONG', 'Alphred', 651138433, 'Mbouda', 'alphredtatong@gmail.com', NULL, '$2y$12$5BbiyGan.4DgVr1e6vKMhOAoV68xMWOEvjJBy7aD9cBZ3D9yVNvhy', 0, 'Célibataire', 'M', '24-FMN-101.PNG', 0, 'pTWDQKinv9jq33tYVFsx9gzeH50R0C', 1, '2024-04-14 06:11:28', '2024-06-28 22:18:41'),
(2, 'TCHINDA FOMEKONG', 'Ange Francis', 674261088, 'Mbouda', 'alphredftatong@gmail.com', NULL, '$2y$12$zKPdWVKnBwa2HV5ZSeui5.PMlQ1Z1XPo/Bp7Zbgw4B1N3MRdxxeRq', 0, 'Célibataire', 'M', '24-PAT-101.jpg', 0, 'tzTtgYJPGdkItdY5TO00cjvjTgZ1Iz', 6, '2024-06-29 12:38:16', '2024-07-07 12:01:50'),
(5, 'YOUKOUJIO', 'Guy Borel', 698371369, 'Baf', 'borelyoukoujio@gmail.com', NULL, '$2y$12$0sQHj2ulU.6SH6anJtjB6uXeRQi4xk7HNUlWoXhOncQAiMJxIcqIm', 0, 'Marié', 'M', '24-PAT-102.png', 0, NULL, 6, '2024-07-08 13:25:17', '2024-07-08 13:25:17');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `appartenir`
--
ALTER TABLE `appartenir`
  ADD CONSTRAINT `appartenir_id_per_foreign` FOREIGN KEY (`id_per`) REFERENCES `personnel` (`id`),
  ADD CONSTRAINT `appartenir_id_ser_foreign` FOREIGN KEY (`id_ser`) REFERENCES `service` (`id`);

--
-- Contraintes pour la table `caisse`
--
ALTER TABLE `caisse`
  ADD CONSTRAINT `caisse_id_pat_foreign` FOREIGN KEY (`id_pat`) REFERENCES `patient` (`id`),
  ADD CONSTRAINT `caisse_id_pers_foreign` FOREIGN KEY (`id_pers`) REFERENCES `personnel` (`id`);

--
-- Contraintes pour la table `consultation`
--
ALTER TABLE `consultation`
  ADD CONSTRAINT `consultation_id_pat_foreign` FOREIGN KEY (`id_pat`) REFERENCES `patient` (`id`),
  ADD CONSTRAINT `consultation_id_pers_foreign` FOREIGN KEY (`id_pers`) REFERENCES `personnel` (`id`);

--
-- Contraintes pour la table `medicament`
--
ALTER TABLE `medicament`
  ADD CONSTRAINT `medicament_id_cat_foreign` FOREIGN KEY (`id_cat`) REFERENCES `categories` (`id`);

--
-- Contraintes pour la table `patient`
--
ALTER TABLE `patient`
  ADD CONSTRAINT `patient_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `personnel`
--
ALTER TABLE `personnel`
  ADD CONSTRAINT `personnel_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `prescrire`
--
ALTER TABLE `prescrire`
  ADD CONSTRAINT `prescrire_id_consul_foreign` FOREIGN KEY (`id_consul`) REFERENCES `consultation` (`id`),
  ADD CONSTRAINT `prescrire_id_pat_foreign` FOREIGN KEY (`id_pat`) REFERENCES `patient` (`id`),
  ADD CONSTRAINT `prescrire_id_pers_foreign` FOREIGN KEY (`id_pers`) REFERENCES `personnel` (`id`);

--
-- Contraintes pour la table `rendez_vous`
--
ALTER TABLE `rendez_vous`
  ADD CONSTRAINT `rendez_vous_id_pat_foreign` FOREIGN KEY (`id_pat`) REFERENCES `patient` (`id`),
  ADD CONSTRAINT `rendez_vous_id_pers_foreign` FOREIGN KEY (`id_pers`) REFERENCES `personnel` (`id`);

--
-- Contraintes pour la table `resultp`
--
ALTER TABLE `resultp`
  ADD CONSTRAINT `resultp_id_cons_foreign` FOREIGN KEY (`id_cons`) REFERENCES `consultation` (`id`),
  ADD CONSTRAINT `resultp_id_pat_foreign` FOREIGN KEY (`id_pat`) REFERENCES `patient` (`id`),
  ADD CONSTRAINT `resultp_id_pers_foreign` FOREIGN KEY (`id_pers`) REFERENCES `personnel` (`id`);

--
-- Contraintes pour la table `transfert`
--
ALTER TABLE `transfert`
  ADD CONSTRAINT `transfert_id_pat_foreign` FOREIGN KEY (`id_pat`) REFERENCES `patient` (`id`),
  ADD CONSTRAINT `transfert_id_pers_foreign` FOREIGN KEY (`id_pers`) REFERENCES `personnel` (`id`),
  ADD CONSTRAINT `transfert_id_ser_foreign` FOREIGN KEY (`id_ser`) REFERENCES `service` (`id`);

--
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_id_type_user_foreign` FOREIGN KEY (`id_type_user`) REFERENCES `type_users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
