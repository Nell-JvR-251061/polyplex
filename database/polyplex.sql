-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 19, 2026 at 08:24 PM
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
  `ability_1` int(10) UNSIGNED DEFAULT NULL,
  `ability_2` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shapes`
--

INSERT INTO `shapes` (`shape_id`, `shape`, `border_colour`, `fill_colour`, `shape_level`, `trading`, `created_at`, `ability_1`, `ability_2`) VALUES
(1, 'pentagon', '#0688C2', '#F79D08', 1, 0, '2026-08-19 16:42:46', 1, NULL),
(3, 'circle', '#35A668', '#F4E4C3', 2, 0, '2026-08-19 16:42:46', 6, NULL),
(4, 'hexagon', '#000000', '#FFFFFF', 4, 0, '2026-08-19 16:42:46', 2, 5);

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `team_id` int(10) UNSIGNED NOT NULL,
  `team_name` varchar(255) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `shape_a_id` int(10) UNSIGNED DEFAULT NULL,
  `shape_b_id` int(10) UNSIGNED DEFAULT NULL,
  `shape_c_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`team_id`, `team_name`, `user_id`, `shape_a_id`, `shape_b_id`, `shape_c_id`) VALUES
(1, 'Victory Squared', 1, 1, 3, 4);

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
  `password_hash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `surname`, `user_name`, `email`, `password_hash`) VALUES
(1, 'Néll', 'Janse van Rensburg', 'Nellio', 'nell@mail.com', '$2y$10$N.h4fCM69FluKAjIwvt0HudqYJRmnsLvoigzLc5Wt5wjem7klxGvG');

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
  ADD KEY `fk_shapes_ability_1` (`ability_1`),
  ADD KEY `fk_shapes_ability_2` (`ability_2`);

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`team_id`),
  ADD KEY `fk_team_user` (`user_id`),
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
  ADD PRIMARY KEY (`user_id`);

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
  MODIFY `shape_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `team_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `trades`
--
ALTER TABLE `trades`
  MODIFY `trade_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  ADD CONSTRAINT `fk_shapes_ability_1` FOREIGN KEY (`ability_1`) REFERENCES `abilities` (`ability_id`),
  ADD CONSTRAINT `fk_shapes_ability_2` FOREIGN KEY (`ability_2`) REFERENCES `abilities` (`ability_id`);

--
-- Constraints for table `teams`
--
ALTER TABLE `teams`
  ADD CONSTRAINT `fk_team_shape_a` FOREIGN KEY (`shape_a_id`) REFERENCES `shapes` (`shape_id`),
  ADD CONSTRAINT `fk_team_shape_b` FOREIGN KEY (`shape_b_id`) REFERENCES `shapes` (`shape_id`),
  ADD CONSTRAINT `fk_team_shape_c` FOREIGN KEY (`shape_c_id`) REFERENCES `shapes` (`shape_id`),
  ADD CONSTRAINT `fk_team_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `trades`
--
ALTER TABLE `trades`
  ADD CONSTRAINT `fk_trade_shape` FOREIGN KEY (`shape_id`) REFERENCES `shapes` (`shape_id`),
  ADD CONSTRAINT `fk_trade_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
