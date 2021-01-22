-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Počítač: db
-- Vytvořeno: Pát 22. led 2021, 00:32
-- Verze serveru: 8.0.22
-- Verze PHP: 7.4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
                         `type` varchar(50) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `Grade`
--

INSERT INTO `Grade` (`id`, `grade`, `date_created`, `type`) VALUES
(20, 'A', '2021-01-22', 'Math test'),
(21, 'B', '2021-01-22', 'Programming theory'),
(22, 'E', '2021-01-22', 'Html basics'),
(23, 'C', '2021-01-22', 'Interview'),
(24, 'D', '2021-01-22', 'Programming practical test'),
(25, 'F', '2021-01-22', 'Programming data structures'),
(26, 'A', '2021-01-22', 'Programming theory');

-- --------------------------------------------------------

--
-- Struktura tabulky `Room`
--

CREATE TABLE `Room` (
                        `id` int NOT NULL,
                        `name` varchar(250) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
                        `capacity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `Room`
--

INSERT INTO `Room` (`id`, `name`, `capacity`) VALUES
(2, 'Room A', 101),
(3, 'Room B', 15),
(4, 'Room C', 20);

-- --------------------------------------------------------

--
-- Struktura tabulky `Schedule`
--

CREATE TABLE `Schedule` (
                            `id` int NOT NULL,
                            `day` varchar(50) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
                            `lesson_start` time NOT NULL,
                            `lesson_end` time NOT NULL,
                            `id_subject` int NOT NULL,
                            `id_room` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `Schedule`
--

INSERT INTO `Schedule` (`id`, `day`, `lesson_start`, `lesson_end`, `id_subject`, `id_room`) VALUES
(25, 'Monday', '10:00:00', '12:00:00', 23, 2),
(26, 'Thursday', '08:00:00', '10:00:00', 23, 2),
(27, 'Monday', '14:00:00', '16:00:00', 24, 3),
(28, 'Tuesday', '08:00:00', '12:00:00', 25, 4),
(29, 'Tuesday', '12:00:00', '14:00:00', 26, 4),
(30, 'Wednesday', '10:00:00', '12:00:00', 24, 3),
(31, 'Monday', '16:00:00', '18:00:00', 23, 2);

-- --------------------------------------------------------

--
-- Struktura tabulky `Schedule-User`
--

CREATE TABLE `Schedule-User` (
                                 `id` int NOT NULL,
                                 `id_schedule` int NOT NULL,
                                 `id_user` int NOT NULL,
                                 `id_grade` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `Schedule-User`
--

INSERT INTO `Schedule-User` (`id`, `id_schedule`, `id_user`, `id_grade`) VALUES
(51, 25, 101, 20),
(52, 25, 101, 23),
(53, 25, 102, 25),
(54, 25, 103, NULL),
(55, 26, 102, 20),
(57, 26, 102, 20),
(58, 26, 102, 20),
(59, 26, 103, 22),
(60, 27, 101, 20),
(62, 28, 103, 21),
(63, 28, 103, 23),
(64, 27, 101, 26),
(65, 26, 101, NULL),
(66, 28, 101, NULL),
(67, 30, 101, NULL),
(68, 29, 101, NULL),
(69, 31, 101, NULL);

-- --------------------------------------------------------

--
-- Struktura tabulky `Subject`
--

CREATE TABLE `Subject` (
                           `id` int NOT NULL,
                           `name` varchar(250) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
                           `description` varchar(500) CHARACTER SET utf8 COLLATE utf8_czech_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `Subject`
--

INSERT INTO `Subject` (`id`, `name`, `description`) VALUES
(23, 'Math', 'Math lesson 3'),
(24, 'Information technology', 'Basics of information technologies in the word'),
(25, 'Programming', 'Basics of programming data structures'),
(26, 'Web servers', 'Apache/nginx');

-- --------------------------------------------------------

--
-- Struktura tabulky `User`
--

CREATE TABLE `User` (
                        `id` int NOT NULL,
                        `firstname` varchar(250) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
                        `lastname` varchar(250) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
                        `email` varchar(250) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
                        `password` varchar(50) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
                        `role` varchar(50) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
                        `rememberme_hash` varchar(250) COLLATE utf8_czech_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `User`
--

INSERT INTO `User` (`id`, `firstname`, `lastname`, `email`, `password`, `role`, `rememberme_hash`) VALUES
(101, 'Tomáš', 'Vondra', 'tomas.vondra@gmail.com', 'password', 'student', 'c4cd55dbeb0a61434e3555a401901ef1'),
(102, 'David', 'Senohrabek', 'david.seno@upce.cz', 'password', 'student', ''),
(103, 'Jan', 'Mrázek', 'jano@seznam.cz', 'password', 'student', NULL),
(104, 'Karel', 'Šimerda', 'šimer@centrum.cz', 'password', 'teacher', NULL),
(105, 'Josef', 'Marek', 'marek@gmail.com', 'password', 'teacher', '1b75ef50adf39d7f9933e8d9a9ebed38'),
(106, 'Administrator', 'Administrator', 'admin@administrator.cz', 'password', 'admin', 'eb831560d16e5ea25871ca30ac355231'),
(107, 'Administrator', 'Administrator', 'second@administrator.cz', 'password', 'admin', NULL),
(109, 'Test', 'Test', 'test@test.cz', 'test', 'admin', NULL);

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
    ADD PRIMARY KEY (`id`),
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
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `Grade`
--
ALTER TABLE `Grade`
    MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT pro tabulku `Room`
--
ALTER TABLE `Room`
    MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pro tabulku `Schedule`
--
ALTER TABLE `Schedule`
    MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT pro tabulku `Schedule-User`
--
ALTER TABLE `Schedule-User`
    MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT pro tabulku `Subject`
--
ALTER TABLE `Subject`
    MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT pro tabulku `User`
--
ALTER TABLE `User`
    MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `Schedule`
--
ALTER TABLE `Schedule`
    ADD CONSTRAINT `fk_schedule_room` FOREIGN KEY (`id_room`) REFERENCES `Room` (`id`) ON DELETE CASCADE,
    ADD CONSTRAINT `fk_schedule_subject` FOREIGN KEY (`id_subject`) REFERENCES `Subject` (`id`) ON DELETE CASCADE;

--
-- Omezení pro tabulku `Schedule-User`
--
ALTER TABLE `Schedule-User`
    ADD CONSTRAINT `fk_schedule_grade` FOREIGN KEY (`id_grade`) REFERENCES `Grade` (`id`) ON DELETE CASCADE,
    ADD CONSTRAINT `fk_schedule_schedule` FOREIGN KEY (`id_schedule`) REFERENCES `Schedule` (`id`) ON DELETE CASCADE,
    ADD CONSTRAINT `fk_schedule_user` FOREIGN KEY (`id_user`) REFERENCES `User` (`id`) ON DELETE CASCADE;

insert into user (firstname, lastname, email, password, role) VALUES ("Tom�", "Vondra", "admin", "admin", "admin");

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
