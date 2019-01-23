-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Czas generowania: 23 Sty 2019, 16:42
-- Wersja serwera: 5.7.19
-- Wersja PHP: 7.1.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `kroepniek`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `nickname` text COLLATE utf8_polish_ci NOT NULL,
  `name` text COLLATE utf8_polish_ci NOT NULL,
  `lastname` text COLLATE utf8_polish_ci NOT NULL,
  `password` text COLLATE utf8_polish_ci NOT NULL,
  `email` text COLLATE utf8_polish_ci NOT NULL,
  `Birth` datetime DEFAULT NULL,
  `RegisterDate` datetime DEFAULT NULL,
  `Street` text COLLATE utf8_polish_ci,
  `HouseNumber` text COLLATE utf8_polish_ci,
  `City` text COLLATE utf8_polish_ci,
  `ZipCode` text COLLATE utf8_polish_ci,
  `Country` text COLLATE utf8_polish_ci,
  `Phone` text COLLATE utf8_polish_ci,
  `isAdmin` tinyint(1) NOT NULL,
  `isBanned` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`ID`, `nickname`, `name`, `lastname`, `password`, `email`, `Birth`, `RegisterDate`, `Street`, `HouseNumber`, `City`, `ZipCode`, `Country`, `Phone`, `isAdmin`, `isBanned`) VALUES
(1, 'Kroepniek', 'Daniel', 'Mondzielewski', '$2y$10$/4Fjn1rfLjw5hIGfrNWXs.6ywQPmPxzqmSKRNzvQSdO1xXlDnRgme', 'mondzielewski123@wp.pl', '2001-12-03 00:00:00', '2018-12-03 00:00:00', 'Mierloseweg', '67', 'Helmond', '5707AC', 'Nederland', '0657813055', 1, 0),
(2, 'test', 'test', 'Test', '$2y$10$/4Fjn1rfLjw5hIGfrNWXs.6ywQPmPxzqmSKRNzvQSdO1xXlDnRgme', 'test@wp.pl', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0),
(3, 'Register', 'Les', 'VanBackEnd', '$2y$10$DLc8I0CjXNxm4ufv/KFUPOOqhFT0KGqeTiLsU2pr7Bf5oaphKbZkG', 'Het@werkt.nl', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1),
(4, 'ILikethis', 'Peter', 'Nocker', '$2y$10$W6eQioh0z2XrdCIjHTbgje/Gr6c1POUngFd2Bn2TokXhc/EMVp3C2', 'aaaa@ss.sd', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0),
(5, 'NoTesty', 'NoJaElo', 'JakTam', '$2y$10$DCZQk5Ar1rEjurxBoBWfp.FWBbAXAUUGXRpgbzwMaZLysZr0EHE76', 'Kura@wp.pl', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0),
(6, 'Testing', 'Hello', 'ImBack', '$2y$10$W.azmdgKZohWnVQsWef6Pubtc8gIeXQIv3gHzyxJkQyVyTCrEtKK6', 'Dzban@fupe.peel', NULL, '2019-01-23 09:40:36', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `warnings`
--

CREATE TABLE `warnings` (
  `ID` int(11) NOT NULL COMMENT 'ID',
  `ID_ASOS` int(11) NOT NULL COMMENT 'ID asocjacyjne',
  `Title` text COLLATE utf8_polish_ci NOT NULL COMMENT 'Tytuł ostrzeżenia',
  `Message` text COLLATE utf8_polish_ci NOT NULL COMMENT 'Treść ostrzeżeia',
  `WarnPoints` int(11) NOT NULL COMMENT 'Punkty ostrzeżenia'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- Indeksy dla tabeli `warnings`
--
ALTER TABLE `warnings`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT dla tabeli `warnings`
--
ALTER TABLE `warnings`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID';
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
