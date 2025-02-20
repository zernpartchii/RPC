-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 15, 2023 at 08:23 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rpc`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteProgram_sp` (IN `p_Program` INT)  BEGIN
DELETE FROM `program` WHERE id = p_Program;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteZone_sp` (IN `p_Zone` INT)  BEGIN
	DELETE FROM `zone` WHERE id = p_Zone;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_research_sp` (IN `p_id` INT(11) UNSIGNED)  DELETE FROM research_information WHERE id = p_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_proponents_sp` (IN `p_Proponents` VARCHAR(100))  BEGIN
	DECLARE research_id INT;
    SET research_id = (SELECT MAX(id) FROM `research_information`);
    
    INSERT INTO proponents(research_id, proponents) 
    VALUES(research_id, p_Proponents);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_research_sp` (IN `p_group_number` VARCHAR(25), IN `p_zone` VARCHAR(25), IN `p_program` VARCHAR(25), IN `p_title` VARCHAR(250), IN `p_adviser` VARCHAR(50), IN `p_stat` VARCHAR(50), IN `p_sy` VARCHAR(45))  BEGIN
INSERT INTO research_information(

group_number, zone,
program, title,
adviser, stat_da, S_Y)

VALUES(

p_group_number, p_zone,
p_program, p_title,
p_adviser, p_stat, p_sy
    
);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_users_sp` (IN `p_firstname` VARCHAR(50), IN `p_lastname` VARCHAR(50), IN `p_email` VARCHAR(100), IN `p_users_password` VARCHAR(100), IN `p_type` VARCHAR(30), IN `p_zone` VARCHAR(45))  BEGIN
INSERT INTO users_information(first_name,last_name,email,user_password, type, zone)
VALUES(p_firstname,p_lastname,p_email,p_users_password, p_type, p_zone);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `login_user_sp` (INOUT `p_email` INT(100))  BEGIN
SELECT id, email, user_password FROM `users_information` WHERE email = p_email;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `newPassword_sp` (IN `p_newPassword` VARCHAR(100), IN `p_id` INT)  BEGIN
UPDATE users_information SET user_password = p_newPassword WHERE id = p_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `read_research_sp` ()  BEGIN
SELECT * FROM `research_information` ORDER BY id DESC;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_proponents_sp` (IN `p_proponent` VARCHAR(100), IN `p_id` INT(11))  BEGIN
	UPDATE proponents SET
    proponents = p_proponent
    WHERE id = p_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_research_sp` (IN `p_group_number` VARCHAR(20), IN `p_zone` VARCHAR(25), IN `p_program` VARCHAR(50), IN `p_title` VARCHAR(250), IN `p_adviser` VARCHAR(50), IN `p_stat` VARCHAR(25), IN `p_sy` VARCHAR(45), IN `p_id` INT(11) UNSIGNED)  UPDATE research_information SET

group_number = p_group_number, 
zone = p_zone,
program = p_program, 
title = p_title,
adviser = p_adviser,
stat_da = p_stat,
S_Y = p_sy

WHERE id = p_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_users_sp` (IN `p_firstname` VARCHAR(50), IN `p_lastname` VARCHAR(50), IN `p_email` VARCHAR(100), IN `p_userpassword` VARCHAR(100), IN `p_users_id` INT(11) UNSIGNED)  UPDATE  users_information SET 
first_name = p_firstname,
last_name = p_lastname,
email = p_email,
user_password = p_userpassword
WHERE id = p_users_id$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

CREATE TABLE `branch` (
  `id` int(11) NOT NULL,
  `branch` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`id`, `branch`) VALUES
(1, 'Bansalan'),
(2, 'Davao'),
(3, 'Digos'),
(4, 'Panabo'),
(5, 'Penaplato'),
(6, 'Tagum');

-- --------------------------------------------------------

--
-- Table structure for table `program`
--

