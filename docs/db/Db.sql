-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Počítač: db
-- Vytvořeno: Pon 03. úno 2020, 11:58
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
-- Struktura tabulky `Administrator`
--

CREATE TABLE `Administrator` (
  `id` int NOT NULL,
  `username` varchar(250) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `password` varchar(250) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `description` varchar(250) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `date_created` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `Grade`
--

CREATE TABLE `Grade` (
  `id` int NOT NULL,
  `id_teacher` int NOT NULL,
  `id_student` varchar(7) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `id_subject` int NOT NULL,
  `grade` varchar(1) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `date_evaluation` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_czech_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `Student`
--

CREATE TABLE `Student` (
  `id` varchar(7) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `firstname` varchar(250) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `lastname` varchar(250) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `study_field` varchar(250) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `date_birth` date NOT NULL,
  `password` varchar(50) COLLATE utf8_czech_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `Subject`
--

CREATE TABLE `Subject` (
  `id` int NOT NULL,
  `name` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `shortcut` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `description` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `Subject-Student`
--

CREATE TABLE `Subject-Student` (
  `id_subject` int NOT NULL,
  `id_student` varchar(7) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `Teacher`
--

CREATE TABLE `Teacher` (
  `id` int NOT NULL,
  `firstname` varchar(250) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `lastname` varchar(250) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `title` varchar(20) CHARACTER SET utf8 COLLATE utf8_czech_ci DEFAULT NULL,
  `institute` varchar(250) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_czech_ci NOT NULL,
  `password` varchar(50) COLLATE utf8_czech_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `Teacher-Subject`
--

CREATE TABLE `Teacher-Subject` (
  `id_teacher` int NOT NULL,
  `id_subject` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Klíče pro exportované tabulky
--

--
-- Klíče pro tabulku `Administrator`
--
ALTER TABLE `Administrator`
  ADD PRIMARY KEY (`id`);

--
-- Klíče pro tabulku `Grade`
--
ALTER TABLE `Grade`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_grade_teacher` (`id_teacher`),
  ADD KEY `fk_grade_student` (`id_student`),
  ADD KEY `fk_grade_subject` (`id_subject`);

--
-- Klíče pro tabulku `Student`
--
ALTER TABLE `Student`
  ADD PRIMARY KEY (`id`);

--
-- Klíče pro tabulku `Subject`
--
ALTER TABLE `Subject`
  ADD PRIMARY KEY (`id`);

--
-- Klíče pro tabulku `Subject-Student`
--
ALTER TABLE `Subject-Student`
  ADD KEY `fk_subject_student_subject` (`id_subject`),
  ADD KEY `fk_subject_student_student` (`id_student`);

--
-- Klíče pro tabulku `Teacher`
--
ALTER TABLE `Teacher`
  ADD PRIMARY KEY (`id`);

--
-- Klíče pro tabulku `Teacher-Subject`
--
ALTER TABLE `Teacher-Subject`
  ADD KEY `fk_teacher_subject_teacher` (`id_teacher`),
  ADD KEY `fk_teacher_subject_subject` (`id_subject`);

--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `Grade`
--
ALTER TABLE `Grade`
  ADD CONSTRAINT `fk_grade_student` FOREIGN KEY (`id_student`) REFERENCES `Student` (`id`),
  ADD CONSTRAINT `fk_grade_subject` FOREIGN KEY (`id_subject`) REFERENCES `Subject` (`id`),
  ADD CONSTRAINT `fk_grade_teacher` FOREIGN KEY (`id_teacher`) REFERENCES `Teacher` (`id`);

--
-- Omezení pro tabulku `Subject-Student`
--
ALTER TABLE `Subject-Student`
  ADD CONSTRAINT `fk_subject_student_student` FOREIGN KEY (`id_student`) REFERENCES `Student` (`id`),
  ADD CONSTRAINT `fk_subject_student_subject` FOREIGN KEY (`id_subject`) REFERENCES `Subject` (`id`);

--
-- Omezení pro tabulku `Teacher-Subject`
--
ALTER TABLE `Teacher-Subject`
  ADD CONSTRAINT `fk_teacher_subject_subject` FOREIGN KEY (`id_subject`) REFERENCES `Subject` (`id`),
  ADD CONSTRAINT `fk_teacher_subject_teacher` FOREIGN KEY (`id_teacher`) REFERENCES `Teacher` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
