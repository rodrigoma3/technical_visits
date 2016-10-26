-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 26-Out-2016 às 01:28
-- Versão do servidor: 10.1.16-MariaDB
-- PHP Version: 7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `technical_visits`
--
CREATE DATABASE IF NOT EXISTS `technical_visits` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `technical_visits`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `acos`
--

CREATE TABLE IF NOT EXISTS `acos` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `foreign_key` int(10) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `lft` int(10) DEFAULT NULL,
  `rght` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_acos_lft_rght` (`lft`,`rght`),
  KEY `idx_acos_alias` (`alias`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `acos`
--

INSERT INTO `acos` (`id`, `parent_id`, `model`, `foreign_key`, `alias`, `lft`, `rght`) VALUES
(1, NULL, NULL, NULL, 'controllers', 1, 144),
(2, 1, NULL, NULL, 'Cities', 2, 13),
(3, 2, NULL, NULL, 'index', 3, 4),
(4, 2, NULL, NULL, 'view', 5, 6),
(5, 2, NULL, NULL, 'add', 7, 8),
(6, 2, NULL, NULL, 'edit', 9, 10),
(7, 2, NULL, NULL, 'delete', 11, 12),
(8, 1, NULL, NULL, 'Courses', 14, 25),
(9, 8, NULL, NULL, 'index', 15, 16),
(10, 8, NULL, NULL, 'view', 17, 18),
(11, 8, NULL, NULL, 'add', 19, 20),
(12, 8, NULL, NULL, 'edit', 21, 22),
(13, 8, NULL, NULL, 'delete', 23, 24),
(14, 1, NULL, NULL, 'Disciplines', 26, 37),
(15, 14, NULL, NULL, 'index', 27, 28),
(16, 14, NULL, NULL, 'view', 29, 30),
(17, 14, NULL, NULL, 'add', 31, 32),
(18, 14, NULL, NULL, 'edit', 33, 34),
(19, 14, NULL, NULL, 'delete', 35, 36),
(26, 1, NULL, NULL, 'Groups', 38, 57),
(27, 26, NULL, NULL, 'index', 39, 40),
(28, 26, NULL, NULL, 'view', 41, 42),
(29, 26, NULL, NULL, 'add', 43, 44),
(30, 26, NULL, NULL, 'edit', 45, 46),
(31, 26, NULL, NULL, 'delete', 47, 48),
(32, 26, NULL, NULL, 'permission', 49, 50),
(33, 26, NULL, NULL, 'rebuilt', 51, 52),
(35, 1, NULL, NULL, 'Pages', 58, 61),
(36, 35, NULL, NULL, 'display', 59, 60),
(37, 1, NULL, NULL, 'Refusals', 62, 73),
(38, 37, NULL, NULL, 'index', 63, 64),
(39, 37, NULL, NULL, 'view', 65, 66),
(40, 37, NULL, NULL, 'add', 67, 68),
(41, 37, NULL, NULL, 'edit', 69, 70),
(42, 37, NULL, NULL, 'delete', 71, 72),
(43, 1, NULL, NULL, 'States', 74, 85),
(44, 43, NULL, NULL, 'index', 75, 76),
(45, 43, NULL, NULL, 'view', 77, 78),
(46, 43, NULL, NULL, 'add', 79, 80),
(47, 43, NULL, NULL, 'edit', 81, 82),
(48, 43, NULL, NULL, 'delete', 83, 84),
(49, 1, NULL, NULL, 'Teams', 86, 97),
(50, 49, NULL, NULL, 'index', 87, 88),
(51, 49, NULL, NULL, 'view', 89, 90),
(52, 49, NULL, NULL, 'add', 91, 92),
(53, 49, NULL, NULL, 'edit', 93, 94),
(54, 49, NULL, NULL, 'delete', 95, 96),
(55, 1, NULL, NULL, 'Users', 98, 123),
(58, 55, NULL, NULL, 'index', 103, 104),
(59, 55, NULL, NULL, 'view', 105, 106),
(60, 55, NULL, NULL, 'add', 107, 108),
(61, 55, NULL, NULL, 'edit', 109, 110),
(62, 55, NULL, NULL, 'delete', 111, 112),
(63, 55, NULL, NULL, 'permission', 113, 114),
(64, 1, NULL, NULL, 'Visits', 124, 135),
(65, 64, NULL, NULL, 'index', 125, 126),
(66, 64, NULL, NULL, 'view', 127, 128),
(67, 64, NULL, NULL, 'add', 129, 130),
(68, 64, NULL, NULL, 'edit', 131, 132),
(69, 64, NULL, NULL, 'delete', 133, 134);

-- --------------------------------------------------------

--
-- Estrutura da tabela `aros`
--

CREATE TABLE IF NOT EXISTS `aros` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `foreign_key` int(10) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `lft` int(10) DEFAULT NULL,
  `rght` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_aros_lft_rght` (`lft`,`rght`),
  KEY `idx_aros_alias` (`alias`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `aros`
--

INSERT INTO `aros` (`id`, `parent_id`, `model`, `foreign_key`, `alias`, `lft`, `rght`) VALUES
(1, NULL, 'Group', 2, NULL, 1, 4),
(2, 1, 'User', 1, NULL, 2, 3),
(3, NULL, 'Group', 3, NULL, 5, 10),
(4, 3, 'User', 2, NULL, 6, 7),
(5, 3, 'User', 3, NULL, 8, 9);

-- --------------------------------------------------------

--
-- Estrutura da tabela `aros_acos`
--

CREATE TABLE IF NOT EXISTS `aros_acos` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `aro_id` int(10) NOT NULL,
  `aco_id` int(10) NOT NULL,
  `_create` varchar(2) NOT NULL DEFAULT '0',
  `_read` varchar(2) NOT NULL DEFAULT '0',
  `_update` varchar(2) NOT NULL DEFAULT '0',
  `_delete` varchar(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ARO_ACO_KEY` (`aro_id`,`aco_id`),
  KEY `idx_aco_id` (`aco_id`)
) ENGINE=InnoDB AUTO_INCREMENT=131 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `aros_acos`
--

INSERT INTO `aros_acos` (`id`, `aro_id`, `aco_id`, `_create`, `_read`, `_update`, `_delete`) VALUES
(1, 1, 1, '1', '1', '1', '1'),
(2, 1, 2, '1', '1', '1', '1'),
(3, 1, 3, '1', '1', '1', '1'),
(4, 1, 4, '1', '1', '1', '1'),
(5, 1, 5, '1', '1', '1', '1'),
(6, 1, 6, '1', '1', '1', '1'),
(7, 1, 7, '1', '1', '1', '1'),
(8, 1, 8, '1', '1', '1', '1'),
(9, 1, 9, '1', '1', '1', '1'),
(10, 1, 10, '1', '1', '1', '1'),
(11, 1, 11, '1', '1', '1', '1'),
(12, 1, 12, '1', '1', '1', '1'),
(13, 1, 13, '1', '1', '1', '1'),
(14, 1, 14, '1', '1', '1', '1'),
(15, 1, 15, '1', '1', '1', '1'),
(16, 1, 16, '1', '1', '1', '1'),
(17, 1, 17, '1', '1', '1', '1'),
(18, 1, 18, '1', '1', '1', '1'),
(19, 1, 19, '1', '1', '1', '1'),
(26, 1, 26, '1', '1', '1', '1'),
(27, 1, 27, '1', '1', '1', '1'),
(28, 1, 28, '1', '1', '1', '1'),
(29, 1, 29, '1', '1', '1', '1'),
(30, 1, 30, '1', '1', '1', '1'),
(31, 1, 31, '1', '1', '1', '1'),
(32, 1, 32, '1', '1', '1', '1'),
(33, 1, 33, '1', '1', '1', '1'),
(34, 1, 34, '1', '1', '1', '1'),
(35, 1, 35, '1', '1', '1', '1'),
(36, 1, 36, '1', '1', '1', '1'),
(37, 1, 37, '1', '1', '1', '1'),
(38, 1, 38, '1', '1', '1', '1'),
(39, 1, 39, '1', '1', '1', '1'),
(40, 1, 40, '1', '1', '1', '1'),
(41, 1, 41, '1', '1', '1', '1'),
(42, 1, 42, '1', '1', '1', '1'),
(43, 1, 43, '1', '1', '1', '1'),
(44, 1, 44, '1', '1', '1', '1'),
(45, 1, 45, '1', '1', '1', '1'),
(46, 1, 46, '1', '1', '1', '1'),
(47, 1, 47, '1', '1', '1', '1'),
(48, 1, 48, '1', '1', '1', '1'),
(49, 1, 49, '1', '1', '1', '1'),
(50, 1, 50, '1', '1', '1', '1'),
(51, 1, 51, '1', '1', '1', '1'),
(52, 1, 52, '1', '1', '1', '1'),
(53, 1, 53, '1', '1', '1', '1'),
(54, 1, 54, '1', '1', '1', '1'),
(55, 1, 55, '1', '1', '1', '1'),
(56, 1, 56, '1', '1', '1', '1'),
(57, 1, 57, '1', '1', '1', '1'),
(58, 1, 58, '1', '1', '1', '1'),
(59, 1, 59, '1', '1', '1', '1'),
(60, 1, 60, '1', '1', '1', '1'),
(61, 1, 61, '1', '1', '1', '1'),
(62, 1, 62, '1', '1', '1', '1'),
(63, 1, 63, '1', '1', '1', '1'),
(64, 1, 64, '1', '1', '1', '1'),
(65, 1, 65, '1', '1', '1', '1'),
(66, 1, 66, '1', '1', '1', '1'),
(67, 1, 67, '1', '1', '1', '1'),
(68, 1, 68, '1', '1', '1', '1'),
(69, 1, 69, '1', '1', '1', '1'),
(70, 1, 70, '1', '1', '1', '1'),
(71, 3, 1, '-1', '-1', '-1', '-1'),
(72, 3, 2, '-1', '-1', '-1', '-1'),
(73, 3, 3, '-1', '-1', '-1', '-1'),
(74, 3, 4, '-1', '-1', '-1', '-1'),
(75, 3, 5, '-1', '-1', '-1', '-1'),
(76, 3, 6, '-1', '-1', '-1', '-1'),
(77, 3, 7, '-1', '-1', '-1', '-1'),
(78, 3, 8, '-1', '-1', '-1', '-1'),
(79, 3, 9, '-1', '-1', '-1', '-1'),
(80, 3, 10, '-1', '-1', '-1', '-1'),
(81, 3, 11, '-1', '-1', '-1', '-1'),
(82, 3, 12, '-1', '-1', '-1', '-1'),
(83, 3, 13, '-1', '-1', '-1', '-1'),
(84, 3, 14, '-1', '-1', '-1', '-1'),
(85, 3, 15, '-1', '-1', '-1', '-1'),
(86, 3, 16, '-1', '-1', '-1', '-1'),
(87, 3, 17, '-1', '-1', '-1', '-1'),
(88, 3, 18, '-1', '-1', '-1', '-1'),
(89, 3, 19, '-1', '-1', '-1', '-1'),
(90, 3, 26, '-1', '-1', '-1', '-1'),
(91, 3, 27, '-1', '-1', '-1', '-1'),
(92, 3, 28, '-1', '-1', '-1', '-1'),
(93, 3, 29, '-1', '-1', '-1', '-1'),
(94, 3, 30, '-1', '-1', '-1', '-1'),
(95, 3, 31, '-1', '-1', '-1', '-1'),
(96, 3, 32, '-1', '-1', '-1', '-1'),
(97, 3, 33, '-1', '-1', '-1', '-1'),
(98, 3, 35, '-1', '-1', '-1', '-1'),
(99, 3, 36, '-1', '-1', '-1', '-1'),
(100, 3, 37, '-1', '-1', '-1', '-1'),
(101, 3, 38, '-1', '-1', '-1', '-1'),
(102, 3, 39, '-1', '-1', '-1', '-1'),
(103, 3, 40, '-1', '-1', '-1', '-1'),
(104, 3, 41, '-1', '-1', '-1', '-1'),
(105, 3, 42, '-1', '-1', '-1', '-1'),
(106, 3, 43, '-1', '-1', '-1', '-1'),
(107, 3, 44, '-1', '-1', '-1', '-1'),
(108, 3, 45, '-1', '-1', '-1', '-1'),
(109, 3, 46, '-1', '-1', '-1', '-1'),
(110, 3, 47, '-1', '-1', '-1', '-1'),
(111, 3, 48, '-1', '-1', '-1', '-1'),
(112, 3, 49, '-1', '-1', '-1', '-1'),
(113, 3, 50, '-1', '-1', '-1', '-1'),
(114, 3, 51, '-1', '-1', '-1', '-1'),
(115, 3, 52, '-1', '-1', '-1', '-1'),
(116, 3, 53, '-1', '-1', '-1', '-1'),
(117, 3, 54, '-1', '-1', '-1', '-1'),
(118, 3, 55, '-1', '-1', '-1', '-1'),
(119, 3, 58, '-1', '-1', '-1', '-1'),
(120, 3, 59, '1', '1', '1', '1'),
(121, 3, 60, '-1', '-1', '-1', '-1'),
(122, 3, 61, '-1', '-1', '-1', '-1'),
(123, 3, 62, '-1', '-1', '-1', '-1'),
(124, 3, 63, '-1', '-1', '-1', '-1'),
(125, 3, 64, '1', '1', '1', '1'),
(126, 3, 65, '1', '1', '1', '1'),
(127, 3, 66, '1', '1', '1', '1'),
(128, 3, 67, '1', '1', '1', '1'),
(129, 3, 68, '1', '1', '1', '1'),
(130, 3, 69, '1', '1', '1', '1');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cities`
--

CREATE TABLE IF NOT EXISTS `cities` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `short_distance` tinyint(1) NOT NULL,
  `state_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cities_state_id` (`state_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `cities`
--

INSERT INTO `cities` (`id`, `name`, `short_distance`, `state_id`) VALUES
(1, 'Caxias do Sul', 1, 1),
(2, 'Erechim', 0, 1),
(3, 'Bento Gonçalves', 1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `courses`
--

CREATE TABLE IF NOT EXISTS `courses` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type_of_academic_period` int(10) NOT NULL,
  `amount_of_academic_periods` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `courses`
--

INSERT INTO `courses` (`id`, `name`, `type_of_academic_period`, `amount_of_academic_periods`) VALUES
(1, 'Análise e Desenvolvimento de Sistemas', 1, 6);

-- --------------------------------------------------------

--
-- Estrutura da tabela `disciplines`
--

CREATE TABLE IF NOT EXISTS `disciplines` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `academic_period` int(10) UNSIGNED NOT NULL,
  `course_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `disciplines_course_id` (`course_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `disciplines`
--

INSERT INTO `disciplines` (`id`, `name`, `academic_period`, `course_id`) VALUES
(1, 'Desenvolvimento III', 6, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `disciplines_teams`
--

CREATE TABLE IF NOT EXISTS `disciplines_teams` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `team_id` int(10) UNSIGNED NOT NULL,
  `discipline_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `classes_disciplines_class_id` (`team_id`),
  KEY `classes_disciplines_discipline_id` (`discipline_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `disciplines_teams`
--

INSERT INTO `disciplines_teams` (`id`, `team_id`, `discipline_id`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(2, 'Administrativo', 'Administrativo'),
(3, 'Professor', 'Professor');

-- --------------------------------------------------------

--
-- Estrutura da tabela `refusals`
--

CREATE TABLE IF NOT EXISTS `refusals` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL,
  `reason` varchar(255) NOT NULL,
  `type` int(10) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `visit_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `refusals_visit_id` (`visit_id`),
  KEY `refusals_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `states`
--

CREATE TABLE IF NOT EXISTS `states` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `initials` varchar(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `states`
--

INSERT INTO `states` (`id`, `name`, `initials`) VALUES
(1, 'Rio Grande do Sul', 'RS');

-- --------------------------------------------------------

--
-- Estrutura da tabela `teams`
--

CREATE TABLE IF NOT EXISTS `teams` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `teams`
--

INSERT INTO `teams` (`id`, `name`) VALUES
(1, 'Turma A');

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `group_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `users_group_id` (`group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `group_id`) VALUES
(1, 'Administrator', 'admin@email.com', '$2a$10$s3WS37ypmUZyaQl4ik7oMOQhc2PNnahnjZLtH2hutqwXcdZKIr9pW', 2),
(3, 'test', 'tester@mail.com', '$2a$10$/3sqlLd9QNcDGmUOG2zDhOyz2jA6PfAvivdPfoaWEiUbWArrL.PQe', 3);

-- --------------------------------------------------------

--
-- Estrutura da tabela `visits`
--

CREATE TABLE IF NOT EXISTS `visits` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL,
  `departure` datetime NOT NULL,
  `arrival` datetime NOT NULL,
  `destination` varchar(255) NOT NULL,
  `number_of_students` int(10) UNSIGNED NOT NULL,
  `refund` double UNSIGNED NOT NULL,
  `transport` int(10) NOT NULL,
  `transport_cost` double UNSIGNED NOT NULL,
  `distance` double UNSIGNED NOT NULL,
  `objective` varchar(255) NOT NULL,
  `comments` varchar(255) NOT NULL,
  `status` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `city_id` int(10) UNSIGNED NOT NULL,
  `team_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `visits_user_id` (`user_id`),
  KEY `visits_city_id` (`city_id`),
  KEY `visits_class_id` (`team_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `visits`
--

INSERT INTO `visits` (`id`, `created`, `departure`, `arrival`, `destination`, `number_of_students`, `refund`, `transport`, `transport_cost`, `distance`, `objective`, `comments`, `status`, `user_id`, `city_id`, `team_id`) VALUES
(18, '2016-10-25 20:15:17', '2017-05-26 20:20:00', '2017-05-26 22:30:00', 'AGORA SIM', 1, 1, 1, 1, 1, '1', '1', 1, 1, 1, 1),
(19, '2016-10-26 00:07:50', '2016-10-25 20:30:00', '2016-10-26 12:00:00', 'Praia', 15, 50.55, 1, 500, 500, 'Tira Onda', 'Bagual', 1, 1, 1, 1),
(20, '2016-10-26 00:29:52', '2010-10-10 10:10:00', '2002-02-20 20:20:00', 'asd', 1, 11, 0, 1, 1, '1', '1', 1, 1, 1, 1),
(21, '2016-10-26 01:18:42', '2016-10-25 21:18:00', '2016-10-25 22:00:00', 'ULTIMO TESTE', 1, 1, 0, 1, 1, '1434', '1', 0, 1, 1, 1);

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `cities`
--
ALTER TABLE `cities`
  ADD CONSTRAINT `fk_cities_state_id` FOREIGN KEY (`state_id`) REFERENCES `states` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `disciplines`
--
ALTER TABLE `disciplines`
  ADD CONSTRAINT `fk_disciplines_course_id` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `disciplines_teams`
--
ALTER TABLE `disciplines_teams`
  ADD CONSTRAINT `fk_classes_disciplines_class_id` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_classes_disciplines_discipline_id` FOREIGN KEY (`discipline_id`) REFERENCES `disciplines` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `refusals`
--
ALTER TABLE `refusals`
  ADD CONSTRAINT `fk_refusals_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_refusals_visit_id` FOREIGN KEY (`visit_id`) REFERENCES `visits` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_group_id` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `visits`
--
ALTER TABLE `visits`
  ADD CONSTRAINT `fk_visits_city_id` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_visits_class_id` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_visits_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
