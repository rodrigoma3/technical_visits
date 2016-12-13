-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 07-Dez-2016 às 12:56
-- Versão do servidor: 10.1.13-MariaDB
-- PHP Version: 7.0.6

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

CREATE TABLE `acos` (
  `id` int(10) NOT NULL,
  `parent_id` int(10) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `foreign_key` int(10) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `lft` int(10) DEFAULT NULL,
  `rght` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `acos`
--

INSERT INTO `acos` (`id`, `parent_id`, `model`, `foreign_key`, `alias`, `lft`, `rght`) VALUES
(1, NULL, NULL, NULL, 'controllers', 1, 258),
(2, 1, NULL, NULL, 'Cities', 2, 15),
(3, 2, NULL, NULL, 'index', 3, 4),
(4, 2, NULL, NULL, 'view', 5, 6),
(5, 2, NULL, NULL, 'add', 7, 8),
(6, 2, NULL, NULL, 'edit', 9, 10),
(7, 2, NULL, NULL, 'delete', 11, 12),
(8, 1, NULL, NULL, 'Courses', 16, 27),
(9, 8, NULL, NULL, 'index', 17, 18),
(10, 8, NULL, NULL, 'view', 19, 20),
(11, 8, NULL, NULL, 'add', 21, 22),
(12, 8, NULL, NULL, 'edit', 23, 24),
(13, 8, NULL, NULL, 'delete', 25, 26),
(14, 1, NULL, NULL, 'Disciplines', 28, 39),
(15, 14, NULL, NULL, 'index', 29, 30),
(16, 14, NULL, NULL, 'view', 31, 32),
(17, 14, NULL, NULL, 'add', 33, 34),
(18, 14, NULL, NULL, 'edit', 35, 36),
(19, 14, NULL, NULL, 'delete', 37, 38),
(26, 1, NULL, NULL, 'Groups', 40, 65),
(27, 26, NULL, NULL, 'index', 41, 42),
(28, 26, NULL, NULL, 'view', 43, 44),
(29, 26, NULL, NULL, 'add', 45, 46),
(30, 26, NULL, NULL, 'edit', 47, 48),
(31, 26, NULL, NULL, 'delete', 49, 50),
(32, 26, NULL, NULL, 'permission', 51, 52),
(37, 1, NULL, NULL, 'Refusals', 66, 81),
(38, 37, NULL, NULL, 'index', 67, 68),
(39, 37, NULL, NULL, 'view', 69, 70),
(40, 37, NULL, NULL, 'add', 71, 72),
(43, 1, NULL, NULL, 'States', 82, 93),
(44, 43, NULL, NULL, 'index', 83, 84),
(45, 43, NULL, NULL, 'view', 85, 86),
(46, 43, NULL, NULL, 'add', 87, 88),
(47, 43, NULL, NULL, 'edit', 89, 90),
(48, 43, NULL, NULL, 'delete', 91, 92),
(49, 1, NULL, NULL, 'Teams', 94, 105),
(50, 49, NULL, NULL, 'index', 95, 96),
(51, 49, NULL, NULL, 'view', 97, 98),
(52, 49, NULL, NULL, 'add', 99, 100),
(53, 49, NULL, NULL, 'edit', 101, 102),
(54, 49, NULL, NULL, 'delete', 103, 104),
(55, 1, NULL, NULL, 'Users', 106, 177),
(58, 55, NULL, NULL, 'index', 111, 112),
(59, 55, NULL, NULL, 'view', 113, 114),
(60, 55, NULL, NULL, 'add', 115, 116),
(61, 55, NULL, NULL, 'edit', 117, 118),
(62, 55, NULL, NULL, 'delete', 119, 120),
(63, 55, NULL, NULL, 'permission', 121, 122),
(64, 1, NULL, NULL, 'Visits', 178, 201),
(65, 64, NULL, NULL, 'index', 179, 180),
(66, 64, NULL, NULL, 'view', 181, 182),
(67, 64, NULL, NULL, 'add', 183, 184),
(68, 64, NULL, NULL, 'edit', 185, 186),
(73, 55, NULL, NULL, 'allow_access', 135, 136),
(74, 64, NULL, NULL, 'copy', 187, 188),
(76, 1, NULL, NULL, 'Parameters', 212, 237),
(83, 76, NULL, NULL, 'email', 213, 214),
(88, 76, NULL, NULL, 'password', 215, 216),
(89, 76, NULL, NULL, 'cost_per_km', 217, 218),
(90, 76, NULL, NULL, 'system', 219, 220),
(91, 76, NULL, NULL, 'rebuilt', 221, 222),
(93, 37, NULL, NULL, 'cancel', 73, 74),
(98, 37, NULL, NULL, 'disapproved_visit', 75, 76),
(99, 37, NULL, NULL, 'disapproved_report', 77, 78),
(100, 37, NULL, NULL, 'disapproved_change', 79, 80),
(103, 64, NULL, NULL, 'pre_approve_visit', 189, 190),
(108, 64, NULL, NULL, 'approve_visit', 191, 192),
(113, 64, NULL, NULL, 'deliver_report', 193, 194),
(118, 64, NULL, NULL, 'downloadfile', 195, 196),
(120, 2, NULL, NULL, 'cities_short_distance', 13, 14),
(124, 64, NULL, NULL, 'approve_report', 197, 198),
(129, 64, NULL, NULL, 'transport_update', 199, 200);

-- --------------------------------------------------------

--
-- Estrutura da tabela `aros`
--

CREATE TABLE `aros` (
  `id` int(10) NOT NULL,
  `parent_id` int(10) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `foreign_key` int(10) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `lft` int(10) DEFAULT NULL,
  `rght` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `aros`
--

INSERT INTO `aros` (`id`, `parent_id`, `model`, `foreign_key`, `alias`, `lft`, `rght`) VALUES
(1, NULL, 'Group', 2, NULL, 1, 6),
(2, 1, 'User', 1, NULL, 2, 3),
(3, NULL, 'Group', 3, NULL, 7, 12),
(4, 3, 'User', 2, NULL, 8, 9),
(6, 3, 'User', 4, NULL, 10, 11),
(7, 1, 'User', 5, NULL, 4, 5);

-- --------------------------------------------------------

--
-- Estrutura da tabela `aros_acos`
--

CREATE TABLE `aros_acos` (
  `id` int(10) NOT NULL,
  `aro_id` int(10) NOT NULL,
  `aco_id` int(10) NOT NULL,
  `_create` varchar(2) NOT NULL DEFAULT '0',
  `_read` varchar(2) NOT NULL DEFAULT '0',
  `_update` varchar(2) NOT NULL DEFAULT '0',
  `_delete` varchar(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(34, 1, 34, '1', '1', '1', '1'),
(37, 1, 37, '1', '1', '1', '1'),
(38, 1, 38, '1', '1', '1', '1'),
(39, 1, 39, '1', '1', '1', '1'),
(40, 1, 40, '1', '1', '1', '1'),
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
(100, 3, 37, '-1', '-1', '-1', '-1'),
(101, 3, 38, '-1', '-1', '-1', '-1'),
(102, 3, 39, '-1', '-1', '-1', '-1'),
(103, 3, 40, '-1', '-1', '-1', '-1'),
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
(129, 3, 68, '1', '1', '1', '1');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cities`
--

CREATE TABLE `cities` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `short_distance` tinyint(1) NOT NULL,
  `state_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `cities`
--

INSERT INTO `cities` (`id`, `name`, `short_distance`, `state_id`) VALUES
(1, 'Caxias do Sul', 1, 1),
(2, 'Erechim', 0, 1),
(3, 'Bento Gonçalves', 1, 1),
(4, 'Florianopolis', 0, 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `courses`
--

CREATE TABLE `courses` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `type_of_academic_period` int(10) NOT NULL,
  `amount_of_academic_periods` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `disciplines`
--

CREATE TABLE `disciplines` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `academic_period` int(10) UNSIGNED NOT NULL,
  `course_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `disciplines_teams`
--

CREATE TABLE `disciplines_teams` (
  `id` int(10) UNSIGNED NOT NULL,
  `team_id` int(10) UNSIGNED NOT NULL,
  `discipline_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `groups`
--

CREATE TABLE `groups` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

CREATE TABLE `refusals` (
  `id` int(10) UNSIGNED NOT NULL,
  `created` datetime NOT NULL,
  `reason` varchar(255) NOT NULL,
  `type` int(10) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `visit_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `states`
--

CREATE TABLE `states` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `initials` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `states`
--

INSERT INTO `states` (`id`, `name`, `initials`) VALUES
(1, 'Rio Grande do Sul', 'RS'),
(2, 'Santa Catarina', 'SC');

-- --------------------------------------------------------

--
-- Estrutura da tabela `teams`
--

CREATE TABLE `teams` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `group_id` int(10) UNSIGNED NOT NULL,
  `token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `enabled`, `group_id`, `token`) VALUES
(1, 'Administrator', 'admin@email.com', '$2a$10$s3WS37ypmUZyaQl4ik7oMOQhc2PNnahnjZLtH2hutqwXcdZKIr9pW', 1, 2, ''),
(4, 'Professor Um', 'prof@email.com', '$2a$10$Edn7Swzny30i3znkXfw53OS8aXIx2a7HNTCLWblTmeqLvwKR2jpw.', 1, 3, ''),
(5, 'Transporte', 'transporte@email.com', '$2a$10$uRhGEz5YdaNch2MBTcCXSeg7zwPoFncnO8A5Q2SN40fMRT5nXe8v2', 1, 2, '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `visits`
--

CREATE TABLE `visits` (
  `id` int(10) UNSIGNED NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
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
  `report` varchar(255) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `city_id` int(10) UNSIGNED NOT NULL,
  `team_id` int(10) UNSIGNED NOT NULL,
  `discipline_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `acos`
--
ALTER TABLE `acos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_acos_lft_rght` (`lft`,`rght`),
  ADD KEY `idx_acos_alias` (`alias`);

--
-- Indexes for table `aros`
--
ALTER TABLE `aros`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_aros_lft_rght` (`lft`,`rght`),
  ADD KEY `idx_aros_alias` (`alias`);

--
-- Indexes for table `aros_acos`
--
ALTER TABLE `aros_acos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ARO_ACO_KEY` (`aro_id`,`aco_id`),
  ADD KEY `idx_aco_id` (`aco_id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cities_state_id` (`state_id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `disciplines`
--
ALTER TABLE `disciplines`
  ADD PRIMARY KEY (`id`),
  ADD KEY `disciplines_course_id` (`course_id`);

--
-- Indexes for table `disciplines_teams`
--
ALTER TABLE `disciplines_teams`
  ADD PRIMARY KEY (`id`),
  ADD KEY `classes_disciplines_class_id` (`team_id`),
  ADD KEY `classes_disciplines_discipline_id` (`discipline_id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `refusals`
--
ALTER TABLE `refusals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `refusals_visit_id` (`visit_id`),
  ADD KEY `refusals_user_id` (`user_id`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_group_id` (`group_id`);

--
-- Indexes for table `visits`
--
ALTER TABLE `visits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `visits_user_id` (`user_id`),
  ADD KEY `visits_city_id` (`city_id`),
  ADD KEY `visits_class_id` (`team_id`),
  ADD KEY `discipline_id` (`discipline_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `acos`
--
ALTER TABLE `acos`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;
--
-- AUTO_INCREMENT for table `aros`
--
ALTER TABLE `aros`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `aros_acos`
--
ALTER TABLE `aros_acos`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;
--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `disciplines`
--
ALTER TABLE `disciplines`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `disciplines_teams`
--
ALTER TABLE `disciplines_teams`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `refusals`
--
ALTER TABLE `refusals`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `visits`
--
ALTER TABLE `visits`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
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
  ADD CONSTRAINT `fk_visits_discipline_id` FOREIGN KEY (`discipline_id`) REFERENCES `disciplines` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_visits_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
