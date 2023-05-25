-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Gegenereerd op: 25 mei 2023 om 11:20
-- Serverversie: 8.0.31
-- PHP-versie: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `voedselbank_db`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `bestelling`
--

CREATE TABLE `bestelling` (
  `BestellingID` int NOT NULL,
  `KoperAccountID` int NOT NULL,
  `BestelingInhoud` varchar(999) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `categorie`
--

CREATE TABLE `categorie` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `leveranciers`
--

CREATE TABLE `leveranciers` (
  `id` int NOT NULL,
  `username` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `Mail` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `producten`
--

CREATE TABLE `producten` (
  `id` int NOT NULL,
  `naam` varchar(255) NOT NULL,
  `beschrijving` varchar(100) NOT NULL,
  `voorraad` int NOT NULL,
  `EAN-Nummer` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `producten`
--

INSERT INTO `producten` (`id`, `naam`, `beschrijving`, `voorraad`, `EAN-Nummer`) VALUES
(16, 'Appel', 'grote mooie appels', 283, '38293849192'),
(23, 'Kaas', 'lekkere kaas', 123, '98729487128'),
(25, 'Appelflap', 'Lekkere zoete appel met bladerdeeg en suiker', 44, '38294829192');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `user`
--

CREATE TABLE `user` (
  `AccountID` int NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Wachtwoord` varchar(255) NOT NULL,
  `Naam` varchar(100) NOT NULL,
  `Telefoonnummer` varchar(100) NOT NULL,
  `role` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `user`
--

INSERT INTO `user` (`AccountID`, `Email`, `Wachtwoord`, `Naam`, `Telefoonnummer`, `role`) VALUES
(1, 'joris@joris.nl', '$2y$10$5i1nXjle256QS6J.uFJAcur5HNx6yeLnBLym0IrFiABLXmKPf/H6a', 'joris', '0612345678', '0'),
(2, 'gaming@gmail.com', '$2y$10$hDNissTX5KJ3n73JGqKF9.jCQ0.iM0NMi2FcjMlQrf4UkSMaTe6uW', 'ik ben een gebruiker', '069999999', '0'),
(3, 'billy@billy.com', '$2y$10$qzgN.m.TNfhaP8zV5qceF.ObbVgud.8dwaNTC/dEakdnP3fiQroUG', 'Billy', '06245677422', '0'),
(4, 'beingchilling@china.com', '$2y$10$uL/.d1xPGVyeVEdfeU5Dv.p1VmKPFCwp8F8PGV8cFosa8h6d0x6nq', 'benjemens?', '-', '0'),
(5, 'bodi@gmail.com', '$2y$10$Yr46.7IEpW7PBda74sfDFuSDJuk4yMXt1D8CBqRRI6rgNfVMhy9PO', 'bodi', 'bodi', '0'),
(6, 'bodilukepoels@gmail.com', '$2y$10$yEkRZ6jmrLn.xaTG2tPMXeLgeRTr05q5LtcxS59sM7UjDtyVG46V6', 'Bodi', '0640701827', '0');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `bestelling`
--
ALTER TABLE `bestelling`
  ADD PRIMARY KEY (`BestellingID`);

--
-- Indexen voor tabel `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `leveranciers`
--
ALTER TABLE `leveranciers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexen voor tabel `producten`
--
ALTER TABLE `producten`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`AccountID`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `bestelling`
--
ALTER TABLE `bestelling`
  MODIFY `BestellingID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `leveranciers`
--
ALTER TABLE `leveranciers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT voor een tabel `producten`
--
ALTER TABLE `producten`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT voor een tabel `user`
--
ALTER TABLE `user`
  MODIFY `AccountID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
