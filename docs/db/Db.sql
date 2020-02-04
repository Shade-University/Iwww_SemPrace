-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Počítač: db
-- Vytvořeno: Pon 03. úno 2020, 19:11
-- Verze serveru: 8.0.19
-- Verze PHP: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `Db`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `Grade`
--

CREATE TABLE `Grade` (
  `id` int NOT NULL,
  `grade` varchar(1) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `date_created` date NOT NULL,
  `type` varchar(50) COLLATE utf8_czech_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `Room`
--

CREATE TABLE `Room` (
  `id` int NOT NULL,
  `name` varchar(250) COLLATE utf8_czech_ci NOT NULL,
  `capacity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `Schedule`
--

CREATE TABLE `Schedule` (
  `id` int NOT NULL,
  `day` varchar(50) COLLATE utf8_czech_ci NOT NULL,
  `lesson_start` date NOT NULL,
  `lesson_end` date NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `id_subject` int NOT NULL,
  `id_room` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `Schedule-User`
--

CREATE TABLE `Schedule-User` (
  `id_schedule` int NOT NULL,
  `id_user` int NOT NULL,
  `id_grade` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `Subject`
--

CREATE TABLE `Subject` (
  `id` int NOT NULL,
  `name` varchar(250) COLLATE utf8_czech_ci NOT NULL,
  `description` varchar(500) COLLATE utf8_czech_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `User`
--

CREATE TABLE `User` (
  `id` int NOT NULL,
  `firstname` varchar(250) COLLATE utf8_czech_ci NOT NULL,
  `lastname` varchar(250) COLLATE utf8_czech_ci NOT NULL,
  `email` varchar(250) COLLATE utf8_czech_ci NOT NULL,
  `password` varchar(50) COLLATE utf8_czech_ci NOT NULL,
  `role` varchar(50) COLLATE utf8_czech_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Klíče pro exportované tabulky
--

--
-- Klíče pro tabulku `Grade`
--
ALTER TABLE `Grade`
  ADD PRIMARY KEY (`id`);

--
-- Klíče pro tabulku `Room`
--
ALTER TABLE `Room`
  ADD PRIMARY KEY (`id`);

--
-- Klíče pro tabulku `Schedule`
--
ALTER TABLE `Schedule`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_schedule_room` (`id_room`),
  ADD KEY `fk_schedule_subject` (`id_subject`);

--
-- Klíče pro tabulku `Schedule-User`
--
ALTER TABLE `Schedule-User`
  ADD KEY `fk_schedule_user` (`id_user`),
  ADD KEY `fk_schedule_schedule` (`id_schedule`),
  ADD KEY `fk_schedule_grade` (`id_grade`);

--
-- Klíče pro tabulku `Subject`
--
ALTER TABLE `Subject`
  ADD PRIMARY KEY (`id`);

--
-- Klíče pro tabulku `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`id`);

--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `Schedule`
--
ALTER TABLE `Schedule`
  ADD CONSTRAINT `fk_schedule_room` FOREIGN KEY (`id_room`) REFERENCES `Room` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_schedule_subject` FOREIGN KEY (`id_subject`) REFERENCES `Subject` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Omezení pro tabulku `Schedule-User`
--
ALTER TABLE `Schedule-User`
  ADD CONSTRAINT `fk_schedule_grade` FOREIGN KEY (`id_grade`) REFERENCES `Grade` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_schedule_schedule` FOREIGN KEY (`id_schedule`) REFERENCES `Schedule` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_schedule_user` FOREIGN KEY (`id_user`) REFERENCES `User` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
