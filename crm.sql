-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1:3306
-- Létrehozás ideje: 2026. Ápr 04. 14:33
-- Kiszolgáló verziója: 8.4.7
-- PHP verzió: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `crm`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `client_clients`
--

DROP TABLE IF EXISTS `client_clients`;
CREATE TABLE IF NOT EXISTS `client_clients` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT 'Azonosító',
  `name` varchar(126) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Név',
  `company` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Vállalat neve',
  `email` varchar(126) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'E-mail cím',
  `phone` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Telefonszám',
  `tax_number` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'Adószám',
  `address` varchar(126) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'Cím',
  `notes` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'Megjegyzés',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `client_clients`
--

INSERT INTO `client_clients` (`id`, `name`, `company`, `email`, `phone`, `tax_number`, `address`, `notes`, `is_deleted`) VALUES
(1, 'Teszt Elek', 'Telkom Kft.', 'info@telkom.hu', '+36201234567', '12312312-3-13', 'Budapest, Telkom iroda', 'Lorem ipsum dolor sit amet coseqetor', 0),
(2, 'Nagy Barnabás', 'Digit-Arcade Kft.', 'b.nagy@digitarcade.hu', '+36209996543', '87653210-0-22', '4025 Debrecen, Piac utca 12.', NULL, 0),
(3, 'Szabó Eszter', 'Pannon-Logisztix Kft.', 'eszter.szabo@panlog.hu', '+36705554433', '11223344-2-13', '9022 Győr, Dunapart rezidencia 2.', 'Fontos partner, havi support szerződéssel.', 0),
(4, 'Varga Miklós', 'Soft-Core Solutions', 'm.varga@softcore.hu', '+3612223344_', '55667788-3-41', '1037 Budapest, Montevideo utca 9.', 'Csak angol nyelvű dokumentációt kérnek.', 0),
(5, 'Horváth Zalán', 'Cloud-Bázis Bt.', 'zalan@cloudbazis.hu', '+36304448899', '99887766-1-19', '6720 Szeged, Tisza Lajos krt. 45.', 'Induló startup, kedvezményes konstrukcióban.', 1),
(6, 'Horváth Zalán', 'Cloud-Bázis Bt.', 'zalan@cloudbazis.hu', '+36304448899', '99887766-1-19', '6720 Szeged, Tisza Lajos krt. 45.', 'Induló startup, kedvezményes konstrukcióban.', 0);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `messages_message`
--

