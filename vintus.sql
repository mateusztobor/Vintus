-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 11 Lis 2023, 00:45
-- Wersja serwera: 10.4.22-MariaDB
-- Wersja PHP: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `vintus`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `baskets`
--

CREATE TABLE `baskets` (
  `basket_id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `user_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `baskets_items`
--

CREATE TABLE `baskets_items` (
  `item_id` bigint(20) NOT NULL,
  `item_vid` bigint(20) NOT NULL,
  `basket_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `fee` decimal(10,2) NOT NULL,
  `currency` varchar(3) NOT NULL,
  `hearts` bigint(20) NOT NULL,
  `size` varchar(32) NOT NULL,
  `brand` varchar(255) NOT NULL,
  `swap` tinyint(1) NOT NULL,
  `seller_type` tinyint(1) NOT NULL,
  `url` varchar(512) NOT NULL,
  `picture` varchar(512) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `user_id` bigint(20) NOT NULL,
  `nick` varchar(64) COLLATE utf8mb4_bin NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`user_id`, `nick`, `email`, `password`) VALUES
(1, 'test', 'test@vintus.com', '$2y$10$GoXHU29Q8R7PbrZph8d/Z.VlO.e2Qk0tHoSx8xi43BnnBhbvECEiy');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `baskets`
--
ALTER TABLE `baskets`
  ADD PRIMARY KEY (`basket_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeksy dla tabeli `baskets_items`
--
ALTER TABLE `baskets_items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `basket_id` (`basket_id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `nick` (`nick`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `baskets_items`
--
ALTER TABLE `baskets_items`
  MODIFY `item_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `user_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `baskets`
--
ALTER TABLE `baskets`
  ADD CONSTRAINT `baskets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `baskets_items`
--
ALTER TABLE `baskets_items`
  ADD CONSTRAINT `baskets_items_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `baskets_items_ibfk_2` FOREIGN KEY (`basket_id`) REFERENCES `baskets` (`basket_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