CREATE TABLE `program` (
  `id` int(11) NOT NULL,
  `Zone_id` int(11) NOT NULL,
  `Initials` varchar(20) NOT NULL,
  `Course_Program` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `program`
--

INSERT INTO `program` (`id`, `Zone_id`, `Initials`, `Course_Program`) VALUES
(37, 1, 'BSA', 'BS in Accountancy'),
(38, 1, 'BSIA', 'BS in Internal Auditing'),
(39, 1, 'BSAT', 'BS in Accounting Technology'),
(40, 1, 'BSBAMFM', 'BS in Business Administration Major in Financial Management'),
(41, 1, 'BSBAMMM', 'BS in Business Administration Major in Marketing Management'),
(42, 1, 'BSBAMHR', 'BS in Business Administration Major in Human Resource'),
(43, 1, 'BSHM', 'BS in Hospitality Management'),
(44, 1, 'BSTM', 'BS in Tourism Management'),
(45, 2, 'BSC', 'BS in Criminology'),
(46, 2, 'BSCS', 'BS in Computer Science'),
(47, 2, 'BSIT', 'BS in Information Technology'),
(48, 2, 'BSEE', 'BS in Electrical Engineering'),
(49, 2, 'BSECE', 'BS in Electronics and Communications Engineering'),
(50, 2, 'BSCE', 'BS in Computer Engineering'),
(51, 3, 'BAE', 'Bachelor of Arts in English'),
(52, 3, 'BSP', 'BS in Psychology'),
(53, 3, 'BEE', 'Bachelor of Elementary Education'),
(54, 3, 'BSEME', 'Bachelor of Secondary Education Major in English'),
(55, 3, 'BSEMM', 'Bachelor of Secondary Education Major in Mathematics'),
(56, 3, 'BSEMSS', 'Bachelor of Secondary Education Major in Social Studies'),
(57, 3, 'BSEMB', 'Bachelor of Secondary Education Major in Biology'),
(58, 3, 'BSEMF', 'Bachelor of Secondary Education Major in Filipino'),
(59, 3, 'BPE', 'Bachelor in Physical Education');

-- --------------------------------------------------------

--
-- Table structure for table `proponents`
--

CREATE TABLE `proponents` (
  `id` int(11) NOT NULL,
  `research_id` int(11) NOT NULL,
  `Proponents` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `proponents`
--

INSERT INTO `proponents` (`id`, `research_id`, `Proponents`) VALUES
(283, 95, 'Geszer Gumapac'),
(284, 95, 'Marife Siaton'),
(285, 95, ''),
(286, 96, 'Michael Llano '),
(287, 96, 'Alex Aniñon'),
(288, 96, ''),
(289, 97, 'KAYE ARBIOL '),
(290, 97, 'APRIL ROSE NITUDA'),
(291, 97, ''),
(292, 98, 'KEISHA PASINABO '),
(293, 98, 'JohnLloyd ILAGAN'),
(294, 98, ''),
(295, 99, 'Aaron John Emuy '),
(296, 99, 'Rodel Powao'),
(297, 99, ''),
(298, 100, 'JUANE CANOY '),
(299, 100, 'FRITZ JANE POSTRERO'),
(300, 100, ''),
(313, 105, 'Lord Grimn'),
(314, 105, 'Dazzling Rain'),
(315, 105, ''),
(331, 111, 'adsfasdf'),
(332, 111, 'adsfasdf'),
(333, 111, 'asdfasdf');

-- --------------------------------------------------------

--
-- Table structure for table `research_information`
--

CREATE TABLE `research_information` (
  `id` int(11) NOT NULL,
  `Group_Number` varchar(20) NOT NULL,
  `Zone` varchar(25) NOT NULL,
  `Program` varchar(200) NOT NULL,
  `Title` varchar(250) NOT NULL,
  `Adviser` varchar(50) NOT NULL,
  `Stat_DA` varchar(25) NOT NULL,
  `S_Y` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `research_information`
--

INSERT INTO `research_information` (`id`, `Group_Number`, `Zone`, `Program`, `Title`, `Adviser`, `Stat_DA`, `S_Y`) VALUES
(95, 'Group 1', '2', 'BS in Information Technology', 'Research and Publication Center', 'John Jefferson Dela Cruz', 'Irish Mendoza', '2021-2022'),
(96, 'Group 2', '2', 'BS in Information Technology', 'The best practices for dealing with tight project deadlines.', 'Irish Mendoza', 'John Jefferson Dela Cruz', '2021-2022'),
(97, 'Group 9', '3', 'Bachelor of Arts in English', 'Why time management is essential for  goal setting', 'John Jefferson Dela Cruz', 'Ben Mahinay', '2023-2024'),
(98, 'Group 3', '1', 'BS in Accountancy', 'What is a borderline personality disorder? What leads to depression in a person?', 'John Jefferson Dela Cruz', 'Ben Mahinay', '2020-2021'),
(99, 'Group 4', '3', 'Bachelor of Arts in English', 'The best practice for quitting alcohol and cigarettes.', 'Rosfield Atiagan', 'John Jefferson Dela Cruz', '2024-2025'),
(100, 'Group 5', '2', 'BS in Information Technology', 'Criminals: Are there more men or women? Politics and Prisoners: Should prisoners have the right to vote? Victimless Crime: Does it exist? Sexual Harassment: Are women the only victims?', 'Ben Mahinay', 'Irish Mendoza', '2021-2022'),
(105, '69', '2', 'BS in Information Technol', 'The Beginning After the End', 'John Mark', 'John Adam Presper Eckert', '2021-2022'),
(111, '56', '2', 'BS in Information Technol', 'asdfasdf', 'asdfasdf', 'adsfasdf', '2021-2022');

-- --------------------------------------------------------

--
-- Table structure for table `users_information`
--

CREATE TABLE `users_information` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `user_password` varchar(100) NOT NULL,
  `type` varchar(30) NOT NULL,
  `zone` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users_information`
--

INSERT INTO `users_information` (`id`, `first_name`, `last_name`, `email`, `user_password`, `type`, `zone`) VALUES
(82, 'User', 'Admin', 'admin@gmail.com', '$2y$10$XEH/mH5EMhZbsPHKOrzliunLs0erUYBO4LQEYkbh3wmPrDskIRE0y', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `zone`
--

CREATE TABLE `zone` (
  `id` int(11) NOT NULL,
  `Zone` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `zone`
--

INSERT INTO `zone` (`id`, `Zone`) VALUES
(1, 'Zone 1 - DAE, DBAE, HM, TM'),
(2, 'Zone 2 - DCJE, CS, IT, DEE'),
(3, 'Zone 3 - DASE, DTE');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `program`
--
ALTER TABLE `program`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `proponents`
--
ALTER TABLE `proponents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_research_id` (`research_id`);

--
-- Indexes for table `research_information`
--
ALTER TABLE `research_information`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_information`
--
ALTER TABLE `users_information`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zone`
--
ALTER TABLE `zone`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `branch`
--
ALTER TABLE `branch`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `program`
--
ALTER TABLE `program`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `proponents`
--
ALTER TABLE `proponents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=334;

--
-- AUTO_INCREMENT for table `research_information`
--
ALTER TABLE `research_information`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT for table `users_information`
--
ALTER TABLE `users_information`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `zone`
--
ALTER TABLE `zone`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `proponents`
--
ALTER TABLE `proponents`
  ADD CONSTRAINT `fk_research_id` FOREIGN KEY (`research_id`) REFERENCES `research_information` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
