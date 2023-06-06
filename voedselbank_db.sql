-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 06 jun 2023 om 22:14
-- Serverversie: 10.4.28-MariaDB
-- PHP-versie: 8.2.4

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
  `BestellingID` int(11) NOT NULL,
  `KoperAccountID` int(11) NOT NULL,
  `BestelingInhoud` varchar(999) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `categorie`
--

CREATE TABLE `categorie` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `leveranciers`
--

CREATE TABLE `leveranciers` (
  `id` int(11) NOT NULL,
  `naam` varchar(255) NOT NULL,
  `mail` varchar(100) NOT NULL,
  `telefoonnummer` int(10) NOT NULL,
  `postcode` varchar(6) NOT NULL,
  `bezorgingsdatum` date NOT NULL,
  `bezorgingstijd` time(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `leveranciers`
--

INSERT INTO `leveranciers` (`id`, `naam`, `mail`, `telefoonnummer`, `postcode`, `bezorgingsdatum`, `bezorgingstijd`) VALUES
(12, 'postnl', 'postnl@nl', 640273918, '1444LO', '2023-06-14', '21:10:00.000000');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `producten`
--

CREATE TABLE `producten` (
  `id` int(11) NOT NULL,
  `naam` varchar(255) NOT NULL,
  `beschrijving` varchar(100) NOT NULL,
  `voorraad` int(11) NOT NULL,
  `EAN-Nummer` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `producten`
--

INSERT INTO `producten` (`id`, `naam`, `beschrijving`, `voorraad`, `EAN-Nummer`) VALUES
(16, 'Appel', 'grote mooie appels', 283, '38293849192'),
(23, 'Kaas', 'lekkere kaas', 123, '98729487128'),
(25, 'Appelflap', 'Lekkere zoete appel met bladerdeeg en suiker', 44, '38294829192'),
(26, 'appeltaart', 'lekkere appeltaart', 24, '2948140283');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `user`
--

CREATE TABLE `user` (
  `AccountID` int(11) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Wachtwoord` varchar(255) NOT NULL,
  `Naam` varchar(100) NOT NULL,
  `Telefoonnummer` varchar(100) NOT NULL,
  `role` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `user`
--

INSERT INTO `user` (`AccountID`, `Email`, `Wachtwoord`, `Naam`, `Telefoonnummer`, `role`) VALUES
(1, 'joris@joris.nl', '$2y$10$5i1nXjle256QS6J.uFJAcur5HNx6yeLnBLym0IrFiABLXmKPf/H6a', 'joris', '0612345678', 0),
(2, 'gaming@gmail.com', '$2y$10$hDNissTX5KJ3n73JGqKF9.jCQ0.iM0NMi2FcjMlQrf4UkSMaTe6uW', 'ik ben een gebruiker', '069999999', 0),
(3, 'billy@billy.com', '$2y$10$qzgN.m.TNfhaP8zV5qceF.ObbVgud.8dwaNTC/dEakdnP3fiQroUG', 'Billy', '06245677422', 0),
(4, 'beingchilling@china.com', '$2y$10$uL/.d1xPGVyeVEdfeU5Dv.p1VmKPFCwp8F8PGV8cFosa8h6d0x6nq', 'benjemens?', '-', 0),
(5, 'bodi@gmail.com', '$2y$10$Yr46.7IEpW7PBda74sfDFuSDJuk4yMXt1D8CBqRRI6rgNfVMhy9PO', 'bodi', 'bodi', 3),
(6, 'bodilukepoels@gmail.com', '$2y$10$yEkRZ6jmrLn.xaTG2tPMXeLgeRTr05q5LtcxS59sM7UjDtyVG46V6', 'Bodi', '0640701827', 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `voedselpakket`
--

CREATE TABLE `voedselpakket` (
  `naam` varchar(100) NOT NULL,
  `producten` varchar(255) NOT NULL,
  `aantal_pakketten` int(255) NOT NULL,
  `ophaaldatum` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `voedselpakket`
--

INSERT INTO `voedselpakket` (`naam`, `producten`, `aantal_pakketten`, `ophaaldatum`) VALUES
('YES', '', 12, '2023-06-23'),
('YES2', '', 24, '0000-00-00');

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
  ADD UNIQUE KEY `username` (`naam`);

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
-- Indexen voor tabel `voedselpakket`
--
ALTER TABLE `voedselpakket`
  ADD PRIMARY KEY (`naam`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `bestelling`
--
ALTER TABLE `bestelling`
  MODIFY `BestellingID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `leveranciers`
--
ALTER TABLE `leveranciers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT voor een tabel `producten`
--
ALTER TABLE `producten`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT voor een tabel `user`
--
ALTER TABLE `user`
  MODIFY `AccountID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
