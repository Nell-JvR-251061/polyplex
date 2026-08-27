-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 27, 2026 at 08:42 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `polyplex`
--

-- --------------------------------------------------------

--
-- Table structure for table `abilities`
--

CREATE TABLE `abilities` (
  `ability_id` int(10) UNSIGNED NOT NULL,
  `ability_name` varchar(255) DEFAULT NULL,
  `ability_description` varchar(255) DEFAULT NULL,
  `ability_modifier` enum('+','-','x','/') DEFAULT '+',
  `ability_target` enum('self','team','opponent','opponent_team') DEFAULT 'self'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `abilities`
--

INSERT INTO `abilities` (`ability_id`, `ability_name`, `ability_description`, `ability_modifier`, `ability_target`) VALUES
(1, 'Sharpen', 'Increases own strength by this shape\'s level.', '+', 'self'),
(2, 'Inspire', 'Increases teammates strength by this shape\'s level.', '+', 'team'),
(3, 'Intimidate', 'Lowers a random opponents strength by this shape\'s level', '-', 'opponent'),
(4, 'Blinded', 'lowers each opponent\'s strength by this shape\'s level.', '-', 'opponent_team'),
(5, 'Hexed', 'Halves a random opponent\'s strength', '/', 'opponent'),
(6, 'Overdrive', 'Doubles own strength.', 'x', 'self');

-- --------------------------------------------------------

--
-- Table structure for table `matches`
--

CREATE TABLE `matches` (
  `match_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `user_team_id` int(10) UNSIGNED DEFAULT NULL,
  `opponent_id` int(10) UNSIGNED DEFAULT NULL,
  `opponent_team_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shapes`
--

CREATE TABLE `shapes` (
  `shape_id` int(10) UNSIGNED NOT NULL,
  `shape` enum('circle','triangle','square','pentagon','hexagon') DEFAULT 'circle',
  `border_colour` varchar(7) DEFAULT '#000000',
  `fill_colour` varchar(7) DEFAULT '#FFFFFF',
  `shape_level` int(11) DEFAULT NULL,
  `trading` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `shape_ability` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shapes`
--

INSERT INTO `shapes` (`shape_id`, `shape`, `border_colour`, `fill_colour`, `shape_level`, `trading`, `created_at`, `shape_ability`) VALUES
(1, 'pentagon', '#0688C2', '#F79D08', 1, 0, '2026-08-19 16:42:46', 1),
(3, 'circle', '#35A668', '#F4E4C3', 2, 0, '2026-08-19 16:42:46', 6),
(4, 'hexagon', '#000000', '#FFFFFF', 4, 0, '2026-08-19 16:42:46', 2),
(5, 'hexagon', '#FFFFFF', '#8a994a', 1, 0, '2026-08-25 14:51:05', 5),
(6, 'hexagon', '#000000', '#e75244', 1, 0, '2026-08-25 14:51:24', 6),
(7, 'triangle', '#000000', '#bff659', 1, 0, '2026-08-26 15:18:06', 2),
(8, 'hexagon', '#000000', '#165d75', 1, 0, '2026-08-26 15:18:09', 2),
(9, 'square', '#FFD700', '#5d153b', 4, 1, '2026-08-26 23:22:09', 6),
(10, 'circle', '#000000', '#9a1c50', 9, 1, '2026-08-26 23:22:10', 2),
(11, 'square', '#000000', '#df8eae', 7, 1, '2026-08-26 23:22:28', 2),
(12, 'pentagon', '#000000', '#d868ce', 6, 1, '2026-08-26 23:24:05', 3),
(13, 'triangle', '#000000', '#8e46ee', 4, 1, '2026-08-26 23:24:07', 3),
(14, 'square', '#000000', '#27504c', 2, 1, '2026-08-26 23:24:07', 1),
(15, 'circle', '#FFD700', '#1b5496', 1, 0, '2026-08-26 23:24:08', 4),
(16, 'square', '#FFFFFF', '#65f746', 5, 1, '2026-08-26 23:24:09', 3),
(17, 'hexagon', '#000000', '#134c29', 6, 1, '2026-08-26 23:24:29', 6),
(18, 'pentagon', '#FFD700', '#e1b27a', 7, 1, '2026-08-26 23:24:30', 6),
(19, 'square', '#FFD700', '#e978c3', 9, 1, '2026-08-26 23:24:30', 2),
(20, 'square', '#FFFFFF', '#ef5a48', 9, 1, '2026-08-26 23:24:30', 4),
(21, 'square', '#FFD700', '#9b9921', 7, 1, '2026-08-26 23:24:31', 6),
(22, 'square', '#FFFFFF', '#0fea60', 1, 0, '2026-08-26 23:24:31', 1),
(23, 'square', '#FFFFFF', '#f2d6fa', 9, 1, '2026-08-26 23:24:31', 1),
(24, 'hexagon', '#FFD700', '#20a2f9', 1, 0, '2026-08-26 23:24:32', 4),
(25, 'pentagon', '#000000', '#329be7', 6, 1, '2026-08-26 23:24:32', 4),
(26, 'pentagon', '#FFD700', '#ef4340', 3, 1, '2026-08-26 23:24:32', 6),
(27, 'hexagon', '#FFD700', '#c70891', 3, 1, '2026-08-26 23:24:32', 2),
(28, 'triangle', '#000000', '#458579', 8, 1, '2026-08-26 23:24:33', 4),
(29, 'triangle', '#FFD700', '#3204dc', 8, 1, '2026-08-26 23:24:33', 3),
(30, 'circle', '#FFFFFF', '#be5d74', 8, 1, '2026-08-26 23:24:33', 1),
(31, 'square', '#000000', '#a88306', 3, 1, '2026-08-26 23:24:34', 3),
(32, 'triangle', '#FFFFFF', '#484549', 5, 1, '2026-08-26 23:24:34', 2),
(33, 'pentagon', '#FFFFFF', '#0ef3d1', 2, 1, '2026-08-26 23:24:34', 4),
(34, 'triangle', '#000000', '#bde4d8', 6, 1, '2026-08-26 23:24:40', 6),
(35, 'hexagon', '#000000', '#a9a025', 5, 1, '2026-08-26 23:24:40', 1),
(36, 'circle', '#FFD700', '#874436', 7, 1, '2026-08-26 23:24:41', 2),
(37, 'hexagon', '#FFFFFF', '#ede7bf', 9, 1, '2026-08-26 23:24:41', 1),
(38, 'triangle', '#FFFFFF', '#f2d626', 10, 1, '2026-08-26 23:24:41', 5),
(39, 'hexagon', '#000000', '#58101b', 9, 1, '2026-08-26 23:24:41', 6),
(40, 'pentagon', '#FFD700', '#bf1c79', 3, 1, '2026-08-26 23:24:42', 2),
(41, 'hexagon', '#000000', '#10d6ea', 7, 1, '2026-08-26 23:24:42', 1),
(42, 'pentagon', '#FFD700', '#c642e9', 4, 1, '2026-08-26 23:24:42', 5),
(43, 'pentagon', '#FFD700', '#8d011b', 8, 1, '2026-08-26 23:24:43', 2),
(44, 'pentagon', '#FFFFFF', '#e21aa0', 4, 1, '2026-08-26 23:24:43', 1),
(45, 'square', '#FFD700', '#77a605', 10, 1, '2026-08-26 23:24:43', 5),
(46, 'triangle', '#000000', '#4146e8', 7, 1, '2026-08-26 23:24:50', 4),
(47, 'circle', '#FFD700', '#66db70', 9, 1, '2026-08-26 23:24:51', 1),
(48, 'triangle', '#FFFFFF', '#a461dd', 9, 1, '2026-08-26 23:24:52', 4),
(49, 'hexagon', '#000000', '#46cf97', 2, 1, '2026-08-26 23:25:05', 6),
(50, 'pentagon', '#FFFFFF', '#4fe4a9', 7, 1, '2026-08-26 23:25:21', 6),
(51, 'hexagon', '#000000', '#d0ed03', 1, 0, '2026-08-27 02:43:09', 3),
(52, 'triangle', '#000000', '#748d80', 1, 1, '2026-08-27 02:43:09', 3),
(53, 'square', '#000000', '#f66120', 1, 0, '2026-08-27 02:43:09', 4),
(54, 'circle', '#FFD700', '#badf2c', 1, 1, '2026-08-27 06:15:55', 2),
(55, 'pentagon', '#FFFFFF', '#d003a3', 1, 0, '2026-08-27 06:15:55', 4),
(56, 'circle', '#FFFFFF', '#37d7a5', 1, 0, '2026-08-27 06:15:55', 3),
(57, 'hexagon', '#FFD700', '#c783f5', 1, 0, '2026-08-27 06:31:39', 2),
(58, 'hexagon', '#FFFFFF', '#c58920', 1, 1, '2026-08-27 06:31:39', 4),
(59, 'triangle', '#FFD700', '#14055a', 1, 0, '2026-08-27 06:31:39', 1);

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `team_id` int(10) UNSIGNED NOT NULL,
  `team_name` varchar(255) NOT NULL,
  `shape_a_id` int(10) UNSIGNED DEFAULT NULL,
  `shape_b_id` int(10) UNSIGNED DEFAULT NULL,
  `shape_c_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`team_id`, `team_name`, `shape_a_id`, `shape_b_id`, `shape_c_id`) VALUES
(1, 'Victory Squared', 1, 3, 4),
(2, 'Darkwing Ducks', 51, 24, 15),
(3, 'DJ\'s Crew', 22, 55, 56),
(4, 'Jame\'s Knight', 57, 53, 59);

-- --------------------------------------------------------

--
-- Table structure for table `trades`
--

CREATE TABLE `trades` (
  `trade_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `shape_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `user_team` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `surname`, `user_name`, `email`, `password_hash`, `user_team`) VALUES
(1, 'Néll', 'Janse van Rensburg', 'Nellio', 'nell@mail.com', '$2y$10$N.h4fCM69FluKAjIwvt0HudqYJRmnsLvoigzLc5Wt5wjem7klxGvG', 1),
(2, 'James', 'May', 'JammieMay', 'jamesmay@mail.com', '$2y$10$lDHfL63F1MDneH/Buy54d.Q3Mnd.hLWFHEDFrNwNQ5.C7nrADMAwK', NULL),
(4, 'Geff', 'May', 'Geffers', 'geff@mail.com', '$2y$10$DUgXeHEoCv9fcNYL2uno6.81C7ZvjpARzaUGlMTXheu0G2QfbUoni', NULL),
(5, 'Adam', 'Guy', 'Addy', 'adam@mail.com', '$2y$10$QgeVlRdTxuhSzQ5nMOkKhu0CmsRAMfD7dgM35Me2Bg1jfTtbPFIKy', 2),
(6, 'Derek', 'James', 'DJMan', 'DJ@mail.com', '$2y$10$7BB.N8IBtwRlmy4TFmeUYugFpU1QhKWMDr/fbr5ycLoQNy6C6r9pe', 3),
(7, 'James', 'Gun', 'JamesManner', 'jameg@mail.com', '$2y$10$hgUnDwMNBMTgy6hG9MZgYO3U1XWf1g.uL2RNdmAxL0YaUhm7R/8li', 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `abilities`
--
ALTER TABLE `abilities`
  ADD PRIMARY KEY (`ability_id`);

--
-- Indexes for table `matches`
--
ALTER TABLE `matches`
  ADD PRIMARY KEY (`match_id`),
  ADD KEY `fk_match_user` (`user_id`),
  ADD KEY `fk_match_user_team` (`user_team_id`),
  ADD KEY `fk_match_opponent` (`opponent_id`),
  ADD KEY `fk_match_opponent_team` (`opponent_team_id`);

--
-- Indexes for table `shapes`
--
ALTER TABLE `shapes`
  ADD PRIMARY KEY (`shape_id`),
  ADD KEY `fk_shapes_ability` (`shape_ability`) USING BTREE;

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`team_id`),
  ADD KEY `fk_team_shape_a` (`shape_a_id`),
  ADD KEY `fk_team_shape_b` (`shape_b_id`),
  ADD KEY `fk_team_shape_c` (`shape_c_id`);

--
-- Indexes for table `trades`
--
ALTER TABLE `trades`
  ADD PRIMARY KEY (`trade_id`),
  ADD KEY `fk_trade_user` (`user_id`),
  ADD KEY `fk_trade_shape` (`shape_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `fk_user_team` (`user_team`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `abilities`
--
ALTER TABLE `abilities`
  MODIFY `ability_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `matches`
--
ALTER TABLE `matches`
  MODIFY `match_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shapes`
--
ALTER TABLE `shapes`
  MODIFY `shape_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `team_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `trades`
--
ALTER TABLE `trades`
  MODIFY `trade_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `matches`
--
ALTER TABLE `matches`
  ADD CONSTRAINT `fk_match_opponent` FOREIGN KEY (`opponent_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `fk_match_opponent_team` FOREIGN KEY (`opponent_team_id`) REFERENCES `teams` (`team_id`),
  ADD CONSTRAINT `fk_match_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `fk_match_user_team` FOREIGN KEY (`user_team_id`) REFERENCES `teams` (`team_id`);

--
-- Constraints for table `shapes`
--
ALTER TABLE `shapes`
  ADD CONSTRAINT `fk_shapes_ability_1` FOREIGN KEY (`shape_ability`) REFERENCES `abilities` (`ability_id`);

--
-- Constraints for table `teams`
--
ALTER TABLE `teams`
  ADD CONSTRAINT `fk_team_shape_a` FOREIGN KEY (`shape_a_id`) REFERENCES `shapes` (`shape_id`),
  ADD CONSTRAINT `fk_team_shape_b` FOREIGN KEY (`shape_b_id`) REFERENCES `shapes` (`shape_id`),
  ADD CONSTRAINT `fk_team_shape_c` FOREIGN KEY (`shape_c_id`) REFERENCES `shapes` (`shape_id`);

--
-- Constraints for table `trades`
--
ALTER TABLE `trades`
  ADD CONSTRAINT `fk_trade_shape` FOREIGN KEY (`shape_id`) REFERENCES `shapes` (`shape_id`),
  ADD CONSTRAINT `fk_trade_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_user_team` FOREIGN KEY (`user_team`) REFERENCES `teams` (`team_id`);

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `delete_old_shapes_event` ON SCHEDULE EVERY 1 DAY STARTS '2026-08-27 05:14:32' ON COMPLETION NOT PRESERVE ENABLE DO DELETE FROM shapes 
  WHERE `created_at` < NOW() - INTERVAL 7 DAY$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