DROP TABLE IF EXISTS `messages_message`;
CREATE TABLE IF NOT EXISTS `messages_message` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT 'Azonosító',
  `sender_id` int NOT NULL COMMENT 'Küldő',
  `reply_to_id` int DEFAULT NULL COMMENT 'Válasz (opcionális)',
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Üzenet',
  `created_at` datetime DEFAULT NULL COMMENT 'Küldve',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Törölve',
  PRIMARY KEY (`id`),
  KEY `fk_message_user_sender` (`sender_id`),
  KEY `fk_message_message` (`reply_to_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `messages_message`
--

INSERT INTO `messages_message` (`id`, `sender_id`, `reply_to_id`, `content`, `created_at`, `is_deleted`) VALUES
(1, 2, NULL, 'Sziasztok!', '2026-03-25 19:51:36', 0),
(2, 2, 1, 'Válasz', '2026-04-04 16:28:49', 0);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `project_projects`
--

DROP TABLE IF EXISTS `project_projects`;
CREATE TABLE IF NOT EXISTS `project_projects` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT 'Azonosító',
  `client_id` int NOT NULL COMMENT 'Ügyfél',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Név',
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci COMMENT 'Leírás',
  `status_id` int DEFAULT NULL COMMENT 'Státusz',
  `priority` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Prioritás',
  `start_date` date NOT NULL COMMENT 'Projekt kezdete',
  `deadline` date NOT NULL COMMENT 'Határidő',
  `budget` float DEFAULT NULL COMMENT 'Költségvetési keret',
  `created_by` int DEFAULT NULL COMMENT 'Létrehozta',
  `created_at` datetime DEFAULT NULL COMMENT 'Létrehozva',
  `updated_at` datetime DEFAULT NULL COMMENT 'Módosítva',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_project_x_clients` (`client_id`),
  KEY `fk_project_x_statuses` (`status_id`),
  KEY `fk_project_x_users` (`created_by`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `project_projects`
--

INSERT INTO `project_projects` (`id`, `client_id`, `name`, `description`, `status_id`, `priority`, `start_date`, `deadline`, `budget`, `created_by`, `created_at`, `updated_at`, `is_deleted`) VALUES
(1, 1, 'CRM Migráció v2', '<h3>Adatb&aacute;zis k&ouml;lt&ouml;ztet&eacute;s</h3>\r\n\r\n<ul>\r\n	<li>SQL export&aacute;l&aacute;sa</li>\r\n	<li>Mezők megfeleltet&eacute;se</li>\r\n	<li><strong>Valid&aacute;l&aacute;s</strong></li>\r\n</ul>\r\n\r\n<p>&Uuml;gyelni kell a karakterk&oacute;dol&aacute;sra!</p>\r\n', 2, 2, '2026-02-20', '2026-04-05', 1200000, 2, '2026-02-22 15:57:37', '2026-04-04 16:32:33', 0),
(2, 5, 'Webshop Integráció', '<p>Az &uuml;gyf&eacute;l szeretn&eacute; a&nbsp;<em>webshopj&aacute;t</em>&nbsp;&ouml;sszek&ouml;tni a megl&eacute;vő rakt&aacute;rk&eacute;szlettel.</p>\r\n', 1, 1, '2026-03-01', '2026-05-10', 800000, 8, '2026-02-22 16:05:21', '2026-02-22 16:05:21', 0),
(3, 3, 'API Debugging', '<p><strong>Hiba:</strong> Az API nem ad vissza v&aacute;laszt a logisztikai modulnak.</p>\r\n\r\n<p>S&uuml;rgős jav&iacute;t&aacute;s sz&uuml;ks&eacute;ges a sz&aacute;ml&aacute;z&aacute;s miatt.</p>\r\n', 4, 3, '2026-03-01', '2026-03-10', 300000, 2, '2026-02-22 16:06:32', '2026-02-24 21:28:57', 0),
(4, 2, 'Mobil App Design', '<h1>UI/UX Tervez&eacute;s</h1>\r\n\r\n<p>A projekt jelenleg a felhaszn&aacute;l&oacute;i tesztel&eacute;s f&aacute;zis&aacute;ban van. Sz&iacute;nk&oacute;dok ellenőrz&eacute;se sz&uuml;ks&eacute;ges.</p>\r\n', 3, 0, '2026-02-22', '2026-05-10', 3500000, 8, '2026-02-22 16:07:15', '2026-02-22 16:07:15', 0);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `project_schedules`
--

DROP TABLE IF EXISTS `project_schedules`;
CREATE TABLE IF NOT EXISTS `project_schedules` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT 'Azonosító',
  `task_id` int NOT NULL COMMENT 'Feladat',
  `start_date` datetime NOT NULL COMMENT 'Kezdés',
  `day_spread` smallint UNSIGNED DEFAULT NULL COMMENT 'Napszám',
  PRIMARY KEY (`id`),
  KEY `FK_schedules_tasks` (`task_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `project_schedules`
--

INSERT INTO `project_schedules` (`id`, `task_id`, `start_date`, `day_spread`) VALUES
(1, 1, '2026-02-23 08:00:00', 1),
(2, 2, '2026-02-24 08:00:00', 2),
(3, 3, '2026-03-02 08:00:00', 5),
(4, 4, '2026-03-02 08:00:00', 1),
(5, 5, '2026-03-09 08:00:00', 3),
(6, 6, '2026-03-02 08:00:00', 1);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `project_statuses`
--

DROP TABLE IF EXISTS `project_statuses`;
CREATE TABLE IF NOT EXISTS `project_statuses` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT 'Azonosító',
  `name` varchar(68) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Név',
  `color_code` varchar(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'Szín',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `project_statuses`
--

INSERT INTO `project_statuses` (`id`, `name`, `color_code`) VALUES
(1, 'Új', '#59c02c'),
(2, 'Folyamatban', '#45818e'),
(3, 'Tesztelés alatt', '#ffc107'),
(4, 'Várakoztatva', '#f44336'),
(5, 'Lezárt', '#6aa84f');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `project_tags`
--

DROP TABLE IF EXISTS `project_tags`;
CREATE TABLE IF NOT EXISTS `project_tags` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT 'Azonosító',
  `name` varchar(68) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Név',
  `color_code` varchar(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Szín',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `project_tags`
--

INSERT INTO `project_tags` (`id`, `name`, `color_code`) VALUES
(1, 'Fontos', '#e3bd4b'),
(2, 'Egyeztetés', '#3c78d8'),
(3, 'Support', '#2196f3'),
(4, 'Sürgős', '#cc0000');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `project_tag_relation`
--

DROP TABLE IF EXISTS `project_tag_relation`;
CREATE TABLE IF NOT EXISTS `project_tag_relation` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT 'Azonosító',
  `project_id` int NOT NULL COMMENT 'Projekt',
  `tag_id` int NOT NULL COMMENT 'Tag',
  PRIMARY KEY (`id`),
  KEY `project_id_index` (`project_id`),
  KEY `tag_id_index` (`tag_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `project_tag_relation`
--

INSERT INTO `project_tag_relation` (`id`, `project_id`, `tag_id`) VALUES
(2, 1, 1),
(3, 1, 3),
(4, 2, 2),
(5, 3, 2),
(6, 3, 4),
(7, 4, 2);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `project_tasks`
--

DROP TABLE IF EXISTS `project_tasks`;
CREATE TABLE IF NOT EXISTS `project_tasks` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT 'Azonosító',
  `project_id` int DEFAULT NULL COMMENT 'Projekt',
  `assigned_to` int DEFAULT NULL COMMENT 'Hozzárendelve',
  `title` varchar(126) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Név',
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Leírás',
  `status` tinyint(1) DEFAULT NULL COMMENT 'Státusz',
  `priority` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Prioritás',
  `due_date` datetime DEFAULT NULL COMMENT 'Határidő',
  `estimated_hours` smallint UNSIGNED DEFAULT NULL COMMENT 'Becsült óra',
  `sort_order` smallint UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Sorrend',
  `created_by` int DEFAULT NULL COMMENT 'Létrehozta',
  `created_at` datetime DEFAULT NULL COMMENT 'Létrehozva',
  `updated_at` datetime DEFAULT NULL COMMENT 'Módosítva',
  `completed_at` datetime DEFAULT NULL COMMENT 'Elkészült',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_task_x_project` (`project_id`),
  KEY `fk_task_x_users` (`assigned_to`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `project_tasks`
--

INSERT INTO `project_tasks` (`id`, `project_id`, `assigned_to`, `title`, `description`, `status`, `priority`, `due_date`, `estimated_hours`, `sort_order`, `created_by`, `created_at`, `updated_at`, `completed_at`, `is_deleted`) VALUES
(1, 1, 7, 'Adatbázis mentés', '<p>Biztons&aacute;gi ment&eacute;s k&eacute;sz&iacute;t&eacute;se az <strong>&eacute;les adatb&aacute;zisr&oacute;l</strong> a migr&aacute;ci&oacute; megkezd&eacute;se előtt.</p>\r\n\r\n<p><code>pg_dump -U postgres dbname &gt; backup.sql</code></p>\r\n', 3, 2, '2026-02-28 16:00:00', 2, 0, 8, '2026-02-22 16:31:55', '2026-02-22 16:31:55', '2026-02-22 16:31:55', 0),
(2, 1, 7, 'Szkript futtatása', '<h3>Migr&aacute;ci&oacute;s folyamat</h3>\r\n\r\n<p>Az adatok &aacute;talak&iacute;t&aacute;sa az &uacute;j s&eacute;m&aacute;ra. Kritikus l&eacute;p&eacute;s!</p>\r\n', 1, 3, '2026-02-28 16:00:00', 6, 0, 8, '2026-02-22 16:32:47', '2026-02-22 16:32:47', NULL, 0),
(3, 2, 7, 'API dokumentáció', '<p>Swagger/OpenAPI dokument&aacute;ci&oacute; gener&aacute;l&aacute;sa a <em>Webshop</em> v&eacute;gpontokhoz. Csatoland&oacute; a fejlesztői k&eacute;zik&ouml;nyvh&ouml;z.</p>\r\n', 0, 0, '2026-03-31 16:00:00', 10, 0, 8, '2026-02-22 16:33:41', '2026-02-22 16:33:41', NULL, 0),
(4, 3, 8, 'Log fájlok elemzése', '<p>A szerver logok &aacute;tf&eacute;s&uuml;l&eacute;se a 404-es hib&aacute;k azonos&iacute;t&aacute;sa &eacute;rdek&eacute;ben a logisztikai modulban.</p>\r\n', 1, 2, '2026-02-24 16:00:00', 4, 0, 8, '2026-02-22 16:34:43', '2026-02-22 16:34:43', NULL, 0),
(5, 4, 7, 'UX prototípus', '<ul>\r\n	<li>Főoldal v&aacute;zlat</li>\r\n	<li>Term&eacute;kkatal&oacute;gus n&eacute;zet</li>\r\n	<li><strong>Kos&aacute;r folyamat</strong></li>\r\n</ul>\r\n', 1, 1, '2026-03-31 16:00:00', 15, 0, 8, '2026-02-22 16:35:40', '2026-02-22 16:35:40', NULL, 0),
(6, 2, 9, 'Pénzügyi beszámoló elkészítése', '<p>P&eacute;nz&uuml;gyi besz&aacute;mol&oacute; a projektről</p>\r\n', 0, 1, '2026-03-05 16:00:00', 6, 0, 8, '2026-02-22 16:36:48', '2026-02-22 16:36:48', NULL, 0);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `project_task_messages`
--

DROP TABLE IF EXISTS `project_task_messages`;
CREATE TABLE IF NOT EXISTS `project_task_messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sender_id` int NOT NULL COMMENT 'Küldő',
  `receiver_id` int NOT NULL COMMENT 'Címzett',
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Tartalom',
  `task_id` int NOT NULL COMMENT 'Feladat',
  `created_at` datetime DEFAULT NULL COMMENT 'Léterhozva',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Törölve',
  PRIMARY KEY (`id`),
  KEY `fk_messages_tasks` (`task_id`),
  KEY `fk_messages_sender_user` (`sender_id`),
  KEY `fk_messages_receiver_user` (`receiver_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `project_task_messages`
--

INSERT INTO `project_task_messages` (`id`, `sender_id`, `receiver_id`, `content`, `task_id`, `created_at`, `is_deleted`) VALUES
(1, 7, 2, 'Teszt üzenet', 5, '2026-03-25 19:52:21', 0);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `user_positions`
--

DROP TABLE IF EXISTS `user_positions`;
CREATE TABLE IF NOT EXISTS `user_positions` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT 'Azonosító',
  `name` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Megnevezés',
  `rights` tinyint NOT NULL DEFAULT '0' COMMENT 'Jogosultság',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `user_positions`
--

INSERT INTO `user_positions` (`id`, `name`, `rights`) VALUES
(1, 'Cégvezető', 0),
(2, 'Adminisztrátor', 1),
(3, 'Pénzügy', 2),
(4, 'Munkatárs', 3);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `user_profiles`
--

DROP TABLE IF EXISTS `user_profiles`;
CREATE TABLE IF NOT EXISTS `user_profiles` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT 'Azonosító',
  `user_id` int NOT NULL COMMENT 'Felhasználó',
  `name` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Név',
  `phone` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'Telefonszám',
  `position_id` int DEFAULT NULL COMMENT 'Beosztés',
  PRIMARY KEY (`id`),
  KEY `FK_profiles_positions` (`position_id`),
  KEY `FK_profiles_user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `user_profiles`
--

INSERT INTO `user_profiles` (`id`, `user_id`, `name`, `phone`, `position_id`) VALUES
(1, 2, 'Admin1', '+36112312313', 2),
(4, 7, 'Munkatárs Sándor', '+36201234567', 4),
(5, 8, 'Ceo Cecil', '+36707567777', 1),
(6, 9, 'Pénzügy Páter', '+36201111111', 3);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `user_users`
--

DROP TABLE IF EXISTS `user_users`;
CREATE TABLE IF NOT EXISTS `user_users` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT 'Azonosító',
  `username` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Felhasználónév',
  `email` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'E-mail cím',
  `password` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Jelszó',
  `registration_date` datetime DEFAULT NULL COMMENT 'Regisztráció dátuma',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Státusz',
  `token` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UQ_users_username` (`username`),
  UNIQUE KEY `UQ_users_email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `user_users`
--

INSERT INTO `user_users` (`id`, `username`, `email`, `password`, `registration_date`, `status`, `token`) VALUES
(2, 'admin', 'admin@tempmail.com', '$2y$10$m9HZe8eIriGvN26D8A0FIevihbmEA/UALHVyqLE1UBZdLi01Mup4m', '2025-10-06 19:11:39', 1, 'ee0d82a6eff93dd35bdfc15c01f5d6ab'),
(7, 'munkatars', 'munkatars@crm-light.hu', '$2y$10$5syO5XhST5j9Gq7LLFeMfOOcHT8vIYKsm6Mppg4jU7LBXqaEk0gxK', '2026-02-22 15:36:41', 1, '57e34775cea454bc815d8e8a0be35d5c'),
(8, 'ceo', 'ceo@crm-light.hu', '$2y$10$m9HZe8eIriGvN26D8A0FIevihbmEA/UALHVyqLE1UBZdLi01Mup4m', '2026-02-22 15:38:58', 1, '99d54f43e0e6a072125be65ad4eed2a0'),
(9, 'penzugy', 'penzugy@crm-light.hu', '$2y$10$X/wXFLrpSXD8cj9LGXyHUu0AGWOEVZe6cRJ5JeIURlMgPYNBh8gTG', '2026-02-22 15:48:53', 1, 'f9111ef95bd820fae4cea35e2e7c595e');

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `messages_message`
--
ALTER TABLE `messages_message`
  ADD CONSTRAINT `fk_message_message` FOREIGN KEY (`reply_to_id`) REFERENCES `messages_message` (`id`),
  ADD CONSTRAINT `fk_message_user_sender` FOREIGN KEY (`sender_id`) REFERENCES `user_users` (`id`);

--
-- Megkötések a táblához `project_projects`
--
ALTER TABLE `project_projects`
  ADD CONSTRAINT `fk_project_x_clients` FOREIGN KEY (`client_id`) REFERENCES `client_clients` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_project_x_statuses` FOREIGN KEY (`status_id`) REFERENCES `project_statuses` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_project_x_users` FOREIGN KEY (`created_by`) REFERENCES `user_users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Megkötések a táblához `project_schedules`
--
ALTER TABLE `project_schedules`
  ADD CONSTRAINT `FK_schedules_tasks` FOREIGN KEY (`task_id`) REFERENCES `project_tasks` (`id`);

--
-- Megkötések a táblához `project_tag_relation`
--
ALTER TABLE `project_tag_relation`
  ADD CONSTRAINT `project_tag_relation_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `project_tasks` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `project_tag_relation_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `project_tags` (`id`) ON UPDATE CASCADE;

--
-- Megkötések a táblához `project_tasks`
--
ALTER TABLE `project_tasks`
  ADD CONSTRAINT `fk_task_x_project` FOREIGN KEY (`project_id`) REFERENCES `project_projects` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_task_x_users` FOREIGN KEY (`assigned_to`) REFERENCES `user_users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Megkötések a táblához `project_task_messages`
--
ALTER TABLE `project_task_messages`
  ADD CONSTRAINT `fk_messages_receiver_user` FOREIGN KEY (`receiver_id`) REFERENCES `user_users` (`id`),
  ADD CONSTRAINT `fk_messages_sender_user` FOREIGN KEY (`sender_id`) REFERENCES `user_users` (`id`),
  ADD CONSTRAINT `fk_messages_tasks` FOREIGN KEY (`task_id`) REFERENCES `project_tasks` (`id`);

--
-- Megkötések a táblához `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD CONSTRAINT `FK_profiles_positions` FOREIGN KEY (`position_id`) REFERENCES `user_positions` (`id`),
  ADD CONSTRAINT `FK_profiles_user` FOREIGN KEY (`user_id`) REFERENCES `user_users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
