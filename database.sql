-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 29 Tem 2022, 10:11:15
-- Sunucu sürümü: 10.4.22-MariaDB
-- PHP Sürümü: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `league`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `matches`
--

CREATE TABLE `matches` (
                           `id` int(11) NOT NULL,
                           `first_team_id` int(11) NOT NULL,
                           `second_team_id` int(11) NOT NULL,
                           `first_score` int(11) DEFAULT NULL,
                           `second_score` int(11) DEFAULT NULL,
                           `first_point` int(11) NOT NULL,
                           `second_point` int(11) NOT NULL,
                           `debug` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `teams`
--

CREATE TABLE `teams` (
                         `id` int(11) NOT NULL,
                         `name` varchar(75) NOT NULL,
                         `power` int(3) NOT NULL,
                         `won` int(3) NOT NULL,
                         `drawn` int(3) NOT NULL,
                         `lost` int(3) NOT NULL,
                         `point` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `teams`
--

INSERT INTO `teams` (`id`, `name`, `power`, `won`, `drawn`, `lost`, `point`) VALUES
                                                                                 (1, 'Fenerbahçe', 85, 0, 0, 0, 0),
                                                                                 (2, 'Galatasaray', 90, 0, 0, 0, 0),
                                                                                 (3, 'Beşiktaş', 80, 0, 0, 0, 0),
                                                                                 (4, 'Trabzonspor', 75, 0, 0, 0, 0),
                                                                                 (5, 'Konyaspor', 75, 0, 0, 0, 0),
                                                                                 (6, 'Adana Demirspor', 65, 0, 0, 0, 0),
                                                                                 (7, 'Başakşehir', 70, 0, 0, 0, 0),
                                                                                 (8, 'Sivasspor', 75, 0, 0, 0, 0),
                                                                                 (9, 'Kasımpaşa', 55, 0, 0, 0, 0),
                                                                                 (10, 'Antalyaspor', 60, 0, 0, 0, 0),
                                                                                 (11, 'Kayserispor', 70, 0, 0, 0, 0),
                                                                                 (12, 'Fatih Karagümrük', 50, 0, 0, 0, 0),
                                                                                 (13, 'Giresunspor', 65, 0, 0, 0, 0),
                                                                                 (14, 'Malatyaspor', 60, 0, 0, 0, 0),
                                                                                 (15, 'Ümraniyespor', 50, 0, 0, 0, 0),
                                                                                 (16, 'Alanyaspor', 60, 0, 0, 0, 0),
                                                                                 (17, 'Göztepe', 75, 0, 0, 0, 0),
                                                                                 (18, 'Hatayspor', 90, 0, 0, 0, 0);

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `matches`
--
ALTER TABLE `matches`
    ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `teams`
--
ALTER TABLE `teams`
    ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `matches`
--
ALTER TABLE `matches`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `teams`
--
ALTER TABLE `teams`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
