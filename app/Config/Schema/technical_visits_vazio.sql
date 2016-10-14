-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 09-Out-2016 às 18:02
-- Versão do servidor: 10.1.10-MariaDB
-- PHP Version: 5.6.15

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
-- Estrutura da tabela `cities`
--

CREATE TABLE IF NOT EXISTS `cities` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `short_distance` tinyint(1) NOT NULL,
  `state_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cities_state_id` (`state_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `classes`
--

CREATE TABLE IF NOT EXISTS `classes` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `classes_disciplines`
--

CREATE TABLE IF NOT EXISTS `classes_disciplines` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `class_id` int(10) UNSIGNED NOT NULL,
  `discipline_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `classes_disciplines_class_id` (`class_id`),
  KEY `classes_disciplines_discipline_id` (`discipline_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `courses`
--

CREATE TABLE IF NOT EXISTS `courses` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type_of_academic_period` varchar(255) NOT NULL,
  `amount_of_academic_periods` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `refusals`
--

CREATE TABLE IF NOT EXISTS `refusals` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  `reason` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `visits`
--

CREATE TABLE IF NOT EXISTS `visits` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `departure` datetime NOT NULL,
  `arrival` datetime NOT NULL,
  `destination` varchar(255) NOT NULL,
  `number_of_students` int(10) UNSIGNED NOT NULL,
  `daily` double UNSIGNED NOT NULL,
  `transport` varchar(255) NOT NULL,
  `cost_transport` double UNSIGNED NOT NULL,
  `distance` double UNSIGNED NOT NULL,
  `objective` varchar(255) NOT NULL,
  `comments` varchar(255) NOT NULL,
  `status` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `city_id` int(10) UNSIGNED NOT NULL,
  `class_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `visits_user_id` (`user_id`),
  KEY `visits_city_id` (`city_id`),
  KEY `visits_class_id` (`class_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `cities`
--
ALTER TABLE `cities`
  ADD CONSTRAINT `fk_cities_state_id` FOREIGN KEY (`state_id`) REFERENCES `states` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `classes_disciplines`
--
ALTER TABLE `classes_disciplines`
  ADD CONSTRAINT `fk_classes_disciplines_class_id` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_classes_disciplines_discipline_id` FOREIGN KEY (`discipline_id`) REFERENCES `disciplines` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `disciplines`
--
ALTER TABLE `disciplines`
  ADD CONSTRAINT `fk_disciplines_course_id` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

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
  ADD CONSTRAINT `fk_visits_class_id` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_visits_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
