-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Gegenereerd op: 08 jun 2023 om 14:36
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
-- Tabelstructuur voor tabel `gezinnen`
--

CREATE TABLE `gezinnen` (
  `id` int NOT NULL,
  `naam` varchar(200) NOT NULL,
  `volwassenen` int NOT NULL,
  `kinderen` int NOT NULL,
  `postcode` int NOT NULL,
  `mail` varchar(255) NOT NULL,
  `telefoonnummer` int NOT NULL,
  `wensen` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `leveranciers`
--

CREATE TABLE `leveranciers` (
  `id` int NOT NULL,
  `naam` varchar(255) NOT NULL,
  `mail` varchar(100) NOT NULL,
  `telefoonnummer` int NOT NULL,
  `postcode` varchar(6) NOT NULL,
  `bezorgingsdatum` date NOT NULL,
  `bezorgingstijd` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `leveranciers`
--

INSERT INTO `leveranciers` (`id`, `naam`, `mail`, `telefoonnummer`, `postcode`, `bezorgingsdatum`, `bezorgingstijd`) VALUES
(12, 'postnl', 'postnl@nl', 640273918, '1444LO', '2023-06-14', '21:10'),
(15, 'DHL', 'DHL@DHL.nl', 123456789, '1333ZB', '2023-06-09', '15:57');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `producten`
--

CREATE TABLE `producten` (
  `id` int NOT NULL,
  `naam` varchar(255) NOT NULL,
  `beschrijving` varchar(100) NOT NULL,
  `categorie` varchar(500) NOT NULL,
  `voorraad` int NOT NULL,
  `EAN-Nummer` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `producten`
--

INSERT INTO `producten` (`id`, `naam`, `beschrijving`, `categorie`, `voorraad`, `EAN-Nummer`) VALUES
(29, 'kaas', 'kaas', 'Fruit', 100, '11267532348'),
(30, 'melk', 'melk', 'Koek', 200, '12345678910'),
(31, 'groene melk', 'de melk is groen', 'Sappen', 100, '29343232457324732748');

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
  `role` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `user`
--

INSERT INTO `user` (`AccountID`, `Email`, `Wachtwoord`, `Naam`, `Telefoonnummer`, `role`) VALUES
(1, 'joris@joris.nl', '$2y$10$5i1nXjle256QS6J.uFJAcur5HNx6yeLnBLym0IrFiABLXmKPf/H6a', 'joris', '0612345678', 0),
(2, 'gaming@gmail.com', '$2y$10$hDNissTX5KJ3n73JGqKF9.jCQ0.iM0NMi2FcjMlQrf4UkSMaTe6uW', 'ik ben een gebruiker', '069999999', 0),
(3, 'billy@billy.com', '$2y$10$qzgN.m.TNfhaP8zV5qceF.ObbVgud.8dwaNTC/dEakdnP3fiQroUG', 'Billy', '06245677422', 0),
(4, 'beingchilling@china.com', '$2y$10$uL/.d1xPGVyeVEdfeU5Dv.p1VmKPFCwp8F8PGV8cFosa8h6d0x6nq', 'benjemens?', '-', 0),
(5, 'bodi@gmail.com', '$2y$10$hFjsxjhMCFbC5ZHOAfF5E.fCQssmUSTaJqJFG6avZGTYxvFvXY/r.', 'bodi', 'bodi', 3),
(6, 'bodilukepoels@gmail.com', '$2y$10$yEkRZ6jmrLn.xaTG2tPMXeLgeRTr05q5LtcxS59sM7UjDtyVG46V6', 'Bodi', '0640701827', 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `voedselpakket`
--

CREATE TABLE `voedselpakket` (
  `id` int NOT NULL,
  `naam` varchar(255) NOT NULL,
  `producten` varchar(255) NOT NULL,
  `aantal_pakketten` int NOT NULL,
  `samenstellingsdatum` date NOT NULL DEFAULT '0000-00-00',
  `ophaaldatum` date NOT NULL DEFAULT '0000-00-00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `bestelling`
--
ALTER TABLE `bestelling`
  ADD PRIMARY KEY (`BestellingID`);

--
-- Indexen voor tabel `gezinnen`
--
ALTER TABLE `gezinnen`
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
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `bestelling`
--
ALTER TABLE `bestelling`
  MODIFY `BestellingID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `gezinnen`
--
ALTER TABLE `gezinnen`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT voor een tabel `leveranciers`
--
ALTER TABLE `leveranciers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT voor een tabel `producten`
--
ALTER TABLE `producten`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT voor een tabel `user`
--
ALTER TABLE `user`
  MODIFY `AccountID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT voor een tabel `voedselpakket`
--
ALTER TABLE `voedselpakket`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
