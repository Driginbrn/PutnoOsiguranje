-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 13, 2023 at 08:19 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `putnoosiguranje`
--

-- --------------------------------------------------------

--
-- Table structure for table `dodatni_osiguranik`
--

CREATE TABLE `dodatni_osiguranik` (
  `d_nosilac_osiguranja` varchar(50) NOT NULL,
  `d_datum_rodjenja` date NOT NULL,
  `d_broj_pasosa` int(11) NOT NULL,
  `glavni_osiguranik_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dodatni_osiguranik`
--

INSERT INTO `dodatni_osiguranik` (`d_nosilac_osiguranja`, `d_datum_rodjenja`, `d_broj_pasosa`, `glavni_osiguranik_id`) VALUES
('Andjela Avramovic', '2002-08-13', 2888, 8888);

-- --------------------------------------------------------

--
-- Table structure for table `osiguranje`
--

CREATE TABLE `osiguranje` (
  `nosilac_osiguranja` varchar(50) NOT NULL,
  `datum_rodjenja` date NOT NULL,
  `broj_pasosa` int(20) NOT NULL,
  `telefon` int(10) DEFAULT NULL,
  `email` varchar(30) NOT NULL,
  `datum_putovanja_od` date NOT NULL,
  `datum_putovanja_do` date NOT NULL,
  `vrsta_polise` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `osiguranje`
--

INSERT INTO `osiguranje` (`nosilac_osiguranja`, `datum_rodjenja`, `broj_pasosa`, `telefon`, `email`, `datum_putovanja_od`, `datum_putovanja_do`, `vrsta_polise`) VALUES
('Viktor', '2000-12-15', 4444, 0, 'viktor@gmail.com', '2023-09-01', '2023-09-30', 'individualno'),
('Milos Talic', '2000-04-15', 8888, 601234567, 'misatalic@gmail.com', '2023-09-12', '2023-09-30', 'grupno');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dodatni_osiguranik`
--
ALTER TABLE `dodatni_osiguranik`
  ADD PRIMARY KEY (`d_broj_pasosa`),
  ADD KEY `glavni_osiguranik_id` (`glavni_osiguranik_id`);

--
-- Indexes for table `osiguranje`
--
ALTER TABLE `osiguranje`
  ADD PRIMARY KEY (`broj_pasosa`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dodatni_osiguranik`
--
ALTER TABLE `dodatni_osiguranik`
  ADD CONSTRAINT `dodatni_osiguranik_ibfk_1` FOREIGN KEY (`glavni_osiguranik_id`) REFERENCES `osiguranje` (`broj_pasosa`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
