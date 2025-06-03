-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 02, 2025 at 05:59 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `library_system_lab4`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookloans`
--

CREATE TABLE `bookloans` (
  `loan_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `loan_date` date NOT NULL,
  `return_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookloans`
--

INSERT INTO `bookloans` (`loan_id`, `book_id`, `member_id`, `loan_date`, `return_date`) VALUES
(1, 1, 1, '2025-05-27', '2025-05-27'),
(2, 3, 1, '2025-05-27', '2025-05-27'),
(3, 3, 1, '2025-05-28', '2025-05-28'),
(4, 1, 1, '2025-05-28', '2025-05-28'),
(5, 2, 1, '2025-05-29', '2025-05-29');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `book_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `price` float NOT NULL,
  `genre` varchar(100) DEFAULT NULL,
  `publication_year` int(11) DEFAULT NULL,
  `type` enum('physical','ebook') DEFAULT 'physical',
  `file_format` varchar(50) DEFAULT NULL,
  `file_size` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`book_id`, `title`, `author`, `price`, `genre`, `publication_year`, `type`, `file_format`, `file_size`) VALUES
(1, 'nelkon and parker', 'nelkon', 4500, 'acadmy', 2007, 'physical', NULL, NULL),
(2, 'clean code', 'robert martin', 29.99, 'programming', 2008, 'ebook', 'pdf', 3),
(3, 'clean code', 'robert martin', 29.99, 'programming', 2008, 'ebook', 'pdf', 3);

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `member_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `membership_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`member_id`, `name`, `email`, `membership_date`) VALUES
(1, 'mbenga andreas', 'mbengaandreas84@gmail.com', '2025-05-27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookloans`
--
ALTER TABLE `bookloans`
  ADD PRIMARY KEY (`loan_id`),
  ADD KEY `book_id` (`book_id`),
  ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`book_id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`member_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookloans`
--
ALTER TABLE `bookloans`
  MODIFY `loan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookloans`
--
ALTER TABLE `bookloans`
  ADD CONSTRAINT `bookloans_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`),
  ADD CONSTRAINT `bookloans_ibfk_2` FOREIGN KEY (`member_id`) REFERENCES `members` (`member_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
