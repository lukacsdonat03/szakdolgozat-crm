-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1:3306
-- Létrehozás ideje: 2025. Okt 16. 18:08
-- Kiszolgáló verziója: 9.1.0
-- PHP verzió: 8.2.26

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
-- Tábla szerkezet ehhez a táblához `user_positions`
--

DROP TABLE IF EXISTS `user_positions`;
CREATE TABLE IF NOT EXISTS `user_positions` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT 'Azonosító',
  `name` varchar(128) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Megnevezés',
  `rights` tinyint NOT NULL DEFAULT '0' COMMENT 'Jogosultság',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `user_positions`
--

INSERT INTO `user_positions` (`id`, `name`, `rights`) VALUES
(1, 'Cégvezető', 1),
(2, 'Adminisztrátor', 1);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `user_profiles`
--

DROP TABLE IF EXISTS `user_profiles`;
CREATE TABLE IF NOT EXISTS `user_profiles` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT 'Azonosító',
  `user_id` int NOT NULL COMMENT 'Felhasználó',
  `name` varchar(128) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Név',
  `phone` varchar(32) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'Telefonszám',
  `position_id` int DEFAULT NULL COMMENT 'Beosztés',
  PRIMARY KEY (`id`),
  KEY `FK_profiles_user` (`user_id`),
  KEY `FK_profiles_positions` (`position_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `user_profiles`
--

INSERT INTO `user_profiles` (`id`, `user_id`, `name`, `phone`, `position_id`) VALUES
(1, 2, 'Admin1', '06201234567', 2),
(2, 3, 'Teszt Elek', '06207654321', 1);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `user_users`
--

DROP TABLE IF EXISTS `user_users`;
CREATE TABLE IF NOT EXISTS `user_users` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT 'Azonosító',
  `username` varchar(128) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Felhasználónév',
  `email` varchar(128) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'E-mail cím',
  `password` varchar(60) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Jelszó',
  `registration_date` datetime DEFAULT NULL COMMENT 'Regisztráció dátuma',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Státusz',
  `token` varchar(32) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UQ_users_username` (`username`),
  UNIQUE KEY `UQ_users_email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `user_users`
--

INSERT INTO `user_users` (`id`, `username`, `email`, `password`, `registration_date`, `status`, `token`) VALUES
(2, 'admin1', 'admin@tempmail.com', '$2y$10$P9KPcmoyOgOSTDykg0ocKeJdtfCJGW/dbZ041.i/WOw7tcWTBw8/W', '2025-10-06 19:11:39', 1, 'ee0d82a6eff93dd35bdfc15c01f5d6ab'),
(3, 'teszt', 'lukacsdonatxxx@gmail.com', '$2y$10$iUfoe9CmkTzFjBkZeeEPQu9Cjx2Y..flfb.NzA9unSXs9H4m7HUMC', '2025-10-12 19:52:52', 1, '475000e14ec576a7f329c65003853806');

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD CONSTRAINT `FK_profiles_positions` FOREIGN KEY (`position_id`) REFERENCES `user_positions` (`id`),
  ADD CONSTRAINT `FK_profiles_user` FOREIGN KEY (`user_id`) REFERENCES `user_users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
